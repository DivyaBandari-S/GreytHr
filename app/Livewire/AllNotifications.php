<?php

namespace App\Livewire;

use App\Models\AppliedJob;
use App\Models\JobseekersExamDetails;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AllNotifications extends Component
{
    public $activeTab = 'Shorlisted';
    public $user;
    public $examination;
    public $notificationList;
    public function logout()
    {
        Auth::logout();
        return redirect('/emplogin');
    }

    public $rejectedJobs;
    public function showJobDetails($jobId)
    {
        return redirect()->route('full-job-view', ['jobId' => $jobId]);
    }
    public function showShortlistedJobInterviewDetails($jobId)
    {
        return redirect()->route('job-interview-details', ['jobId' => $jobId]);
    }
    public $examinations;
    public function render()
    {
        $this->user = auth()->user();
        $this->notificationList = JobseekersExamDetails::with('user', 'job', 'company')
            ->where('user_id', $this->user->user_id)
            ->orderBy('created_at', 'desc')
            ->get();
        $this->rejectedJobs = AppliedJob::where('user_id', $this->user->user_id)
            ->whereIn('application_status', ['Rejected'])
            ->get();
        $this->examinations = JobseekersExamDetails::with('user', 'job')
            ->where('user_id', $this->user->user_id)
            ->whereNotNull('exam_link')
            ->get();

        return view('livewire.all-notifications');
    }
}
