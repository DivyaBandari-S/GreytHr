<?php
// File Name                       : WhoisinChartHr.php
// Description                     : This file contains the list of employees under the company hr who are on leave ,who arrived late,who arrived on time.
// Creator                         : Pranita Priyadarshi
// Email                           : priyadarshipranita72@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : EmployeeDetails,SwipeRecord
namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\Hr;
use App\Models\SwipeRecord;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;

class WhoisinChartHr extends Component
{
    public $employees;
    public $absentemployees;
    public $absentemployeescount;

    public $lateemployees;
   

    public $lateemployeescount;
 
    public $isdatepickerclicked=0;
  
    public $search = '';
    public $from_date;
    public $notFound;
    // public $notFound2;
    // public $notFound3;
    public $earlyemployees;

    public $currentDate;
    public $showPopup = false;
    public $earlyemployeescount;

    
    public $openRows = [];
    public function toggleAccordion($empId)
    {
        if (isset($this->openRows[$empId])) {
            unset($this->openRows[$empId]);
        } else {
            $this->openRows[$empId] = true;
        }
    }
    

    public function updateDate()
    {
    
        $this->isdatepickerclicked=1;
        $date =$this->from_date;
        
        return $date;
    }
    public function togglePopup()
    {
       $this->showPopup=true;
      
    }   
    public function searchFilters()
    {
        // dd($this->search);
    }
    // public function downloadExcelForAbsent()
    // {
    //     $employees = EmployeeDetails::all();

    //     return response()->xlsx($employees, 'employees.xlsx');
    // }
    public function downloadExcelForAbsent()
    {
        $companyId = Auth::user()->company_id;
        if($this->isdatepickerclicked==1)
        {
            $this->currentDate=$this->updateDate();
            
            // dd($this->currentDate);
        }
        else
        {
           $this->currentDate = now()->toDateString();
        }
        $currentDate1=$this->currentDate;
        $formattedDate = \Carbon\Carbon::parse($currentDate1)->format('jS M Y');
        $this->absentemployees = EmployeeDetails::select('emp_id', 'first_name', 'last_name')
        ->where('company_id', '=', $companyId)
                ->whereNotIn('emp_id', function ($query) use ($currentDate1) {
                    $query->select('emp_id')
                        ->from('swipe_records')
                        ->whereDate('created_at', $currentDate1);
                })
              ->get();
        $userId = Auth::id();
        $companyName = Hr::join('companies', 'hr.company_id', '=', 'companies.company_id')
        ->where('hr.hr_emp_id', $userId)
        ->value('companies.company_name');
        
        $data[]=[$companyName];
        $data[] = ['Absent Employees on ' .  $formattedDate, '', '', ''];
        $data[] = ['Employee ID', 'First Name', 'Last Name', 'Expected In Time'];
        foreach ($this->absentemployees as $employee) {
            $data[] = [$employee->emp_id, $employee->first_name, $employee->last_name,'10:00:00'];
        }
    
        $filePath = storage_path('app/employees.xlsx');
    
        SimpleExcelWriter::create($filePath)->addRows($data);
    
        return response()->download($filePath, 'absentemployees.xlsx');
    }
    public function downloadExcelForLateArrivals()
    {
        $companyId = Auth::user()->company_id;
        if($this->isdatepickerclicked==1)
        {
            $this->currentDate=$this->updateDate();
            
            // dd($this->currentDate);
        }
        else
        {
           $this->currentDate = now()->toDateString();
        }
        $currentDate1=$this->currentDate;
        $formattedDate = \Carbon\Carbon::parse($currentDate1)->format('jS M Y');
        $this->lateemployees = EmployeeDetails::where('company_id', '=', $companyId)->
        whereExists(function ($query) use ($currentDate1) {
            $query->select('emp_id')
                ->from('swipe_records')
                ->whereRaw('DATE(created_at) = ?', [$currentDate1])
                ->whereRaw('TIME(created_at) > ?', ['10:00:00'])
                ->whereRaw('swipe_records.emp_id = employee_details.emp_id')
                ->where('in_or_out', 'IN'); // Add condition for in_or_out
        })
        ->select('emp_id', 'first_name', 'last_name')
        ->addSelect(['swipe_time' => SwipeRecord::select('swipe_time')
            ->whereColumn('swipe_records.emp_id', 'employee_details.emp_id')
            ->whereRaw('DATE(swipe_records.created_at) = ?', [$currentDate1])
            ->whereRaw('TIME(swipe_records.created_at) > ?', ['10:00:00'])
            ->where('in_or_out', 'IN') // Add condition for in_or_out
            ->limit(1) // Assuming only one record is expected
        ])
        ->get();
        $userId = Auth::id();
        $companyName = Hr::join('companies', 'hr.company_id', '=', 'companies.company_id')
        ->where('hr.hr_emp_id', $userId)
        ->value('companies.company_name');
        $data[]=[$companyName];
        $data[] = ['Late Employees on ' .  $formattedDate, '', '', ''];
        $data[] = ['Employee ID', 'First Name', 'Last Name', 'Swipe Time','Late By'];
    
        foreach ($this->lateemployees as $employee) {
            $swipeTime = \Carbon\Carbon::parse($employee->swipe_time);
            $lateTime = \Carbon\Carbon::parse('10:00:00');
            $lateBy =  $swipeTime->diff($lateTime)->format('%H:%I');
            $data[] = [$employee->emp_id, $employee->first_name, $employee->last_name,$employee->swipe_time,$lateBy];
        }
    
        $filePath = storage_path('app/employees.xlsx');
    
        SimpleExcelWriter::create($filePath)->addRows($data);
    
        return response()->download($filePath, 'lateemployees.xlsx');
    }
    public function downloadExcelForEarlyArrivals()
    {
        $companyId = Auth::user()->company_id;
        if($this->isdatepickerclicked==1)
        {
            $this->currentDate=$this->updateDate();
            
            // dd($this->currentDate);
        }
        else
        {
           $this->currentDate = now()->toDateString();
        }
        $currentDate1=$this->currentDate;
        $formattedDate = \Carbon\Carbon::parse($currentDate1)->format('jS M Y');
        $this->earlyemployees = EmployeeDetails::where('company_id', '=', $companyId)->
        whereExists(function ($query) use ($currentDate1) {
            $query->select('emp_id')
                ->from('swipe_records')
                ->whereRaw('DATE(created_at) = ?', [$currentDate1])
                ->whereRaw('TIME(created_at) < ?', ['10:00:00']) // Adjust the condition to be less than
                ->whereRaw('swipe_records.emp_id = employee_details.emp_id')
                ->where('in_or_out', 'IN');
        })
        ->select('emp_id', 'first_name', 'last_name')
        ->addSelect(['swipe_time' => SwipeRecord::select('swipe_time')
            ->whereColumn('swipe_records.emp_id', 'employee_details.emp_id')
            ->whereRaw('DATE(swipe_records.created_at) = ?', [$currentDate1])
            ->whereRaw('TIME(swipe_records.created_at) < ?', ['10:00:00']) // Adjust the condition to be less than
            ->where('in_or_out', 'IN')
            ->limit(1)
        ])
        ->get();
        $userId = Auth::id();
        $companyName = Hr::join('companies', 'hr.company_id', '=', 'companies.company_id')
        ->where('hr.hr_emp_id', $userId)
        ->value('companies.company_name');
        $data[]=[$companyName];
        $data[] = ['Early Employees on ' .  $formattedDate, '', '', ''];
        $data[] = ['Employee ID', 'First Name', 'Last Name', 'Swipe Time', 'Early By'];
    
        foreach ($this->earlyemployees as $employee) {
            $swipeTime = \Carbon\Carbon::parse($employee->swipe_time);
            $earlyTime = \Carbon\Carbon::parse('10:00:00');
            $earlyBy =  $earlyTime->diff($swipeTime)->format('%H:%I');
            $data[] = [$employee->emp_id, $employee->first_name, $employee->last_name,$employee->swipe_time,$earlyBy];
        }
    
        $filePath = storage_path('app/employees.xlsx');
    
        SimpleExcelWriter::create($filePath)->addRows($data);
    
        return response()->download($filePath, 'earlyemployees.xlsx');
    }
    public function render()
    {
        $companyId = Auth::user()->company_id;
     
        if($this->isdatepickerclicked==1)
        {
            $this->currentDate=$this->updateDate();
            
            // dd($this->currentDate);
        }
        else
        {
           $this->currentDate = now()->toDateString();
        }
        $currentDate1=$this->currentDate;
       
        $this->employees = EmployeeDetails::select('emp_id', 'first_name', 'last_name')->where('company_id',$companyId)->get();

       
        $this->absentemployees = EmployeeDetails::select('emp_id', 'first_name', 'last_name', 'mobile_number', 'company_email')
        ->where('company_id', '=', $companyId) // Replace $yourCompanyId with the actual company_id you are filtering
        ->whereNotIn('emp_id', function ($query) {
            $query->select('emp_id')
                ->from('swipe_records')
                ->whereDate('created_at', $this->currentDate);
        })
        ->when($this->search, function ($query, $search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('emp_id', 'like', '%' . $search . '%');
            });
        })
        ->get();
         
        
        
        
    
        $this->absentemployeescount = EmployeeDetails::select('emp_id', 'first_name', 'last_name')
        ->where('company_id', '=', $companyId) // Replace $yourCompanyId with the actual company_id you are filtering
        ->whereNotIn('emp_id', function ($query) use ($currentDate1) {
            $query->select('emp_id')
                ->from('swipe_records')
                ->whereDate('created_at', $currentDate1);
        })
        ->count();
        
        $this->lateemployees = EmployeeDetails::where('company_id', '=', $companyId) // Replace $yourCompanyId with the actual company_id you are filtering
        ->whereExists(function ($query) use ($currentDate1) {
            $query->select('emp_id')
                ->from('swipe_records')
                ->whereRaw('DATE(created_at) = ?', [$currentDate1])
                ->whereRaw('TIME(created_at) > ?', ['10:00:00'])
                ->whereRaw('swipe_records.emp_id = employee_details.emp_id')
                ->where('in_or_out', 'IN'); // Add condition for in_or_out
        })
        ->select('emp_id', 'first_name', 'last_name', 'mobile_number', 'company_email')
        ->addSelect(['swipe_time' => SwipeRecord::select('swipe_time')
            ->whereColumn('swipe_records.emp_id', 'employee_details.emp_id')
            ->whereRaw('DATE(swipe_records.created_at) = ?', [$currentDate1])
            ->whereRaw('TIME(swipe_records.created_at) > ?', ['10:00:00'])
            ->where('in_or_out', 'IN') // Add condition for in_or_out
            ->limit(1) // Assuming only one record is expected
        ])
        ->when($this->search, function ($query, $search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('emp_id', 'like', '%' . $search . '%');
            });
        })
        ->get();
         
        
        $this->lateemployeescount = EmployeeDetails::where('company_id', '=', $companyId) // Replace $yourCompanyId with the actual company_id you are filtering
        ->whereExists(function ($query) use ($currentDate1) {
            $query->select('emp_id')
                ->from('swipe_records')
                ->whereRaw('DATE(created_at) = ?', [$currentDate1])
                ->whereRaw('TIME(created_at) > ?', ['10:00:00'])
                ->whereRaw('swipe_records.emp_id = employee_details.emp_id')
                ->where('in_or_out', 'IN'); // Add condition for in_or_out
        })
        ->count();
        $this->earlyemployees = EmployeeDetails::whereExists(function ($query) use ($currentDate1) {
            $query->select('emp_id')
                ->from('swipe_records')
                ->whereRaw('DATE(created_at) = ?', [$currentDate1])
                ->whereRaw('TIME(created_at) < ?', ['10:00:00']) // Adjust the condition to be less than
                ->whereRaw('swipe_records.emp_id = employee_details.emp_id')
                ->where('in_or_out', 'IN');
        })
        ->select('emp_id', 'first_name', 'last_name','mobile_number','company_email')
        ->addSelect(['swipe_time' => SwipeRecord::select('swipe_time')
            ->whereColumn('swipe_records.emp_id', 'employee_details.emp_id')
            ->whereRaw('DATE(swipe_records.created_at) = ?', [$currentDate1])
            ->whereRaw('TIME(swipe_records.created_at) < ?', ['10:00:00']) // Adjust the condition to be less than
            ->where('in_or_out', 'IN')
            ->limit(1)
        ])
        ->when($this->search, function ($query, $search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                   ->orWhere('emp_id', 'like', '%' . $search . '%');
            });
        })
       
        ->get();
    
        $this->earlyemployeescount = EmployeeDetails::whereExists(function ($query) use ($currentDate1) {
            $query->select('emp_id')
                ->from('swipe_records')
                ->whereRaw('DATE(created_at) = ?', [$currentDate1])
                ->whereRaw('TIME(created_at) < ?', ['10:00:00']) // Adjust the condition to be less than
                ->whereRaw('swipe_records.emp_id = employee_details.emp_id')
                ->where('in_or_out', 'IN');
        })
        ->select('emp_id', 'first_name', 'last_name')
        ->addSelect(['swipe_time' => SwipeRecord::select('swipe_time')
            ->whereColumn('swipe_records.emp_id', 'employee_details.emp_id')
            ->whereRaw('DATE(swipe_records.created_at) = ?', [$currentDate1])
            ->whereRaw('TIME(swipe_records.created_at) < ?', ['10:00:00']) // Adjust the condition to be less than
            ->where('in_or_out', 'IN')
            ->limit(1)
        ])
        ->count();
        $earlyEmployeesCount =$this->earlyemployeescount;
        $absentemployeescount=$this->absentemployeescount;
        $lateemployeescount=$this->lateemployeescount;
        $totalEmployeesCount=$this->employees->count();
        
        if ($totalEmployeesCount > 0) {
            $earlypercentage = ($earlyEmployeesCount / $totalEmployeesCount) * 100;
            $latepercentage = ($lateemployeescount / $totalEmployeesCount) * 100;
            $absentpercentage = ($absentemployeescount / $totalEmployeesCount) * 100;
        } else {
            $absentpercentage = 0;
            $latepercentage=0; 
            $earlypercentage=0;// Handle the case where totalEmployeesCount is zero to avoid division by zero.
        }
       
          
       
        $currentDate = now()->toDateString();
        
        return view('livewire.whoisin-chart-hr',['currentDate'=>$currentDate,'absentpercentage'=>$absentpercentage,'latepercentage'=>$latepercentage,'earlypercentage'=>$earlypercentage]);
    }
}
