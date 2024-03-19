<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use Livewire\Component;
use App\Models\SalaryRevision;
use App\Models\EmpBankDetail;
class DownloadPdf extends Component
{
    public $employeeDetails;
    public $salaryRevision;
    public $empBankDetails;
    public function render()
{

   
    
   $employeeId = auth()->guard('emp')->user()->emp_id;
    $this->employeeDetails =  EmployeeDetails::where('emp_id', $employeeId)->get();
    $this->salaryRevision =  SalaryRevision::where('emp_id', $employeeId)->get();
    $this-> empBankDetails=  EmpBankDetail::where('emp_id', $employeeId)->get();
    return view('livewire.download-pdf', ['employees' => $this->employeeDetails],['salaryRevision' => $this->salaryRevision],['empBankDetails' => $this->empBankDetails]);
   
}

}