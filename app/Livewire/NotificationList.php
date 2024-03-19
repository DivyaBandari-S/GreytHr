<?php

namespace App\Livewire;

use App\Models\AppliedJob;
use App\Models\Job;
use App\Models\JobseekersExamDetails;
use App\Models\JobseekersInterviewDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationList extends Component
{
    public $notificationList;
    public $user;
    public $companyDetails;
    public $job;
    public function logout()
    {
        Auth::logout();
        return redirect('/emplogin');
    }

    public function showJobDetails($jobId)
    {
        return redirect()->route('full-job-view', ['jobId' => $jobId]);
    }
    public function mount($jobId)
    {
        $this->user = auth()->user();

        $this->notificationList = JobseekersExamDetails::with('user', 'job', 'company')
            ->where('user_id', $this->user->user_id)
            ->where('job_id', $jobId) // Add this condition to filter by the specific job_id
            ->orderBy('created_at', 'desc')
            ->get();
    }


    public function render()
    {
        return view('livewire.notification-list');
    }
}
