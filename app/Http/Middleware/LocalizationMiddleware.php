<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use App\Models\Language;
use Illuminate\Support\Facades\Cache;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->segment(1);

        $activeLocales = Cache::remember('languages_active_codes', 3600, function () {
            return Language::where('is_active', true)->pluck('code')->toArray();
        });

        $defaultLocale = config('app.fallback_locale', 'en');

        // Check if the first segment is a valid locale
        if (in_array($locale, $activeLocales)) {
            App::setLocale($locale);
            URL::defaults(['locale' => $locale]);
            return $next($request);
        }

        // If not a valid locale, and we want to enforce it for public routes:
        // We might want to redirect to /{default_locale}/{request_uri}
        // BUT, checking if this is an API request or admin request which might not be prefixed?
        // For this middleware, we assume it's applied to the front-facing routes where prefix is expected.
        // If the segment 1 is NOT a locale, we redirect to default.

        // Prevent redirect loop if the root is requested (/) -> /en

        $segments = $request->segments();
        array_unshift($segments, $defaultLocale);

        return redirect()->to(implode('/', $segments));
    }
}
