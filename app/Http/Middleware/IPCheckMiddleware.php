<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class IPCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $apiKey = $request->header('X-API-KEY');

        $access = DB::table('allowed_access')
            ->where('ip', $ip)
            ->first();

        if (!$access || $access->api_key !== $apiKey) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
