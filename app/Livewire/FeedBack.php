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
    public $originalFeedbackText;
    public $replyText;
    public $feedbackId;
    public $isReplyModalOpen = false;
    public $isEditModalVisible = false;
    public $updatedFeedbackMessage;
    public $selectedFeedbackId;
    public $employeeName;
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
                })
                    ->orWhere(function ($q) use ($empId) {
                        $q->where('feedback_from', $empId)
                            ->whereNotNull('replay_feedback_message'); // Include feedback replies
                    });
                break;

            case 'given':
                $query->where('feedback_from', $empId)
                    ->where('feedback_type', 'give')
                    ->where('is_draft', false); // Feedback voluntarily given
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
        // Order by `created_at` (original feedback) and `updated_at` (reply)
        $this->feedbacks = $query->orderByRaw('created_at desc')
            ->orderByRaw('updated_at desc')
            ->get();
    }


    public function openReplyModal($feedbackId)
    {
        $feedback = FeedBackModel::find($feedbackId);

        if (!$feedback) {
            session()->flash('error', 'Feedback not found.');
            return;
        }

        // Set pre-filled values
        $this->feedbackId = $feedbackId;
        $this->selectedEmployee = $feedback->feedbackFromEmployee; // Assuming a relation with Employee
        $this->originalFeedbackText = $feedback->feedback_message;
        $this->replyText = ''; // Clear previous reply

        // Open modal
        $this->isReplyModalOpen = true;
    }

    public function closeReplyModal()
    {
        $this->isReplyModalOpen = false;
    }

    public function submitReply()
    {
        $feedback = FeedBackModel::find($this->feedbackId);

        if (!$feedback) {
            session()->flash('error', 'Feedback not found.');
            return;
        }

        // Save the reply
        $feedback->update([
            'is_accepted' => true,
            'replay_feedback_message' => $this->replyText,
            'updated_at' => now(),
        ]);

        // Close modal
        $this->isReplyModalOpen = false;

        session()->flash('success', 'Feedback replied successfully.');
        // Refresh feedback list
        $this->loadTabData($this->activeTab);
    }


    public function declineFeedback($feedbackId)
    {
        $feedback = FeedbackModel::find($feedbackId);
        if (!$feedback) {
            session()->flash('error', 'Feedback not found.');
            return;
        }

        // Mark as declined
        $feedback->update(['is_declined' => true]);

        session()->flash('success', 'Feedback declined successfully.');
        // Refresh feedback list
        $this->loadTabData($this->activeTab);
    }

    public function editGiveFeedback($feedbackId)
    {
        // Find the feedback record
        $feedback = FeedbackModel::find($feedbackId);

        if ($feedback && $feedback->feedback_from == auth()->id()) {
            // If the logged-in user is the sender (feedback_from), allow editing
            $this->selectedFeedbackId = $feedback->id;
            $this->selectedEmployee = $feedback->feedbackToEmployee;
            $this->updatedFeedbackMessage = $feedback->feedback_message;
            $this->isEditModalVisible = true;
        } else {
            // Handle the case where the user is not the sender
            session()->flash('error', 'You are not authorized to edit this feedback.');
        }
    }

    // Update feedback action with inline validation
    public function updateGiveFeedback()
    {
        // Inline validation for the updated feedback message
        $this->validate([
            'updatedFeedbackMessage' => 'required|string|min:5',
        ]);

        // Find the feedback and update the message
        $feedback = FeedbackModel::find($this->selectedFeedbackId);
        if ($feedback) {
            // Only update if the feedback message is different
            if ($this->updatedFeedbackMessage != $feedback->feedback_message) {
                $feedback->update(['feedback_message' => $this->updatedFeedbackMessage]);
                session()->flash('message', 'Feedback updated successfully!');
            } else {
                session()->flash('message', 'No changes detected to save.');
            }
            $this->isEditModalVisible = false; // Close the modal after update
        }
        // Refresh the feedback list to reflect changes
        $this->loadTabData($this->activeTab);
    }


    public function deleteGiveFeedback($feedbackId)
    {
        // Find the feedback record
        $feedback = FeedbackModel::find($feedbackId);

        if ($feedback && $feedback->feedback_from == auth()->id()) {
            // If the logged-in user is the sender (feedback_from), allow deletion
            $feedback->update(['status' => 0]); // Soft delete by updating status to 0
            session()->flash('message', 'Feedback deleted successfully!');
        } else {
            // Handle the case where the user is not the sender
            session()->flash('error', 'You are not authorized to delete this feedback.');
        }

        // Refresh the feedback list to reflect changes
        $this->loadTabData($this->activeTab);
    }

    public function saveAsGivenDraft()
    {
        // Validate feedback data before saving
        $this->validate([
            'selectedEmployee' => 'required|array',
            'selectedEmployee.emp_id' => 'required',
            'feedbackMessage' => 'required|string|min:2',
        ]);

        // Check if employee is selected
        if (!$this->selectedEmployee) {
            session()->flash('error', 'Please select a valid employee.');
            return;
        }

        // Check if feedback already exists as draft
        $existingFeedback = FeedBackModel::where('feedback_from', auth()->user()->emp_id)
            ->where('feedback_to', $this->selectedEmployee['emp_id'])
            ->where('feedback_type', 'give')
            ->where('is_draft', true)
            ->first();

        // If feedback already exists, update it
        if ($existingFeedback) {
            $existingFeedback->update([
                'feedback_message' => $this->feedbackMessage,
                'is_draft' => true, // Ensure it's marked as draft
            ]);
            session()->flash('message', 'Draft feedback updated successfully!');
        } else {
            // Otherwise, create new draft feedback
            FeedBackModel::create([
                'feedback_type' => 'give',
                'feedback_from' => auth()->user()->emp_id,
                'feedback_to' => $this->selectedEmployee['emp_id'],
                'feedback_message' => $this->feedbackMessage,
                'is_draft' => true, // Mark it as draft
            ]);
            session()->flash('message', 'Draft feedback saved successfully!');
        }

        // Close the modal and reset fields
        $this->closeModal();
        $this->resetFields();

        // Refresh the feedback list
        $this->loadTabData($this->activeTab);
    }


    public function withDrawnGivenFeedback($feedbackId)
    {
        // Find the feedback by ID
        $feedback = FeedBackModel::find($feedbackId);

        // Check if feedback exists and if the logged-in user is the one who created the feedback
        if (!$feedback) {
            session()->flash('error', 'Feedback not found.');
            return;
        }

        if ($feedback->feedback_from != auth()->user()->emp_id) {
            session()->flash('error', 'You are not authorized to withdraw this feedback.');
            return;
        }

        // Update the feedback to mark it as not a draft
        $feedback->update([
            'is_draft' => false, // Set is_draft to false indicating the draft is withdrawn
        ]);

        // Provide success message
        session()->flash('message', 'Draft feedback withdrawn and finalized successfully!');

        // Refresh the feedback list
        $this->loadTabData($this->activeTab);
    }


    public function render()
    {
        return view('livewire.feed-back', [
            'feedbacks' => $this->feedbacks,
        ]);
    }
}
