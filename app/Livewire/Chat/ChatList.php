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



    public function chatUserSelected($senderId, $receiverId)
    {
        // Debugging senderId and receiverId
        // dd($senderId, $receiverId);

        // Check if a conversation already exists
        $conversation = Conversation::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                ->where('receiver_id', $receiverId);
        })
            ->orWhere(function ($query) use ($senderId, $receiverId) {
                $query->where('sender_id', $receiverId)
                    ->where('receiver_id', $senderId);
            })
            ->first();

        // dd($conversation); // If null, no match was found

        // If a conversation exists, open it, otherwise create a new one
        if ($conversation) {
            $this->selectedConversation = $conversation;
        } else {
            // Handle new conversation creation
            $this->selectedConversation = Conversation::create([
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'last_time_message' => now(),
                'last_message' => '',
            ]);
        }

        // Dispatch event to open chat box
        $this->dispatch('loadConversation', ['conversationId' => $this->selectedConversation->id]);
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

        // Fetch employees not in $userConversations
        $noConversationsList = EmployeeDetails::whereNotIn('emp_id', $userConversations)
            ->where('status', 1) // Ensure they're active
            ->where(function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('job_role', 'like', '%' . $this->search . '%');
            })
            ->orderBy('first_name', 'asc') // Optional sorting
            ->get();

        // Debug to verify results
        // dd($conversationsList, $noConversationsList);
        // Return the filtered and search-processed lists to the view
        return view('livewire.chat.chat-list', [
            'conversations' => $conversationsList,
            'noConversations' => $noConversationsList
        ]);
    }
}
