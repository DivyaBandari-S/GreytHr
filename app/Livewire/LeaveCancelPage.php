<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class LeaveCancelPage extends Component
{
    public $cancelLeaveRequests;
    public $selectedLeaveRequestId;
    public  $showinfoMessage = true;
    public  $showinfoButton = false;
    public $showCcRecipents = false;
    public $ccRecipients = [];
    public $selectedCCEmployees = [];
    public $searchTerm = '';
    public $filter = '';
    public $applying_to;
    public $selectedYear;
    public $loginEmpManagerId;
    public $loginEmpManager;
    public $loginEmpManagerProfile;
    public $managerFullName;
    public $employeeDetails = [];
    public $leaveRequestDetails;
    public $applyingToDetails = [];
    public $managerDetails = [];
    public $selectedManager = [];

    public $showApplyingToContainer = false;
    public $show_reporting = false;
    public $showApplyingTo = false;
    protected $rules = [
        'leave_type' => 'required',
        'from_date' => 'required|date',
        'from_session' => 'required',
        'to_date' => 'required|date',
        'to_session' => 'required',
        'contact_details' => 'required',
        'reason' => 'required',
        'files.*' => 'nullable|file|max:10240',
    ];

    protected $messages = [
        'leave_type.required' => 'Leave type is required',
        'from_date.required' => 'From date is required',
        'from_session.required' => 'Session is required',
        'to_date.required' => 'To date is required',
        'to_session.required' => 'Session is required',
        'contact_details.required' => 'Contact details are required',
        'reason.required' => 'Reason is required',
        'files.*.file' => 'Each file must be a valid file',
        'files.*.max' => 'Each file must not exceed 10MB in size',
    ];


    public function mount()
    {
        try {
            $this->searchTerm = '';
            $this->filter = '';
            $this->selectedYear = Carbon::now()->format('Y');
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->applying_to = EmployeeDetails::where('emp_id', $employeeId)->first();
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in mount method: ' . $e->getMessage());
            // Display a friendly error message to the user
            session()->flash('error', 'An error occurred while loading leave apply page. Please try again later.');
            // Redirect the user to a safe location
            return redirect()->back();
        }
    }
    public function validateField($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function fetchEmployeeDetails()
    {
        // Reset the list of selected employees
        $this->selectedCCEmployees = [];

        // Fetch details for selected employees
        foreach ($this->selectedPeople as $empId => $selected) {
            $employee = EmployeeDetails::where('emp_id', $empId)->first();

            if ($employee) {
                // Calculate initials
                $firstNameInitial = strtoupper(substr($employee->first_name, 0, 1));
                $lastNameInitial = strtoupper(substr($employee->last_name, 0, 1));
                $initials = $firstNameInitial . $lastNameInitial;

                // Add to selectedEmployees array
                $this->selectedCCEmployees[] = [
                    'emp_id' => $empId,
                    'first_name' => $employee->first_name,
                    'last_name' => $employee->last_name,
                    'initials' => $initials,
                ];
            }
        }
    }
    public function openCcRecipientsContainer()
    {
        try {
            $this->showCcRecipents = true;
            $this->searchCCRecipients();
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in openCcRecipientsContainer method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while opening CC recipients container. Please try again later.');
        }
    }

    //this method will help to close the cc to container
    public function closeCcRecipientsContainer()
    {
        try {
            $this->showCcRecipents = !$this->showCcRecipents;
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in closeCcRecipientsContainer method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while closing CC recipients container. Please try again later.');
        }
    }
    public function searchCCRecipients()
    {
        try {
            // Fetch employees based on the search term for CC To
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->ccRecipients = EmployeeDetails::where('company_id', $this->applying_to->company_id)
                ->where('emp_id', '!=', $employeeId) // Exclude the current user
                ->where(function ($query) {
                    $query
                        ->orWhere('emp_id', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('first_name', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
                })
                ->groupBy('emp_id', 'image')
                ->select(
                    'emp_id',
                    'image',
                    DB::raw('MIN(CONCAT(first_name, " ", last_name)) as full_name')
                )
                ->orderBy('full_name')
                ->get();
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in searchCCRecipients method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while searching for CC recipients. Please try again later.');
        }
    }
    public function searchEmployees()
    {
        try {
            // Fetch employees based on the search term
            $this->employeeDetails = EmployeeDetails::where('company_id', $this->applying_to->company_id)
                ->where(function ($query) {
                    $query
                        ->orWhere('emp_id', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('first_name', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
                })
                ->select('manager_id')
                ->groupBy('manager_id')
                ->distinct()
                ->get();
            $managers = [];
            foreach ($this->employeeDetails as $employee) {
                if ($employee->manager_id) {
                    // Retrieve employee details based on manager_id
                    $managerDetails = EmployeeDetails::where('emp_id', $employee->manager_id)->get();
                    // Check if employee details exist and concatenate first name and last name
                    if ($managerDetails) {
                        $fullName = ucwords(strtolower($managerDetails->first_name)) . ' ' . ucwords(strtolower($employeeDetails->last_name));
                        $managers[] = [
                            'emp_id' => $managerDetails->emp_id,
                            'image' => $managerDetails->image,
                            'full_name' => $fullName
                        ];
                    }
                }
            }

            // Apply filtering based on $filter
            if (!empty($this->filter)) {
                $managers = array_filter($managers, function ($manager) {
                    return stripos($manager['full_name'], $this->filter) !== false;
                });
            }

            // Sort the managers by full name
            usort($managers, function ($a, $b) {
                return strcmp($a['full_name'], $b['full_name']);
            });

            $this->managerFullName = $managers;
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in searchEmployees method: ' . $e->getMessage());
            // Display a friendly error message to the user
            session()->flash('error', 'An error occurred while searching for employees. Please try again later.');
        }
    }
    public function toggleManager($empId)
    {
        if (!in_array($empId, $this->selectedManager)) {
            $this->selectedManager = [$empId];
            $this->fetchManagerDetails($empId);

            // Update the database with the selected manager ID for the particular leave request
            // Assuming you have a leave request ID and a LeaveRequest model
            $leaveRequest = LeaveRequest::find($this->leaveRequestId); // Make sure $this->leaveRequestId is set
            if ($leaveRequest) {
                $leaveRequest->manager_id = $empId;
                $leaveRequest->save();
            }
        }

        $this->showApplyingToContainer = false;
    }
    private function fetchManagerDetails($managerId)
    {
        $employeeDetails = EmployeeDetails::where('emp_id', $managerId)->first();

        if ($employeeDetails) {
            $this->loginEmpManagerProfile = $employeeDetails->image ? asset('storage/' . $employeeDetails->image) : null;
            $this->loginEmpManager = $employeeDetails->first_name . ' ' . $employeeDetails->last_name;
            $this->loginEmpManagerId = $employeeDetails->emp_id;
        } else {
            // Handle case if details are not found
            $this->resetManagerDetails(); // Reset to default values or show N/A
        }
    }

    // Method to reset manager details
    private function resetManagerDetails()
    {
        $this->loginEmpManagerProfile = null;
        $this->loginEmpManager = null;
        $this->loginEmpManagerId = null;
    }


    public function markAsLeaveCancel()
    {
        try {
            // Find the leave request by ID
            $leaveRequest = LeaveRequest::findOrFail($this->selectedLeaveRequestId);
            // Update the leave request status and category
            $leaveRequest->category_type = 'Leave Cancel';
            $leaveRequest->status = 'approved';
            $leaveRequest->cancel_status = 'Pending Leave Cancel';
            $leaveRequest->save();
            session()->flash('message', 'Applied request for leave cancel successfully.');
            $this->reset(); // Reset component state
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to mark leave request as cancel. Please try again.');
            Log::error('Error marking leave request as cancel: ' . $e->getMessage());
        }
    }

    public function toggleInfo()
    {
        $this->showinfoMessage = !$this->showinfoMessage;
        $this->showinfoButton = !$this->showinfoButton;
    }

    public  $LeaveShowinfoMessage = true;
    public  $LeaveShowinfoButton = false;
    public function toggleInfoLeave()
    {
        $this->LeaveShowinfoMessage = !$this->LeaveShowinfoMessage;
        $this->LeaveShowinfoButton = !$this->LeaveShowinfoButton;
    }

    //it will calculate number of days for leave application
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

    public function applyingTo($leaveRequestId)
    {
        $leaveRequest = LeaveRequest::find($leaveRequestId);

        if ($leaveRequest) {
            $this->selectedLeaveRequestId = $leaveRequestId;
            $this->leaveRequestDetails = $leaveRequest;

            // Decode JSON data from 'applying_to'
            $this->applyingToDetails = json_decode($leaveRequest->applying_to, true);

            // Extract manager details
            $this->managerDetails = !empty($this->applyingToDetails[0]) ? $this->applyingToDetails[0] : null;

            $this->showApplyingToContainer = false;
            $this->show_reporting = true;
            $this->showApplyingTo = false;
        } else {
            // Handle the case where the leave request is not found
            $this->leaveRequestDetails = null;
            $this->applyingToDetails = [];
            $this->managerDetails = null;
        }
    }
    public function toggleApplyingto()
    {
        $this->showApplyingToContainer = !$this->showApplyingToContainer;
    }

    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->cancelLeaveRequests = LeaveRequest::where('emp_id', $employeeId)
            ->where('status', 'approved')
            ->where('from_date', '>=', now()->subMonths(2))
            ->where('category_type', 'Leave')
            ->with('employee')
            ->get();
        return view('livewire.leave-cancel-page', [
            'cancelLeaveRequests' => $this->cancelLeaveRequests,
            'managerFullName' => $this->managerFullName
        ]);
    }
}
