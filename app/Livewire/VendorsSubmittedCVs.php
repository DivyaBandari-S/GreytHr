<?php

namespace App\Livewire;

use App\Models\Company;
use Livewire\Component;
use App\Models\VendorsSubmitCvToHr;

class VendorsSubmittedCVs extends Component
{
    public $hrDetails;
    public $submittedCVs;
    public $cVs = [];

    public function logout()
    {
        auth()->guard('com')->logout();
        return redirect('/Login&Register');
    }
    public function render()
    {
        $hrEmail = auth()->guard('com')->user()->contact_email;
        $this->hrDetails = Company::where('contact_email', $hrEmail)->first();
        $this->submittedCVs = VendorsSubmitCvToHr::with('user', 'job')
            ->where('submited_to', '=', $this->hrDetails->contact_email)
            ->orderBy('created_at','desc')
            ->get();
        return view('livewire.vendors-submitted-c-vs');
    }
}
