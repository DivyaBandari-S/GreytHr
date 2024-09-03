<?php
// File Name                       : LeaveBalances.php
// Description                     : This file contains the implementation displaying leave balance and consumed leaves for each type of leaves
// Creator                         : Bandari Divya
// Email                           : bandaridivya1@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : LeaveRequest,EmployeeDetails.
namespace App\Livewire;

use Illuminate\Support\Carbon;
use Livewire\Component;
use App\Helpers\LeaveHelper;
use App\Models\EmployeeDetails;
use App\Models\EmployeeLeaveBalances;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;


class LeaveBalances extends Component
{
    public $employeeDetails;
    public $casualLeavePerYear;
    public $casualProbationLeavePerYear;
    public $lossOfPayPerYear;
    public $marriageLeaves;
    public $maternityLeaves;
    public $paternityLeaves;
    public $sickLeavePerYear;
    public $sickLeaveBalance;
    public $casualLeaveBalance;
    public $casualProbationLeaveBalance;
    public $lossOfPayBalance;
    public $leaveTransactions;
    public $leaveTypeModal = 'all';
    public $transactionTypeModal = 'all';
    public $employeeId;
    public $status;
    public $fromDateModal;
    public $toDateModal;
    public $leaveType;
    public $transactionType;
    public $consumedSickLeaves;
    public $consumedCasualLeaves;
    public $consumedLossOfPayLeaves;
    public $consumedProbationLeaveBalance;
    public $sortBy = 'newest_first';
    public $selectedYear;

    public $totalCasualDays;
    public $totalSickDays;
    public $totalLossOfPayDays;
    public $totalCasualLeaveProbationDays;
    public $previousYear;
    public $nextYear;
    public $currentYear;
    public $beforePreviousYear;
    public $percentageCasual;
    public $percentageSick;
    public $percentageCasualProbation, $differenceInMonths;
    public $showModal = false;
    public $dateErrorMessage;

    protected $rules = [
        'fromDateModal' => 'required|date',
        'toDateModal' => 'required|date|after_or_equal:fromDateModal',
    ];
    protected $messages = [
        'fromDateModal.required' => 'From date is required',
        'toDateModal.required' => 'To date is required',
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($this->toDateModal < $this->fromDateModal) {
            $this->dateErrorMessage = 'To date must be greater than to From date.';
        } else {
            $this->dateErrorMessage = null;
        }
    }

    //in this method will get leave balance for each type
    public function mount()
    {
        try {
            $this->selectedYear = Carbon::now()->format('Y'); // Initialize to the current year
            $this->updateLeaveBalances();
            $hireDate = $this->employeeDetails->hire_date;
            if ($hireDate) {
                $hireDate = Carbon::parse($hireDate);
                $currentDate = Carbon::now();

                $this->differenceInMonths = $hireDate->diffInMonths($currentDate);
            } else {
                $this->differenceInMonths = null;
            }
        } catch (\Exception $e) {
            // Log the error if needed
            logger()->error('Error during component mount: ' . $e->getMessage());
            // Set an error message in the session
            session()->flash('mountError', 'An error occurred while loading the component. Please try again later.');
        }
    }
    public function updatedSelectedYear($value)
    {
        // Debugging output
        logger()->info('Selected Year Updated: ' . $value);
        $this->updateLeaveBalances();
    }


    private function updateLeaveBalances()
    {
        try {
            $this->currentYear = $this->selectedYear;
            $this->employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $this->employeeId)->first();
            $this->fromDateModal = Carbon::createFromDate($this->currentYear, 1, 1)->format('Y-m-d');
            $this->toDateModal = Carbon::createFromDate($this->currentYear, 12, 31)->format('Y-m-d');

            if ($this->employeeDetails) {
                $hireDate = $this->employeeDetails->hire_date;
                if ($hireDate) {
                    $hireDate = Carbon::parse($hireDate);
                    $currentDate = Carbon::now();
                    $this->differenceInMonths = $hireDate->diffInMonths($currentDate);
                } else {
                    $this->differenceInMonths = null;
                }

                $this->sickLeavePerYear = EmployeeLeaveBalances::getLeaveBalancePerYear($this->employeeId, 'Sick Leave', $this->currentYear);
                $this->lossOfPayPerYear = EmployeeLeaveBalances::getLeaveBalancePerYear($this->employeeId, 'Loss Of Pay', $this->currentYear);
                $this->casualLeavePerYear = EmployeeLeaveBalances::getLeaveBalancePerYear($this->employeeId, 'Casual Leave', $this->currentYear);
                $this->casualProbationLeavePerYear = EmployeeLeaveBalances::getLeaveBalancePerYear($this->employeeId, 'Casual Leave Probation', $this->currentYear);
                $this->marriageLeaves = EmployeeLeaveBalances::getLeaveBalancePerYear($this->employeeId, 'Marriage Leave', $this->currentYear);
                $this->maternityLeaves = EmployeeLeaveBalances::getLeaveBalancePerYear($this->employeeId, 'Maternity Leave', $this->currentYear);
                $this->paternityLeaves = EmployeeLeaveBalances::getLeaveBalancePerYear($this->employeeId, 'Paternity Leave', $this->currentYear);
                $leaveBalances = LeaveHelper::getApprovedLeaveDays($this->employeeId, $this->selectedYear);
                $this->totalCasualDays = $leaveBalances['totalCasualDays'];
                $this->totalSickDays = $leaveBalances['totalSickDays'];
                $this->totalCasualLeaveProbationDays = $leaveBalances['totalCasualLeaveProbationDays'];
                $this->totalLossOfPayDays = $leaveBalances['totalLossOfPayDays'];

                $this->sickLeaveBalance = $this->sickLeavePerYear - $this->totalSickDays;
                $this->casualLeaveBalance = $this->casualLeavePerYear - $this->totalCasualDays;
                $this->casualProbationLeaveBalance = $this->casualProbationLeavePerYear - $this->totalCasualLeaveProbationDays;
                $this->lossOfPayBalance = $this->totalLossOfPayDays;

                $this->consumedCasualLeaves = $this->casualLeavePerYear - $this->casualLeaveBalance;
                $this->consumedSickLeaves = $this->sickLeavePerYear - $this->sickLeaveBalance;
                $this->consumedProbationLeaveBalance = $this->casualProbationLeavePerYear - $this->casualProbationLeaveBalance;
            }
        } catch (\Exception $e) {
            logger()->error('Error during component mount: ' . $e->getMessage());
            session()->flash('mountError', 'An error occurred while loading the component. Please try again later.');
        }
    }

    //this method will show increment color a color if leave are consumed,
    protected function getTubeColor($consumedLeaves, $leavePerYear, $leaveType)
    {
        try {
            // Check if $leavePerYear is greater than 0 to avoid division by zero
            if ($leavePerYear > 0) {
                $percentage = ($consumedLeaves / $leavePerYear) * 100;
                // Define color thresholds based on the percentage consumed and leave type
                switch ($leaveType) {
                    case 'Sick Leave':
                        return $this->getSickLeaveColor($percentage);
                    case 'Casual Leave Probation':
                        return $this->getSickLeaveColor($percentage);
                    case 'Casual Leave':
                        return $this->getSickLeaveColor($percentage);
                    default:
                        return '#000000';
                }
            } else {
                return '#0ea8fc';
            }
        } catch (\Exception $e) {
            Log::error('Error in getTubeColor method: ' . $e->getMessage());
            return '#000000';
        }
    }


    protected function getSickLeaveColor($percentage)
    {
        return '#0ea8fc';
    }

    //this method will fetch the oldest nd newest  data
    public function checkSortBy()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
        $query = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
            ->select('leave_applications.*', 'employee_details.*', 'leave_applications.created_at as leave_created_at')
            ->where('leave_applications.emp_id', $employeeId);
        if ($this->sortBy == 'oldest_first') {
            $query->orderBy('leave_created_at', 'asc');
        } else {
            $query->orderBy('leave_created_at', 'desc');
        }
        $this->leaveTransactions = $query->get();
    }
    public function showPopupModal()
    {
        $this->showModal = true;
    }
    public function closeModal()
    {
        $this->showModal = false;
    }


    public function render()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;

            if ($this->casualLeavePerYear > 0) {
                $this->percentageCasual = ($this->consumedCasualLeaves / $this->casualLeavePerYear) * 100;
            }
            if ($this->sickLeavePerYear > 0) {
                $this->percentageSick = ($this->consumedSickLeaves / $this->sickLeavePerYear) * 100;
            }
            if ($this->casualProbationLeavePerYear > 0) {
                $this->percentageCasualProbation = ($this->consumedProbationLeaveBalance / $this->casualProbationLeavePerYear) * 100;
            }


            $this->yearDropDown();
            // Check if employeeDetails is not null before accessing its properties
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

            //to check employee details are not null
            if ($this->employeeDetails) {
                $gender = $this->employeeDetails->gender;
                $grantedLeave = ($gender === 'Female') ? 90 : 05;

                $leaveBalances = LeaveBalances::getLeaveBalances($employeeId, $this->selectedYear);

                return view('livewire.leave-balances', [
                    'gender' => $gender,
                    'grantedLeave' => $grantedLeave,
                    'sickLeaveBalance' => $leaveBalances['sickLeaveBalance'],
                    'casualLeaveBalance' => $leaveBalances['casualLeaveBalance'],
                    'lossOfPayBalance' => $leaveBalances['lossOfPayBalance'],
                    'employeeDetails' => $this->employeeDetails,
                    'leaveTransactions' => $this->leaveTransactions,
                    'percentageCasual' => $this->percentageCasual,
                    'percentageSick' => $this->percentageSick,
                    'differenceInMonths' => $this->differenceInMonths,
                    'percentageCasualProbation' => $this->percentageCasualProbation
                ]);
            }
        } catch (\Exception $e) {

            Log::error($e->getMessage());
            session()->flash('error', 'An error occurred. Please try again later.'); // Flash an error message to the user
            return redirect()->back(); // Redirect back to the previous page
        }
    }


    public static function getLeaveBalances($employeeId, $selectedYear)
    {
        try {
            $selectedYear = now()->year;
            $employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
            $sickLeavePerYear = EmployeeLeaveBalances::getLeaveBalancePerYear($employeeId, 'Sick Leave', $selectedYear);
            $casualLeavePerYear = EmployeeLeaveBalances::getLeaveBalancePerYear($employeeId, 'Casual Leave', $selectedYear);
            $casualProbationLeavePerYear = EmployeeLeaveBalances::getLeaveBalancePerYear($employeeId, 'Casual Leave Probation', $selectedYear);
            $marriageLeaves = EmployeeLeaveBalances::getLeaveBalancePerYear($employeeId, 'Marriage Leave', $selectedYear);
            $maternityLeaves = EmployeeLeaveBalances::getLeaveBalancePerYear($employeeId, 'Maternity Leave', $selectedYear);
            $paternityLeaves = EmployeeLeaveBalances::getLeaveBalancePerYear($employeeId, 'Petarnity Leave', $selectedYear);

            if (!$employeeDetails) {
                return null;
            }

            // Get the logged-in employee's approved leave days for all leave types
            $approvedLeaveDays = LeaveHelper::getApprovedLeaveDays($employeeId, $selectedYear);
            // Calculate leave balances
            $sickLeaveBalance = $sickLeavePerYear - $approvedLeaveDays['totalSickDays'];
            $casualLeaveBalance = $casualLeavePerYear - $approvedLeaveDays['totalCasualDays'];
            $lossOfPayBalance = $approvedLeaveDays['totalLossOfPayDays'];
            $casualProbationLeaveBalance = $casualProbationLeavePerYear - $approvedLeaveDays['totalCasualLeaveProbationDays'];
            $marriageLeaveBalance = $marriageLeaves - $approvedLeaveDays['totalMarriageDays'];
            $maternityLeaveBalance = $maternityLeaves - $approvedLeaveDays['totalMaternityDays'];
            $paternityLeaveBalance = $paternityLeaves - $approvedLeaveDays['totalPaternityDays'];

            return [
                'sickLeaveBalance' => $sickLeaveBalance,
                'casualLeaveBalance' => $casualLeaveBalance,
                'lossOfPayBalance' => $lossOfPayBalance,
                'casualProbationLeaveBalance' => $casualProbationLeaveBalance,
                'marriageLeaveBalance' => $marriageLeaveBalance,
                'maternityLeaveBalance' => $maternityLeaveBalance,
                'paternityLeaveBalance' => $paternityLeaveBalance,
            ];
        } catch (\Exception $e) {
            if ($e instanceof \Illuminate\Database\QueryException) {
                // Handle database query exceptions
                Log::error("Database error in getLeaveBalances(): " . $e->getMessage());
                session()->flash('emp_error', 'Database connection error occurred. Please try again later.');
            } else {
                Log::error("Error in getLeaveBalances(): " . $e->getMessage());
                session()->flash('emp_error', 'Failed to retrieve leave balances. Please try again later.');
            }
            return null;
        }
    }


    //calcalate number of days for leave
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
            if ($startDate->isSameDay($endDate)) {
                if ($this->getSessionNumber($fromSession) !== $this->getSessionNumber($toSession)) {
                    return 1;
                } elseif ($this->getSessionNumber($fromSession) == $this->getSessionNumber($toSession)) {
                    return 0.5;
                } else {
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

    //method to use dynamic years in a dropdown
    public function yearDropDown()
    {
        try {
            $currentYear = Carbon::now()->format('Y');
            if ($this->isTrue($currentYear - 2)) {
            } elseif ($this->isTrue($currentYear - 1)) {
            } elseif ($this->isTrue($currentYear)) {
            } else {
            }
        } catch (\Exception $e) {
            // Add an error message or log a message indicating that an error occurred
            $errorMessage = 'An error occurred in yearDropDown() method: ' . $e->getMessage();
            $this->addError('session', 'An error occurred. Please try again later.');
        }
    }
    public function isTrue($year)
    {
        return $this->selectedYear === $year;
    }



    public function generatePdf()
    {
        $this->validate();

        if ($this->dateErrorMessage) {
            return;
        }
        $employeeId = auth()->guard('emp')->user()->emp_id;

        // Fetch employee details
        $employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

        // Query to fetch leave transactions based on selected criteria
        $leaveRequests = LeaveRequest::where('emp_id', $employeeId)
            ->when($this->fromDateModal, function ($query) {
                $query->where('from_date', '>=', $this->fromDateModal);
            })
            ->when($this->toDateModal, function ($query) {
                $query->where('to_date', '<=', $this->toDateModal);
            })
            ->when($this->leaveType && $this->leaveType != 'all', function ($query) {
                // Map leaveType input values to database enum values
                $leaveTypes = [
                    'casual_probation' => 'Casual Leave Probation',
                    'maternity' => 'Maternity Leave',
                    'paternity' => 'Paternity Leave',
                    'sick' => 'Sick Leave',
                    'lop' => 'Loss of Pay'
                ];

                if (array_key_exists($this->leaveType, $leaveTypes)) {
                    $query->where('leave_type', $leaveTypes[$this->leaveType]);
                }
            })
            ->when($this->transactionType && $this->transactionType != 'all', function ($query) {
                // Map transactionType input values to database status values
                $transactionTypes = [
                    'granted' => 'Granted',
                    'availed' => 'Availed',
                    'cancelled' => 'Cancelled',
                    'withdrawn' => 'Withdrawn',
                    'rejected' => 'Rejected',
                    'approved' => 'Approved'
                ];
                if (array_key_exists($this->transactionType, $transactionTypes)) {
                    $query->where('status', $transactionTypes[$this->transactionType]);
                }
            })
            ->orderBy('created_at', $this->sortBy === 'oldest_first' ? 'asc' : 'desc')
            ->get()
            ->map(function ($leaveRequest) {
                $leaveRequest->days = $leaveRequest->calculateLeaveDays(
                    $leaveRequest->from_date,
                    $leaveRequest->from_session,
                    $leaveRequest->to_date,
                    $leaveRequest->to_session
                );
                return $leaveRequest;
            });

        // Generate PDF using the fetched data
        $pdf = Pdf::loadView('pdf_template', [
            'employeeDetails' => $employeeDetails,
            'leaveTransactions' => $leaveRequests,
            'fromDate' => $this->fromDateModal,
            'toDate' => $this->toDateModal,
        ]);
        $this->showModal = false;

        // Return the PDF as a downloadable response
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'leave_transactions.pdf');
    }
}
