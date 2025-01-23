<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FeedbackNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $feedback;
    public $subjectText;

    /**
     * Create a new message instance.
     */
    public function __construct($feedback, $subjectText)
    {
        $this->feedback = $feedback;
        $this->subjectText = $subjectText;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectText, // Dynamic subject based on action
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.feedback_notification',
            with: [
                'feedbackMessage' => $this->feedback->feedback_message,
                'feedbackFrom' => ($this->feedback->feedbackFromEmployee->first_name . ' ' . $this->feedback->feedbackFromEmployee->last_name) ?? 'Unknown',
                'feedbackTo' => ($this->feedback->feedbackToEmployee->first_name . ' ' . $this->feedback->feedbackToEmployee->last_name) ?? 'Unknown',
                'feedbackTime' => $this->feedback->created_at->format('d M Y, H:i A'),
                'feedbackStatus' => $this->subjectText,
                'feedbackType' => $this->feedback->feedback_type, // Added feedback_type here
            ]
        );
    }
}
