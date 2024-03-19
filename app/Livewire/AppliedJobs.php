<?php

namespace App\Livewire;

use App\Models\AppliedJob;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AppliedJobs extends Component
{
    public $appliedJobs;
    public $user;
    public function logout()
    {
        Auth::logout();
        return redirect('/emplogin');
    }
    public function render()
    {
        $this->user = auth()->user();
        $appliedJobs = AppliedJob::where('user_id', $this->user->user_id)->get();
        $this->appliedJobs = $appliedJobs;
        return view('livewire.applied-jobs');
    }
}
