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

    public function resetComponent()
    {
        $this->selectedConversation = null;
    }

    public function chatUserSelected($senderId, $receiverId)
    {

        // Fetch the conversation between the two users
        $this->selectedConversation = Conversation::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)
                ->where('receiver_id', $senderId);
        })->first();
        $receiverInstance = EmployeeDetails::find($receiverId);
        $this->dispatch('loadConversation', $this->selectedConversation, $receiverInstance);
        // $this->emitTo('chat.send-message', 'updateSendMessage', $this->selectedConversation, $receiverInstance);

        # code...
    }

    // public function getChatUserInstance(Conversation $conversation, $request)
    // {
    //     # code...
    //     dd('hello');
    //     $this->auth_id = auth()->id();
    //     //get selected conversation

    //     if ($conversation->sender_id == $this->auth_id) {
    //         $this->receiverInstance = EmployeeDetails::firstWhere('id', $conversation->receiver_id);
    //         # code...
    //     } else {
    //         $this->receiverInstance = EmployeeDetails::firstWhere('id', $conversation->sender_id);
    //     }

    //     if (isset($request)) {

    //         return $this->receiverInstance->$request;
    //         # code...
    //     }
    // }
    // public function mount()
    // {

    //     $this->auth_id = auth()->id();
    //     $this->conversations = Conversation::where('sender_id', $this->auth_id)
    //         ->orWhere('receiver_id', $this->auth_id)->orderBy('last_time_message', 'DESC')->get();

    //     # code...
    // }
    public function render()
    {
        // Get the authenticated user's ID
        $this->auth_id = auth()->id();

        // Fetch all relevant conversations
        $conversationIds = Conversation::where('sender_id', $this->auth_id)
            ->orWhere('receiver_id', $this->auth_id)
            ->pluck('id');

        // Fetch employees involved in the conversations
        $this->conversations = EmployeeDetails::whereIn('emp_id', function ($query) {
            $query->select('receiver_id')
                ->from('conversations')
                ->where('sender_id', $this->auth_id)
                ->union(
                    Conversation::select('sender_id')
                        ->where('receiver_id', $this->auth_id)
                );
        })
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('job_role', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('updated_at', 'DESC') // Sort by last activity
            ->get();

        return view('livewire.chat.chat-list', [
            'conversations' => $this->conversations,
        ]);
    }
}
