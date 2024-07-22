<?php
// File Name                       : ViewPendingDetails.php
// Description                     : This file contains the implementation displaying details of approved leaves and it will appear only for manager after approving leaves
// Creator                         : Bandari Divya
// Email                           : bandaridivya1@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : EmployeeDetails,LeaveRequest
namespace App\Livewire;

use App\Models\LeaveRequest;
use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use PDOException;

class ViewPendingDetails extends Component
{
    public $employeeDetails = [];
    public $employeeId;
    public $leaveRequests;
    public $count;
    public $applying_to = [];
    public $matchingLeaveApplications = [];
    public $leaveRequest;
    public $leaveApplications;
    public $selectedYear;


    public function mount()
    {
        try {
            //for year selection
            $this->selectedYear = Carbon::now()->format('Y');
            //login employee id
            $employeeId = auth()->guard('emp')->user()->emp_id;
            //fetching pending leave requests
            $this->leaveRequests = LeaveRequest::where('leave_applications.status', 'pending')
                ->where(function ($query) use ($employeeId) {
                    $query->whereJsonContains('applying_to', [['manager_id' => $employeeId]])
                        ->orWhereJsonContains('cc_to', [['emp_id' => $employeeId]]);
                })
                ->join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
                ->orderBy('created_at', 'desc')
                ->get(['leave_applications.*', 'employee_details.image', 'employee_details.first_name', 'employee_details.last_name']);

            $matchingLeaveApplications = [];

            //foreach to get leave balance and leave requests
            foreach ($this->leaveRequests as $leaveRequest) {
                $leaveRequest->from_date = Carbon::parse($leaveRequest->from_date);
                $leaveRequest->to_date = Carbon::parse($leaveRequest->to_date);

                $applyingToJson = trim($leaveRequest->applying_to);
                $applyingArray = is_array($applyingToJson) ? $applyingToJson : json_decode($applyingToJson, true);

                $ccToJson = trim($leaveRequest->cc_to);
                $ccArray = is_array($ccToJson) ? $ccToJson : json_decode($ccToJson, true);

                $isManagerInApplyingTo = isset($applyingArray[0]['manager_id']) && $applyingArray[0]['manager_id'] == $employeeId;
                $isEmpInCcTo = isset($ccArray[0]['emp_id']) && $ccArray[0]['emp_id'] == $employeeId;

                if ($isManagerInApplyingTo || $isEmpInCcTo) {
                    $leaveBalances = LeaveBalances::getLeaveBalances($leaveRequest->emp_id, $this->selectedYear);

                    // Check if the from_date year is equal to the current year
                    $fromDateYear = Carbon::parse($leaveRequest->from_date)->format('Y');

                    if ($fromDateYear == $this->selectedYear) {
                        // Get leave balance for the current year only
                        $leaveBalances = LeaveBalances::getLeaveBalances($leaveRequest->emp_id, $this->selectedYear);
                    } else {
                        // If from_date year is not equal to the current year, set leave balance to 0
                        $leaveBalances = 0;
                    }

                    $matchingLeaveApplications[] = [
                        'leaveRequest' => $leaveRequest,
                        'leaveBalances' => $leaveBalances,
                    ];
                }
            }

            $this->leaveApplications = $matchingLeaveApplications;
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle query execution errors
            Log::error('A database query error occurred: ' . $e->getMessage());
            session()->flash('error', 'Error while getting the data. Please try again.');
        } catch (PDOException $e) {
            // Handle connection errors
            Log::error('Database connection error occurred: ' . $e->getMessage());
            session()->flash('error', 'Connection error . Please try again.');
        } catch (\Exception $e) {
            // Handle any other unexpected errors
            Log::error('An unexpected error occurred: ' . $e->getMessage());
            session()->flash('error', 'Connection error . Please try again.');
        }
    }


    // Check if there are pending leave requests
    public function hasPendingLeave()
    {
        try {
            // Check if there are pending leave requests
            return $this->leaveRequests->where('status', 'pending')->isNotEmpty();
        } catch (\Exception $e) {
            Log::error('An error occurred win hasPendingLeave: ' . $e->getMessage());
            session()->flash('error', 'Error while getting leave application. Please try again.');
        }
    }

    //calcilate number of days in a leave application
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
        // You might need to customize this based on your actual session values
        return (int) str_replace('Session ', '', $session);
    }


    //This method used to approve leave application by manager
    public function approveLeave($index)
    {
        try {
            // Find the leave request by ID
            $leaveRequest = $this->leaveApplications[$index]['leaveRequest'];

            // Calculate the difference in days from the created date to now
            $createdDate = Carbon::parse($leaveRequest->created_at);
            $daysSinceCreation = $createdDate->diffInDays(Carbon::now());

            // Check if status is already approved
            if ($leaveRequest->status === 'approved') {
                session()->flash('message', 'Leave application is already approved.');
            } else {
                // Check if days since creation is more than 3 days or status is not yet approved
                if ($daysSinceCreation > 3 || $leaveRequest->status !== 'approved') {
                    // Update status to 'approved'
                    $leaveRequest->status = 'approved';
                    $leaveRequest->save();
                    $leaveRequest->touch(); // Update timestamps

                    session()->flash('message', 'Leave application approved successfully.');
                } else {
                    session()->flash('error', 'Leave application must be at least 3 days old or manually approved by a manager.');
                }
            }

            $this->reset();

            return redirect()->to('/employees-review');
        } catch (\Exception $e) {
            // Handle the exception
            Log::error('Error approving leave: ' . $e->getMessage());
            session()->flash('error', 'Failed to approve leave application. Please try again.');

            return redirect()->back(); // Redirect back to the previous page
        }
    }

    //this to reject the leave
    public function rejectLeave($index)
    {
        try {
            // Find the leave request by ID
            $leaveRequest = $this->leaveApplications[$index]['leaveRequest'];

            // Update status to 'rejected'
            $leaveRequest->status = 'rejected';
            $leaveRequest->save();
            $leaveRequest->touch();
            $this->reset();
            session()->flash('message', 'Leave application rejected.');
            return redirect()->to('/employees-review');
        } catch (\Exception $e) {
            // Log the error
            Log::error($e);

            // Flash a message to the session
            session()->flash('error_message', 'An error occurred while rejecting leave application.');

            // Redirect back or to a specific route
            return redirect()->back();
        }
    }
}
