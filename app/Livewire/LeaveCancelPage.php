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
    public $managerDetails;
    public $selectedManager = [];
    public $employee;
    public $showApplyingToContainer = false;
    public $show_reporting = false;
    public  $fullName;
    public $searchQuery = '';
    public $showCasualLeaveProbation;
    public $empManagerDetails, $selectedManagerDetails;
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
            $this->selectedYear = Carbon::now()->format('Y');
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employee = EmployeeDetails::where('emp_id', $employeeId)->first();
            if ($this->employee) {
                $managerId = $this->employee->manager_id;
                // Fetch the logged-in employee's manager details
                $managerDetails = EmployeeDetails::where('emp_id', $managerId)->first();
                if ($managerDetails) {
                    $fullName = ucfirst(strtolower($managerDetails->first_name)) . ' ' . ucfirst(strtolower($managerDetails->last_name));
                    $this->loginEmpManager = $fullName;
                    $this->selectedManagerDetails = $managerDetails;
                }
                // Determine if the dropdown option should be displayed
                $this->showCasualLeaveProbation = $this->employee && !$this->employee->probation_period && !$this->employee->confirmation_date;
            }
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
            $applying_to = EmployeeDetails::where('emp_id', $employeeId)->first();
            $this->ccRecipients = EmployeeDetails::where('company_id', $applying_to->company_id)
                ->where('emp_id', '!=', $employeeId) // Exclude the current user
                ->where(function ($query) {
                    $query
                        ->orWhere('first_name', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
                })
                ->groupBy('emp_id', 'image', 'gender')
                ->select(
                    'emp_id',
                    'gender',
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


    public function markAsLeaveCancel()
    {
        try {
            // Check if a leave request ID is set
            if (empty($this->selectedLeaveRequestId)) {
                throw new \Exception('No leave request selected.');
            }

            // Find the leave request by ID
            $leaveRequest = LeaveRequest::findOrFail($this->selectedLeaveRequestId);

            // Update all fields. This assumes you have a form or input that provides all the necessary fields.
            $leaveRequest->update([
                'category_type' => 'Leave Cancel',
                'status' => 'approved',
                'cancel_status' => 'Pending Leave Cancel',
            ]);

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
            $this->markAsLeaveCancel();
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
        $this->selectedYear = Carbon::now()->format('Y');
        $this->loginEmpManager = null;
        $this->selectedManager = $this->selectedManager ?? [];
        $managers = collect();
        $employeeId = auth()->guard('emp')->user()->emp_id;
        try {
            // Fetch details for the current employee
            $applying_to = EmployeeDetails::where('emp_id', $employeeId)->first();
            if ($applying_to) {
                $managerId = $applying_to->manager_id;
                // Fetch the logged-in employee's manager details
                $managerDetails = EmployeeDetails::where('emp_id', $managerId)->first();
                if ($managerDetails) {
                    $fullName = ucfirst(strtolower($managerDetails->first_name)) . ' ' . ucfirst(strtolower($managerDetails->last_name));
                    $this->loginEmpManager = $fullName;
                    $this->empManagerDetails = $managerDetails;

                    // Add the logged-in manager to the collection
                    $managers->push([
                        'full_name' => $fullName,
                        'emp_id' => $managerDetails->emp_id,
                        'gender' => $managerDetails->gender,
                        'image' => $managerDetails->image,
                    ]);
                }
            }

            // Fetch employees with job roles CTO and Chairman
            $jobRoles = ['CTO', 'Chairman'];
            $filteredManagers = EmployeeDetails::whereIn('job_role', $jobRoles)
                ->where(function ($query) {
                    // Apply search functionality
                    if ($this->searchQuery) {
                        $query->whereRaw('CONCAT(first_name, " ", last_name) LIKE ?', ["%{$this->searchQuery}%"]);
                    }
                })
                ->get(['first_name', 'last_name', 'emp_id', 'gender', 'image']);

            // Add the filtered managers to the collection
            $managers = $managers->merge(
                $filteredManagers->map(function ($manager) {
                    $fullName = ucfirst(strtolower($manager->first_name)) . ' ' . ucfirst(strtolower($manager->last_name));
                    return [
                        'full_name' => $fullName,
                        'emp_id' => $manager->emp_id,
                        'gender' => $manager->gender,
                        'image' => $manager->image,
                    ];
                })
            );
        } catch (\Exception $e) {
            Log::error('Error fetching employee or manager details: ' . $e->getMessage());
        }
        $this->cancelLeaveRequests = LeaveRequest::where('emp_id', $employeeId)
            ->where('status', 'approved')
            ->where('from_date', '>=', now()->subMonths(2))
            ->where('category_type', 'Leave')
            ->with('employee')
            ->get();
        return view('livewire.leave-cancel-page', [
            'cancelLeaveRequests' => $this->cancelLeaveRequests,
            'empManagerDetails' => $this->empManagerDetails,
            'selectedManagerDetails' => $this->selectedManagerDetails,
            'loginEmpManager' => $this->loginEmpManager,
            'managers' => $managers,
            'ccRecipients' => $this->ccRecipients,
            'showCasualLeaveProbation' => $this->showCasualLeaveProbation
        ]);
    }
}
