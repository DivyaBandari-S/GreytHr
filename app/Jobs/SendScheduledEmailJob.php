<?php

namespace App\Jobs;

use App\Mail\SendTimeSheetMail;
use App\Models\EmailLog;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendScheduledEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pathToFile;
    protected $originalFileName;
    protected $to;
    protected $emailLog;
    protected $cc;

    /**
     * Create a new job instance.
     */
    public function __construct(EmailLog $emailLog)
    {
        $this->emailLog = $emailLog;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            // Check if scheduled time has passed
            if (Carbon::now()->gte(Carbon::parse($this->emailLog->scheduled_at))) {
                // Your logic to send email goes here
                // For example, you can use SendTimeSheetMail::send($this->emailLog);

                // Update email log with actual sent time and change status
                $this->emailLog->update([
                    'created_at' => now(),
                    'scheduled_status' => 'sent',
                ]);

                Log::info('Email sent for log ID: ' . $this->emailLog->id);
            } else {
                Log::info('Scheduled email not yet due for log ID: ' . $this->emailLog->id);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send email for log ID ' . $this->emailLog->id . ': ' . $e->getMessage());
            throw $e;
        }
    }
}
