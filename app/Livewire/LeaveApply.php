<?php
// File Name                       : LeaveApply.php
// Description                     : This file contains the implementation of Applying for a leave
// Creator                         : Bandari Divya
// Email                           : bandaridivya1@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : LeaveRequest,EmployeeDetails.
namespace App\Livewire;

use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\LeaveRequest;
use App\Models\Notification;
use App\Models\EmployeeDetails;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Mail\LeaveApplicationNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LeaveApply extends Component
{
    use WithFileUploads, WithPagination;

    public $leave_type;
    public $emp_id;
    public $from_date;
    public $from_session = 'Session 1';
    public $to_session = 'Session 2';
    public $to_date;
    public $applying_to;
    public $contact_details;
    public $reason;
    public $reportTo;
    public $report_to;
    public $managerId;
    public $employeeId;
    public $file_paths;
    public $filePaths = [];
    public $defaultApplyingTo;
    public $cc_to;
    public $searchTerm = '';
    public $selectedEmployeeNames = [];
    public $selectedPeople = [];
    public $selectedManager = [];
    public $first_name;
    public $employeeDetails = [];
    public $ccRecipients = [];
    public $applyingToDetails = [];
    public $files = [];
    public $filteredEmployees = [];
    public $has;
    public $isOpen = false;
    public $leaveDetails;
    private $createdLeaveRequest;
    private $dynamicFromAddress;
    public $items = [];
    public $selectedItems = [];
    public $managerFullName;
    public $loginEmpManagerId;
    public $filteredCcRecipients;
    public $loginEmpManager;
    public $errorMessage = '';
    public $filter = '';
    public $selectedYear;
    public $leaveBalances = [];
    public $showCcRecipents = false;

    public $show_reporting = false;
    public $showApplyingTo = true;
    public $showNumberOfDays = false;
    public $showApplyingToContainer = false;
    public $fromDate;
    public $fromSession;
    public $toSession;
    public $toDate;
    public $calculatedNumberOfDays = 0;
    public $loginEmpManagerProfile;
    public $differenceInMonths;
    public $probationDetails;
    public $managerDetails;
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


    public function validateField($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        try {
            $this->searchTerm = '';
            $this->filter = '';
            $this->selectedYear = Carbon::now()->format('Y');
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->applying_to = EmployeeDetails::where('emp_id', $employeeId)->first();
            $this->probationDetails = EmployeeDetails::where('emp_id', $employeeId)->get();
            foreach ($this->probationDetails as $employee) {
                if ($employee->hire_date) {
                    $hireDate = Carbon::parse($employee->hire_date);
                    $this->differenceInMonths = $hireDate->diffInMonths(Carbon::now());
                }
            }
            if ($this->applying_to) {
                $this->loginEmpManagerId = $this->applying_to->manager_id;
                // Retrieve the corresponding employee details for the manager
                $managerDetails = EmployeeDetails::where('emp_id', $this->loginEmpManagerId)->first();

                if ($managerDetails) {
                    // Concatenate first_name and last_name to create the full name
                    $fullName = ucfirst(strtolower($managerDetails->first_name)) . ' ' . ucfirst(strtolower($managerDetails->last_name));
                    // Assign the full name to a property for later use
                    $this->loginEmpManager = $fullName;
                    $this->loginEmpManagerProfile = $managerDetails->image;
                } else {
                    $this->loginEmpManager = $this->applying_to->report_to;
                }
            }
            $this->searchEmployees();
            $this->searchCCRecipients();
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in mount method: ' . $e->getMessage());
            // Display a friendly error message to the user
            session()->flash('error', 'An error occurred while loading leave apply page. Please try again later.');
            // Redirect the user to a safe location
            return redirect()->back();
        }
    }

    // this method to get managers
    public function searchEmployees()
    {
        try {
            // Fetch employees based on the search term
            $this->employeeDetails = EmployeeDetails::where('company_id', $this->applying_to->company_id)
                ->where(function ($query) {
                    $query->where('company_name', 'like', '%' . $this->searchTerm . '%')
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
                // Retrieve employee details based on manager_id
                $employeeDetails = EmployeeDetails::where('emp_id', $employee->manager_id)->first();

                // Check if employee details exist and concatenate first name and last name
                if ($employeeDetails) {
                    $fullName = ucwords(strtolower($employeeDetails->first_name)) . ' ' . ucwords(strtolower($employeeDetails->last_name));
                    $managers[] = [
                        'emp_id' => $employeeDetails->emp_id,
                        'image' => $employeeDetails->image,
                        'full_name' => $fullName
                    ];
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


    //this method used to filter cc recipients from employee details
    public function searchCCRecipients()
    {
        try {
            // Fetch employees based on the search term for CC To
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->ccRecipients = EmployeeDetails::where('company_id', $this->applying_to->company_id)
                ->where('emp_id', '!=', $employeeId) // Exclude the current user
                ->where(function ($query) {
                    $query->where('company_name', 'like', '%' . $this->searchTerm . '%')
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
    public $selectedCcTo = [];
    public $selectedCCEmployees = [];

    public function toggleSelection($empId)
    {
        if (isset($this->selectedPeople[$empId])) {
            unset($this->selectedPeople[$empId]);
        } else {
            $this->selectedPeople[$empId] = true;
        }
        $this->searchCCRecipients();
        $this->fetchEmployeeDetails();
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
    public function handleCheckboxChange($empId)
    {
        if (isset($this->selectedPeople[$empId])) {
            // If the checkbox is unchecked, remove from CC
            $this->removeFromCcTo($empId);
        } else {
            // If the checkbox is checked, add to CC
            $this->selectedPeople[$empId] = true;
        }
    }
    public function removeFromCcTo($empId)
    {
        // Remove the employee from selectedCcTo array
        $this->selectedCcTo = array_values(array_filter($this->selectedCcTo, function ($recipient) use ($empId) {
            return $recipient['emp_id'] != $empId;
        }));

        // Update cc_to field with selectedCcTo (comma-separated string of emp_ids)
        $this->cc_to = implode(',', array_column($this->selectedCcTo, 'emp_id'));

        // Toggle selection state in selectedPeople
        unset($this->selectedPeople[$empId]);

        // Fetch updated employee details
        $this->fetchEmployeeDetails();
        $this->searchCCRecipients();
    }


    //this method will handle the search functionality
    public function handleSearch($type)
    {
        try {
            if ($type === 'employees') {
                $this->searchEmployees();
            } elseif ($type === 'ccRecipients') {
                $this->searchCCRecipients();
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in handleSearch method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while handling the search. Please try again later.');
        }
    }

    public function applyingTo()
    {
        $this->showApplyingToContainer = !$this->showApplyingToContainer;
        $this->show_reporting = true;
        $this->showApplyingTo = false;
    }


    //this method used to open the ccto container
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

    //it will update the number of days in leave apply page
    public function handleFieldUpdate($field)
    {
        try {
            $this->showNumberOfDays = true;
            if ($field == 'from_date' || $field == 'to_date' || $field == 'from_session' || $field == 'to_session') {
                $this->calculateNumberOfDays($this->fromDate, $this->fromSession, $this->toDate, $this->toSession);
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in handleFieldUpdate method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while handling field update. Please try again later.');
        }
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

    //selected applying to manager details
    public function toggleManager($empId)
    {
        // Select the manager only if it is not already selected
        if (!in_array($empId, $this->selectedManager)) {
            $this->selectedManager = [$empId];

            // Fetch details for the selected manager
            $this->fetchManagerDetails($empId);
        }

        // Ensure showApplyingToContainer remains false
        $this->showApplyingToContainer = false;
    }


    // Method to fetch manager details
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

    //method to apply for a leave
    public function leaveApply()
    {
        $this->validate();

        try {
            $this->selectleave();

            // Check for overlapping leave
            $overlappingLeave = LeaveRequest::where('emp_id', auth()->guard('emp')->user()->emp_id)
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('from_date', '<=', $this->from_date)
                            ->where('to_date', '>=', $this->from_date);
                    })->orWhere(function ($q) {
                        $q->where('from_date', '<=', $this->to_date)
                            ->where('to_date', '>=', $this->to_date);
                    })->orWhere(function ($q) {
                        $q->where('from_date', '>=', $this->from_date)
                            ->where('to_date', '<=', $this->to_date);
                    });
                })
                ->whereIn('status', ['approved', 'pending'])
                ->exists();

            // If overlapping leave is found, set the error message
            if ($overlappingLeave) {
                $this->errorMessage = 'The selected leave dates overlap with an existing leave application.';
                return;
            }
            //to check validation for fromdate to todate
            if ($this->to_date < $this->from_date) {
                $this->errorMessage = 'To date must be greater than or equal to from date.';
                return redirect()->back()->withInput();
            }

            $filePaths = [];

            if (isset($this->files)) {
                foreach ($this->files as $file) {
                    $fileName = uniqid() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/help-desk-files', $fileName);
                    $filePaths[] = 'help-desk-files/' . $fileName;
                }
            }

            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
            $ccToDetails = [];
            foreach ($this->selectedCCEmployees as $selectedEmployeeId) {
                // Check if the employee ID already exists in ccToDetails
                $existingIds = array_column($ccToDetails, 'emp_id');

                if (!in_array($selectedEmployeeId, $existingIds)) {

                    // Fetch additional details from EmployeeDetails table
                    $employeeDetails = EmployeeDetails::where('emp_id', $selectedEmployeeId)->first();

                    // Concatenate first_name and last_name to get the full name
                    $fullName = $employeeDetails->first_name . ' ' . $employeeDetails->last_name;

                    $ccToDetails[] = [
                        'emp_id' => $selectedEmployeeId,
                        'full_name' => $fullName,
                    ];
                }
            }
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $applyingToDetails = [];

            if (empty($this->selectedManager)) {
                // No manager is selected, use default values
                $applyingToDetails[] = [
                    'manager_id' => $this->loginEmpManagerId,
                    'report_to' => $this->loginEmpManager,
                    'image' => $this->loginEmpManagerProfile
                ];
            } else {
                // Managers are selected, fetch details for each selected manager
                foreach ($this->selectedManager as $selectedManagerId) {
                    $employeeDetails = EmployeeDetails::where('emp_id', $selectedManagerId)->first();
                    if ($employeeDetails) {
                        $managerfullName = $employeeDetails->first_name . ' ' . $employeeDetails->last_name;
                        $applyingToDetails[] = [
                            'manager_id' => $selectedManagerId,
                            'report_to' =>  $managerfullName,
                        ];
                    }
                }
            }
            $this->createdLeaveRequest = LeaveRequest::create([
                'emp_id' => $employeeId,
                'leave_type' => $this->leave_type,
                'category_type' => 'Leave',
                'from_date' => $this->from_date,
                'from_session' => $this->from_session,
                'to_session' => $this->to_session,
                'to_date' => $this->to_date,
                'applying_to' => json_encode($applyingToDetails),
                'file_paths' => json_encode($filePaths),
                'cc_to' => json_encode($ccToDetails),
                'contact_details' => $this->contact_details,
                'reason' => $this->reason,
            ]);

            Notification::create([
                'emp_id' =>  $employeeId,
                'notification_type' => 'leave',
                'leave_type'=>$this->leave_type,
                'leave_reason'=>$this->reason,
                'applying_to'=> json_encode($applyingToDetails),
                'cc_to'=>json_encode($ccToDetails),
            ]);

            logger('LeaveRequest created successfully', ['leave_request' => $this->createdLeaveRequest]);
            // Check if emp_id is set on the $createdLeaveRequest object
            if ($this->createdLeaveRequest && $this->createdLeaveRequest->emp_id) {
                // Reset the component
                session()->flash('message', 'Leave application submitted successfully!');
                return redirect()->to('/leave-page');
            } else {
                // Log an error if there's an issue with creating the LeaveRequest
                logger('Error creating LeaveRequest', ['emp_id' => $employeeId]);
                session()->flash('error', 'Error submitting leave application. Please try again.');
                return redirect()->to('/leave-page');
            }
        } catch (\Exception $e) {
            if ($e instanceof \Illuminate\Database\QueryException) {
                // Handle database query exceptions
                Log::error("Database error submitting leave application: " . $e->getMessage());
                session()->flash('error', 'Database error occurred. Please try again later.');
            } elseif (strpos($e->getMessage(), 'Call to a member function store() on null') !== false) {
                // Display a user-friendly error message for null image
                session()->flash('error', 'Please upload an image.');
            } elseif ($e instanceof \Illuminate\Http\Client\RequestException) {
                // Handle network request exceptions
                Log::error("Network error submitting leave application: " . $e->getMessage());
                session()->flash('error', 'Network error occurred. Please try again later.');
            } elseif ($e instanceof \PDOException) {
                // Handle database connection errors
                Log::error("Database connection error submitting leave application: " . $e->getMessage());
                session()->flash('error', 'Database connection error. Please try again later.');
            } else {
                // Handle other generic exceptions
                Log::error("Error submitting leave application: " . $e->getMessage());
                session()->flash('error', 'Failed to submit leave application. Please try again later.');
            }
            // Redirect the user back to the leave application page
        }
    }
    public function cancelLeaveApplication()
    {
        Log::info('Before reset:');
        Log::info($this->reason); // Log current values before reset

        // Reset properties
        $this->leave_type = '';
        $this->from_date = '';
        $this->to_date = '';
        $this->selectedManager = [];
        $this->selectedPeople = [];
        $this->files = '';
        $this->contact_details = '';
        $this->reason = '';

        Log::info('After reset:');
        Log::info($this->reason);
    }

    public function handleEnterKey()
    {
        $this->searchCCRecipients();
    }



    public function selectLeave()
    {
        try {
            $this->show_reporting = $this->leave_type !== 'default';
            $this->showApplyingTo = false;
            $this->selectedYear = Carbon::now()->format('Y');
            $employeeId = auth()->guard('emp')->user()->emp_id;
            // Retrieve all leave balances
            $allLeaveBalances = LeaveBalances::getLeaveBalances($employeeId, $this->selectedYear);
            // Filter leave balances based on the selected leave type
            switch ($this->leave_type) {
                case 'Casual Leave Probation':
                    $this->leaveBalances = [
                        'casualProbationLeaveBalance' => $allLeaveBalances['casualProbationLeaveBalance']
                    ];
                    break;
                case 'Casual Leave':
                    $this->leaveBalances = [
                        'casualLeaveBalance' => $allLeaveBalances['casualLeaveBalance']
                    ];
                    break;
                case 'Loss of Pay':
                    $this->leaveBalances = [
                        'lossOfPayBalance' => $allLeaveBalances['lossOfPayBalance']
                    ];
                    break;
                case 'Sick Leave':
                    $this->leaveBalances = [
                        'sickLeaveBalance' => $allLeaveBalances['sickLeaveBalance']
                    ];
                    break;
                case 'Maternity Leave':
                    $this->leaveBalances = [
                        'maternityLeaveBalance' => $allLeaveBalances['maternityLeaveBalance']
                    ];
                    break;
                case 'Paternity Leave':
                    $this->leaveBalances = [
                        'paternityLeaveBalance' => $allLeaveBalances['paternityLeaveBalance']
                    ];
                    break;
                case 'Marriage Leave':
                    $this->leaveBalances = [
                        'marriageLeaveBalance' => $allLeaveBalances['marriageLeaveBalance']
                    ];
                    break;
                default:
                    $this->leaveBalances = [];
                    break;
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error("Error selecting leave: " . $e->getMessage());
            // Flash an error message to the user
            session()->flash('error', 'An error occurred while selecting leave and leave balance. Please try again later.');
            // Redirect the user back
            return redirect()->back();
        }
    }
    public  $showinfoMessage = true;
    public  $showinfoButton = false;
    public function toggleInfo()
    {
        $this->showinfoMessage = !$this->showinfoMessage;
        $this->showinfoButton = !$this->showinfoButton;
    }
    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $employeeGender = EmployeeDetails::where('emp_id', $employeeId)->select('gender')->first();
        return view('livewire.leave-apply', [
            'employeeGender' => $employeeGender,
            'calculatedNumberOfDays' => $this->calculatedNumberOfDays
        ]);
    }
}
