<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Language;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Validates {locale} from URL segment against active languages.
     * If valid   → sets app locale and shares language data for views.
     * If invalid → redirects to /{defaultLocale}/... with flash notification.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->segment(1);

        // Cache active languages (full objects used by language switcher in header)
        $activeLanguages = Cache::remember('active_languages', 3600, function () {
            return Language::where('is_active', true)
                ->get(['id_language', 'code', 'name', 'icon', 'is_default']);
        });

        $activeLocales = $activeLanguages->pluck('code')->toArray();
        $defaultLocale = Language::getDefaultCode();

        // Share language data with all views (for language switcher component)
        View::share('activeLanguages', $activeLanguages);
        View::share('currentLocale', in_array($locale, $activeLocales) ? $locale : $defaultLocale);

        // Valid locale → set and continue
        if (in_array($locale, $activeLocales)) {
            App::setLocale($locale);
            URL::defaults(['locale' => $locale]);
            return $next($request);
        }

        // Invalid locale → redirect to default locale + flash notification
        // Since middleware is attached to {locale} prefixed routes, 
        // segment(1) is the invalid locale. We must replace it.
        $segments = $request->segments();
        $requestedLocale = array_shift($segments); // Remove the invalid locale segment

        array_unshift($segments, $defaultLocale); // Insert default locale

        $redirectUrl = '/' . implode('/', $segments);

        // Prevent infinite redirect loop if the defaultLocale is somehow not in activeLocales
        if (trim($redirectUrl, '/') === trim($request->path(), '/')) {
            // Force fallback to avoid redirect loop
            App::setLocale($defaultLocale);
            URL::defaults(['locale' => $defaultLocale]);
            return $next($request);
        }

        return redirect()->to($redirectUrl)
            ->with('locale_fallback', 'The selected language is not available. Showing content in the default language.');
    }
}
