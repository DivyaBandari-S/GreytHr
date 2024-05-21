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
use App\Models\EmployeeDetails;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\RegularisationNew;
use App\Models\RegularisationNew1;

use Livewire\Component;

class EmployeesReview extends Component
{
    public $count;
    public $leaveRequests;
    public $employeeId;
    public $leaveApplications;
    public $approvedLeaveRequests;
    public $applying_to= [];
    public $matchingLeaveApplications = [];
    public $leaveRequest;
    public $employeeDetails;
    public $approvedLeaveApplicationsList;
    public $searchQuery ='';
    public $filterData;
    public $selectedYear;
    public $empLeaveRequests;
    public $activeButton;
    public $activeButtonAttendance = false;
    public $regularisations;
    public $activeContent ;

    public $approvedRegularisationRequestList;

    public $searchTerm = '';

    public $regularisations_count;

    public $regularisation_count;
    public $currentSection="Attendance Regularization";
    public $section;
    public function showContent($section)
    {
        $this->currentSection = $section;
    }
    public function searchPendingLeave(){
        $this->render();
    }

    public function toggleActiveContent($section)
    {
        $this->activeButton[$section] = true;
        $this->activeContent = $section;
    }

    public function toggleClosedContent($section)
    {
        $this->activeButton[$section] = false;
        $this->activeContent = '';
    }

   public function mount(){


    $this->activeButton = [
        'Attendance Regularization' => true,
        'Confirmation' => true,
        'Resignations' => true,
        'Helpdesk' => true,
        'Leave' => true,
        'Leave Cancel' => true,
        'Leave Comp Off' => true,
        'Restricted Holiday' => true,
    ];

    $this->selectedYear = Carbon::now()->format('Y');
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
            }elseif($this->getSessionNumber($fromSession) !== $this->getSessionNumber($toSession)){
                if ($this->getSessionNumber($fromSession) !== 1) {
                    $totalDays += 1; // Add half a day
                }
            }
            else {
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
public $Leave;
    public function navigateToHelpdesk()
    {
        $this->currentSection = 'Leave';
        $this->showContent('Leave');
        return redirect('employees-review');
    }


    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $employees=EmployeeDetails::where('manager_id',$employeeId)->select('emp_id', 'first_name', 'last_name')->get();
        $empIds = $employees->pluck('emp_id')->toArray();
        // Retrieve records from AttendanceRegularisationNew for the extracted emp_ids

        $this->regularisations = RegularisationNew1::whereIn('emp_id', $empIds)
        ->where('is_withdraw', 0) // Assuming you want records with is_withdraw set to 0
        ->where('status','pending')
        ->whereJsonDoesntContain('regularisation_entries', [])
        ->get();
        // Fetch all leave requests (pending, approved, rejected) for the logged-in user and company
        $this->empLeaveRequests = LeaveRequest::with('employee')
        ->where('emp_id', $employeeId)
        ->whereIn('status', ['approved', 'rejected', 'Withdrawn'])
        ->orderBy('created_at', 'desc')
        ->get();

        // Format the date properties
        foreach ($this->empLeaveRequests as $leaveRequest) {
            $leaveRequest->formatted_from_date = Carbon::parse($leaveRequest->from_date)->format('d-m-Y');
            $leaveRequest->formatted_to_date = Carbon::parse($leaveRequest->to_date)->format('d-m-Y');
        }
       //query to fetch the pending leave appplications to approve manager
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

         //query to fetch the approved leave appplications
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

                if ($fromDateYear == $selectedYear) {
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

        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;

        $employees=EmployeeDetails::where('manager_id',$loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();

        $empIds = $employees->pluck('emp_id')->toArray();

        $this->approvedRegularisationRequestList = RegularisationNew1::whereIn('regularisation_new1s.emp_id', $empIds)

        ->whereIn('regularisation_new1s.status', ['approved', 'rejected'])

        ->orderByDesc('regularisation_new1s.id')

        ->join('employee_details', 'regularisation_new1s.emp_id', '=', 'employee_details.emp_id')

        ->select('regularisation_new1s.*', 'employee_details.first_name', 'employee_details.last_name')

        ->orderByDesc('id')

        ->get();

        $this->regularisations = RegularisationNew1::whereIn('emp_id', $empIds)

        ->where('is_withdraw', 0)

        ->where('status', 'pending')

        ->whereRaw('JSON_LENGTH(regularisation_entries) > 0') // Exclude records with empty regularisation_entries

        ->with('employee')

        ->get();
        $this->countofregularisations=count($this->regularisations);

           $this->approvedRegularisationRequestList = $this->approvedRegularisationRequestList->filter(function ($regularisation) {

            return $regularisation->regularisation_entries !== "[]";

    });
        return view('livewire.employees-review', [
            'leaveApplications' => $this->leaveApplications,
            'count' => $this->count,
            'approvedLeaveApplicationsList' => $this->approvedLeaveApplicationsList,
            'empLeaveRequests' => $this->empLeaveRequests,
            'activeContent' => $this->activeContent,
            'regularisation_count'=>$this->regularisation_count,
            'countofregularisations' => $this->countofregularisations
        ]);
    }


}
