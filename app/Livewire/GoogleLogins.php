<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\EmployeeDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GoogleLogins extends Component
{
    public $google;
    public $googleClientId;
    public $googleClientSecret;
    public $googleRedirectUri;

    public function redirectToGoogle()
    {
        return Socialite::driver('google')-> redirect()->to('https://s6.payg-india.com/auth/google/callback');
    }

    public function handleGoogleCallback()
    {
        $this->googleClientId = config('services.google.client_id');
        $this->googleClientSecret = config('services.google.client_secret');
        $this->googleRedirectUri = config('services.google.redirect');


        try {
            $googleUser = Socialite::driver('google')->user();
         // dd( $googleUser);
            if ($googleUser && $googleUser->id) {
                $existingUser = User::where('email', $googleUser->email)->first();

                if ($existingUser) {
                    // Existing user found; update details if needed (such as full name)
                    $existingUser->full_name = $googleUser->name;
                    // Update other fields as needed

                    $existingUser->save();

                    Auth::login($existingUser);

                    return redirect('/Jobs'); // Redirect to Jobs if the user exists
                } else {
                    // No existing user found; redirect to register with Google details
                    $userData = [
                        'full_name' => $googleUser->name,
                        'email' => $googleUser->email,
                    ];
                     //dd($userData);
                    User::create($userData);
                   Auth::login(User::where('email', $googleUser->email)->first());

                    return redirect('/Jobs'); // Redirect to Jobs after registration

                }
            } else {
                session()->flash('error', 'ID not found in Google user data.');
                return redirect('/Login&Register'); // Redirect to Jobs if ID not found
            }
        } catch (\Exception $e) {
            Log::error('Exception caught: ' . $e->getMessage());
            session()->flash('error', 'Error occurred during Google authentication.');
            return redirect('/Login&Register');
        }
    }




    public function render()
    {
        return view('livewire.google-logins');
    }
}
