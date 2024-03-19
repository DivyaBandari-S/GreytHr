<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Company;

class CompanyLoginForPostJobs extends Component
{
    public $credentials;
    public $contact_mail;
    public $password;
    public function login()
    {
        $this->validate([
            'contact_mail' => 'required',
            'password' => 'required',
        ]);

        $this->credentials = [
            'contact_email' => $this->contact_mail,
            'password' => $this->password,
        ];

        if (Auth::guard('com')->attempt($this->credentials)) {
            return redirect('/PostJobs');
        } else {
            $this->addError('contact_mail', 'Invalid Company Mail or Password');

        }
    }
    public function render()
    {
        return view('livewire.company-login-for-post-jobs');
    }
}
