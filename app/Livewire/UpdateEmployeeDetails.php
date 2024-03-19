<?php
// File Name                       : UpdateEmployeeDetails.php
// Description                     : This file contains the implementation of list employee details admin side
// Creator                         : Bandari Divya
// Email                           : bandaridivya1@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : EmployeeDetails
namespace App\Livewire;

use Livewire\Component;
use App\Models\EmployeeDetails;
use App\Models\Company;

class UpdateEmployeeDetails extends Component
{
    public $employees;
    public $employeeId;
    public $companies;
    public $hrDetails;
    public $counter = 1;
    public $search = '';

    public function logout()
    {
        auth()->guard('com')->logout();
        return redirect('/Login&Register');
    }

    // soft delete employee
    public function deleteEmp($id)
    {
        $emp = EmployeeDetails::find($id);

        if ($emp) {
            // Toggle the status between 0 and 1
            $emp->update(['status' => $emp->status == 1 ? 0 : 1]);
        }
    }

    public $filteredEmployees;

    public function filter()
    {
        $this->filteredEmployees = EmployeeDetails::where(function ($query) {
            $query->where('first_name', 'like', '%' . $this->search . '%')
                ->orWhere('last_name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('emp_id', 'like', '%' . $this->search . '%')
                ->orWhere('mobile_number', 'like', '%' . $this->search . '%');
        })
            ->get();
    }
    public function render()
    {
        $hrEmail = auth()->guard('hr')->user()->company_id;
        $hrCompanies = Company::where('company_id', $hrEmail)->get();
        $hrDetails = Company::where('company_id', $hrEmail)->first();
        $this->companies = $hrCompanies;
        $this->hrDetails = $hrDetails;
        $this->employees = EmployeeDetails::where('company_id', $hrDetails->company_id)->where(function ($query) {
            $query->where('first_name', 'like', '%' . $this->search . '%')
                ->orWhere('last_name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('emp_id', 'like', '%' . $this->search . '%')
                ->orWhere('mobile_number', 'like', '%' . $this->search . '%');
        })->orderBy('status', 'desc')->get();
        return view('livewire.update-employee-details');
    }
  
}
