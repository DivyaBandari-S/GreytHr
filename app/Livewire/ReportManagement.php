<?php

namespace App\Livewire;
use Carbon\Carbon;
use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelWriter;
use App\Models\LeaveRequest;
class ReportManagement extends Component
{
    public $currentSection = " ";

    public $searching=0;

    public $sno;
    public $employeeType;
    public $leaveType;
    public $search;
    public $fromDate;
    public $sortBy;
    public $toDate;

    public $employees;
    public function showContent($section)
    {

        $this->currentSection = $section;
        $this->resetFields();

    }
    public function updateLeaveType()
    {
        $this->leaveType=$this->leaveType;
    }

    public function  updateSortBy()
    {
        $this->sortBy=$this->sortBy;
    }

    public function  updateEmployeeType()
    {
        $this->employeeType=$this->employeeType;
    }

    public function closeShiftSummaryReport()
    {
        $this->currentSection='';
    }
    public function closeAbsentReport()
    {
        $this->currentSection='';
    }
    public function showContent1($section)
    {

        $this->currentSection = $section;


    }
    public function searchfilter()
    {
       $this->searching=1;
    }
    public function close()
    {
        $this->currentSection='';
        $this->resetErrorBag();
        $this->resetFields();
    }

    public function updateFromDate()
    {
        $this->fromDate = $this->fromDate;
    }
    public function updateToDate()
    {
        $this->toDate = $this->toDate;
    }



     public $myTeam;
     protected $rules = [
        'fromDate' => 'required|date',
        'toDate' => 'required|date|after_or_equal:fromDate',
        'leaveType' => 'required',
        'employeeType' => 'required',
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->resetErrorBag($propertyName); // Clear errors for the updated property
    }

    public function resetFields()
    {
        $this->fromDate = null;
        $this->toDate = null;
        $this->leaveType = null;
        $this->employeeType = null;
    }

     public function downloadLeaveAvailedReportInExcel()
     {
        $this->validate([
            'fromDate' => 'required|date',
            'toDate' => 'required|date|after_or_equal:fromDate',
            'leaveType' => 'required',
            'employeeType' => 'required',
        ], [
            'fromDate.required' => 'From date is required.',
            'toDate.required' => 'To date is required.',
            'toDate.after_or_equal' => 'To date must be a date after or equal to the from date.',
            'leaveType.required' => 'Leave type is required.',
            'employeeType.required' => 'Employee type is required.',
        ]);

         $companyId = Auth::user()->company_id;
         $this->peoples = EmployeeDetails::with('starredPeople')
             ->where('company_id', $companyId)
             ->where('employee_status', 'active')
             ->orderBy('first_name')
             ->orderBy('last_name')
             ->get();

         $this->sno = 0;
         $employeeId = auth()->guard('emp')->user()->emp_id;
         $managerDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

         $query = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
             ->where('leave_type', $this->leaveType)
             ->select('leave_applications.*', 'employee_details.first_name', 'employee_details.last_name')
             ->orderBy('leave_applications.emp_id', 'asc');

         if ($this->employeeType == 'past') {
             $query->where(function ($query) {
                 $query->where('employee_details.employee_status', 'resigned')
                     ->orWhere('employee_details.employee_status', 'terminated');
             });
         } else {
             $query->where('employee_details.employee_status', $this->employeeType);
         }

         // Apply date filters if set
         if ($this->fromDate && $this->toDate) {
             $fromDate = Carbon::parse($this->fromDate)->startOfDay();
             $toDate = Carbon::parse($this->toDate)->endOfDay();
             $query->whereBetween('leave_applications.from_date', [$fromDate, $toDate]);
         }

         $this->myTeam = $query->get();

         $data = [
             ['List of Employees'],
             ['Sl No.', 'Employee No', 'Name', 'Manager No', 'Manager Name', 'Leave Type', 'From', 'To', 'Days', 'Reason', 'Applied date', 'Approved Date', 'Approver']
         ];

         foreach ($this->myTeam as $leaveAvailedRep) {
             $fromDate = Carbon::parse($leaveAvailedRep->from_date)->format('d-m-Y');
             $toDate = Carbon::parse($leaveAvailedRep->to_date)->format('d-m-Y');
             $createdAt = Carbon::parse($leaveAvailedRep->created_at)->format('d-m-Y');
             $updatedAt = Carbon::parse($leaveAvailedRep->updated_at)->format('d-m-Y');
             $leaveDays = $leaveAvailedRep->calculateLeaveDays(
                $leaveAvailedRep->from_date,
                $leaveAvailedRep->from_session,
                $leaveAvailedRep->to_date,
                $leaveAvailedRep->to_session
            );
                 $data[] = [
                 ++$this->sno,
                 $leaveAvailedRep->emp_id,
                 $leaveAvailedRep->first_name . ' ' . $leaveAvailedRep->last_name,
                 $managerDetails->emp_id,
                 $managerDetails->first_name . ' ' . $managerDetails->last_name,
                 $leaveAvailedRep->leave_type,
                 $fromDate,
                 $toDate,
                 $leaveDays,
                 $leaveAvailedRep->reason,
                 $createdAt,
                 $updatedAt,
                 $managerDetails->first_name . ' ' . $managerDetails->last_name
             ];
         }

         $filePath = storage_path('app/leave_availed_report.xlsx');
         $writer = SimpleExcelWriter::create($filePath);

         foreach ($data as $row) {
             $writer->addRow($row);
         }

         return response()->download($filePath, 'leave_availed_report.xlsx');


     }

     public $filteredEmployees;

     public function searchfilterleave()
     {
         $this->searching = 1;
         $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
         $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->get();
         $nameFilter = $this->search;

         $filteredEmployees = $employees->filter(function ($employee) use ($nameFilter) {
             return stripos($employee->first_name, $nameFilter) !== false ||
                 stripos($employee->last_name, $nameFilter) !== false ||
                 stripos($employee->emp_id, $nameFilter) !== false ||
                 stripos($employee->job_title, $nameFilter) !== false ||
                 stripos($employee->city, $nameFilter) !== false ||
                 stripos($employee->state, $nameFilter) !== false;
         });

         if ($filteredEmployees->isEmpty()) {
             $this->notFound = true;
         } else {
             $this->notFound = false;
         }
     }

        public function render()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;

        $search='';
        if($this->searching==1)
        {
            $this->employees = EmployeeDetails::where('manager_id', $loggedInEmpId)
            ->join('parent_details', 'employee_details.emp_id', '=', 'parent_details.emp_id')
            ->select('employee_details.*', 'parent_details.*')
            ->where(function($query) use ($search) {
                $query->where('employee_details.first_name', 'like', '%' . $search . '%')
                      ->orWhere('employee_details.last_name', 'like', '%' . $search . '%')
                      ->orWhere('parent_details.mother_occupation', 'like', '%' . $search . '%')
                      ->orWhere('parent_details.father_occupation', 'like', '%' . $search . '%');
            })
            ->get();
        }
        else
        {
            $this->employees = EmployeeDetails::where('manager_id', $loggedInEmpId)
        ->join('parent_details', 'employee_details.emp_id', '=', 'parent_details.emp_id')
        ->select('employee_details.*', 'parent_details.*')
        ->get();
        }

        // For Leave Balance On Day


        $this->employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();
        if ($this->searching == 1) {
            $nameFilter = $this->search; // Assuming $this->search contains the name filter
            $this->filteredEmployees = $this->employees->filter(function ($employee) use ($nameFilter) {
                return stripos($employee->first_name, $nameFilter) !== false ||
                    stripos($employee->last_name, $nameFilter) !== false ||
                    stripos($employee->emp_id, $nameFilter) !== false ||
                    stripos($employee->job_title, $nameFilter) !== false ||
                    stripos($employee->city, $nameFilter) !== false ||
                    stripos($employee->state, $nameFilter) !== false;
            });


            if ($this->filteredEmployees->isEmpty()) {
                $this->notFound = true; // Set a flag indicating that the name was not found
            } else {
                $this->notFound = false;
            }
        } else {
            $this->filteredEmployees = $this->employees;
        }

        return view('livewire.report-management');

    }

}
