<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DelegateAddedNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $addedBy;
    public $workflow;
    public $fromDate;
    public $toDate;
    public $delegateName;
    public function __construct( $addedBy,$workflow,$fromDate,$toDate,$delegateName)
    {
        $this->addedBy=$addedBy;
        $this->workflow=$workflow;
        $this->fromDate=$fromDate;
        $this->toDate=$toDate;
        $this->delegateName=$delegateName;

    }
    public function build()
    {
        return $this->subject('Delegate Added Notification')
            ->view('mails.delegate_added_notification') // Ensure this Blade view exists
            ->with([
                'addedBy' => $this->addedBy ,
                'workflow' => $this->workflow,
                'fromDate' => $this->fromDate,
                'toDate' => $this->toDate,
                'delegateName' => $this->delegateName,
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Delegate Added Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.delegate_added_notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
