<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use Livewire\Component;

class FeedBack extends Component
{
    public $searchEmployee = '';
    public $personalizedMessage = '';
    public $feedbackType;
    public $isRequestModalOpen = false; // Controls Request Feedback modal
    public $isGiveModalOpen = false;    // Controls Give Feedback modal
    public $selectedEmployee = null; // To store the selected employee
    public $searchTerm = '';
    public $employees = []; // This will hold the search results
    protected $rules = [
        'searchEmployee' => 'required|string|max:255',
        'personalizedMessage' => 'required|string',
    ];

    public function openRequestModal()
    {
        $this->reset(['searchEmployee', 'personalizedMessage']);
        $this->isRequestModalOpen = true;
    }

    public function openGiveModal()
    {
        $this->reset(['searchEmployee', 'personalizedMessage']);
        $this->isGiveModalOpen = true;
    }

    public function closeModal()
    {
        $this->isRequestModalOpen = false;
        $this->isGiveModalOpen = false;
    }



    // This method will run whenever the search input is updated
    public function updatedSearchEmployee()
    {
        // Search query: looking for matches by name or emp_id
        $this->employees = EmployeeDetails::where('emp_id', 'like', '%' . $this->searchEmployee . '%')
            ->orWhere('first_name', 'like', '%' . $this->searchEmployee . '%')
            ->orWhere('last_name', 'like', '%' . $this->searchEmployee . '%')
            ->get();
    }

    // This method will set the selected employee
    public function selectEmployee($employeeId)
    {
        $this->selectedEmployee = EmployeeDetails::find($employeeId);
        $this->searchEmployee = $this->selectedEmployee->first_name; // Optionally, show the selected name in the input field
        $this->employees = []; // Clear the search results
    }
    public function clearSelectedEmployee()
    {
        $this->selectedEmployee = null;
        $this->searchTerm = '';
    }

    public function saveRequestFeedback()
    {
        $this->validate();

        // Save logic for request feedback
        // Example: Save to the database
        // RequestFeedback::create([
        //     'employee' => $this->searchEmployee,
        //     'message' => $this->personalizedMessage,
        // ]);

        $this->reset(['searchEmployee', 'personalizedMessage']);
        $this->isRequestModalOpen = false;
        session()->flash('message', 'Request Feedback submitted successfully!');
    }

    public function saveGiveFeedback()
    {
        $this->validate();

        // Save logic for give feedback
        // Example: Save to the database
        // GiveFeedback::create([
        //     'employee' => $this->searchEmployee,
        //     'message' => $this->personalizedMessage,
        // ]);

        $this->reset(['searchEmployee', 'personalizedMessage']);
        $this->isGiveModalOpen = false;
        session()->flash('message', 'Give Feedback submitted successfully!');
    }

    public function render()
    {
        return view('livewire.feed-back');
    }
}
