<?php

namespace App\Livewire;

use App\Mail\SendMail;
use App\Models\AppliedJob;
use App\Models\Company;
use App\Models\JobseekersExamDetails;
use App\Models\JobseekersInterviewDetail;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Support\Facades\Response;
use Livewire\WithFileUploads;

class JobSeekersAppliedJobs extends Component
{
    use WithFileUploads;
    public $isOpen = false;
    public $appliedJobs;
    public $hrDetails;
    public $date;
    public $time;
    public $location_link;
    public $instructions;
    public $company_website;
    public $showError = false;
    public $showSuccessMessage = false;
    public $selectedJobApplicationId;
    public $selectedAction, $ccEmails, $cc;
    public $fromAddress;
    public $toAddress;
    public $recipientName;
    public $jobPosition;
    public $startDate;
    public $salary;
    public $company;
    public $password, $senderName, $signature;
    public function dismissError()
    {
        $this->showError = false;
    }
    public function dismissMessage()
    {
        $this->showSuccessMessage = false;
    }

    public function ccTo()
    {
        $ccWithoutSpaces = str_replace(' ', '', $this->cc);
        $this->ccEmails = $ccWithoutSpaces ? array_map('trim', explode(',', $ccWithoutSpaces)) : [];
    }

    public $ol = false;
    public $selectedJobApplicationIdForOL, $informDate, $contactPhone;
    public function showOL($jobApplicationId)
    {
        $this->appliedJobId = $jobApplicationId;
        $this->selectedJobApplicationIdForOL = AppliedJob::with('user', 'job', 'com', 'job.com')->find($jobApplicationId);
        $this->ol = true;
    }
    public function removeCC($ccAddress)
    {
        // Remove the specified CC address from the list
        $this->cc = implode(',', array_diff(explode(',', $this->cc), [$ccAddress]));
    }
    public function closeOL()
    {
        $this->ol = false;
    }
    public $showSuccessMessageForOL = false;
    public function sendOfferLetter()
    {
        try {
            $this->validate([
                'startDate' => 'required',
                'salary' => 'required',
                'signature' => 'required',
                'informDate' => 'required',
                'password' => 'required',
            ]);

            $passwordWithoutSpaces = str_replace(' ', '', $this->password);
            Config::set('mail.mailers.smtp.host', 'smtp.gmail.com');
            Config::set('mail.mailers.smtp.port', '587');
            Config::set('mail.mailers.smtp.username', $this->selectedJobApplicationIdForOL->applied_to);
            Config::set('mail.mailers.smtp.password', $passwordWithoutSpaces);
            Config::set('mail.mailers.smtp.encryption', 'tls');
            Config::set('mail.from.address', $this->selectedJobApplicationIdForOL->applied_to);
            Config::set('mail.from.name', 'Software Solutions');

            Mail::to($this->selectedJobApplicationIdForOL->user->email)->cc($this->ccEmails)
                ->send(new SendMail($this->selectedJobApplicationIdForOL->applied_to, $this->selectedJobApplicationIdForOL->job->com->hr_name, $this->signature, $this->selectedJobApplicationIdForOL->user->full_name, $this->selectedJobApplicationIdForOL->company_name, $this->selectedJobApplicationIdForOL->job_title, $this->startDate, $this->salary, $this->informDate, $this->selectedJobApplicationIdForOL->job->com->contact_phone));

            $this->resetProperties();
            $this->ol = false;
            $this->showSuccessMessageForOL = true;
        } catch (\Swift_TransportException $transportException) {
            $errorMessage = $transportException->getMessage();
            if (strpos(strtolower($errorMessage), 'authentication failed') !== false) {
                $this->showErrorMessageForOL = true;
                $this->errorMessageForOL = "Error sending offer letter: SMTP authentication failed. Please check your email address or password.";
            } else {
                $this->showErrorMessageForOL = true;
                $this->errorMessageForOL = "Error sending offer letter: $errorMessage";
            }
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            $errorMessage = $validationException->getMessage();
           
            $this->showErrorMessageForOL = true;
            $this->errorMessageForOL = "Validation error: $errorMessage";
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
           
            $this->showErrorMessageForOL = true;
            $this->errorMessageForOL = "Error sending offer letter: SMTP authentication failed. Please check your email address or password.";
        }
    }



    public $showErrorMessageForOL = false;
    public $errorMessageForOL;
    public function dismissErrorMessageForOL()
    {
        $this->showErrorMessageForOL = false;
    }

    public function resetProperties()
    {
        $this->password = null;
        $this->ccEmails = null;
        $this->cc = null;
        $this->startDate = null;
        $this->informDate = null;
        $this->signature = null;
        $this->salary = null;
    }
    public function dismissMessageForOL()
    {
        $this->showSuccessMessageForOL = false;
    }
    public function resetExamDetails()
    {
        $this->date = null;
        $this->time = null;
        $this->location_link = null;
        $this->instructions = null;
        $this->company_website = null;
    }
    public function submit()
    {
        $this->validate([
            'date' => 'required',
            'time' => 'required',
            'location_link' => 'required',
            'instructions' => 'required',
            'company_website' => 'required',
        ]);

        try {
            JobseekersExamDetails::create([
                'user_id' => $this->selectedJobApplicationId->user->user_id,
                'job_id' => $this->selectedJobApplicationId->job->job_id,
                'exam_date' => $this->date,
                'exam_time' => $this->time,
                'instructions' => $this->instructions,
                'company_website' => $this->company_website,
                'location_link' => $this->location_link,
            ]);
            $this->jobApplication = AppliedJob::find($this->selectedJobApplicationId->id);

            if ($this->jobApplication) {
                $this->jobApplication->update([
                    'application_status' => 'Shortlisted',
                ]);
            }
            $this->resetExamDetails();
            $this->isOpen = false;
            $this->showSuccessMessage = true;
        } catch (QueryException $e) {
            $this->isOpen = false;
            $this->addError('duplicate', 'You have already shortlisted to this CV.');
            $this->showError = true; // Show the error message
        }
    }
    public $examPopUp, $examLinkSent = false;
    public $selectedJobseeker;
    public $examLink;
    public $showExaminationMessage = false;
    public function resetExamLink()
    {
        $this->examDate = null;
        $this->examTime = null;
        $this->examLink = null;
    }
    public function sendExamLink()
    {
        $this->validate([
            'examLink' => 'required'
        ]);
        $examLink = JobseekersExamDetails::where('job_id', $this->selectedJobseeker->job_id)->first();

        if ($examLink) {
            $examLink->update([
                'exam_link' => $this->examLink,
            ]);
        }
        $this->resetExamLink();
        $this->examPopUp = false;

        $this->showExaminationMessage = true;
    }
    public function dismissExamMessage()
    {
        $this->showExaminationMessage = false;
    }
    public $examDate;
    public $examTime;

    public function openExamPopUp($jobApplicationId)
    {
        $this->selectedJobseeker = JobseekersExamDetails::where('job_id', $jobApplicationId)->first();
        $this->examDate = $this->selectedJobseeker->exam_date;
        $this->examTime = $this->selectedJobseeker->exam_time;
        $this->examPopUp = true;
        $this->examLinkSent = true;
    }

    public $interviewPopup = false;
    public function openInterview($jobApplicationId)
    {
        $this->interviewPopup = true;
        $this->selectedJobseeker = JobseekersExamDetails::where('job_id', $jobApplicationId)->first();
    }

    public function closeInterview()
    {
        $this->interviewPopup = false;
    }
    public function closeExamPopUp()
    {
        $this->examPopUp = false;
    }
    public function logout()
    {
        auth()->guard('com')->logout();
        return redirect('/Login&Register');
    }
    public function downloadResumeHTML($fileName)
    {
        $filePath = public_path('storage/' . $fileName);
        if (file_exists($filePath)) {
            return Response::download($filePath, 'resume.html');
        } else {
            return 'Resume not found';
        }
    }
    public $activePreview = null;

    public $appliedJobId;
    public function open($jobApplicationId)
    {
        $this->appliedJobId = $jobApplicationId;
        $this->selectedJobApplicationId = AppliedJob::find($jobApplicationId);
        $this->isOpen = true;
    }
    public function close()
    {
        $this->isOpen = false;
    }
    public $jobApplication;
    public function reject($jobApplicationId)
    {
        $this->selectedJobApplicationId = $jobApplicationId;
        $this->selectedAction = 'Rejected';
        if ($this->selectedJobApplicationId && $this->selectedAction) {
            $this->jobApplication = AppliedJob::find($this->selectedJobApplicationId);
            if ($this->jobApplication) {
                $this->jobApplication->update([
                    'application_status' => $this->selectedAction,
                ]);
            }
        }
        return redirect('/JobSeekersAppliedJobs');
    }

    public $interviewExamData;
    public function render()
    {
        $hrEmail = auth()->guard('com')->user()->contact_email;
        $this->hrDetails = Company::where('contact_email', $hrEmail)->first();
        $this->appliedJobs = AppliedJob::with('user', 'job')
            ->where('applied_to', '=', $this->hrDetails->contact_email)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('livewire.job-seekers-applied-jobs');
    }
}
