<?php

namespace App\Mail;

use App\Models\HelpDesks;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HelpDeskNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */use Queueable, SerializesModels;

    public $helpDesk;

    /**
     * Create a new message instance.
     *
     * @param HelpDesks $helpDesk
     */
    public function __construct(HelpDesks $helpDesk)
    {
        $this->helpDesk = $helpDesk;
   
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Request Created')
                    ->view('emails.helpdesk-notification');
    }
    public function content(): Content
    {
        return new Content(
            view: 'emails.helpdesk-notification',
        );
    }
 
}

 

