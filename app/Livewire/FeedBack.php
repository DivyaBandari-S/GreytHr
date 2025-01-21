<?php

namespace App\Livewire;

use App\Models\FeedBackModel;
use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FeedBack extends Component
{
    public $searchEmployee = '';
    public $feedbackMessage = '';
    public $feedbackType;
    public $isRequestModalOpen = false;
    public $isGiveModalOpen = false;
    public $selectedEmployee = null;
    public $employees = [];
    public $activeTab = 'received';
    public $feedbacks = [];
    public $userId;

    protected $rules = [
        'selectedEmployee' => 'required|array',
        'selectedEmployee.emp_id' => 'required',
        'feedbackMessage' => 'required|string|min:2',
        'feedbackType' => 'required|in:request,give',
    ];

    public function mount()
    {
        $this->loadTabData($this->activeTab);
    }

    public function openRequestModal()
    {
        $this->resetFields();
        $this->feedbackType = 'request';
        $this->isRequestModalOpen = true;
    }

    public function openGiveModal()
    {
        $this->resetFields();
        $this->feedbackType = 'give';
        $this->isGiveModalOpen = true;
    }

    public function resetFields()
    {
        $this->reset(['searchEmployee', 'feedbackMessage', 'selectedEmployee', 'employees', 'feedbackType']);
    }

    public function closeModal()
    {
        $this->resetFields();
        $this->isRequestModalOpen = false;
        $this->isGiveModalOpen = false;
    }

    public function updatedSearchEmployee()
    {
        $this->employees = EmployeeDetails::select('emp_id', 'first_name', 'last_name')
            ->where(function ($query) {
                $query->where('emp_id', 'like', "%{$this->searchEmployee}%")
                    ->orWhere('first_name', 'like', "%{$this->searchEmployee}%")
                    ->orWhere('last_name', 'like', "%{$this->searchEmployee}%");
            })
            ->orderBy('first_name', 'asc')
            ->limit(10)
            ->get();
    }

    public function selectEmployee($employeeId)
    {
        $employee = collect($this->employees)->firstWhere('emp_id', $employeeId);
        if ($employee) {
            $this->selectedEmployee = [
                'emp_id' => $employee['emp_id'],
                'first_name' => $employee['first_name'],
                'last_name' => $employee['last_name'],
            ];
        }
        $this->reset(['searchEmployee', 'employees']);
    }

    public function clearSelectedEmployee()
    {
        $this->selectedEmployee = null;
    }

    public function saveFeedback()
    {
        $this->validate();

        if (!$this->selectedEmployee) {
            session()->flash('error', 'Please select a valid employee.');
            return;
        }

        FeedBackModel::create([
            'feedback_type' => $this->feedbackType,
            'feedback_to' => $this->selectedEmployee['emp_id'],
            'feedback_from' => auth()->user()->emp_id,
            'feedback_message' => $this->feedbackMessage,
        ]);

        session()->flash('message', 'Feedback submitted successfully!');
        $this->closeModal();
        $this->loadTabData($this->activeTab); // Refresh tab data
    }

    public function loadTabData($tab)
    {
        $this->activeTab = $tab;
        $this->feedbacks = []; // Reset feedbacks when changing tabs

        $empId = auth()->user()->emp_id;

        $query = FeedBackModel::where('status', 1);

        switch ($this->activeTab) {
            case 'received':
                $query->where(function ($q) use ($empId) {
                    $q->where('feedback_to', $empId)
                        ->where('feedback_type', 'request')
                        ->where('is_accepted', true)
                        ->orWhere(function ($q2) use ($empId) {
                            $q2->where('feedback_to', $empId)
                                ->where('feedback_type', 'give'); // Directly received feedback
                        });
                });
                break;

            case 'given':
                $query->where('feedback_from', $empId)
                    ->where('feedback_type', 'give'); // Feedback voluntarily given
                break;

            case 'pending':
                $query->where('feedback_to', $empId)
                    ->where('feedback_type', 'request')
                    ->where('is_accepted', false)
                    ->where('is_declined', false); // Show only unaccepted & not declined requests
                break;

            case 'drafts':
                $query->where('feedback_from', $empId)
                    ->where('is_draft', true)
                    ->where('feedback_type', 'give');
                break;
        }

        // Order results by latest timestamp
        $this->feedbacks = $query->orderBy('created_at', 'desc')->get();
    }


    public function render()
    {
        return view('livewire.feed-back', [
            'feedbacks' => $this->feedbacks,
        ]);
    }
}
