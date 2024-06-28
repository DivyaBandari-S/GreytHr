<?php

namespace App\Livewire;

use App\Jobs\SendScheduledEmailJob;
use App\Mail\SendTimeSheetMail;
use App\Models\EmailLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadTimeSheet extends Component
{
    use WithFileUploads;

    public $files = [];
    public $to;
    public $cc;
    public $subject;
    public $scheduledDateTime;
    public $activeButton = 'history';
    public $showTimeInput = false;
    public $showHistory = true;
    public $showQueued = false;
    public $emailLogs;
    public $message;

    public function mount()
    {
        $this->fetchEmailLogs();
    }

    public function fetchEmailLogs()
    {
        $this->emailLogs = EmailLog::all();
    }
        public function dismissMessage()
    {
        session()->forget('message');
        $this->message = null;
    }

    public function updatedFiles()
    {
        $this->validate([
            'files.*' => 'required|mimes:xlsx,xls|max:10240', // Validate each file in the array
        ]);
    }

    public function setActiveButton($button)
    {
        $this->activeButton = $button;
        if ($button == 'history') {
            $this->showHistory = true;
            $this->showQueued = false;
        } else {
            $this->showHistory = false;
            $this->showQueued = true;
        }
    }

    // Custom validation method for emails
    protected function validateEmails($emails)
    {
        $emailsArray = explode(',', $emails);
        foreach ($emailsArray as $email) {
            $email = trim($email);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
        }
        return true;
    }

    // Method to handle "To" emails
    public function To()
    {
        $this->validate([
            'to' => ['required', function ($attribute, $value, $fail) {
                if (!$this->validateEmails($value)) {
                    $fail('The ' . $attribute . ' format is invalid.');
                }
            }],
        ]);
    }

    // Method to handle "CC" emails
    public function ccTo()
    {
        $this->validate([
            'cc' => ['nullable', function ($attribute, $value, $fail) {
                if ($value && !$this->validateEmails($value)) {
                    $fail('The ' . $attribute . ' format is invalid.');
                }
            }],
        ]);
    }
    public function removeCC($ccAddress)
    {
        // Remove the specified CC address from the list
        $this->cc = implode(',', array_diff(explode(',', $this->cc), [$ccAddress]));
    }
    public function removeTo($toAddress)
    {
        // Remove the specified CC address from the list
        $this->to = implode(',', array_diff(explode(',', $this->cc), [$toAddress]));
    }
    // Method to send email immediately
    public function sendEmailImmediate()
    {
        $this->validate([
            'files.*' => 'required|mimes:xlsx,xls|max:10240', // Validate each file in the array
            'to' => ['required', function ($attribute, $value, $fail) {
                if (!$this->validateEmails($value)) {
                    $fail('The ' . $attribute . ' format is invalid.');
                }
            }],
            'cc' => ['nullable', function ($attribute, $value, $fail) {
                if ($value && !$this->validateEmails($value)) {
                    $fail('The ' . $attribute . ' format is invalid.');
                }
            }],
        ]);

        try {
            $filePaths = [];
            foreach ($this->files as $file) {
                // Store file temporarily
                $path = $file->store('excel-uploads', 'public');
                $filePaths[] = $path;
                $originalFileName = $file->getClientOriginalName();

                // Send email immediately for each file
                Mail::to(array_map('trim', explode(',', $this->to)))
                    ->cc($this->cc ? array_map('trim', explode(',', $this->cc)) : null)
                    ->send(new SendTimeSheetMail($path, $originalFileName));

                Log::info('Email sent immediately to ' . $this->to . ' for file ' . $originalFileName);
            }

            // Save email log
            EmailLog::create([
                'subject' => $this->subject,
                'to' => json_encode(array_map('trim', explode(',', $this->to))),
                'cc' => $this->cc ? json_encode(array_map('trim', explode(',', $this->cc))) : null,
                'files' => json_encode($filePaths),
            ]);

            session()->flash('message', 'Email(s) sent immediately successfully.');
            $this->reset(['files', 'to', 'cc', 'subject']);
            $this->fetchEmailLogs();
        } catch (\Exception $e) {
            Log::error('Failed to send email to ' . $this->to . ': ' . $e->getMessage());
            throw $e;
        }
    }

   // Method to schedule email for later
   public function sendEmailAfter()
   {
       $this->showTimeInput = true;
   
       $this->validate([
           'files.*' => 'required|mimes:xlsx,xls|max:10240', // Validate each file in the array
           'to' => ['required', function ($attribute, $value, $fail) {
               if (!$this->validateEmails($value)) {
                   $fail('The ' . $attribute . ' format is invalid.');
               }
           }],
           'cc' => ['nullable', function ($attribute, $value, $fail) {
               if ($value && !$this->validateEmails($value)) {
                   $fail('The ' . $attribute . ' format is invalid.');
               }
           }],
           'scheduledDateTime' => 'required|date|after:now',
       ]);
   
       try {
           $filePaths = [];
           foreach ($this->files as $file) {
               // Store file temporarily
               $path = $file->store('excel-uploads', 'public');
               $filePaths[] = $path;
               $originalFileName = $file->getClientOriginalName();
   
               // Create EmailLog entry with scheduled status
               $emailLog = EmailLog::create([
                   'subject' => $this->subject,
                   'to' => json_encode(array_map('trim', explode(',', $this->to))),
                   'cc' => $this->cc ? json_encode(array_map('trim', explode(',', $this->cc))) : null,
                   'scheduled_at' => $this->scheduledDateTime,
                   'files' => json_encode($filePaths),
                   'scheduled_status' => 'scheduled', // Initial status
               ]);
   
               // Parse the scheduled date and time
               $when = Carbon::parse($this->scheduledDateTime, 'Asia/Kolkata');
   
               // Dispatch job to send email
               SendScheduledEmailJob::dispatch($emailLog)->delay($when);
               
               Log::info('Email scheduled to be sent to ' . $this->to . ' at ' . $when . ' for file ' . $originalFileName);
           }
   
           session()->flash('message', 'Email(s) scheduled to be sent successfully.');
           $this->reset(['files', 'to', 'cc', 'subject', 'scheduledDateTime']);
           $this->fetchEmailLogs();
       } catch (\Exception $e) {
           Log::error('Failed to schedule email: ' . $e->getMessage());
           throw $e;
       }
   }
    public function render()
    {
        return view('livewire.upload-time-sheet',[
            'emailLogs' => $this->emailLogs
        ]);
    }
}
