<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent as EventsMessageSent;
use App\Models\Conversation;
use App\Models\EmployeeDetails;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Vinkla\Hashids\Facades\Hashids;

class ChatBox extends Component
{
    use WithFileUploads;

    public $conversationId;
    public $messages = [];
    public $newMessage;
    public $media;
    public $receiverId;
    public $selectedConversation;

    protected $listeners = ['loadConversation'];

    public function loadConversation(Conversation $conversation, EmployeeDetails $receiver)
    {
        $this->selectedConversation =  $conversation;
        $this->conversationId =  $this->selectedConversation->id;

        // Load messages for the selected conversation
        $this->messages = Message::where('conversation_id',  $this->conversationId)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function sendMessage()
    {
        // Validate the input
        $this->validate([
            'newMessage' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpg,png,gif,mp4|max:20480', // 20MB max
        ]);

        if ($this->newMessage == null && !$this->media) {
            // Don't send an empty message and return
            return null;
        }

        $mediaPath = null;
        $messageType = 'text';

        // Check if a media file is uploaded
        if ($this->media) {
            try {
                $mediaPath = $this->media->store('messages', 'public'); // Save file in storage
                $messageType = $this->media->getMimeType() === 'video/mp4' ? 'video' : 'image';
            } catch (\Exception $e) {
                // Handle error, log it or notify user
                Log::error('Failed to upload media: ' . $e->getMessage());
                return;
            }
        }

        // Determine the receiver ID
        $this->receiverId = Conversation::find($this->conversationId)
            ->participants()
            ->where('user_id', '!=', auth()->id())
            ->first()
            ->user_id;

        // Create the message (either text or media)
        $message = Message::create([
            'conversation_id' => $this->conversationId,
            'sender_id' => auth()->user()->emp_id,
            'receiver_id' => $this->receiverId,
            'body' => $this->newMessage,
            'type' => $messageType,
            'media_path' => $mediaPath,
            'read' => false,
        ]);

        // Emit event for real-time updates
        // event(new MessageSent($message));

        // Clear the input fields
        $this->newMessage = '';
        $this->media = null;
    }

    public function render()
    {
        return view('livewire.chat.chat-box', [
            'messages' => $this->messages,
            'conversationId' => $this->conversationId,
        ]);
    }
}
