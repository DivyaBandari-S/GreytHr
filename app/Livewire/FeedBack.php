<?php

namespace App\Livewire;

use App\Helpers\FlashMessageHelper;
use App\Models\FeedBackModel;
use App\Models\EmployeeDetails;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Mail\FeedbackNotificationMail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

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
    public $feedbackIdToDelete;
    public $showDeleteModal = false; // Boolean to control modal visibility
    public $feedbackImage;
    public $feedbackEmptyText;
    public $searchFeedback;
    public $filteredFeedbacks = [];
    public $filteredEmployees = [];
    public $filteredEmp = null;
    public bool $isAIAssistOpen = false; // New property to toggle AI Assist
    public $enableAIAssist = false;

    public $suggestions = [];

    protected $rules = [
        'selectedEmployee' => 'required|array',
        'selectedEmployee.emp_id' => 'required',
        'feedbackMessage' => 'required|string|min:2',
        'feedbackType' => 'required|in:request,give',
    ];

    public function toggleAIAssist()
    {
        $this->isAIAssistOpen = true;

        // Only call AI assist if feedbackMessage is not empty after cleaning
        $this->feedbackMessage = $this->cleanText($this->feedbackMessage);

        // Only call AI assist if feedbackMessage is not empty
        if (!empty($this->feedbackMessage)) {
            $this->dispatch('trigger-correct-grammar');
        }
    }

    public function correctGrammar()
    {
        try {
            $rawText = $this->cleanText($this->feedbackMessage); // Clean input

            $response = Http::withHeaders([
                "Authorization" => "Bearer " . env('OPENROUTER_API_KEY'),
                "HTTP-Referer" => env('YOUR_SITE_URL', ''), // Optional
                "X-Title" => env('YOUR_SITE_NAME', ''), // Optional
            ])->post(env('OPENROUTER_API_URL', 'https://openrouter.ai/api/v1/chat/completions'), [
                "model" => env('OPENROUTER_MODEL', 'openai/gpt-4o'),
                "messages" => [
                    [
                        "role" => "user",
                        "content" => "Correct this text for grammar and provide three alternative suggestions:\n\n" . $rawText
                    ]
                ]
            ]);

            $data = $response->json(); // Convert response to array

            if (!isset($data['choices'][0]['message']['content'])) {
                throw new \Exception("Invalid response from API");
            }

            $aiResponse = trim($data['choices'][0]['message']['content']);
            $lines = explode("\n", $aiResponse);

            // **Extract the corrected text**
            $correctedText = "";
            $suggestions = [];

            foreach ($lines as $line) {
                $line = trim($line);

                // Ignore empty lines and headers
                if ($line === "" || str_contains($line, "Corrected Text") || str_contains($line, "Reasoning for Correction") || str_contains($line, "Alternative Versions")) {
                    continue;
                }

                // If it starts with a number (suggestion), store it separately
                if (preg_match('/^\d+\.\s/', $line)) {
                    $suggestions[] = preg_replace('/^\d+\.\s/', '', $line);
                } elseif (empty($correctedText)) {
                    // First meaningful line is the corrected text
                    $correctedText = $line;
                }
            }

            // ✅ Update Livewire properties
            $this->feedbackMessage = $correctedText; // Corrected text is updated
            $this->suggestions = array_slice($suggestions, 0, 3); // Limit to 3 suggestions

        } catch (\Exception $e) {
            session()->flash('error', 'Grammar correction service is unavailable.');
            $this->suggestions = [];
        }
    }
    public function useSuggestion($suggestion)
    {
        $this->feedbackMessage = $this->sanitizeTextInput($suggestion);
        dd($this->feedbackMessage);
    }


    /**
     * Remove HTML tags and extra spaces from input text
     */
    private function cleanText($text)
    {
        $text = strip_tags($text); // Remove HTML tags (rich text cleanup)
        $text = preg_replace('/\s+/', ' ', $text); // Remove multiple spaces
        return trim($text); // Trim leading/trailing spaces
    }

    // public function correctGrammar()
    // {
    //     try {
    //         // Remove HTML tags and trim the input before sending it to the API
    //         $rawText = trim(strip_tags($this->feedbackMessage));

    //         $response = Http::post('http://127.0.0.1:8001/grammar-correct', [
    //             'text' => $rawText
    //         ]);

    //         $data = $response->json(); // Convert response to array
    //         // Ensure the keys exist before accessing them
    //         $this->feedbackMessage = trim(strip_tags($data['corrected_text'] ?? $rawText));
    //         $this->suggestions = $data['suggestions'] ?? []; // Default to an empty array if not present
    //     } catch (\Exception $e) {
    //         // Handle API errors gracefully
    //         session()->flash('error', 'Grammar correction service is unavailable.');
    //         $this->suggestions = [];
    //     }
    // }


    // public function useSuggestion($suggestion)
    // {
    //     dd($suggestion);
    //     $this->feedbackMessage = $suggestion;
    // }

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
        $this->reset(['searchEmployee', 'feedbackMessage', 'selectedEmployee', 'employees', 'feedbackType', 'suggestions',]);
    }
    public function clearValidationMessages($field)
    {
        $this->resetValidation($field);  // Clears validation for a specific field
    }

    public function closeModal()
    {
        $this->resetErrorBag(); // Reset the validation errors
        $this->resetFields();
        $this->isRequestModalOpen = false;
        $this->isGiveModalOpen = false;
        $this->isReplyModalOpen = false;
        $this->isAIAssistOpen = false;
    }

    public function updatedSearchEmployee()
    {
        $authEmpId = auth()->user()->emp_id; // Get the authenticated user's employee ID

        if (empty($this->searchEmployee)) {
            // If searchEmployee is empty, return no results
            $this->employees = collect();
            return;
        }

        $this->employees = EmployeeDetails::select('emp_id', 'first_name', 'last_name')
            ->where('emp_id', '!=', $authEmpId) // Exclude the authenticated user
            ->where(function ($query) {
                $query->where('emp_id', 'like', "%{$this->searchEmployee}%")
                    ->orWhere('first_name', 'like', "%{$this->searchEmployee}%")
                    ->orWhere('last_name', 'like', "%{$this->searchEmployee}%");
            })
            ->orderBy('first_name', 'asc')
            ->limit(2)
            ->get();
    }



    public function selectEmployee($employeeId)
    {
        $employee = collect($this->employees)->firstWhere('emp_id', $employeeId);
        if ($employee) {
            // $this->selectedEmployee = [
            //     'emp_id' => $employee['emp_id'],
            //     'first_name' => $employee['first_name'],
            //     'last_name' => $employee['last_name'],
            // ];
            $this->selectedEmployee = $employee;
            // dd( $this->selectedEmployee->emp_id);
        }
        $this->reset(['searchEmployee', 'employees']);
    }

    public function clearSelectedEmployee()
    {
        $this->selectedEmployee = null;
    }
    public function updated($propertyName, $value)
    {
        // Check if the property being updated requires cleaning
        $fieldsToSanitize = ['feedbackMessage', 'updatedFeedbackMessage', 'replyText']; // Add all fields you need

        if (in_array($propertyName, $fieldsToSanitize)) {
            $this->clearValidationMessages($propertyName);
            $this->$propertyName = $this->sanitizeTextInput($value);
        }
    }

    /**
     * Sanitize input text for Quill Editor.
     */
    private function sanitizeTextInput($value)
    {
        do {
            $previousValue = $value;
            $value = preg_replace('/<p>\s*(<br>\s*)*<\/p>/', '', $value);
            $value = trim($value);
        } while ($previousValue !== $value);
        // Enable AI Assist if input is not empty, otherwise reset AI Assist state
        $this->enableAIAssist = !empty($value);
        if (!$this->enableAIAssist) {
            $this->isAIAssistOpen = false;
        }
        return $value === '' ? '' : $value;
        //  return $value ?: '';
    }


    public function saveFeedback()
    {
        $this->validate();
        try {

            // Ensure an employee is selected
            if (!$this->selectedEmployee || !isset($this->selectedEmployee->emp_id)) {
                session()->flash('error', 'Please select a valid employee.');
                return;
            }

            // Create the feedback record
            $feedback = FeedBackModel::create([
                'feedback_type' => $this->feedbackType,
                'feedback_to' => $this->selectedEmployee->emp_id,
                'feedback_from' => auth()->user()->emp_id,
                'feedback_message' => $this->feedbackMessage,
            ]);

            // Determine the email subject based on feedback type
            $subject = $this->feedbackType === 'request' ? 'New Feedback Request' : 'New Feedback Given';

            // Ensure the receiver exists before sending email
            if ($feedback->feedbackToEmployee && isset($feedback->feedbackToEmployee->email)) {
                Mail::to($feedback->feedbackToEmployee->email)->send(new FeedbackNotificationMail($feedback, $subject));
            } else {
                FlashMessageHelper::flashWarning('Feedback submitted, but email could not be sent.');
            }

            // Flash message and close modal
            FlashMessageHelper::flashSuccess('Feedback submitted successfully!');
            $this->closeModal();

            // Refresh tab data
            $this->loadTabData($this->activeTab);
        } catch (\Exception $e) {
            // Log the error and display a user-friendly message
            Log::error('Feedback Submission Error: ' . $e->getMessage());
            FlashMessageHelper::flashError('An unexpected error occurred. Please try again.');
        }
    }





    public function loadTabData($tab)
    {
        $this->activeTab = $tab;
        $this->feedbacks = [];
        $this->filteredFeedbacks = [];
        $this->reset(['searchFeedback', 'filteredEmp']);

        $empId = auth()->user()->emp_id;
        $query = FeedBackModel::where('status', 1);

        // Tab-based filtering
        switch ($this->activeTab) {
            case 'received':
                $query->where(function ($q) use ($empId) {
                    // Feedbacks received by the logged-in user (feedback_to)
                    $q->where('feedback_to', $empId)
                        ->where(function ($q2) {
                            $q2->where('feedback_type', 'request')
                                ->where(function ($q3) {
                                    $q3->where('is_accepted', true)
                                        ->orWhere('is_declined', true);
                                })
                                ->orWhere('feedback_type', 'give'); // Ensure "Give Feedback" appears for receiver
                        });
                })->orWhere(function ($q) use ($empId) {
                    // Feedbacks sent by the logged-in user (feedback_from)
                    $q->where('feedback_from', $empId)
                        ->where(function ($q2) {
                            $q2->whereNotNull('replay_feedback_message')
                                ->orWhere('is_declined', true);
                        });
                })->where(function ($q) use ($empId) {
                    // Ensure only sender and receiver see the feedback
                    $q->where('feedback_from', $empId)
                        ->orWhere('feedback_to', $empId);
                });

                $this->setFeedbackMetadata('request_feedback.jpg', 'See what your coworkers have to say!');
                break;



            case 'given':
                $query->where('feedback_from', $empId)
                    ->where('feedback_type', 'give')
                    ->where('is_draft', false);
                $this->setFeedbackMetadata('give_feedback.jpg', 'Empower Your Peers with 1:1 Feedback');
                break;

            case 'pending':
                $query->where('feedback_to', $empId)
                    ->where('feedback_type', 'request')
                    ->where('is_accepted', false)
                    ->where('is_declined', false);
                $this->setFeedbackMetadata('pending_feedback.jpg', 'Waiting for feedback from your peers.');
                break;

            case 'drafts':
                $query->where('feedback_from', $empId)
                    ->where('is_draft', true)
                    ->where('feedback_type', 'give');
                $this->setFeedbackMetadata('draft_feedback.jpg', 'Save feedback for later.');
                break;
        }

        // Fetch data
        $this->feedbacks = $query->latest()->get();
        $this->filteredFeedbacks = $this->feedbacks;

        $this->dispatch('tabChanged');
    }

    private function setFeedbackMetadata($image, $emptyText)
    {
        $this->feedbackImage = $image;
        $this->feedbackEmptyText = $emptyText;
    }

    // Filter employees based on search input
    public function updatedSearchFeedback()
    {
        $authEmpId = auth()->user()->emp_id;

        $this->filteredEmployees = empty($this->searchFeedback) ? collect() :
            EmployeeDetails::select('emp_id', 'first_name', 'last_name')
            ->where('emp_id', '!=', $authEmpId)
            ->where(function ($query) {
                $query->where('emp_id', 'like', "%{$this->searchFeedback}%")
                    ->orWhere('first_name', 'like', "%{$this->searchFeedback}%")
                    ->orWhere('last_name', 'like', "%{$this->searchFeedback}%");
            })
            ->orderBy('first_name', 'asc')
            ->limit(2)
            ->get();
    }

    // Filter feedback by selected employee
    public function filterFeedbackByEmp($employeeId)
    {
        $this->filteredEmp = collect($this->filteredEmployees)->firstWhere('emp_id', $employeeId);
        $this->applyFeedbackFilter();
        $this->reset(['searchFeedback', 'filteredEmployees']);
    }

    // Apply filters based on selected employee & tab
    private function applyFeedbackFilter()
    {
        $query = FeedbackModel::query();
        $empId = auth()->id();
        $filteredEmpId = $this->filteredEmp ? $this->filteredEmp->emp_id : null;

        if ($filteredEmpId) {
            // Ensure both IDs match bidirectionally
            $query->where(function ($q) use ($filteredEmpId, $empId) {
                $q->where([
                    ['feedback_from', '=', $empId],
                    ['feedback_to', '=', $filteredEmpId],
                ])->orWhere([
                    ['feedback_from', '=', $filteredEmpId],
                    ['feedback_to', '=', $empId],
                ]);
            });
        }

        switch ($this->activeTab) {
            case 'received':
                $query->where(function ($q) use ($empId) {
                    // Ensure feedback is either accepted, declined, or a non-draft feedback that was given
                    $q->where('feedback_to', $empId)
                        ->where('feedback_type', 'request')
                        ->where('is_accepted', true)
                        ->orWhere('is_declined', true)
                        ->orWhere(function ($q2) use ($empId) {
                            $q2->where('feedback_to', $empId)
                                ->where('feedback_type', 'give')
                                ->where('is_draft', false); // Exclude drafts
                        });
                });

                // Ensure bidirectional match for feedbacks, exclude drafts and pending feedbacks
                if ($filteredEmpId) {
                    $query->orWhere(function ($q) use ($empId, $filteredEmpId) {
                        $q->where([
                            ['feedback_from', '=', $filteredEmpId],
                            ['feedback_to', '=', $empId],
                        ])
                            ->where('is_draft', false) // Exclude drafts
                            ->where(function ($q2) {
                                // Ensure the feedback is either accepted or declined
                                $q2->where('is_accepted', true)
                                    ->orWhere('is_declined', true);
                            });
                    });

                    $query->orWhere(function ($q) use ($empId, $filteredEmpId) {
                        $q->where([
                            ['feedback_from', '=', $empId],
                            ['feedback_to', '=', $filteredEmpId],
                        ])
                            ->whereNotNull('replay_feedback_message')
                            ->where('is_draft', false); // Exclude drafts
                    });
                }

                // Ensure no pending feedbacks (where both is_accepted and is_declined are false)
                $query->where(function ($q) {
                    $q->where('is_accepted', true)
                        ->orWhere('is_declined', true);
                });

                // Exclude drafts
                $query->where('is_draft', false);
                break;


            case 'given':
                $query->where('feedback_from', $empId)
                    ->where('feedback_type', 'give')
                    ->where('is_draft', false);
                break;

            case 'pending':
                $query->where('is_accepted', false)
                    ->where('is_declined', false)
                    ->where('feedback_type', 'request');
                break;

            case 'drafts':
                $query->where('feedback_from', $empId)
                    ->where('is_draft', true)
                    ->where('feedback_type', 'give');
                break;
        }

        $this->filteredFeedbacks = $query->with(['feedbackFromEmployee', 'feedbackToEmployee'])->latest()->get();
    }






    public function clearFilterEmp()
    {
        $this->filteredEmp = null;
        $this->applyFeedbackFilter();
        $this->loadTabData($this->activeTab);
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
        $this->resetErrorBag(); // Reset the validation errors
        $this->resetFields();
        $this->isReplyModalOpen = false;
    }

    public function submitReply()
    {
        // Validate the reply text to ensure it's not empty
        $this->validate([
            'replyText' => 'required|string|min:3', // Adjust max length as needed
        ]);

        $feedback = FeedBackModel::find($this->feedbackId);

        if (!$feedback) {
            FlashMessageHelper::flashError('Feedback not found.');
            return;
        }

        // Save the reply
        $feedback->update([
            'is_accepted' => true,
            'replay_feedback_message' => $this->replyText,
            'updated_at' => now(),
        ]);
        // Get sender's email (feedback_from)
        $sender = $feedback->feedbackFromEmployee; // Assuming relation is defined

        if ($sender && isset($sender->email)) {
            try {
                // Send an email notification to the sender
                $subject = 'Reply to Your ' . ucfirst($feedback->feedback_type) . ' Feedback';
                Mail::to($sender->email)->send(new FeedbackNotificationMail($feedback, $subject));
            } catch (\Exception $e) {
                Log::error('Email Sending Failed: ' . $e->getMessage());
                FlashMessageHelper::flashWarning('Reply saved, but email notification could not be sent.');
            }
        }
        // Close modal
        $this->isReplyModalOpen = false;

        FlashMessageHelper::flashSuccess('Feedback replied successfully.');
        // Refresh feedback list
        $this->loadTabData($this->activeTab);
    }


    public function declineFeedback($feedbackId)
    {
        $feedback = FeedbackModel::find($feedbackId);

        if (!$feedback) {
            FlashMessageHelper::flashError('Feedback not found.');
            return;
        }

        // Mark feedback as declined
        $feedback->update(['is_declined' => true]);

        // Get sender's email (feedback_from)
        $sender = $feedback->feedbackFromEmployee; // Ensure the relationship exists

        if ($sender && isset($sender->email)) {
            try {
                // Define subject dynamically
                $subject = 'Your ' . ucfirst($feedback->feedback_type) . ' Feedback Has Been Declined';

                // Send an email notification
                Mail::to($sender->email)->send(new FeedbackNotificationMail($feedback, $subject));
            } catch (\Exception $e) {
                Log::error('Email Sending Failed: ' . $e->getMessage());
                FlashMessageHelper::flashWarning('Feedback declined, but email notification could not be sent.');
            }
        }

        FlashMessageHelper::flashSuccess('Feedback declined successfully.');

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
            FlashMessageHelper::flashError('You are not authorized to edit this feedback.');
        }
    }

    // Update feedback action with inline validation
    public function updateGiveFeedback()
    {
        // Inline validation for the updated feedback message
        // Validate with custom error messages
        $this->validate([
            'updatedFeedbackMessage' => 'required|string|min:5',
        ], [
            'updatedFeedbackMessage.required' => 'The feedback message is required.',
            'updatedFeedbackMessage.string' => 'The feedback message must be a valid string.',
            'updatedFeedbackMessage.min' => 'The feedback message must be at least 5 characters long.',
        ]);

        // Find the feedback and update the message
        $feedback = FeedbackModel::find($this->selectedFeedbackId);
        if ($feedback) {
            // Only update if the feedback message is different
            if ($this->updatedFeedbackMessage != $feedback->feedback_message) {
                $feedback->update(['feedback_message' => $this->updatedFeedbackMessage]);
                FlashMessageHelper::flashSuccess('Feedback updated successfully!');
            } else {
                FlashMessageHelper::flashInfo('No changes detected to save.');
            }
            $this->isEditModalVisible = false; // Close the modal after update
        }
        // Refresh the feedback list to reflect changes
        $this->loadTabData($this->activeTab);
    }

    // Open the delete confirmation modal
    public function confirmDelete($feedbackId)
    {
        $this->feedbackIdToDelete = $feedbackId;
        $this->showDeleteModal = true; // Show modal
    }

    // Perform the deletion
    public function deleteGiveFeedback()
    {
        $feedback = FeedbackModel::find($this->feedbackIdToDelete);

        if ($feedback && $feedback->feedback_from == auth()->id()) {
            $feedback->update(['status' => 0]); // Soft delete
            FlashMessageHelper::flashSuccess('Feedback deleted successfully!');
        } else {
            FlashMessageHelper::flashError('You are not authorized to delete this feedback.');
        }

        // Close the modal and refresh data
        $this->showDeleteModal = false;
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
            FlashMessageHelper::flashError('Please select a valid employee.');
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
            FlashMessageHelper::flashSuccess('Draft feedback updated successfully!');
        } else {
            // Otherwise, create new draft feedback
            FeedBackModel::create([
                'feedback_type' => 'give',
                'feedback_from' => auth()->user()->emp_id,
                'feedback_to' => $this->selectedEmployee['emp_id'],
                'feedback_message' => $this->feedbackMessage,
                'is_draft' => true, // Mark it as draft
            ]);
            FlashMessageHelper::flashSuccess('Draft feedback saved successfully!');
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
            FlashMessageHelper::flashError('Feedback not found.');
            return;
        }

        if ($feedback->feedback_from != auth()->user()->emp_id) {
            FlashMessageHelper::flashError('You are not authorized to withdraw this feedback.');
            return;
        }

        // Update the feedback to mark it as not a draft
        $feedback->update([
            'is_draft' => false, // Set is_draft to false indicating the draft is withdrawn
        ]);

        // Provide success message
        FlashMessageHelper::flashSuccess('Draft feedback withdrawn and finalized successfully!');

        // Refresh the feedback list
        $this->loadTabData($this->activeTab);
    }
    public function updateDraftGiveFeedback()
    {
        // Inline validation for the updated feedback message
        $this->validate([
            'updatedFeedbackMessage' => 'required|string|min:5',
        ]);

        // Find the feedback and update the message
        $feedback = FeedbackModel::find($this->selectedFeedbackId);
        if ($feedback->is_draft) {
            $feedback->update([
                'feedback_message' => $this->updatedFeedbackMessage,
                'is_draft' => false, // Mark draft as final feedback
            ]);


            FlashMessageHelper::flashSuccess('Draft feedback updated successfully and marked as final!');
        }

        $this->isEditModalVisible = false;
        $this->loadTabData($this->activeTab);
    }

    public function closeEditFeedbackModal()
    {
        $this->resetErrorBag(); // Reset the validation errors
        $this->resetFields();
        $this->isEditModalVisible = false;
    }

    public function render()
    {
        return view('livewire.feed-back');
    }
}
