<?php

namespace App\Mail;

use App\Models\EmployeeDetails;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveApprovalNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $leaveRequest;
    public $employeeDetails;
    public $applyingToDetails;
    public $ccToDetails;
    public $cancelStatus;
    public $leaveCategory;
    public $forMainRecipient;

    public function __construct($leaveRequest, $applyingToDetails, $ccToDetails, $forMainRecipient = true)
    {
        $this->leaveRequest = $leaveRequest;
        $this->applyingToDetails = $applyingToDetails;
        $this->ccToDetails = $ccToDetails;
        $this->forMainRecipient = $forMainRecipient;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $leaveRequest->emp_id)->first();
    }

    /**
     * Get the message envelope.
     */

    public function build()
    {
        // Calculate number of days before passing to the view
        $numberOfDays = $this->calculateNumberOfDays(
            $this->leaveRequest->from_date,
            $this->leaveRequest->from_session,
            $this->leaveRequest->to_date,
            $this->leaveRequest->to_session,
            $this->leaveRequest->leave_type
        );
        // Different subject for main recipient and CC recipients


        return $this->subject('Leave')
            ->view('mails.leave_approval_notification') // Create a view for the email
            ->with([
                'leaveRequest' => $this->leaveRequest,
                'employeeDetails' => $this->employeeDetails,
                'numberOfDays' => $numberOfDays,
                'leave_status' => $this->leaveRequest->leave_status,
                'leaveCategory' => $this->leaveRequest->category_type,
                'cancelStatus' => $this->leaveRequest->cancel_status,
                'forMainRecipient' => $this->forMainRecipient,
            ]);
    }
    public function envelope(): Envelope
    {
        // Define the status mapping
        $statusMap = [
            2 => 'Approved',
            3 => 'Rejected',
            4 => 'Withdrawn',
            5 => 'Pending',
            6 => 'Re-applied',
            7 => 'Pending Leave Cancel'
        ];

        // Get the leave status text using the mapping
        $leaveStatusText = $statusMap[$this->leaveRequest->leave_status] ?? 'Unknown';

        // Determine the subject based on the recipient type
        $subject = $this->forMainRecipient
            ? 'Your leave application has been ' . ucfirst($leaveStatusText)
            : $this->employeeDetails->first_name . ' [' . $this->employeeDetails->emp_id . '] leave application has been ' . ucfirst($leaveStatusText);

        return new Envelope(
            subject: $subject,
        );
    }


    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.leave_approval_notification',
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
    public function calculateNumberOfDays($fromDate, $fromSession, $toDate, $toSession, $leaveType)
    {
        try {
            $startDate = Carbon::parse($fromDate);
            $endDate = Carbon::parse($toDate);

            // Check if the start or end date is a weekend
            if ($startDate->isWeekend() || $endDate->isWeekend()) {
                return 0;
            }

            // Check if the start and end sessions are different on the same day
            if (
                $startDate->isSameDay($endDate) &&
                $this->getSessionNumber($fromSession) === $this->getSessionNumber($toSession)
            ) {
                // Inner condition to check if both start and end dates are weekdays
                if (!$startDate->isWeekend() && !$endDate->isWeekend()) {
                    return 0.5;
                } else {
                    // If either start or end date is a weekend, return 0
                    return 0;
                }
            }

            if (
                $startDate->isSameDay($endDate) &&
                $this->getSessionNumber($fromSession) !== $this->getSessionNumber($toSession)
            ) {
                // Inner condition to check if both start and end dates are weekdays
                if (!$startDate->isWeekend() && !$endDate->isWeekend()) {
                    return 1;
                } else {
                    // If either start or end date is a weekend, return 0
                    return 0;
                }
            }

            $totalDays = 0;

            while ($startDate->lte($endDate)) {
                if ($leaveType == 'Sick Leave') {
                    $totalDays += 1;
                } else {
                    if ($startDate->isWeekday()) {
                        $totalDays += 1;
                    }
                }
                // Move to the next day
                $startDate->addDay();
            }

            // Deduct weekends based on the session numbers
            if ($this->getSessionNumber($fromSession) > 1) {
                $totalDays -= $this->getSessionNumber($fromSession) - 1; // Deduct days for the starting session
            }
            if ($this->getSessionNumber($toSession) < 2) {
                $totalDays -= 2 - $this->getSessionNumber($toSession); // Deduct days for the ending session
            }
            // Adjust for half days
            if ($this->getSessionNumber($fromSession) === $this->getSessionNumber($toSession)) {
                // If start and end sessions are the same, check if the session is not 1
                if ($this->getSessionNumber($fromSession) !== 1) {
                    $totalDays += 0.5; // Add half a day
                } else {
                    $totalDays += 0.5;
                }
            } elseif ($this->getSessionNumber($fromSession) !== $this->getSessionNumber($toSession)) {
                if ($this->getSessionNumber($fromSession) !== 1) {
                    $totalDays += 1; // Add half a day
                }
            } else {
                $totalDays += ($this->getSessionNumber($toSession) - $this->getSessionNumber($fromSession) + 1) * 0.5;
            }

            return $totalDays;
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    private function getSessionNumber($session)
    {
        return (int) str_replace('Session ', '', $session);
    }
}
