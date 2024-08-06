<?php

namespace App\Mail;

use App\Models\SentEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WeeklyDataEntries extends Mailable
{
    use Queueable, SerializesModels;
    public $filePath;
    public $fromAddress;
    public $subject;

    /**
     * Create a new message instance.
     */
    public function __construct($filePath, $fromAddress, $subject)
    {
        $this->filePath = $filePath;
        $this->fromAddress = $fromAddress;
        $this->subject = SentEmail::latest()->value('subject');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject // Set the subject dynamically
        );
    }
    /**
     * Get the message envelope.
     */

    public function build()
    {
        return $this->from($this->fromAddress)
            ->subject($this->subject)
            ->view('data-entry-content_view')
            ->attach($this->filePath, [
                'as' => 'data_entries.xlsx',
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'data-entry_view',
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
