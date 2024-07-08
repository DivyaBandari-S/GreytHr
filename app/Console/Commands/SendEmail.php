<?php

namespace App\Console\Commands;

use App\Mail\SendTimeSheetMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email with timesheet attachment';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('Starting SendEmail Command');
        try {
            // Define the recipients and file information
            $to = 'bandaridivya1@gmail.com'; // Update with actual recipient
            $cc = 'bandaridivya1@gmail.com'; // Update with actual CC, or set to null if not needed
            $path = 'public/excel-uploads/sample.xlsx'; // Update with actual file path
            $originalFileName = 'Shift_Roaster_Data.xlsx'; // Update with actual file name

            // Ensure the file exists before attempting to send it
            if (Storage::exists($path)) {
                Mail::to($to)
                    ->cc($cc)
                    ->send(new SendTimeSheetMail($path, $originalFileName));

                Log::info('Email sent successfully to ' . $to);
            } else {
                Log::warning('File not found: ' . $path);
            }
        } catch (\Exception $e) {
            // Log the error using different channels based on severity
            Log::error('Failed to send email: ' . $e->getMessage());
        }

        return 0;
    }
}
