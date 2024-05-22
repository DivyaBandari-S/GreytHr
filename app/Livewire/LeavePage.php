<?php
// File Name                       : LeaveHistory.php
// Description                     : This file contains the implementation of Applying leave,displaying pending leaves and history of leave applications
// Creator                         : Bandari Divya
// Email                           : bandaridivya1@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : LeaveRequest,EmployeeDetails
namespace App\Livewire;

use Livewire\Component;
use App\Models\LeaveRequest;
use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LeavePage extends Component
{
    public $employeeDetails = [];
    public $employeeId;
    public $leaveRequests;
    public $leaveRequest;

    public $leavePendingRequest;
    public $leavePending;
    public function mount()
    {
        // Get the logged-in user's ID and company ID
        $employeeId = auth()->guard('emp')->user()->emp_id;
        // Fetch all leave requests (pending, approved, rejected) for the logged-in user and company
        $this->leaveRequests = LeaveRequest::where('emp_id', $employeeId)
            ->whereIn('status', ['approved', 'rejected', 'Withdrawn'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch pending leave requests for the logged-in user and company
        $this->leavePending = LeaveRequest::where('emp_id', $employeeId)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        // Format the date properties
        foreach ($this->leaveRequests as $leaveRequest) {
            $leaveRequest->formatted_from_date = Carbon::parse($leaveRequest->from_date)->format('d-m-Y');
            $leaveRequest->formatted_to_date = Carbon::parse($leaveRequest->to_date)->format('d-m-Y');
        }

        foreach ($this->leavePending as $leaveRequest) {
            $leaveRequest->from_date = Carbon::parse($leaveRequest->from_date);
            $leaveRequest->to_date = Carbon::parse($leaveRequest->to_date);
        }
    }


    public function hasPendingLeave()
    {
        try {
            // Check if there are pending leave requests
            return $this->leaveRequests->where('status', 'pending')->isNotEmpty();
        } catch (\Exception $e) {
            // Handle the exception, log it, or display an error message
            Log::error('Error in hasPendingLeave method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while checking for pending leave requests. Please try again later.');
            return false; // or any other appropriate action
        }
    }

    //used to calculate number of days
    public  function calculateNumberOfDays($fromDate, $fromSession, $toDate, $toSession)
    {
        try {

            $startDate = Carbon::parse($fromDate);

            $endDate = Carbon::parse($toDate);
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
                // Check if it's a weekday (Monday to Friday)
                if ($startDate->isWeekday()) {
                    $totalDays += 1;
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

    //in this method we can withdraw applied leave application
    public function cancelLeave($leaveRequestId)
    {
        try {
            // Find the leave request by ID
            $leaveRequest = LeaveRequest::find($leaveRequestId);
            
            // Check if leave request exists
            if (!$leaveRequest) {
                throw new \Exception("Leave request not found.");
            }
            
            // Update status to 'Withdrawn'
            $leaveRequest->status = 'Withdrawn';
            $leaveRequest->save();
            $leaveRequest->touch();
            
            // Flash success message
            session()->flash('message', 'Leave application Withdrawn.');
        } catch (\Exception $e) {
            // Handle the exception, log it, or display an error message
            Log::error('Error canceling leave: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while canceling leave request. Please try again later.');
        }
        
        // Redirect back to leave page
        return redirect()->to('/leave-page');
    }


    public function render()
    {
        return view('livewire.leave-page');
    }
}
