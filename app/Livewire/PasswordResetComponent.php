<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
class PasswordResetComponent extends Component
{

    public $token;
    public $password;
    public $password_confirmation;

    public function mount($token)
    {
        $this->token = $token;
    }

    public function resetPassword()
    {
        // Validate password input only
        $data = $this->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        // Attempt to reset the user's password
        $status = Password::reset(
            [
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user) {
                $user->password = Hash::make($this->password);
                $user->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        // Handle the result
        if ($status == Password::PASSWORD_RESET) {
            session()->flash('message', 'Your password has been reset!');
            return redirect()->route('login');
        } else {
            session()->flash('error', 'There was an error resetting your password.');
        }
    }

    public function render()
    {
        return view('livewire.password-reset-component');
    }
}
