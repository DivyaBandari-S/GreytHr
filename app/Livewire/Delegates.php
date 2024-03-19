<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Delegate;
use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;


class Delegates extends Component
{
    protected $debug = true;
    public $workflow;
    public $fromDate;
    public $toDate;
    public $delegate;
    public $retrievedData;
    public $employeeDetails;

    protected $rules = [
     
        'workflow' => 'required',
        'fromDate' => 'required|date',
        'toDate' => 'required|date|after_or_equal:fromDate',
        'delegate' => 'required',
    ];

    public function submitForm()
{
    try {
      
        $this->validate($this->rules);

        // Use the correct property name to get the authenticated user's ID
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->retrievedData = Delegate::where('emp_id', $employeeId)->first();

        // Create a new record in the database
        Delegate::create([
            'emp_id' => $employeeId,
            'workflow' => $this->workflow,
            'from_date' => $this->fromDate,
            'to_date' => $this->toDate,
            'delegate' => $this->delegate,
        ]);
       
        // Clear the form inputs
        $this->resetForm();

        // Optionally, redirect to a success page
      
    } catch (\Exception $e) {
        // Log or dump the exception for debugging
        dd($e->getMessage());
    }
}

    
    public function resetForm()
    {
        $this->workflow = '';
        $this->fromDate = '';
        $this->toDate = '';
        $this->delegate = '';
    }

    public function render()
    {
        $this->retrievedData = Delegate::all();
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->get();

        return view('livewire.delegates', [
            'employees' => $this->employeeDetails,
            'retrievedData' => $this->retrievedData
        ]);
    }
}