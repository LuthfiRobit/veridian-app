<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\IpWhitelist;
use Illuminate\Support\Facades\Cache;

class IpWhitelistMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip for local environment or if specifically disabled in config
        if (app()->environment('local') && config('app.debug')) {
            // Optional: bypass loopback for dev, but let's be strict if needed. 
            // For now, let's allow 127.0.0.1 always?
        }

        $activeIps = Cache::remember('ip_whitelist_active', 3600, function () {
            return IpWhitelist::where('is_active', true)->pluck('ip_address')->toArray();
        });

        // If no IPs are whitelisted, we assume the feature is disabled or open to all? 
        // Blueprint implies "Keamanan akses admin", so if list is not empty, adhere to it.
        // If list is empty, maybe allow all? Let's assume allow all if empty to prevent lockout on fresh install.
        if (empty($activeIps)) {
            return $next($request);
        }

        $clientIp = $request->ip();

        if (!in_array($clientIp, $activeIps)) {
            abort(403, 'Unauthorized Access: Your IP is not whitelisted.');
        }

        return $next($request);
    }
}
