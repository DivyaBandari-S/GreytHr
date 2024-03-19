<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $recipientName,$company,$jobPosition,$startDate,$salary,$fromAddress,$senderName,$signature,$contactPhone,$informDate;

    public function __construct($fromAddress,$senderName,$signature,$recipientName,$company,$jobPosition,$startDate,$salary,$informDate,$contactPhone)
    {
        $this->recipientName = $recipientName;
        $this->company = $company;
        $this->jobPosition = $jobPosition;
        $this->startDate = $startDate;
        $this->salary =$salary;
        $this->fromAddress =$fromAddress;
        $this->senderName =$senderName;
        $this->signature =$signature;
        $this->informDate =$informDate;
        $this->contactPhone =$contactPhone;
    }

    public function build()
    {
        return $this->view('emails.job-invitation')
            ->subject($this->company);
    }
}
