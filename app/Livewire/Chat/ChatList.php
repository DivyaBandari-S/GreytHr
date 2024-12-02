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
    protected $listeners = ['chatUserSelected', 'refresh' => '$refresh', 'resetComponent'];

    public $selectedUserId;

    public function mount()
    {
        $this->auth_id = auth()->id();
    }

    public function updatedSearch()
    {
        $this->fetchConversations(); // Refetch conversations when search query updates
    }

    public function fetchConversations()
    {
        $this->conversations = Conversation::with(['sender', 'receiver'])
            ->where(function ($query) {
                $query->where('sender_id', $this->auth_id)
                    ->orWhere('receiver_id', $this->auth_id);
            })
            ->when($this->search, function ($query) {
                $query->whereHas('sender', function ($subQuery) {
                    $subQuery->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('job_role', 'like', '%' . $this->search . '%');
                })->orWhereHas('receiver', function ($subQuery) {
                    $subQuery->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('job_role', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('last_time_message', 'DESC')
            ->get();
    }

    public function resetComponent()
    {
        $this->selectedConversation = null;
    }

    public function chatUserSelected($senderId, $receiverId)
    {
        $this->selectedConversation = Conversation::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)
                ->where('receiver_id', $senderId);
        })->first();

        $receiverInstance = EmployeeDetails::find($receiverId);
        $this->dispatch('loadConversation', $this->selectedConversation, $receiverInstance)->to(ChatBox::class);
        $this->dispatch('updateSendMessage', $this->selectedConversation, $receiverInstance)->to(ChatSendMessage::class);
        $this->selectedUserId = $receiverId;
    }

    public function render()
    {
        $this->fetchConversations();
        return view('livewire.chat.chat-list');
    }
}
