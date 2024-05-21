<?php

namespace App\Livewire;

use App\Models\Company;
use App\Models\EmployeeDetails;
use Livewire\Component;
use App\Models\SalaryRevision;
use App\Models\EmpBankDetail;
use Illuminate\Support\Facades\Auth;

class DownloadPdf extends Component
{
    public $employeeDetails;
    public $salaryRevision;
    public $empBankDetails;
    public $companies;
    public function render()
{

   
    
   $employeeId = auth()->guard('emp')->user()->emp_id;
    $this->employeeDetails =  EmployeeDetails::where('emp_id', $employeeId)->get();
    $this->salaryRevision =  SalaryRevision::where('emp_id', $employeeId)->get();
    $this-> empBankDetails=  EmpBankDetail::where('emp_id', $employeeId)->get();
    $this->companies = Company::join('employee_details', 'companies.company_id', '=', 'employee_details.company_id')
    ->where('employee_details.emp_id', $employeeId)
    ->orderBy('employee_details.created_at', 'desc')
    ->get();
    
    return view('livewire.download-pdf', ['employees' => $this->employeeDetails],['salaryRevision' => $this->salaryRevision],['empBankDetails' => $this->empBankDetails],['companies' => $this->companies]);
   
}

}