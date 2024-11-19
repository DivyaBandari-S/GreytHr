<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\EmployeeDetails;
use Livewire\Component;

class ChatList extends Component
{
    public $auth_id;
    public $conversations;
    public $receiverInstance;
    public $name;
    public $selectedConversation;
    public $conversationsList;
    public $noConversationsList;
    protected $listeners = ['chatUserSelected', 'refresh' => '$refresh', 'resetComponent'];

    public $search = ''; // Search query

    public function resetComponent()
    {

        $this->selectedConversation = null;
        # code...
    }
    // Fetch employees based on search query

    public function render()
    {
        // Get the authenticated user's ID
        $this->auth_id = auth()->id();

        // Fetch all conversations where the authenticated user is either the sender or receiver
        $this->conversations = Conversation::where('sender_id', $this->auth_id)
            ->orWhere('receiver_id', $this->auth_id)
            ->orderBy('last_time_message', 'DESC')
            ->get();

        // Extract both sender and receiver IDs from the conversations
        $userConversations = $this->conversations->flatMap(function ($conversation) {
            return [$conversation->sender_id, $conversation->receiver_id];
        })->unique();

        // Fetch employee details for IDs present in $userConversations
        $conversationsList = EmployeeDetails::whereIn('emp_id', $userConversations)
            ->orderBy('first_name', 'asc') // Optional sorting
            ->get();

        return view('livewire.chat.chat-list', [
            'conversations' => $conversationsList,
        ]);
    }
}
