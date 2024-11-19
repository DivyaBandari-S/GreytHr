<?php

namespace App\Livewire\Chat;

use App\Models\EmpDepartment;
use App\Models\EmpSubDepartments;
use Livewire\Component;
use App\Models\EmployeeDetails;
use App\Models\EmpDept;
use App\Models\EmpSubDept;

class EmployeeList extends Component
{
    public $selectedDepartment = '';
    public $selectedSubDepartment = '';
    public $searchTerm = '';
    public $employeeDetails = [];

    public function filter()
    {
        // Fetch employees based on the selected department, sub-department, and search term
        $query = EmployeeDetails::query();

        // Filter by status, ensuring only employees with status 1 are included
        $query->where('status', 1)->orderBy('first_name');

        // Filter by department if selected
        if (!empty($this->selectedDepartment)) {
            $query->where('dept_id', $this->selectedDepartment);
        }

        // Filter by sub-department if selected
        if (!empty($this->selectedSubDepartment)) {
            $query->where('sub_dept_id', $this->selectedSubDepartment);
        }

        // Search employees by name, department or sub-department
        if (!empty($this->searchTerm)) {
            // Check if the search term matches a department or sub-department
            $department = EmpDepartment::where('department', 'like', '%' . $this->searchTerm . '%')->first();
            $subDepartment = EmpSubDepartments::where('sub_department', 'like', '%' . $this->searchTerm . '%')->first();

            // If a department is found, filter by dept_id
            if ($department) {
                $query->where('dept_id', $department->id);
            }

            // If a sub-department is found, filter by sub_dept_id
            if ($subDepartment) {
                $query->where('sub_dept_id', $subDepartment->id);
            }

            // Also search by employee's name or job role or emp_id
            $query->where(function ($subQuery) {
                $subQuery->where('first_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('job_role', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('emp_id', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Get the filtered employee details
        $this->employeeDetails = $query->get();
    }



    public function message($empId)
    {
       
    }

    public function render()
    {
        // Fetch all departments and sub-departments for the dropdowns
        $departments = EmpDepartment::all();
        $subDepartments = EmpSubDepartments::when($this->selectedDepartment, function ($query) {
            // Fetch sub-departments based on selected department
            return $query->where('dept_id', $this->selectedDepartment);
        })->get();

        // Apply the filter to fetch employees
        $this->filter();

        return view('livewire.chat.employee-list', [
            'departments' => $departments,
            'subDepartments' => $subDepartments,
        ]);
    }
}
