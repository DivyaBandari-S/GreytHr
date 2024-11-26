<?php

namespace App\Mail;

use App\Models\EmployeeDetails;
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
    public $firstName;
    public $lastName;
    public $RequestId;
    public $requestCreatedBy;
    public $recipient;
    public $createdbyLastName;
    public $createdbyFirstName;
    public $employeeId;
    /**
     * Create a new message instance.
     *
     * @param HelpDesks $helpDesk
     */
    public function __construct(HelpDesks $helpDesk, $firstName, $lastName)
    {
        
        $this->helpDesk = $helpDesk;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->RequestId = $this->helpDesk->request_id ;
        $this->requestCreatedBy = EmployeeDetails::where('emp_id', '=', $this->helpDesk->emp_id)->first();
        if ($this->requestCreatedBy) {
            // Access the first_name, last_name, and emp_id directly
            $this->createdbyFirstName = $this->requestCreatedBy->first_name;
            $this->createdbyLastName = $this->requestCreatedBy->last_name;
            $this->employeeId = $this->requestCreatedBy->emp_id;

        } else {
            // Handle not found scenario
            $this->createdbyFirstName = 'N/A';
            $this->createdbyLastName = 'N/A';
            $this->employeeId = 'N/A';
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Request Created' . $this->helpDesk->request_id . ' created by ' . $this->createdbyFirstName . ' ' . $this->createdbyLastName)
                    ->view('emails.helpdesk-notification');
    }
    public function content(): Content
    {
        return new Content(
            view: 'emails.helpdesk-notification',
        );
    }
 
}

 

