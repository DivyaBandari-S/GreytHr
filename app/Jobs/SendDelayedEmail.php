<?php

namespace App\Jobs;

use App\Mail\SendTimeSheetMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendDelayedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to;
    protected $cc;
    protected $pathToFile;
    protected $originalFileName;

    public function __construct($to, $cc, $pathToFile, $originalFileName)
    {
        $this->to = $to;
        $this->cc = $cc;
        $this->pathToFile = $pathToFile;
        $this->originalFileName = $originalFileName;
    }

    public function handle()
    {
        try {
            Mail::to($this->to)
                ->cc($this->cc)
                ->send(new SendTimeSheetMail($this->pathToFile, $this->originalFileName));
            
            Log::info('Email sent successfully to ' . $this->to);
        } catch (\Exception $e) {
            Log::error('Failed to send email: ' . $e->getMessage());
        }
    }
}
