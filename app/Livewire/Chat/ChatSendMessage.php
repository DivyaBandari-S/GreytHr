<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\EmployeeDetails;
use App\Models\Message;
use Livewire\Component;
use Livewire\WithFileUploads;

class ChatSendMessage extends Component
{
    use WithFileUploads;
    public $selectedConversation;
    public $receiverInstance;
    public $body;
    public $media;
    public $createdMessage;
    protected $listeners = ['updateSendMessage', 'dispatchMessageSent', 'resetComponent'];
    public function resetComponent()
    {

        $this->selectedConversation = null;
        $this->receiverInstance = null;

    }

    function updateSendMessage(Conversation $conversation, EmployeeDetails $receiver)
    {

        //  dd($conversation,$receiver);
        $this->selectedConversation = $conversation;
        $this->receiverInstance = $receiver;
        # code...
    }


    public function sendMessage()
    {
        // Prevent sending empty messages
        if (!$this->body && !$this->media) {
            session()->flash('error', 'Message cannot be empty. Please enter text or attach a file.');
            return;
        }

        $mediaPath = null;
        $mediaType = null;

        // Handle media upload
        if ($this->media) {
            // Validate file size (1MB) and allowed types (image, file, zip)
            $this->validate([
                'media' => 'file|max:1024|mimes:jpg,jpeg,png,gif,webp,pdf,zip,docx,xlsx', // Adjust allowed types here
            ]);
            $mediaPath = $this->media->store('uploads/messages', 'public');
            $mimeType = $this->media->getMimeType();

            if (str_contains($mimeType, 'image')) {
                $mediaType = 'image';
            } elseif (str_contains($mimeType, 'video')) {
                $mediaType = 'video';
            } elseif (str_contains($mimeType, 'zip')) {
                $mediaType = 'zip';
            } else {
                $mediaType = 'file'; // For other types of files
            }

            if (!$this->body) {
                $this->body = ucfirst($mediaType) . ' sent';
            }
        }

        $this->createdMessage = Message::create([
            'conversation_id' => $this->selectedConversation->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->receiverInstance->emp_id,
            'body' => $this->body,
            'media_path' => $mediaPath,
            'type' => $mediaType,
        ]);

        if (auth()->id() === $this->receiverInstance->emp_id) {
            $this->createdMessage->read = 1;
            $this->createdMessage->save();
        }

        $this->selectedConversation->last_time_message = $this->createdMessage->created_at;
        $this->selectedConversation->save();

        // Dispatch events and reset input fields
        $this->dispatch('pushMessage', $this->createdMessage->id)->to(ChatBox::class);

        $this->dispatch('show-toast', ['message' => $this->body]);

        $this->dispatch('refresh')->to(ChatList::class);
        $this->reset(['body', 'media']);
        $this->dispatch('dispatchMessageSent')->self();
    }


    public function dispatchMessageSent()
    {

        broadcast(new MessageSent(Auth()->user(), $this->createdMessage, $this->selectedConversation, $this->receiverInstance));
        # code...
    }
    public function render()
    {
        return view('livewire.chat.chat-send-message');
    }
}
