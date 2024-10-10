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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Process the request and get the response
        $response = $next($request);

        // Set the expiration date to a dynamic future date (e.g., 1 minute in the future)
        $expiresDate = Carbon::now()->addMinute();

        // Log::info('Cache-Control Header: no-cache, no-store, max-age=0, must-revalidate');
        // Log::info('Expires Header: ' . $expiresDate);

        // Check if the response is an instance of the Symfony Response, Laravel RedirectResponse, or JsonResponse
        if ($response instanceof Response) {
            // Add the cache control headers
            $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', $expiresDate->toRfc7231String());
        }

        return $response;
    }
}
