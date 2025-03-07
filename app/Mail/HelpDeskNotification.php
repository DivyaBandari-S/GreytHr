<?php
// File Name                       : HelpDesk.php
// Description                     : This file contains the information about various IT requests related to the catalog.
//                                   It includes functionality for adding members to distribution lists and mailboxes, requesting IT accessories,
//                                   new ID cards, MMS accounts, new distribution lists, laptops, new mailboxes, and DevOps access.
// Creator                         : Ashannagari Archana
// Email                           : archanaashannagari@gmail.com
// Organization                    : PayG.
// Date                            : 2023-09-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : HelpDesk,EmployeeDetails
namespace App\Mail;

use App\Models\EmployeeDetails;
use App\Models\HelpDesks;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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
        $this->RequestId = $helpDesk->request_id; // Fetch directly from the passed model
    
        $this->requestCreatedBy = EmployeeDetails::where('emp_id', $helpDesk->emp_id)->first();
    
        if ($this->requestCreatedBy) {
            $this->createdbyFirstName = $this->requestCreatedBy->first_name;
            $this->createdbyLastName = $this->requestCreatedBy->last_name;
            $this->employeeId = $this->requestCreatedBy->emp_id;
        } else {
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
        // Ensure $this->RequestId is used instead of $RequestId (which is not defined in the method scope)
        return $this->subject('Request ' . $this->RequestId . ' created by ' . $this->createdbyFirstName . ' ' . $this->createdbyLastName)
                    ->view('emails.helpdesk-notification')
                    ->with([
                        'RequestId' => $this->RequestId,
                        'createdbyFirstName' => $this->createdbyFirstName,
                        'createdbyLastName' => $this->createdbyLastName,
                        'employeeId' => $this->employeeId,
                        'firstName' => $this->firstName,
                        'lastName' => $this->lastName,
                        'helpDesk' => $this->helpDesk,
                    ]);
    }
    
    public function content(): Content
    {
        return new Content(
            view: 'emails.helpdesk-notification',
        );
    }
 
}

 

