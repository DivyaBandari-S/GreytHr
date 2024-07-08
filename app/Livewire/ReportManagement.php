<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReportManagement extends Component
{
    public $currentSection = " ";

    public $searching=0;

    public $search;

    public $employees;
    public function showContent($section)
    {
        
        $this->currentSection = $section;
        
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


        return view('livewire.report-management');

    }

}
