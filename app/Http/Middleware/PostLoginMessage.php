<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PostLoginMessage
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session('post_login')) {
            session()->forget('post_login');
            return $this->generatePostLoginResponse();
        }

        return $next($request);
    }

    protected function generatePostLoginResponse(): Response
    {
        $user = Auth::user();
        $userName = ucwords($user->first_name . ' ' . $user->last_name);
        $homeUrl = route('home');

        $html = <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Loading...</title>
        <style>
            body, html {
                height: 100%;
                margin: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #f8f9fa;
            }
            #message {
                font-size: 24px;
                color: #333;
                text-align: center;
            }
            .name {
                font-weight: bold;
                color: #007bff; /* Blue color */
            }
            .dots {
                display: inline-block;
                vertical-align: middle;
            }
            .dots span {
                display: inline-block;
                width: 8px;
                height: 8px;
                margin-left: 2px;
                background-color: #333;
                border-radius: 50%;
                opacity: 0;
                animation: blink 1.4s infinite both;
            }
            .dots span:nth-child(1) {
                animation-delay: 0.2s;
            }
            .dots span:nth-child(2) {
                animation-delay: 0.4s;
            }
            .dots span:nth-child(3) {
                animation-delay: 0.6s;
            }
            @keyframes blink {
                0%, 80%, 100% { opacity: 0; }
                40% { opacity: 1; }
            }
        </style>
        <script>
            setTimeout(function() {
                window.location.href = "$homeUrl";
            }, 3000);
        </script>
    </head>
    <body>
        <div id="message">
            Hi <span class="name">$userName</span>, just a moment, we're getting things ready for you
            <span class="dots">
                <span>.</span><span>.</span><span>.</span>
            </span>
        </div>
    </body>
    </html>
    HTML;

        return new Response($html, 200);
    }
}