<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use Illuminate\Auth\Events\PasswordReset;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class PasswordResetComponent extends Component
{
    public $token;
    public $email; // Email passed through the link
    public $newPassword; // New password
    public $confirmNewPassword; // Confirm new password

    // Define validation rules
    protected $rules = [
        'newPassword' => [
            'required',
            'string',
            'min:8',               // At least 8 characters
            'regex:/[A-Z]/',       // Must contain at least one uppercase letter
            'regex:/[a-z]/',       // Must contain at least one lowercase letter
            'regex:/[0-9]/',       // Must contain at least one digit
            'regex:/[@$!%*#?&]/',  // Must contain at least one special character
        ],
        'confirmNewPassword' => 'required|same:newPassword',  // Confirms that confirmNewPassword matches newPassword
    ];

    public function mount($token)
    {
        $this->token = $token;
        $this->email = request()->query('email'); // Get email from query string
        dd($this->email);
    }

    public function resetPassword()
    {
        $this->validate();

        // Attempt to reset the password
        $response = Password::reset(
            [
                'email' => $this->email, // Use the email from the query
                'password' => $this->newPassword, // Use newPassword
                'password_confirmation' => $this->confirmNewPassword, // Use confirmNewPassword
                'token' => $this->token,
            ],
            function (EmployeeDetails $user) {
                $user->password = bcrypt($this->newPassword); // Hash the new password
                $user->save();
                event(new PasswordReset($user));
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            session()->flash('status', __('Password has been reset!'));
            return redirect()->route('emplogin');
        }

        session()->flash('error', __('Unable to reset password.'));
    }

    public function render()
    {
        return view('livewire.password-reset-component');
    }
}
