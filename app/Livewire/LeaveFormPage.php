<?php

namespace App\Livewire;

use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class LeaveFormPage extends Component
{
    public $employeeDetails = [];
    public $employeeId;
    public $leaveRequests;
    public $leaveRequest;

    public $leavePendingRequest;
    public $leavePending, $combinedRequests;
    public $activeSection = 'applyButton'; // Main section
    public $activeSubSection = 'leave'; // Sub-section within 'applyButton'
    public $showRestricted = false;
    public $showLeave = false;
    public $showPending = false;
    public $showHistory = false;
    public $showLeaveCancel = false;
    public $showCompOff = false;
    public $showLeaveApply = true;

    public  $resShowinfoMessage = true;
    public  $resShowinfoButton = false;
    public $showAlert = false;


    public function toggleInfoRes()
    {
        $this->resShowinfoMessage = !$this->resShowinfoMessage;
        $this->resShowinfoButton = !$this->resShowinfoButton;
    }
    public function hideAlert()
    {
        $this->showAlert = false;
    }
    public  $compOffShowinfoMessage = true;
    public  $compOffShowinfoButton = false;
    public function toggleInfoCompOff()
    {
        $this->compOffShowinfoMessage = !$this->compOffShowinfoMessage;
        $this->compOffShowinfoButton = !$this->compOffShowinfoButton;
    }

    public function toggleSection($section)
    {
        // Manage the main section visibility
        $this->activeSection = $section;
        if ($section === 'applyButton') {
            $this->showLeaveApply = true;
        } else {
            $this->showLeaveApply = false;
        }
        $this->showPending = $section === 'pendingButton';
        if ($section === 'pendingButton') {
            $this->hasPendingLeave();
        } else {
            $this->showHistory = $section === 'historyButton';
            $this->getLeaveHistory();
        }
    }

    public function toggleSideSection($subSection)
    {
        // Manage sub-sections within the 'applyButton' section
        if ($this->activeSection === 'applyButton') {
            $this->activeSubSection = $subSection;
        }
    }
    public function mount()
    {
        $this->activeSection = request()->query('tab', 'applyButton');
        $this->toggleSection($this->activeSection);
        // Get the logged-in user's ID and company ID
        $this->hasPendingLeave();
    }


    public function hasPendingLeave()
    {
        try {
            // Fetch pending leave requests for the logged-in user and company
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->combinedRequests = LeaveRequest::where('emp_id', $employeeId)
                ->where(function ($query) {
                    $query->where('status', 'Pending')
                        ->orWhere(function ($query) {
                            $query->where('status', 'approved')
                                ->where('cancel_status', 'Pending Leave Cancel');
                        });
                })
                ->orderBy('created_at', 'desc')
                ->get();

            foreach ($this->combinedRequests as $leaveRequest) {
                $leaveRequest->from_date = Carbon::parse($leaveRequest->from_date);
                $leaveRequest->to_date = Carbon::parse($leaveRequest->to_date);

                // Check and decode file paths if not null
                if ($leaveRequest->file_paths) {
                    $fileDataArray = json_decode($leaveRequest->file_paths, true);

                    foreach ($fileDataArray as &$fileData) {
                        if (isset($fileData['data'])) {
                            $fileData['data'] = base64_decode($fileData['data']);
                        }
                    }

                    $leaveRequest->file_paths = $fileDataArray;
                }
            }
        } catch (\Exception $e) {
            // Handle the exception, log it, or display an error message
            Log::error('Error in hasPendingLeave method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while checking for pending leave requests. Please try again later.');
            return false; // or any other appropriate action
        }
    }
    public function getLeaveHistory()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            // Fetch all leave requests (pending, approved, rejected) for the logged-in user and company
            $this->leaveRequests = LeaveRequest::where('emp_id', $employeeId)
                ->where(function ($query) {
                    // Include records if status is in the given list, excluding those with 'Pending Leave Cancel' cancel_status when status is 'approved'
                    $query->where(function ($q) {
                        $q->whereIn('status', ['approved', 'rejected', 'withdrawn'])
                            ->where(function ($q) {
                                $q->where('status', '!=', 'approved')
                                    ->orWhere('cancel_status', '!=', 'Pending Leave Cancel');
                            });
                    })->orWhere(function ($q) {
                        $q->whereIn('cancel_status', ['approved', 'rejected', 'withdrawn'])
                            ->where('cancel_status', '!=', 'Pending Leave Cancel');
                    });
                })
                ->orderBy('created_at', 'desc')
                ->get();
            // Format the date properties
            foreach ($this->leaveRequests as $leaveRequest) {
                $leaveRequest->formatted_from_date = Carbon::parse($leaveRequest->from_date)->format('d-m-Y');
                $leaveRequest->formatted_to_date = Carbon::parse($leaveRequest->to_date)->format('d-m-Y');
            }
        } catch (\Exception $e) {
            // Handle the exception, log it, or display an error message
            Log::error('Error in hasPendingLeave method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while checking for leave requests. Please try again later.');
            return false; // or any other appropriate action
        }
    }

    //used to calculate number of days
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
            $leaveRequest->updated_at = now();
            $leaveRequest->save();
            $this->hasPendingLeave();
            session()->flash('cancelMessage', 'Leave application Withdrawn.');
            $this->showAlert = true;
            // Flash success message
        } catch (\Exception $e) {
            // Handle the exception, log it, or display an error message
            Log::error('Error canceling leave: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while canceling leave request. Please try again later.');
        }
    }

    public function cancelLeaveCancel($leaveRequestId)
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
            $leaveRequest->cancel_status = 'Withdrawn';
            $leaveRequest->save();
            $leaveRequest->touch();
            $this->hasPendingLeave();
            session()->flash('cancelMessage', 'Leave application Withdrawn.');
            $this->showAlert = true;
            // Flash success message
        } catch (\Exception $e) {
            // Handle the exception, log it, or display an error message
            Log::error('Error canceling leave: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while canceling leave request. Please try again later.');
        }
    }
    public function render()
    {
        return view('livewire.leave-form-page', [
            'combinedRequests' => $this->combinedRequests
        ]);
    }
}
