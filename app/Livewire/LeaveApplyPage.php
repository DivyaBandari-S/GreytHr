<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class LeaveApplyPage extends Component
{
    public  $showinfoMessage = true;
    public  $showinfoButton = false;
    public $errorMessage = '';
    public $showNumberOfDays = false;
    public $differenceInMonths;
    public $show_reporting = false;
    public $showApplyingTo = true;
    public $leaveBalances = [];
    public $selectedYear;
    public $createdLeaveRequest;

    public function toggleInfo()
    {
        $this->showinfoMessage = !$this->showinfoMessage;
        $this->showinfoButton = !$this->showinfoButton;
    }
    public function leaveApply()
    {
        $this->validate();

        try {
            $this->selectLeave();

            // Check for weekend
            if ($this->isWeekend($this->from_date) || $this->isWeekend($this->to_date)) {
                $this->errorMessage = 'Looks like it\'s already your non-working day. Please pick different date(s) to apply.';
                return redirect()->back()->withInput();
            }

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

            if ($overlappingLeave) {
                $this->errorMessage = 'The selected leave dates overlap with an existing leave application.';
                return;
            }

            // Validate from_date to to_date
            if ($this->to_date < $this->from_date) {
                $this->errorMessage = 'To date must be greater than or equal to from date.';
                return redirect()->back()->withInput();
            }

            // Check for holidays in the selected date range
            $holidays = HolidayCalendar::where(function ($query) {
                $query->whereBetween('date', [$this->from_date, $this->to_date])
                    ->orWhere(function ($q) {
                        $q->where('date', '>=', $this->from_date)
                            ->where('date', '<=', $this->to_date);
                    });
            })->get();

            if ($holidays->isNotEmpty()) {
                $this->errorMessage = 'The selected leave dates overlap with existing holidays. Please pick different dates.';
                return redirect()->back()->withInput();
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
                            'report_to' => $managerfullName,
                        ];
                    }
                }
            }


            // Create the leave request
            $this->createdLeaveRequest = LeaveRequest::create([
                'emp_id' => $employeeId,
                'leave_type' => $this->leave_type,
                'category_type' => 'Leave',
                'from_date' => $this->from_date,
                'from_session' => $this->from_session,
                'to_session' => $this->to_session,
                'to_date' => $this->to_date,
                'applying_to' => json_encode($applyingToDetails),
                'cc_to' => json_encode($ccToDetails),
                'contact_details' => $this->contact_details,
                'reason' => $this->reason,
            ]);

            Notification::create([
                'emp_id' => $employeeId,
                'notification_type' => 'leave',
                'leave_type' => $this->leave_type,
                'leave_reason' => $this->reason,
                'applying_to' => json_encode($applyingToDetails),
                'cc_to' => json_encode($ccToDetails),
            ]);

            logger('LeaveRequest created successfully', ['leave_request' => $this->createdLeaveRequest]);

            if ($this->createdLeaveRequest && $this->createdLeaveRequest->emp_id) {
                session()->flash('message', 'Leave application submitted successfully!');
                return redirect()->to('/leave-page');
            } else {
                logger('Error creating LeaveRequest', ['emp_id' => $employeeId]);
                session()->flash('error', 'Error submitting leave application. Please try again.');
                return redirect()->to('/leave-page');
            }
        } catch (\Exception $e) {
            if ($e instanceof \Illuminate\Database\QueryException) {
                Log::error("Database error: " . $e->getMessage());
                session()->flash('error', 'Database error occurred. Please try again later.');
            } elseif (strpos($e->getMessage(), 'Call to a member function store() on null') !== false) {
                session()->flash('error', 'Please upload an image.');
            } elseif ($e instanceof \Illuminate\Http\Client\RequestException) {
                Log::error("Network error: " . $e->getMessage());
                session()->flash('error', 'Network error occurred. Please try again later.');
            } elseif ($e instanceof \PDOException) {
                Log::error("Database connection error: " . $e->getMessage());
                session()->flash('error', 'Database connection error. Please try again later.');
            } else {
                Log::error("General error: " . $e->getMessage());
                session()->flash('error', 'Failed to submit leave application. Please try again later.');
            }
            return redirect()->to('/leave-page');
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
        //it will calculate number of days for leave application
        public function calculateNumberOfDays($fromDate, $fromSession, $toDate, $toSession)
        {
            try {
                $startDate = Carbon::parse($fromDate);
                $endDate = Carbon::parse($toDate);
    
                // Check if the start or end date is a weekend
                if ($startDate->isWeekend() || $endDate->isWeekend()) {
                    return 'Error: Selected dates fall on a weekend. Please choose weekdays.';
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
    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $employeeGender = EmployeeDetails::where('emp_id', $employeeId)->select('gender')->first();
        return view('livewire.leave-apply-page', [
            'employeeGender' => $employeeGender,
            'calculatedNumberOfDays' => $this->calculatedNumberOfDays
        ]);
    }
}
