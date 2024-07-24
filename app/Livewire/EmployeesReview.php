<?php
// File Name                       : EmployeesReview.php
// Description                     : This file contains the implementation of Approving leave, attendance request applied by team memebers, Manager can review leave & attendance applications which are applied by team
// Creator                         : Bandari Divya
// Email                           : bandaridivya1@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : LeaveRequest,EmployeeDetails -->
namespace App\Livewire;
use Illuminate\Http\Request;

use App\Models\EmployeeDetails;
use App\Models\LeaveRequest;
use App\Models\RegularisationDates;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class EmployeesReview extends Component
{
    public $attendenceActiveTab = 'active';
    public $leaveactiveTab = 'active';
    public $showattendance = true;
    public $showleave = false;
    public $approvedRegularisationRequestList;
    public $count;
    public $approvedLeaveApplicationsList;
    public $empLeaveRequests;
    public $activeContent, $leaveRequests;
    public $regularisation_count;
    public $countofregularisations;
    public $leaveApplications ,$approvedLeaveRequests;
    public $searchQuery = '';
    public $selectedYear;
    public $toggleAccordian =false;


    public $activeTab = 'leave';

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;

        // Toggle visibility based on active tab
        if ($tab === 'attendance') {
            $this->showattendance = true;
            $this->showleave = false;
        } elseif ($tab === 'leave') {
            $this->showattendance = false;
            $this->showleave = true;
        }
    }

    public function mount(Request $request)
    {
        // if ($request->query('tab') === 'leave') {
        //     $this->setActiveTab('leave');
        //     $this->showleave = true;
        //     $this->showattendance = false;

        // }

        $tab = $request->query('tab');
        Log::info('Tab parameter: ' . $tab);

        if ($tab === 'attendance') {
            $this->setActiveTab('attendance'); // Default tab logic if needed
            $this->showleave = false;
            $this->showattendance = true;

        } else {
            $this->setActiveTab('leave');
            $this->showleave = true;
            $this->showattendance = false;

        }
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

    private function getSessionNumber($session)
    {
        return (int) str_replace('Session ', '', $session);
    }

     // Search functionality for pending leave requests
     public function searchPendingLeave()
{
    try {
       $this->render();

    } catch (\Exception $e) {
        Log::error('Error in searchPendingLeave method: ' . $e->getMessage());
        session()->flash('error', 'An error occurred while processing your request. Please try again later.');
    }
}



     public function searchApprovedLeave()
{
    try {
        // Logic to handle the search for approved leaves
        $this->render();
    } catch (\Exception $e) {
        Log::error('Error in searchApprovedLeave method: ' . $e->getMessage());
        session()->flash('error', 'An error occurred while processing your request. Please try again later.');
        return redirect()->back();
    }
}



 public function render(){

    //query to fetch the approved leave appplications............

    $employeeId = auth()->guard('emp')->user()->emp_id;
    $employees = EmployeeDetails::where('manager_id', $employeeId)->select('emp_id', 'first_name', 'last_name')->get();
    $empIds = $employees->pluck('emp_id')->toArray();

    $companyId = auth()->guard('emp')->user()->company_id;
    $this->leaveRequests = LeaveRequest::where('leave_applications.status', 'Pending')
    ->where('company_id', $companyId)
    ->join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
    ->where(function ($query) {
        $query->where('leave_applications.emp_id', 'LIKE', '%' . $this->searchQuery . '%')
            ->orWhere('employee_details.first_name', 'LIKE', '%' . $this->searchQuery . '%')
            ->orWhere('employee_details.last_name', 'LIKE', '%' . $this->searchQuery . '%');
    })
    ->get();
    $this->approvedRegularisationRequestList = RegularisationDates::whereIn('regularisation_dates.emp_id', $empIds)

    ->whereIn('regularisation_dates.status', ['approved', 'rejected'])

    ->orderByDesc('regularisation_dates.id')

    ->join('employee_details', 'regularisation_dates.emp_id', '=', 'employee_details.emp_id')

    ->where(function ($query) {
        $query->where('regularisation_dates.emp_id', 'LIKE', '%' . $this->searchQuery . '%')
            ->orWhere('employee_details.first_name', 'LIKE', '%' . $this->searchQuery . '%')
            ->orWhere('employee_details.last_name', 'LIKE', '%' . $this->searchQuery . '%');
    })

    ->select('regularisation_dates.*', 'employee_details.first_name', 'employee_details.last_name')

    ->orderByDesc('id')

    ->get();
    $this->approvedRegularisationRequestList = $this->approvedRegularisationRequestList->filter(function ($regularisation) {

        return $regularisation->regularisation_entries !== "[]";
    });

    $selectedYear = $this->selectedYear;
    $matchingLeaveApplications = [];

    foreach ($this->leaveRequests as $leaveRequest) {
        $applyingToJson = trim($leaveRequest->applying_to);
        $applyingArray = is_array($applyingToJson) ? $applyingToJson : json_decode($applyingToJson, true);

        $ccToJson = trim($leaveRequest->cc_to);
        $ccArray = is_array($ccToJson) ? $ccToJson : json_decode($ccToJson, true);

        $isManagerInApplyingTo = isset($applyingArray[0]['manager_id']) && $applyingArray[0]['manager_id'] == $employeeId;
        $isEmpInCcTo = isset($ccArray[0]['emp_id']) && $ccArray[0]['emp_id'] == $employeeId;

        if ($isManagerInApplyingTo || $isEmpInCcTo) {
            $matchingLeaveApplications[] = $leaveRequest;
        }
    }
    //count of pending leaves
    $this->count = count($matchingLeaveApplications);
    $this->leaveApplications = $matchingLeaveApplications;


     //query to fetch the approved leave appplications............

     $this->approvedLeaveRequests = LeaveRequest::whereIn('leave_applications.status', ['approved', 'rejected'])
     ->where(function ($query) use ($employeeId) {
         $query->whereJsonContains('applying_to', [['manager_id' => $employeeId]])
             ->orWhereJsonContains('cc_to', [['emp_id' => $employeeId]]);
     })
     ->join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
     ->where(function ($query) {
         $query->where('leave_applications.emp_id', 'LIKE', '%' . $this->searchQuery . '%')
             ->orWhere('leave_applications.leave_type', 'LIKE', '%' . $this->searchQuery . '%')
             ->orWhere('employee_details.first_name', 'LIKE', '%' . $this->searchQuery . '%')
             ->orWhere('employee_details.last_name', 'LIKE', '%' . $this->searchQuery . '%');
     })
     ->orderBy('created_at', 'desc')
     ->get(['leave_applications.*', 'employee_details.image', 'employee_details.first_name', 'employee_details.last_name']);

 $approvedLeaveApplications = [];

 foreach ($this->approvedLeaveRequests as $approvedLeaveRequest) {
     $applyingToJson = trim($approvedLeaveRequest->applying_to);
     $applyingArray = is_array($applyingToJson) ? $applyingToJson : json_decode($applyingToJson, true);

     $ccToJson = trim($approvedLeaveRequest->cc_to);
     $ccArray = is_array($ccToJson) ? $ccToJson : json_decode($ccToJson, true);

     $isManagerInApplyingTo = isset($applyingArray[0]['manager_id']) && $applyingArray[0]['manager_id'] == $employeeId;
     $isEmpInCcTo = isset($ccArray[0]['emp_id']) && $ccArray[0]['emp_id'] == $employeeId;
     $approvedLeaveRequest->formatted_from_date = Carbon::parse($approvedLeaveRequest->from_date)->format('d-m-Y');
     $approvedLeaveRequest->formatted_to_date = Carbon::parse($approvedLeaveRequest->to_date)->format('d-m-Y');

     if ($isManagerInApplyingTo || $isEmpInCcTo) {
         // Get leave balance for the current year only
         $leaveBalances = LeaveBalances::getLeaveBalances($approvedLeaveRequest->emp_id, $selectedYear);
         // Check if the from_date year is equal to the current year
         $fromDateYear = Carbon::parse($approvedLeaveRequest->from_date)->format('Y');

          if($fromDateYear == $selectedYear) {
             // Get leave balance for the current year only
             $leaveBalances = LeaveBalances::getLeaveBalances($approvedLeaveRequest->emp_id, $selectedYear);
         } else {
             // If from_date year is not equal to the current year, set leave balance to 0
             $leaveBalances = 0;
         }
         $approvedLeaveApplications[] =  [
             'approvedLeaveRequest' => $approvedLeaveRequest,
             'leaveBalances' => $leaveBalances,
         ];
     }
 }

 $this->approvedLeaveApplicationsList = $approvedLeaveApplications;


    return view('livewire.employees-review',[
        'leaveApplications' => $this->leaveApplications,
        'matchingLeaveApplications' => $matchingLeaveApplications,
        'count' => $this->count,
        'approvedLeaveApplicationsList' => $this->approvedLeaveApplicationsList,
        'empLeaveRequests' => $this->empLeaveRequests,
        'activeContent' => $this->activeContent,
        'regularisation_count' => $this->regularisation_count,
        'countofregularisations' => $this->countofregularisations
    ]);
 }
}
