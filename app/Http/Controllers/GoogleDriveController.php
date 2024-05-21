<?php
// app/Http/Controllers/GoogleDriveController.php

namespace App\Http\Controllers;

use App\Services\GoogleDriveService;
use Illuminate\Http\Request;

class GoogleDriveController extends Controller
{
    protected $driveService;

    public function __construct(GoogleDriveService $driveService)
    {
        $this->driveService = $driveService;
    }

    /**
     * Redirect to Google's OAuth 2.0 server.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function auth()
    {
        return $this->driveService->redirectToGoogleOAuth();
    }

    /**
     * Handle the OAuth 2.0 server response.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(Request $request)
    {
        try {
            $this->driveService->handleGoogleOAuthCallback();
            // Redirect to a dashboard or another page with a success message
            return redirect('/ProfileInfo')->with('success', 'Successfully authenticated with Google Drive.');
        } catch (\Exception $e) {
            // Redirect to a failure page or back to the auth page with an error message
            return redirect('/google-drive/auth')->with('error', 'Authentication failed: ' . $e->getMessage());
        }
    }


}
