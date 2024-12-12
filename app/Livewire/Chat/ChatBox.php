<?php

namespace App\Livewire\Chat;

use App\Events\MessageRead;
use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\EmployeeDetails;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class ChatBox extends Component
{
    use WithFileUploads;

    public $messages;
    public $newMessage;
    public $media;
    public $receiverId;
    public $selectedConversation;
    public $messages_count;
    public $receiver;
    public $height;
    public $receiverInstance;
    public $senderInstance;
    public $body = '';
    public $createdMessage;
    public $messageBeingEdited;
    public $editMessageBody;

    // protected $listeners = ['loadConversation', 'updateSendMessage', 'dispatchMessageSent', 'resetComponent', 'refreshChatBox' => '$refresh', 'rowChatBottom'];

    public function getListeners()
    {
        $auth_id = auth()->id();
        return [
            "echo-private:chat.{$auth_id},MessageSent" => 'broadcastedMessageReceived',
            "echo-private:chat.{$auth_id},MessageRead" => 'broadcastedMessageRead',
            'loadConversation',
            'pushMessage',
            'loadmore',
            'updateHeight',
            'broadcastMessageRead',
            'resetComponent',
            'refreshChatBox' => '$refresh',
            'rowChatBottom',
            'updateSendMessage'
        ];
    }

    public function editMessage($messageId)
    {
        try {
            $this->messageBeingEdited = Message::find($messageId);
            if (!$this->messageBeingEdited) {
                throw new \Exception('Message not found');
            }
            $this->editMessageBody = $this->messageBeingEdited->body;
            $this->dispatch('showEditMessageModal');
        } catch (\Exception $e) {
            Log::error('Error editing message: ' . $e->getMessage());
        }
    }

    public function deleteMessage($messageId)
    {
        try {
            $message = Message::find($messageId);
            if (!$message) {
                throw new \Exception('Message not found');
            }
            $message->delete();
            $this->dispatch('refreshChatBox');
            $this->dispatch('refresh');
        } catch (\Exception $e) {
            Log::error('Error deleting message: ' . $e->getMessage());
        }
    }



    // public function resetComponent()
    // {
    //     $this->selectedConversation = null;
    // }

    public function broadcastedMessageRead($event)
    {
        try {
            if ($this->selectedConversation && (int) $this->selectedConversation->id === (int) $event['conversation_id']) {
                $this->dispatch('markMessageAsRead');
            }
        } catch (\Exception $e) {
            Log::error('Error in broadcastedMessageRead: ' . $e->getMessage());
        }
    }

    public function broadcastedMessageReceived($event)
    {
        try {
            $this->dispatch('refresh');
            $broadcastedMessage = Message::find($event['message']);
            if (!$broadcastedMessage) {
                throw new \Exception('Broadcasted message not found');
            }

            if ($this->selectedConversation && (int) $this->selectedConversation->id === (int) $event['conversation_id']) {
                $broadcastedMessage->read = 1;
                $broadcastedMessage->save();
                $this->pushMessage($broadcastedMessage->id);
                $this->dispatch('broadcastMessageRead');
            }
        } catch (\Exception $e) {
            Log::error('Error in broadcastedMessageReceived: ' . $e->getMessage());
        }
    }

    public function pushMessage($messageId)
    {
        try {
            $newMessage = Message::find($messageId);

            if (!$newMessage) {
                throw new \Exception('Message not found');
            }

            $this->messages->push($newMessage);

            // Optionally broadcast the new message event here if needed
            // Example: broadcast(new NewMessageReceived($newMessage))->toOthers();

            $this->dispatch('rowChatToBottom');
        } catch (\Exception $e) {
            Log::error('Error pushing message: ' . $e->getMessage(), [
                'messageId' => $messageId,
            ]);
        }
    }

    public function loadConversation(Conversation $conversation, EmployeeDetails $receiver)
    {
        try {
            $this->selectedConversation = $conversation;
            $this->receiverInstance = $receiver;
            $this->senderInstance = EmployeeDetails::find(auth()->id());
            if (!$this->selectedConversation || !$this->receiverInstance || !$this->senderInstance) {
                throw new \Exception('Invalid conversation or receiver');
            }

            $this->messages = Message::where('conversation_id', $this->selectedConversation->id)->get();
            $this->dispatch('chatSelected');
            $this->dispatch('receiveMessageSound');

            Message::where('conversation_id', $this->selectedConversation->id)
                ->where('receiver_id', auth()->id())
                ->update(['read' => 1]);

            $this->dispatch('broadcastMessageRead')->self();
            $this->dispatch('rowChatToBottom');
        } catch (\Exception $e) {
            Log::error('Error loading conversation: ' . $e->getMessage());
            $this->addError('loadConversation', 'Failed to load the conversation.');
        }
    }

    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
