<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class AddCacheControlHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Set the expiration date to a dynamic future date (e.g., 1 hour in the future)
        $expiresDate = Carbon::now()->addMinute();
        Log::info('Cache-Control Header: no-cache, no-store, max-age=0, must-revalidate');
        Log::info('Expires Header: ' . $expiresDate);
        return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', $expiresDate);
    }
}
