<?php

namespace App\Livewire;

use App\Models\LeaveRequest;
use App\Models\LetterRequest;
use Livewire\Component;

class DocumentCenterLetters extends Component
{
    public $tab = "Request Letter";
    public $jumpToTab = "Confirmation Letter";
    public $activeTab = "Apply";

    public $letter_type;
    public  $priority;
    public $reason;

    protected $rules = [
        'letter_type' => 'required',
        'priority' => 'required',
        'reason' => 'required',
    ];

    protected $messages = [
        'letter_type.required' => 'Letter type is required',
        'priority.required' => 'Priority is required',
        'reason.required' => 'Reason is required',
    ];

    public function validateField($field){
        $this->validateOnly($field);
    }
    public function submitRequest()
    {
        $this->validate();

        $employeeId = auth()->guard('emp')->user()->emp_id;

        LetterRequest::create([
            'emp_id' => $employeeId,
            'letter_type' => $this->letter_type,
            'priority' => $this->priority,
            'reason' => $this->reason,
        ]);

        // Reset Livewire component properties
        $this->reset();

        session()->flash('success', 'Request letter submitted successfully!');

        return redirect('/document-center-letters');
    }



    public $allRequests;
    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;

        $this->allRequests = LetterRequest::where('emp_id', $employeeId)->orderBy('created_at', 'desc')->get();
        return view('livewire.document-center-letters');
    }
}
