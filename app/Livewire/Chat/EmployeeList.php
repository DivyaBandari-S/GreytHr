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
        $query = EmployeeDetails::query()->where('status', 1)
        ->orderBy('first_name');

        // Filter by department if selected
        if (!empty($this->selectedDepartment)) {
            $query->where('dept_id', $this->selectedDepartment);
        }

        // Filter by sub-department if selected
        if (!empty($this->selectedSubDepartment)) {
            $query->where('sub_dept_id', $this->selectedSubDepartment);
        }

        // Search employees by name or other attributes
        if (!empty($this->searchTerm)) {
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
        $authUserId = auth()->user()->emp_id; // Get authenticated user's emp_id

        // Check if a one-to-one conversation already exists between the two users
        $conversation = \App\Models\Conversation::where(function ($query) use ($authUserId, $empId) {
            $query->where('sender_id', $authUserId)
                  ->where('receiver_id', $empId);
        })->orWhere(function ($query) use ($authUserId, $empId) {
            $query->where('sender_id', $empId)
                  ->where('receiver_id', $authUserId);
        })->first();

        // If no conversation exists, create a new one
        if (!$conversation) {
            $conversation = \App\Models\Conversation::create([
                'sender_id' => $authUserId,
                'receiver_id' => $empId,
                'last_time_message' => now(),
            ]);
        }

        // Redirect to the chat interface with the conversation ID
        return redirect()->route('chat');
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
