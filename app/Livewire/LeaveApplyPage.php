<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\EmployeeLeaveBalances;
use App\Models\HolidayCalendar;
use App\Models\Hr;
use App\Models\LeaveRequest;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class LeaveApplyPage extends Component
{
    use WithFileUploads;
    public $leave_type, $employeeId;
    public $currentYear;

    public $searchQuery = '';
    public $emp_id;
    public $casualLeavePerYear;
    public $casualProbationLeavePerYear;
    public $marriageLeaves;
    public $maternityLeaves;
    public $paternityLeaves;
    public $sickLeavePerYear;
    public $lossOfPayPerYear;
    public $from_date;
    public $from_session = 'Session 1';
    public $to_session = 'Session 2';
    public $to_date;
    public $applying_to;
    public $contact_details;
    public $reason;
    public $selectedPeople = [];
    public  $showinfoMessage = true;
    public  $showinfoButton = false;
    public $showNumberOfDays = false;
    public $differenceInMonths;
    public $show_reporting = false;
    public $showApplyingTo = true;
    public $leaveBalances = [];
    public $selectedYear;
    public $createdLeaveRequest;
    public $calculatedNumberOfDays = 0;
    public $employeeDetails = [];
    public $showPopupMessage = false;
    public $numberOfDays;
    public $showApplyingToContainer = false;
    public $loginEmpManagerProfile;
    public $loginEmpManager;
    public $cc_to;
    public $showCcRecipents = false;
    public $loginEmpManagerId;
    public $employee;
    public $managerFullName = [];
    public $ccRecipients;
    public $selectedEmployee = [];
    public $selectedManager = [];

    public $searchTerm = '';
    public $filter = '';
    public $errorMessage = '';
    public $fromDate, $file_paths;
    public $fromSession;
    public $toSession;
    public $toDate;
    public $filePath;
    public $selectedCcTo = [];
    public $selectedCCEmployees = [];
    public $showerrorMessage = false;
    public $showCasualLeaveProbation, $showCasualLeaveProbationYear;
    public $showAlert = false;
    public function hideSuccessAlert()
    {
        $this->showAlert = false;
    }
    protected $rules = [
        'leave_type' => 'required',
        'from_date' => 'required|date',
        'from_session' => 'required',
        'to_date' => 'required|date',
        'to_session' => 'required',
        'contact_details' => 'required',
        'reason' => 'required',
    ];
    protected $messages = [
        'leave_type.required' => 'Leave type is required',
        'from_date.required' => 'From date is required',
        'from_session.required' => 'Session is required',
        'to_date.required' => 'To date is required',
        'to_session.required' => 'Session is required',
        'contact_details.required' => 'Contact details are required',
        'reason.required' => 'Reason is required',
    ];
    public function validateField($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function mount()
    {
        $this->searchTerm = '';
        $this->selectedYear = Carbon::now()->format('Y');
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employee = EmployeeDetails::where('emp_id', $employeeId)->first();
        if ($this->employee) {
            $managerId = $this->employee->manager_id;
            // Fetch the logged-in employee's manager details
            $managerDetails = EmployeeDetails::where('emp_id', $managerId)->first();

            if ($managerDetails) {
                // If manager details are found, format the full name
                $fullName = ucfirst(strtolower($managerDetails->first_name)) . ' ' . ucfirst(strtolower($managerDetails->last_name));
                $this->loginEmpManager = $fullName;
                $this->selectedManagerDetails = $managerDetails;
            } else {
                // If no manager is found, check if the managerId is null
                if (is_null($managerId)) {
                    // Get the company_id from the logged-in employee's details
                    $companyId = $this->employee->company_id;
                    // Fetch emp_ids from the HR table
                    $hrEmpIds = Hr::pluck('emp_id');
                    // Now, fetch employee details for these HR emp_ids
                    $hrManagers = EmployeeDetails::whereIn('emp_id', $hrEmpIds)
                        ->whereJsonContains('company_id', $companyId) // Ensure company_id matches
                        ->get();

                    if ($hrManagers->isNotEmpty()) {
                        // Assuming you want the first manager or you can apply your own logic to select a specific manager
                        $firstManager = $hrManagers->first();
                        $fullName = ucfirst(strtolower($firstManager->first_name)) . ' ' . ucfirst(strtolower($firstManager->last_name));
                        $this->loginEmpManager = $fullName;
                        $this->selectedManagerDetails = $firstManager;
                    } else {
                        // Handle case where no HR managers are found
                        $this->loginEmpManager = 'No manager found';
                        $this->selectedManagerDetails = null;
                    }
                }
            }

            // Determine if the dropdown option should be displayed
            $this->showCasualLeaveProbation = $this->employee && !$this->employee->confirmation_date;
            $currentYear = date('Y'); // Get the current year
            $this->showCasualLeaveProbationYear = $this->employee &&
                !empty($this->employee->confirmation_date) &&
                (date('Y', strtotime($this->employee->confirmation_date)) == $currentYear);
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->handleFieldUpdate($propertyName);
    }

    public function toggleInfo()
    {
        $this->showinfoMessage = !$this->showinfoMessage;
        $this->showinfoButton = !$this->showinfoButton;
    }
    public function hideAlert()
    {
        $this->showerrorMessage = false;
        $this->searchCCRecipients();
    }

    //this method used to filter cc recipients from employee details
    public function searchCCRecipients()
    {
        try {
            // Fetch employees based on the search term for CC To
            $employeeId = auth()->guard('emp')->user()->emp_id;

            // Fetch the company_ids for the logged-in employee
            $companyIds = EmployeeDetails::where('emp_id', $employeeId)->value('company_id');

            // Check if companyIds is an array; decode if it's a JSON string
            $companyIdsArray = is_array($companyIds) ? $companyIds : json_decode($companyIds, true);

            // Initialize an empty collection for recipients
            $this->ccRecipients = collect(); // Ensure it's initialized as a collection

            // Loop through each company ID and find employees
            foreach ($companyIdsArray as $companyId) {
                $employees = EmployeeDetails::whereJsonContains('company_id', $companyId) // Check against JSON company_id
                    ->where('emp_id', '!=', $employeeId) // Exclude the logged-in employee
                    ->where(function ($query) {
                        // Apply search filtering if a search term is provided
                        if ($this->searchTerm) {
                            $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                                ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
                        }
                    })
                    ->groupBy('emp_id', 'image', 'gender') // Group by the required fields
                    ->select(
                        'emp_id',
                        'gender',
                        'image',
                        DB::raw('MIN(CONCAT(first_name, " ", last_name)) as full_name') // Create a full name field
                    )
                    ->orderBy('full_name') // Order by full name
                    ->get();

                // Merge the results into the ccRecipients collection
                $this->ccRecipients = $this->ccRecipients->merge($employees);
            }

            // Optionally, you can remove duplicates if necessary
            $this->ccRecipients = $this->ccRecipients->unique('emp_id');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in searchCCRecipients method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while searching for CC recipients. Please try again later.');
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
            $this->searchCCRecipients();
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in closeCcRecipientsContainer method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while closing CC recipients container. Please try again later.');
        }
    }

    public $selectedEmployeeId;

    private function isWeekend($date)
    {
        // Convert date string to a Carbon instance
        $carbonDate = Carbon::parse($date);
        // Check if the day of the week is Saturday or Sunday
        return $carbonDate->isWeekend();
    }
    public function toggleSelection($empId)
    {
        if (isset($this->selectedPeople[$empId])) {
            // If already selected, unselect it
            unset($this->selectedPeople[$empId]);
        } else {
            // Check if limit is reached
            if (count($this->selectedPeople) < 5) {
                // Add employee if under limit
                $this->selectedPeople[$empId] = true;
            } else {
                // Show error if limit exceeded
                session()->flash('error', 'You can only select up to 5 CC recipients.');
                $this->showAlert = true; // Assuming you're using this to control alert visibility
            }
        }
        
        $this->searchCCRecipients(); // Assuming you want to update the recipients list
        $this->fetchEmployeeDetails(); // Fetch details if necessary
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
        $this->showCcRecipents = true;
        // Fetch updated employee details
        $this->fetchEmployeeDetails();
        $this->searchCCRecipients();
    }
    public $showCCEmployees = false;
    public function openModal()
    {
        $this->showCCEmployees = !$this->showCCEmployees;
    }
    public function leaveApply()
    {
        $this->validate();
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $checkJoinDate  = EmployeeDetails::where('emp_id', $employeeId)->first();

        try {
            // Check for weekends
            if ($this->isWeekend($this->from_date) || $this->isWeekend($this->to_date)) {
                $this->errorMessage = 'Looks like it\'s already your non-working day. Please pick different date(s) to apply.';
                $this->showerrorMessage = true;
                return redirect()->back()->withInput();
            }

            // Validate from date for joining date
            if ($this->from_date < $checkJoinDate->hire_date) {
                $this->errorMessage = 'Entered From date and To dates are less than your Join date.';
                $this->showerrorMessage = true;
                return redirect()->back()->withInput();
            }

            // Validate date range
            if ($this->to_date < $this->from_date) {
                $this->errorMessage = 'To date must be greater than or equal to from date.';
                $this->showerrorMessage = true;
                return redirect()->back()->withInput();
            }

            if ($this->from_date == $this->to_date && $this->from_session > $this->to_session) {
                $this->errorMessage = 'To session must be greater than or equal to from session.';
                $this->showerrorMessage = true;
                return redirect()->back()->withInput();
            }

            // Check for overlapping leave requests
            $overlappingLeave = LeaveRequest::where('emp_id', $employeeId)
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
                ->get();
            foreach ($overlappingLeave as $leave) {
                $carbonFromDate = $leave->from_date->format('Y-m-d');
                $carbonToDate = $leave->to_date->format('Y-m-d');

                // Overlap checks
                if (($this->from_date <= $carbonToDate && $this->to_date >= $carbonFromDate) &&
                    ($this->from_session <= $leave->to_session && $this->to_session >= $leave->from_session)
                ) {
                    $this->errorMessage = 'The selected leave dates overlap with an existing leave application.';
                    $this->showerrorMessage = true;
                    return redirect()->back()->withInput();
                }
            }

            // Step 1: Retrieve total number of days for the selected leave type
            $checkLeaveBalance = LeaveRequest::where('emp_id', $employeeId)
                ->where('leave_type', $this->leave_type)
                ->whereNotIn('leave_type', ['Loss Of Pay'])
                ->whereIn('status', ['approved', 'pending'])
                ->get();

            $totalNumberOfDays = 0; // Initialize the counter for total days
            if (!$checkLeaveBalance->isEmpty()) {
                foreach ($checkLeaveBalance as $leaveRequest) {
                    $numberBalanceOfDays = $this->calculateNumberOfDays($leaveRequest->from_date, $leaveRequest->from_session, $leaveRequest->to_date, $leaveRequest->to_session, $leaveRequest->leave_type);
                    $totalNumberOfDays += $numberBalanceOfDays;
                }
            }
            // Calculate the days for the new leave request, if provided
            if ($this->leave_type !== 'Loss of Pay' && $this->from_date && $this->from_session && $this->to_date && $this->to_session) {
                $totalEnteredDays = $this->calculateNumberOfDays(
                    $this->from_date,
                    $this->from_session,
                    $this->to_date,
                    $this->to_session,
                    $this->leave_type
                );
                $totalNumberOfDays += $totalEnteredDays;
            }


            // Step 2: Retrieve leave balances
            $currentYear = now()->year;
            $leaveBalances = [
                'Sick Leave' => EmployeeLeaveBalances::getLeaveBalancePerYear($employeeId, 'Sick Leave', $currentYear),
                'Casual Leave' => EmployeeLeaveBalances::getLeaveBalancePerYear($employeeId, 'Casual Leave', $currentYear),
                'Casual Leave Probation' => EmployeeLeaveBalances::getLeaveBalancePerYear($employeeId, 'Casual Leave Probation', $currentYear),
                'Marriage Leave' => EmployeeLeaveBalances::getLeaveBalancePerYear($employeeId, 'Marriage Leave', $currentYear),
                'Maternity Leave' => EmployeeLeaveBalances::getLeaveBalancePerYear($employeeId, 'Maternity Leave', $currentYear),
                'Paternity Leave' => EmployeeLeaveBalances::getLeaveBalancePerYear($employeeId, 'Paternity Leave', $currentYear),
            ];

            $leaveBalance = (float)($leaveBalances[$this->leave_type] ?? 0); // Default to 0 if leave_type is not found

            // Step 3: Compare total number of days with leave balance
            if ($totalNumberOfDays > $leaveBalance) {
                $this->errorMessage = 'It looks like you have already used all your leave balance, considering pending and approved leaves.';
                $this->showerrorMessage = true;
                return redirect()->back()->withInput();
            }

            // Check for holidays
            $holidays = HolidayCalendar::whereBetween('date', [$this->from_date, $this->to_date])->get();
            if ($holidays->isNotEmpty()) {
                $this->errorMessage = 'The selected leave dates overlap with existing holidays. Please pick different dates.';
                $this->showerrorMessage = true;
                return redirect()->back()->withInput();
            }
            // Check if the leave type is Casual Leave
            if ($this->leave_type === 'Casual Leave') {
                $currentMonth = now()->month;
                $currentYear = now()->year;

                // Get all casual leave requests for the current month
                $leaveRequests = LeaveRequest::where('emp_id', $employeeId)
                    ->where('leave_type', 'Casual Leave')
                    ->whereYear('from_date', $currentYear)
                    ->whereMonth('from_date', $currentMonth)
                    ->whereIn('status', ['approved', 'pending'])
                    ->get();

                $totalLeaveDays = 0;

                foreach ($leaveRequests as $leaveRequest) {
                    $numberOfDays = $this->calculateNumberOfDays(
                        $leaveRequest->from_date,
                        $leaveRequest->from_session,
                        $leaveRequest->to_date,
                        $leaveRequest->to_session,
                        $leaveRequest->leave_type
                    );
                    $totalLeaveDays += $numberOfDays;
                }

                // Calculate days for the new leave request if it's Casual Leave
                if ($this->from_date && $this->to_date) {
                    $newLeaveDays = $this->calculateNumberOfDays(
                        $this->from_date,
                        $this->from_session,
                        $this->to_date,
                        $this->to_session,
                        $this->leave_type
                    );
                    $totalLeaveDays += $newLeaveDays;
                }

                // Check if total leave days exceed 2
                if ($totalLeaveDays > 2) {
                    $this->errorMessage = 'You can only apply for a maximum of 2 days of Casual Leave for this month.';
                    $this->showerrorMessage = true;
                    return redirect()->back()->withInput();
                }
            }


            // Prepare CC and Manager details
            $ccToDetails = [];
            foreach ($this->selectedCCEmployees as $selectedEmployeeId) {
                if (!in_array($selectedEmployeeId, array_column($ccToDetails, 'emp_id'))) {
                    $employeeDetails = EmployeeDetails::where('emp_id', $selectedEmployeeId)->first();
                    if ($employeeDetails) {
                        $ccToDetails[] = [
                            'emp_id' => $selectedEmployeeId,
                            'full_name' => $employeeDetails->first_name . ' ' . $employeeDetails->last_name,
                        ];
                    }
                }
            }

            $applyingToDetails = [];
            if ($this->selectedManagerDetails) {
                $employeeDetails = EmployeeDetails::where('emp_id', $this->selectedManagerDetails->emp_id)->first();
                if ($employeeDetails) {
                    $applyingToDetails[] = [
                        'manager_id' => $employeeDetails->emp_id,
                        'report_to' => $employeeDetails->first_name . ' ' . $employeeDetails->last_name,
                    ];
                }
            } else {
                $employeeDetails = EmployeeDetails::where('emp_id', auth()->guard('emp')->user()->emp_id)->first();
                $defaultManager = $employeeDetails->manager_id;
                $applyingToDetails[] = [
                    'manager_id' => $defaultManager,
                    'report_to' => $this->loginEmpManager,
                    'image' => $this->loginEmpManagerProfile,
                ];
            }

            $this->validate([
                'file_paths.*' => 'nullable|file|mimes:xls,csv,xlsx,pdf,jpeg,png,jpg,gif|max:2048',
            ]);

            // Store files
            $fileDataArray = [];
            if ($this->file_paths) {
                foreach ($this->file_paths as $file) {
                    $fileContent = file_get_contents($file->getRealPath());
                    $mimeType = $file->getMimeType();
                    $base64File = base64_encode($fileContent);
                    $fileDataArray[] = [
                        'data' => $base64File,
                        'mime_type' => $mimeType,
                        'original_name' => $file->getClientOriginalName(),
                    ];
                }
            }

            // Create the leave request
            $this->createdLeaveRequest = LeaveRequest::create([
                'emp_id' => auth()->guard('emp')->user()->emp_id,
                'leave_type' => $this->leave_type,
                'category_type' => 'Leave',
                'from_date' => $this->from_date,
                'from_session' => $this->from_session,
                'to_session' => $this->to_session,
                'to_date' => $this->to_date,
                'file_paths' => json_encode($fileDataArray),
                'applying_to' => json_encode($applyingToDetails),
                'cc_to' => json_encode($ccToDetails),
                'contact_details' => $this->contact_details,
                'reason' => $this->reason,
            ]);

            // Notify
            Notification::create([
                'emp_id' => auth()->guard('emp')->user()->emp_id,
                'notification_type' => 'leave',
                'leave_type' => $this->leave_type,
                'leave_reason' => $this->reason,
                'applying_to' => json_encode($applyingToDetails),
                'cc_to' => json_encode($ccToDetails),
            ]);

            logger('LeaveRequest created successfully', ['leave_request' => $this->createdLeaveRequest]);
            session()->flash('message', 'Leave application submitted successfully!');
            $this->resetFields();
            $this->showAlert = true;
        } catch (\Exception $e) {
            Log::error("Error: " . $e->getMessage());
            session()->flash('error', 'Failed to submit leave application. Please try again later.');
            return redirect()->to('/leave-form-page');
        }
    }

    public function handleFieldUpdate($field)
    {
        try {
            $this->showNumberOfDays = true;
            if ($field == 'from_date' || $field == 'to_date' || $field == 'from_session' || $field == 'to_session') {
                $this->calculateNumberOfDays($this->fromDate, $this->fromSession, $this->toDate, $this->toSession, $this->leaveType);
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in handleFieldUpdate method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while handling field update. Please try again later.');
        }
    }
    public $empId;
    public function applyingTo()
    {
        try {
            $this->showApplyingToContainer = !$this->showApplyingToContainer;
            $this->show_reporting = true;
            $this->showApplyingTo = false;
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in openCcRecipientsContainer method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while opening CC recipients container. Please try again later.');
        }
    }

    public $showSessionDropdown = true; // Default value

    public function updatedLeaveType($value)
    {
        if ($value === 'Maternity Leave' || $value === 'Paternity Leave') {
            $this->showSessionDropdown = false;
        } else {
            $this->showSessionDropdown = true;
        }
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

            // Debugging output
            Log::info('All Leave Balances:', $allLeaveBalances);

            // Filter leave balances based on the selected leave type
            switch ($this->leave_type) {
                case 'Casual Leave Probation':
                    $this->leaveBalances = [
                        'casualProbationLeaveBalance' => $allLeaveBalances['casualProbationLeaveBalance'] ?? '0'
                    ];
                    break;
                case 'Casual Leave':
                    $this->leaveBalances = [
                        'casualLeaveBalance' => $allLeaveBalances['casualLeaveBalance'] ?? '0'
                    ];
                    break;
                case 'Loss of Pay':
                    $this->leaveBalances = [
                        'lossOfPayBalance' => $allLeaveBalances['lossOfPayBalance'] ?? '0'
                    ];
                    break;
                case 'Sick Leave':
                    $this->leaveBalances = [
                        'sickLeaveBalance' => $allLeaveBalances['sickLeaveBalance'] ?? '0'
                    ];
                    break;
                case 'Maternity Leave':
                    $this->leaveBalances = [
                        'maternityLeaveBalance' => $allLeaveBalances['maternityLeaveBalance'] ?? '0'
                    ];
                    break;
                case 'Paternity Leave':
                    $this->leaveBalances = [
                        'paternityLeaveBalance' => $allLeaveBalances['paternityLeaveBalance'] ?? '0'
                    ];
                    break;
                case 'Marriage Leave':
                    $this->leaveBalances = [
                        'marriageLeaveBalance' => $allLeaveBalances['marriageLeaveBalance'] ?? '0'
                    ];
                    break;
                default:
                    $this->leaveBalances = [];
                    break;
            }

            // Debugging output
            Log::info('Selected Leave Type:', ['leave_type' => $this->leave_type]);
            Log::info('Leave Balances:', $this->leaveBalances);

            $this->showNumberOfDays = true;
        } catch (\Exception $e) {
            // Log the error
            Log::error("Error selecting leave: " . $e->getMessage());
            // Flash an error message to the user
            session()->flash('error', 'An error occurred while selecting leave and leave balance. Please try again later.');
            // Redirect the user back
            return redirect()->back();
        }
    }

    //it will calculate number of days for leave application
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
    //selected applying to manager details
    public function toggleManager($empId)
    {
        if ($empId) {
            $this->fetchManagerDetails($empId);
        } else {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $applying_to = EmployeeDetails::where('emp_id', $employeeId)->first();
            if ($applying_to) {
                $managerId = $applying_to->manager_id;
                // Fetch the logged-in employee's manager details
                $managerDetails = EmployeeDetails::where('emp_id', $managerId)->first();
                if ($managerDetails) {
                    $fullName = ucfirst(strtolower($managerDetails->first_name)) . ' ' . ucfirst(strtolower($managerDetails->last_name));
                    $this->loginEmpManager = $fullName;
                    $this->empManagerDetails = $managerDetails;
                }
            }
            $this->selectedManager = [$empId];
            $this->showApplyingToContainer = false;
        }
    }


    // Method to fetch manager details
    private function fetchManagerDetails($empId)
    {
        $employeeDetails = EmployeeDetails::where('emp_id', $empId)->first();
        if ($employeeDetails) {
            $fullName = ucfirst(strtolower($employeeDetails->first_name)) . ' ' . ucfirst(strtolower($employeeDetails->last_name));
            $this->loginEmpManager = $fullName;
            $this->selectedManagerDetails = $employeeDetails;
        } else {
            $this->resetManagerDetails();
        }
    }

    private function resetManagerDetails()
    {
        $this->empManagerDetails = null;
    }

    public function resetFields()
    {
        $this->reason = null;
        $this->contact_details = null;
        $this->leave_type = null;
        $this->to_date = null;
        $this->from_date = null;
        $this->from_session = 'Session 1';
        $this->to_session = 'Session 2';
        $this->cc_to = null;
        $this->applying_to = null;
        $this->showNumberOfDays = false;
        $this->showApplyingToContainer = false;
        $this->show_reporting = false;
        $this->showApplyingTo = true;
        $this->selectedCCEmployees = [];
        $this->file_paths = null;
    }

    public $managerDetails, $fullName;
    public $empManagerDetails, $selectedManagerDetails;
    public function render()
    {
        $this->selectedYear = Carbon::now()->format('Y');
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->loginEmpManager = null;
        $this->selectedManager = $this->selectedManager ?? [];
        $managers = collect();
        $employeeGender = null;

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

            // Fetch the gender of the logged-in employee
            $employeeGender = EmployeeDetails::where('emp_id', $employeeId)->select('gender')->first();

            // Fetch employees with job roles CTO, Chairman, and HR
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

            // Get the company_id from the logged-in employee's details
            $companyIds = $applying_to->company_id;

            // Convert the company IDs to an array if it's in JSON format
            $companyIdsArray = is_array($companyIds) ? $companyIds : json_decode($companyIds, true);

            // Fetch emp_ids from the HR table
            $hrEmpIds = Hr::pluck('emp_id');

            // Now, fetch employee details for these HR emp_ids
            $hrManagers = EmployeeDetails::whereIn('emp_id', $hrEmpIds)
                ->where(function ($query) use ($companyIdsArray) {
                    // Check if any of the company IDs match
                    foreach ($companyIdsArray as $companyId) {
                        $query->orWhere('company_id', 'like', "%\"$companyId\"%"); // Assuming company_id is stored as JSON
                    }
                })
                ->get(['first_name', 'last_name', 'emp_id', 'gender', 'image']);

            // Add HR managers to the collection
            $hrManagers->each(function ($hrManager) use ($managers) {
                $fullName = ucfirst(strtolower($hrManager->first_name)) . ' ' . ucfirst(strtolower($hrManager->last_name));
                $managers->push([
                    'full_name' => $fullName,
                    'emp_id' => $hrManager->emp_id,
                    'gender' => $hrManager->gender,
                    'image' => $hrManager->image,
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Error fetching employee or manager details: ' . $e->getMessage());
        }


        return view('livewire.leave-apply-page', [
            'employeeGender' => $employeeGender,
            'calculatedNumberOfDays' => $this->calculatedNumberOfDays,
            'empManagerDetails' => $this->empManagerDetails,
            'selectedManagerDetails' => $this->selectedManagerDetails,
            'loginEmpManager' => $this->loginEmpManager,
            'managers' => $managers,
            'ccRecipients' => $this->ccRecipients,
            'showCasualLeaveProbation' => $this->showCasualLeaveProbation
        ]);
    }
    // Add a method to update the search query
    public function getFilteredManagers()
    {
        $this->render(); // Re-render to apply the search filter
    }
    public function handleEnterKey()
    {
        $this->searchCCRecipients();
    }
}
