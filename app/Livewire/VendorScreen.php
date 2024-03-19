<?php

namespace App\Livewire;

use App\Models\Job;
use App\Models\User;
use App\Models\VendorsSubmitCvToHr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class VendorScreen extends Component
{
    use WithFileUploads;
    public $jobs;
    public $showError = false;
    public $showSuccessMessage = false;
    public $submited_to;
    public $cv = [];


    public function dismissError()
    {
        $this->showError = false;
    }
    public $selectedJob;
    public $userDetails;
    public function dismissMessage()
    {

        $this->showSuccessMessage = false;
    }
    public function submitJobApplication($jobId)
    {
        $this->validate([
            'cv.' . $jobId => 'required',
        ], [
            'cv.' . $jobId . '.required' => 'At least one CV is required.',
        ],
    );


        $cvSets = [];

        foreach ($this->cv[$jobId] as $pdf) { // Loop through the uploaded files for the specific job ID
            $cvSets[] = ['cv' => $pdf->store('cvs', 'public')];
        }

        $this->selectedJob = Job::find($jobId);
        $userId = auth()->guard('web')->user()->user_id;
        $this->userDetails = User::where('user_id', $userId)->first();

        VendorsSubmitCvToHr::create([
            'user_id' => $this->userDetails->user_id,
            'job_id' => $this->selectedJob->job_id,
            'submited_to' => $this->selectedJob->contact_email,
            'cv' => $cvSets,
        ]);

        $this->showSuccessMessage = true;
    }



    public function showJobDetails($jobId)
    {
        return redirect()->route('full-job-view', ['jobId' => $jobId]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/emplogin');
    }
    public $cvCounts = [];
    public $cvCountsForVendor = [];
    public $user;
    public function render()
    {
        $this->user = auth()->user();
        $this->jobs = Job::where('created_at', '<=', now())
            ->where(function ($query) {
                $query->whereNull('expire_date')
                    ->orWhere('expire_date', '>', now());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate the CV count for each job based on job_id and user_id
        foreach ($this->jobs as $job) {
            $cvRecordsForJob = VendorsSubmitCvToHr::where('job_id', $job->job_id)->get();
            $cvRecordsForJobBasedOnVendor = VendorsSubmitCvToHr::where('job_id', $job->job_id)
                ->where('user_id', $this->user->user_id)
                ->get();

            $this->cvCounts[$job->job_id] = $cvRecordsForJob->sum(function ($record) {
                return count($record->cv);
            });
            $this->cvCountsForVendor[$job->job_id] = $cvRecordsForJobBasedOnVendor->sum(function ($record) {
                return count($record->cv);
            });
        }
        return view('livewire.vendor-screen');
    }
}
