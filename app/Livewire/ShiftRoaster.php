<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\HolidayCalendar;
use App\Models\LeaveRequest;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ShiftRoaster extends Component
{
    public $searching=1;
    public $search;

    public $holiday;
    public $notFound;

    public $selectedMonth;
    public $attendanceMonth;

    public $currentMonth;

    public $previousMonth;

    public $nextMonth;

    public $currentMonthForDropdown;
    public $currentYear;

    public $previousYear;

    public $nextYear;

    public $previousMonthWithPreviousYear;

    public $nextMonthWithPreviousYear;

    public $previousMonthWithNextYear;

    public $nextMonthWithNextYear;

    public $selectedMonthWithoutFormat;
    public $attendanceYear;
    public $previousMonthWithCurrentYear;

    public $currentMonthWithPreviousYear;
    public $nextMonthWithCurrentYear;

    public $currentMonthWithNextYear;
    public function mount()
    {
        $currentDate = now();
        $this->currentMonthForDropdown = now()->format('F'); // Current month (e.g., September)
        $this->previousMonth = now()->subMonth(1)->format('F'); // Previous month
        $this->nextMonth = now()->addMonth(1)->format('F'); // Next month
        $this->currentYear = $currentDate->year;
        $this->selectedMonth=now()->format('F');
        $this->selectedMonthWithoutFormat=now()->format('n');
        
    }
    
    public function updateselectedMonth()
    {
        $selected = explode(' ', $this->selectedMonth);
    
        // Update attendanceMonth and attendanceYear
        if (count($selected) === 2) {
            $this->attendanceMonth = $selected[0];  // The month part
            $this->attendanceYear = $selected[1];   // The year part
            
        }
    
        // Debug output to check if both month and year are updated correctly
   
    }
    public function searchfilter()
    {
        $searching = 1;
        $currentDate = now()->toDateString();
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->get();
        $nameFilter = $this->search;
        $filteredEmployees = $employees->filter(function ($employee) use ($nameFilter) {
            return stripos($employee->first_name, $nameFilter) !== false ||
                stripos($employee->last_name, $nameFilter) !== false ||
                stripos($employee->emp_id, $nameFilter) !== false ||
                stripos($employee->job_role, $nameFilter) !== false ||
                stripos($employee->job_location, $nameFilter) !== false ||
                stripos($employee->state, $nameFilter) !== false;
        });

        if ($filteredEmployees->isEmpty()) {
            $this->notFound = true; 
        } else {
            $this->notFound = false;
        } 
        
    }
    public function downloadExcel()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name','shift_type')->get();
        $currentMonth = $this->selectedMonth;
        $currentMonth1 = DateTime::createFromFormat('F', $currentMonth)->format('n');
        $currentYear = date('Y');
        $holiday = HolidayCalendar::where('month', $currentMonth)
                ->where('year', $currentYear)
                ->pluck('date')
                ->toArray();
        if(empty($holiday))
        {
           $count_of_holiday=0;  
        }
        else
        {
            $count_of_holiday=count($holiday);
            
        }
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth1, $currentYear);
        $data = [['List of Employees for ' . $currentMonth. ' ' . $currentYear],
                  ['Employee ID', 'Name', 'No. of Regular Days'],
                ];
       for ($i = 1; $i <= $daysInMonth; $i++) {
                $date = new DateTime("$currentYear-$currentMonth1-$i");
                // Get the day name
                $dayName = $date->format('D');
                $data[1][] = $i . $dayName; 

       }
       foreach ($employees as $employee) {
        $rowData = [$employee['emp_id'], ucwords(strtolower($employee['first_name'])) . ' ' . ucwords(strtolower($employee['last_name']))];
        
        
        $dateCount=0;
        for ($i = 1; $i <= $daysInMonth; $i++) 
        {
            $currentDate = $currentYear . '-' . str_pad($currentMonth1, 2, '0', STR_PAD_LEFT) . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            if (date('N', strtotime($currentDate)) == 6 || date('N', strtotime($currentDate)) == 7) {
                $dateCount+=1; 
            }
           
        }
        $rowData[]=$daysInMonth-$dateCount-$count_of_holiday;
        
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $currentDate = $currentYear . '-' . str_pad($currentMonth1, 2, '0', STR_PAD_LEFT) . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            if (date('N', strtotime($currentDate)) == 6 || date('N', strtotime($currentDate)) == 7) {
                $rowData[] = 'O'; 
            }
            elseif(in_array($currentDate, $holiday)) {
                $rowData[] = 'H'; 
            }
            else{
                $rowData[] = $employee->shift_type; 
            } 
           
        }
        $data[] = $rowData;
    } 
      
       $filePath = storage_path('app/ShiftRoasterData.xlsx');
       SimpleExcelWriter::create($filePath)->addRows($data);
       return response()->download($filePath, 'Shift_Roaster_Data.xlsx');
    }
    public function render()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $currentMonth=$this->selectedMonth;
        $currentMonthWithoutFormat=$this->selectedMonthWithoutFormat;
        $currentYear = date('Y');  
        $year = $currentYear;
        $employees=EmployeeDetails::where('manager_id',$loggedInEmpId)->where('employee_status','active')->select('emp_id', 'first_name', 'last_name','job_role','job_location','shift_type')->get();
        $employeeIds = $employees->pluck('emp_id')->toArray();
        $this->holiday = HolidayCalendar::where('month',$currentMonth)
        ->where('year', $year)
        ->get('date');
        $approvedLeaveRequests1 = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
        ->where('leave_applications.status', 'approved')
        ->whereIn('leave_applications.emp_id', $employeeIds)
        ->whereDate('from_date', '>=', $year . '-' . $currentMonthWithoutFormat . '-01') // Dynamically set year and month
        ->whereDate('to_date', '<=', $year . '-' . $currentMonthWithoutFormat . '-31') // Dynamically set year and month
        ->get(['leave_applications.*', 'employee_details.emp_id', 'employee_details.first_name', 'employee_details.last_name'])
        ->mapWithKeys(function ($leaveRequest) {
            $fromDate = \Carbon\Carbon::parse($leaveRequest->from_date);
            $toDate = \Carbon\Carbon::parse($leaveRequest->to_date);
            $number_of_days = $fromDate->diffInDays($toDate) + 1;
            $dates = [];
            for ($i = 0; $i < $number_of_days; $i++) {
                $dates[] = $fromDate->copy()->addDays($i)->toDateString();
            }
            return [
                $leaveRequest->emp_id => [
                    'emp_id' => $leaveRequest->emp_id,
                    'dates' => $dates,
                ],
            ];
        }); 
        $leaveDates = [];
        foreach ($approvedLeaveRequests1 as $emp_id => $leaveRequest) {
            foreach ($leaveRequest['dates'] as $date) {
                $leaveDates[$emp_id][] = $date;
            }
        }
       
      
        $count_of_holiday=count($this->holiday);
        if($this->searching==1)
        {
                $nameFilter = $this->search; // Assuming $this->search contains the name filter
                $filteredEmployees = $employees->filter(function ($employee) use ($nameFilter) {
                    return stripos($employee->first_name, $nameFilter) !== false ||
                        stripos($employee->last_name, $nameFilter) !== false ||
                        stripos($employee->emp_id, $nameFilter) !== false||
                        stripos($employee->job_role, $nameFilter) !== false||
                        stripos($employee->job_location, $nameFilter) !== false;
                });

                if ($filteredEmployees->isEmpty()) {
                    $this->notFound = true; // Set a flag indicating that the name was not found
                } else {
                    $this->notFound = false;
                }
        }
        else
        {
            $filteredEmployees=$employees;
        }
        return view('livewire.shift-roaster',['Employees'=>$filteredEmployees,'Holiday'=> $this->holiday,'CountOfHoliday'=>$count_of_holiday,'Month'=>$currentMonth,'ApprovedLeaveRequests1'=>$approvedLeaveRequests1]);
    }
}
