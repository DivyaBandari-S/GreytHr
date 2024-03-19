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
use App\Models\LeaveRequest;
use PDF;


class LeaveBalances extends Component
{
    public $employeeDetails;
    public $sickLeavePerYear = 12;
    public $casualLeavePerYear = 12;
    public $lossOfPayPerYear = 0;
    public $sickLeaveBalance;
    public $casualLeaveBalance;
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
    public $sortBy = 'oldest_first';
    public $selectedYear;

    public $totalCausalDays;
    public $totalSickDays;
    public $totalLossOfPayDays;
    public $previousYear;
    public $nextYear;
    public $beforePreviousYear;

    public function mount()
    {
        $this->selectedYear = Carbon::now()->format('Y');
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

        // Check if employeeDetails is not null before accessing its properties
        if ($this->employeeDetails) {
            // Get the logged-in employee's approved leave days for sick, causal, and loss of pay leave
            $leaveBalances = LeaveHelper::getApprovedLeaveDays($employeeId, $this->selectedYear);

            // Use the returned values in your component
            $this->totalCausalDays = $leaveBalances['totalCausalDays'];
            $this->totalSickDays = $leaveBalances['totalSickDays'];
            $this->totalLossOfPayDays = $leaveBalances['totalLossOfPayDays'];
            // Calculate leave balances
            $this->sickLeaveBalance = $this->sickLeavePerYear - $this->totalSickDays;
            $this->casualLeaveBalance = $this->casualLeavePerYear - $this->totalCausalDays;
            $this->lossOfPayBalance = $this->lossOfPayPerYear - $this->totalLossOfPayDays;
            $this->consumedCasualLeaves = $this->casualLeavePerYear -  $this->casualLeaveBalance;
            $this->consumedSickLeaves = $this->sickLeavePerYear -  $this->sickLeaveBalance;
        }
    }

    protected function getTubeColor($consumedLeaves, $leavePerYear, $leaveType)
    {
        $percentage = ($consumedLeaves / $leavePerYear) * 100;

        // Define color thresholds based on the percentage consumed and leave type
        switch ($leaveType) {
            case 'Sick Leave':
                return $this->getSickLeaveColor($percentage);
            case 'Causal Leave Probation':
                return $this->getSickLeaveColor($percentage);
            default:
                return '#000000'; // Default color
        }
    }

    protected function getSickLeaveColor($percentage)
    {
        return '#0ea8fc';
    }
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

    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;


        $percentageCasual = ($this->consumedCasualLeaves / $this->casualLeavePerYear) * 100;

        $percentageSick = ($this->consumedSickLeaves / $this->sickLeavePerYear) * 100;
        $this->yearDropDown();
        // Check if employeeDetails is not null before accessing its properties
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

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
                'percentageCasual' => $percentageCasual,
                'percentageSick' => $percentageSick,
            ]);
        }
    }

    public static function getLeaveBalances($employeeId, $selectedYear)
    {
        $employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

        if (!$employeeDetails) {
            return null;
        }

        $sickLeavePerYear = 12; // Assuming sick leaves for the specified year
        $casualLeavePerYear = 12; // Assuming casual leaves for the specified year
        $lossOfPayPerYear = 0; // Assuming loss of pay leaves for the specified year

        // Get the logged-in employee's approved leave days for sick, causal, and loss of pay leave
        $approvedLeaveDays = LeaveHelper::getApprovedLeaveDays($employeeId, $selectedYear);

        // Calculate leave balances
        $sickLeaveBalance = $sickLeavePerYear - $approvedLeaveDays['totalSickDays'];
        $casualLeaveBalance = $casualLeavePerYear - $approvedLeaveDays['totalCausalDays'];
        $lossOfPayBalance = $lossOfPayPerYear - $approvedLeaveDays['totalLossOfPayDays'];

        return [
            'sickLeaveBalance' => $sickLeaveBalance,
            'casualLeaveBalance' => $casualLeaveBalance,
            'lossOfPayBalance' => $lossOfPayBalance,
        ];
    }

    public  function calculateNumberOfDays($fromDate, $fromSession, $toDate, $toSession)

    {
        try {

            $startDate = Carbon::parse($fromDate);
            $endDate = Carbon::parse($toDate);
            // Check if the start and end sessions are different on the same day
            if ($startDate->isSameDay($endDate) && $this->getSessionNumber($fromSession) === $this->getSessionNumber($toSession)) {
                // Inner condition to check if both start and end dates are weekdays
                if (!$startDate->isWeekend() && !$endDate->isWeekend()) {
                    return 0.5;
                } else {
                    // If either start or end date is a weekend, return 0
                    return 0;
                }
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
    public function yearDropDown()
    {
        $currentYear = Carbon::now()->format('Y');
        if ($this->isTrue($currentYear - 2)) {
        } elseif ($this->isTrue($currentYear - 1)) {
        } elseif ($this->isTrue($currentYear)) {
        } else {
        }
    }
    public function isTrue($year)
    {
        return $this->selectedYear === $year;
    }

    private function getSessionNumber($session)
    {
        return (int) str_replace('Session ', '', $session);
    }
}
