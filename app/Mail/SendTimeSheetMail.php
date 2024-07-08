<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendTimeSheetMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $pathToFile;
    public $originalFileName;
    /**
     * Create a new message instance.
     */
    public function __construct($pathToFile, $originalFileName)
    {
        $this->pathToFile = $pathToFile;
        $this->originalFileName = $originalFileName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Time sheet updates',
        );
    }
    public function build()
    {
        return $this->view('mail-content')
                    ->attachFromStorageDisk('public', $this->pathToFile, $this->originalFileName)
                    ->with([
                        'originalFileName' => $this->originalFileName,
                    ]);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail-content',
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
