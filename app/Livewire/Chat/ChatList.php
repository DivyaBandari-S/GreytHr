<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\EmployeeDetails;
use Livewire\Component;

class ChatList extends Component
{
    public $auth_id;
    public $conversations;
    public $selectedConversation;
    public $search = ''; // Search query
    public $receiverInstance;
    public $name;
    protected $listeners = ['chatUserSelected', 'refresh' => '$refresh'];

    public $selectedUserId;

    public function mount()
    {
        // dd(auth()->check(),auth()->id());

        $this->auth_id = auth()->id();
    }

    public function updatedSearch()
    {
        try {
            $this->fetchConversations();
        } catch (\Exception $e) {
            logger()->error('Error updating search: ' . $e->getMessage());
        }
    }

    public function fetchConversations()
    {
        try {
            $this->conversations = Conversation::with(['sender', 'receiver'])
                ->where(function ($query) {
                    $query->where('sender_id', $this->auth_id)
                        ->orWhere('receiver_id', $this->auth_id);
                })
                ->when($this->search, function ($query) {
                    $query->where(function ($subQuery) {
                        $subQuery->whereHas('sender', function ($senderQuery) {
                            $senderQuery->where('first_name', 'like', '%' . $this->search . '%')
                                ->orWhere('last_name', 'like', '%' . $this->search . '%')
                                ->orWhere('email', 'like', '%' . $this->search . '%')
                                ->orWhere('job_role', 'like', '%' . $this->search . '%');
                        })
                            ->orWhereHas('receiver', function ($receiverQuery) {
                                $receiverQuery->where('first_name', 'like', '%' . $this->search . '%')
                                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                                    ->orWhere('email', 'like', '%' . $this->search . '%')
                                    ->orWhere('job_role', 'like', '%' . $this->search . '%');
                            });
                    });
                })
                ->orderBy('last_time_message', 'DESC')
                ->distinct()
                ->get();
        } catch (\Exception $e) {
            logger()->error('Error fetching conversations: ' . $e->getMessage());
            $this->conversations = collect(); // Return an empty collection if an error occurs
        }
    }

    public function chatUserSelected($senderId, $receiverId)
    {
        try {
            // Validate input IDs
            if (!$senderId || !$receiverId) {
                logger()->error('Invalid senderId or receiverId provided.');
                return;
            }

            // Fetch the selected conversation
            $this->selectedConversation = Conversation::where(function ($query) use ($senderId, $receiverId) {
                $query->where('sender_id', $senderId)
                    ->where('receiver_id', $receiverId);
            })->orWhere(function ($query) use ($senderId, $receiverId) {
                $query->where('sender_id', $receiverId)
                    ->where('receiver_id', $senderId);
            })->first();

            if (!$this->selectedConversation) {
                logger()->error("No conversation found for senderId: $senderId and receiverId: $receiverId");
                $this->selectedConversation = null;
            }

            // Fetch the receiver instance
            $this->receiverInstance = EmployeeDetails::find($receiverId);

            if (!$this->receiverInstance) {
                logger()->error("No employee details found for receiverId: $receiverId");
                $this->receiverInstance = null;
            }

            // Dispatch Livewire events only if both conversation and receiver are valid
            if ($this->selectedConversation && $this->receiverInstance) {
                $this->dispatch('loadConversation', $this->selectedConversation, $this->receiverInstance)
                    ->to('chat.chat-box');
                $this->dispatch('updateSendMessage', $this->selectedConversation, $this->receiverInstance)
                    ->to('chat.chat-send-message');
                $this->selectedUserId = $receiverId;
            } else {
                logger()->error("Unable to dispatch Livewire events due to invalid data.");
            }
        } catch (\Exception $e) {
            logger()->error('Error selecting chat user: ' . $e->getMessage());

            // Reset variables to null to avoid downstream errors
            $this->selectedConversation = null;
            $this->receiverInstance = null;
        }
    }


    public function render()
    {

        $this->fetchConversations();
        return view('livewire.chat.chat-list');
    }
}
