<?php

namespace App\Livewire;

use App\Models\Company;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FullJobView extends Component
{
    public $job;
    public $company;
    public function mount($jobId)
    {
        $this->job = Job::find($jobId);
        $this->company = Company::find($this->job->company_id);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/emplogin');
    }

    public $user;
    public function render()
    {
        $this->user = auth()->user();

        return view('livewire.full-job-view');
    }
}
