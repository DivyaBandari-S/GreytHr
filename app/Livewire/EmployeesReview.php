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

    public $searching = 0;

    public $search = '';
    public $showattendance = true;
    public $showleave = false;
    public $approvedRegularisationRequestList;
    public $count;
    public $approvedLeaveApplicationsList;
    public $empLeaveRequests;
    public $activeContent, $leaveRequests;
    public $regularisation_count;
    public $countofregularisations;
    public $leaveApplications = [];
    public $approvedLeaveRequests;
    public $searchQuery = '';
    public $selectedYear;
    public $toggleAccordian = false;

    public $matchingLeaveApplications = [];
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
    public function getApprovedLeaveRequests()
    {
        try {
            $this->selectedYear = Carbon::now()->format('Y');
            $selectedYear = $this->selectedYear;
            $employeeId = auth()->guard('emp')->user()->emp_id;
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
                        ->orWhere('leave_applications.status', 'LIKE', '%' . $this->searchQuery . '%')
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
        } catch (\Exception $e) {
            Log::error('Error in getPendingLeaveRequest method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while processing your request. Please try again later.');
        }
    }
    public function getEmpLeaveRequests()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            // Query leave requests with search filter
            $query = LeaveRequest::with('employee')
                ->where('emp_id', $employeeId)
                ->whereIn('status', ['approved', 'rejected', 'Withdrawn'])
                ->orderBy('created_at', 'desc');

            // Apply search filter if searchQuery is not empty
            if (!empty($this->searchQuery)) {
                $query->where(function ($query) {
                    $query->whereHas('employee', function ($query) {
                        $query->where('first_name', 'LIKE', '%' . $this->searchQuery . '%')
                            ->orWhere('last_name', 'LIKE', '%' . $this->searchQuery . '%');
                    })
                        ->orWhere('leave_type', 'LIKE', '%' . $this->searchQuery . '%')
                        ->orWhere('status', 'LIKE', '%' . $this->searchQuery . '%');
                });
            }

            // Fetch results
            $this->empLeaveRequests = $query->get();

            // Format the date properties
            foreach ($this->empLeaveRequests as $leaveRequest) {
                $leaveRequest->formatted_from_date = Carbon::parse($leaveRequest->from_date)->format('d-m-Y');
                $leaveRequest->formatted_to_date = Carbon::parse($leaveRequest->to_date)->format('d-m-Y');
            }
        } catch (\Exception $e) {
            Log::error('Error in getEmpLeaveRequests method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while fetching leave requests. Please try again later.');
        }
    }



    public function mount(Request $request)
    {

        $this->getEmpLeaveRequests();
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
// TO reduce notification count by making as read related to leave and leaveCancel

        DB::table('notifications')
        ->whereIn('notification_type', ['leave', 'leaveCancel'])
        ->update(['is_read' => 1]);

    }


    public function getPendingLeaveRequest()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $companyId = auth()->guard('emp')->user()->company_id;

            // Retrieve team members' emp_ids where logged-in user is the manager
            $teamMembersIds = EmployeeDetails::where('manager_id', $employeeId)
                ->where('company_id', $companyId)
                ->pluck('emp_id')
                ->toArray();

            // Query leave requests for team members with specified conditions
            $query = LeaveRequest::whereIn('emp_id', $teamMembersIds)
                ->where(function ($query) {
                    $query->where('status', 'pending')
                        ->orWhere(function ($query) {
                            $query->where('status', 'approved')
                                ->where('cancel_status', 'Pending Leave Cancel');
                        });
                })
                ->orderBy('created_at', 'desc');

            // Apply search filter if $this->searchQuery is provided
            if (!empty($this->searchQuery)) {
                $query->where(function ($query) {
                    $query->where('emp_id', 'LIKE', '%' . $this->searchQuery . '%')
                        ->orWhere('leave_type', 'LIKE', '%' . $this->searchQuery . '%')
                        ->orWhere('status', 'LIKE', '%' . $this->searchQuery . '%');
                });
            }

            // Execute the query
            $this->leaveApplications = $query->get();
            $this->count = count($this->leaveApplications);

        } catch (\Exception $e) {
            Log::error('Error in getPendingLeaveRequest method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while processing your request. Please try again later.');
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
            $this->getEmpLeaveRequests();
        } catch (\Exception $e) {
            Log::error('Error in searchPendingLeave method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while processing your request. Please try again later.');
        }
    }


    public function searchApprovedLeave()
    {
        $this->searching = 1;
    }

    public function render()
    {
        $this->getApprovedLeaveRequests();
        $this->getPendingLeaveRequest();
        //query to fetch the approved leave appplications............
        $employeeId = auth()->guard('emp')->user()->emp_id;

        $employees = EmployeeDetails::where('manager_id', $employeeId)->select('emp_id', 'first_name', 'last_name')->get();
        $empIds = $employees->pluck('emp_id')->toArray();

        if ($this->searching == 1) {
            $this->approvedRegularisationRequestList = RegularisationDates::whereIn('regularisation_dates.emp_id', $empIds)

                ->whereIn('regularisation_dates.status', ['approved', 'rejected'])

                ->orderByDesc('regularisation_dates.id')

                ->join('employee_details', 'regularisation_dates.emp_id', '=', 'employee_details.emp_id')

                ->where(function ($query) {
                    $query->where('regularisation_dates.emp_id', 'LIKE', '%' . $this->searchQuery . '%')
                        ->orWhere('employee_details.first_name', 'LIKE', '%' . $this->searchQuery . '%')
                        ->orWhere('employee_details.last_name', 'LIKE', '%' . $this->searchQuery . '%')
                        ->orWhere('regularisation_dates.status', 'LIKE', '%' . $this->searchQuery . '%');
                })

                ->select('regularisation_dates.*', 'employee_details.first_name', 'employee_details.last_name')

                ->orderByDesc('regularisation_dates.updated_at')

                ->get();
        } else {
            $this->approvedRegularisationRequestList = RegularisationDates::whereIn('regularisation_dates.emp_id', $empIds)

                ->whereIn('regularisation_dates.status', ['approved', 'rejected'])

              

                ->join('employee_details', 'regularisation_dates.emp_id', '=', 'employee_details.emp_id')


                ->select('regularisation_dates.*', 'employee_details.first_name', 'employee_details.last_name')

                ->orderByDesc('updated_at')

                ->get();
        }
        $this->approvedRegularisationRequestList = $this->approvedRegularisationRequestList->filter(function ($regularisation) {

            return $regularisation->regularisation_entries !== "[]";
        });

        return view('livewire.employees-review', [
            'leaveApplications' => $this->leaveApplications,
            'matchingLeaveApplications' => $this->matchingLeaveApplications,
            'count' => $this->count,
            'searchQuery' => $this->searchQuery,
            'approvedLeaveApplicationsList' => $this->approvedLeaveApplicationsList,
            'empLeaveRequests' => $this->empLeaveRequests,
            'activeContent' => $this->activeContent,
            'regularisation_count' => $this->regularisation_count,
            'countofregularisations' => $this->countofregularisations
        ]);
    }
}
