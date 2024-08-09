<?php

namespace App\Console\Commands;

use App\Mail\WeeklyDataEntries;
use App\Models\SentEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendScheduledEmails extends Command
{
    protected $signature = 'send:scheduled-emails';

    protected $description = 'Send scheduled emails based on their scheduled time';

    public function handle()
    {
        $now = Carbon::now();

        $emails = SentEmail::where('scheduled_time', '<=', $now)
            ->where('status', 'pending')
            ->get();

        foreach ($emails as $email) {
            $this->sendEmail($email);
        }

        $this->info('Scheduled emails sent successfully.');
    }

    protected function sendEmail($email)
    {
        $filePath = storage_path('app/data/data_entries.xlsx'); // Ensure this path is correct

        $mail = new WeeklyDataEntries($filePath, $email->to_email, $email->subject);

        try {
            Mail::to($email->to_email)
                ->cc($email->cc_email)
                ->send($mail);

            $email->update(['status' => 'sent']);
        } catch (\Exception $e) {
            Log::error('Error sending email: ' . $e->getMessage());
            $email->update(['status' => 'failed']);
        }
    }
}
