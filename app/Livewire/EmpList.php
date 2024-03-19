<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EmployeeDetails;
use App\Models\Company;

class EmpList extends Component
{
    public $employees;
    public $companies;
    public $hrDetails;
    public $counter = 1;
    public $search = '';

    public function logout()
    {
        auth()->guard('com')->logout();
        return redirect('/Login&Register');
    }

    // In your Livewire component class
    public function deleteEmp($id)
    {
        $emp = EmployeeDetails::find($id);

        if ($emp) {
            // Toggle the status between 0 and 1
            $emp->update(['status' => $emp->status == 1 ? 0 : 1]);

            // Assuming you have some logic to refresh the employee list; for example:
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
        $hrEmail = auth()->guard('com')->user()->contact_email;
        $hrCompanies = Company::where('contact_email', $hrEmail)->get();
        $hrDetails = Company::where('contact_email', $hrEmail)->first();
        $this->companies = $hrCompanies;
        $this->hrDetails = $hrDetails;     
        $this->employees = EmployeeDetails::where('company_id', $hrDetails->company_id)->where(function ($query) {
            $query->where('first_name', 'like', '%' . $this->search . '%')
                ->orWhere('last_name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('emp_id', 'like', '%' . $this->search . '%')
                ->orWhere('mobile_number', 'like', '%' . $this->search . '%');
        })->orderBy('status', 'desc')->get();
        // Check if there's a search query
        // If there is, apply search criteria


        return view('livewire.emp-list');
    }
}
