<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class GetLocationByUser
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof \Illuminate\Http\Response) {
            $content = $response->getContent();

            // Determine the correct route based on the current route
            $targetRoute = $request->routeIs('emplogin') ? route('emplogin') : route('home');
            $script = '
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        try {
                            if (navigator.geolocation) {
                                console.log("Geolocation is supported by this browser.");
                                navigator.geolocation.getCurrentPosition(
                                    function(position) {
                                         console.log("Latitude: " + position.coords.latitude);
                                         console.log("Longitude: " + position.coords.longitude);

                                        fetch("' . $targetRoute . '", {
                                            method: "POST",
                                            headers: {
                                                "Content-Type": "application/json",
                                                "X-CSRF-TOKEN": document.querySelector(\'meta[name="csrf-token"]\').getAttribute("content")
                                            },
                                            body: JSON.stringify({
                                                latitude: position.coords.latitude,
                                                longitude: position.coords.longitude
                                            })
                                        })
                                        .then(response => response.json())
                                        .then(data => console.log("Location data sent successfully:", data))
                                        .catch(error => console.error("Error sending location data:", error));
                                    },
                                    function(error) {
                                        console.error("Error Code: " + error.code + " - " + error.message);
                                    }
                                );
                            } else {
                                console.error("Geolocation is not supported by this browser.");
                            }
                        } catch (e) {
                            console.error("An error occurred while attempting to retrieve the location:", e);
                        }
                    });
                </script>
            ';

            // Inject the script before the closing </body> tag
            $content = str_replace('</body>', $script . '</body>', $content);
            $response->setContent($content);
        }

        return $response;
    }
}