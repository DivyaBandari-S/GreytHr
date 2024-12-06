<?php

namespace App\Livewire\Chat;

use App\Events\MessageRead;
use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\EmployeeDetails;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Messaging\V1\Service\AlphaSenderInstance;

class ChatBox extends Component
{
    use WithFileUploads;

    public $conversationId;
    public $messages;
    public $newMessage;
    public $media;
    public $receiverId;
    public $selectedConversation;
    public $messages_count;
    public $receiver;
    public $paginateVar = 10;
    public $height;
    public $receiverInstance;
    public $senderInstance;
    public $body = '';
    public $createdMessage;
    public $messageBeingEdited;
    public $editMessageBody;
    protected $listeners = ['loadConversation', 'updateSendMessage', 'dispatchMessageSent', 'resetComponent', 'refresh' => '$refresh'];

    // protected $listeners = [ 'loadConversation', 'pushMessage', 'loadmore', 'updateHeight', "echo-private:chat. {$auth_id},MessageSent"=>'broadcastedMessageReceived',];
    public function  getListeners()
    {

        $auth_id = auth()->user()->id;
        return [
            "echo-private:chat.{$auth_id},MessageSent" => 'broadcastedMessageReceived',
            "echo-private:chat.{$auth_id},MessageRead" => 'broadcastedMessageRead',
            'loadConversation',
            'pushMessage',
            'loadmore',
            'updateHeight',
            'broadcastMessageRead',
            'resetComponent'
        ];
    }

    public function editMessage($messageId)
    {
        $this->messageBeingEdited = Message::find($messageId);
        $this->editMessageBody = $this->messageBeingEdited->body;
        $this->dispatch('showEditMessageModal');
    }

    public function deleteMessage($messageId)
    {
        $message = Message::find($messageId);
        $message->delete();
        // $this->dispatch('loadConversation');
        $this->dispatch('refresh');
        // $this->dispatch('refresh')->to(ChatBox::class);
    }

    public function addEmojiReaction($messageId, $emoji)
    {
        $message = Message::find($messageId);
        // Logic to add emoji reaction (you can store the reactions in a related table or update the message itself)
        $message->reactions()->create([
            'emoji' => $emoji,
            'user_id' => auth()->id()
        ]);
    }

    public function resetComponent()
    {

        $this->selectedConversation = null;
    }

    public function broadcastedMessageRead($event)
    {

        dd($event);
        if ($this->selectedConversation) {



            if ((int) $this->selectedConversation->id === (int) $event['conversation_id']) {

                $this->dispatch('markMessageAsRead');
            }
        }

        # code...
    }
    /*---------------------------------------------------------------------------------------*/
    /*-----------------------------Broadcasted Event fucntion-------------------------------------------*/
    /*----------------------------------------------------------------------------*/

    function broadcastedMessageReceived($event)
    {
        dd($event);
        ///here
        $this->dispatch('refresh');
        # code...

        $broadcastedMessage = Message::find($event['message']);


        #check if any selected conversation is set
        if ($this->selectedConversation) {
            #check if Auth/current selected conversation is same as broadcasted selecetedConversationgfg
            if ((int) $this->selectedConversation->id  === (int)$event['conversation_id']) {
                # if true  mark message as read
                $broadcastedMessage->read = 1;
                $broadcastedMessage->save();
                $this->pushMessage($broadcastedMessage->id);
                // dd($event);

                $this->dispatch('broadcastMessageRead');
            }
        }
    }


    public function broadcastMessageRead()
    {
        broadcast(new MessageRead($this->selectedConversation->id, $this->receiverInstance->emp_id));
        # code...
    }

    /*--------------------------------------------------*/
    /*------------------push message to chat--------------*/
    /*------------------------------------------------ */
    public function pushMessage($messageId)
    {
        $newMessage = Message::find($messageId);
        $this->messages->push($newMessage);
        $this->dispatch('rowChatToBottom');
        # code...
    }



    /*--------------------------------------------------*/
    /*------------------load More --------------------*/
    /*------------------------------------------------ */
    function loadmore()
    {

        //  dd('top reached ');
        // $this->messages_count = Message::where('conversation_id', $this->selectedConversation->id)->count();

        $this->messages = Message::where('conversation_id',  $this->selectedConversation->id)->get();

        $height = $this->height;
        $this->dispatch('updatedHeight', ($height));
        # code...
    }


    /*---------------------------------------------------------------------*/
    /*------------------Update height of messageBody-----------------------*/
    /*---------------------------------------------------------------------*/
    function updateHeight($height)
    {

        // dd($height);
        $this->height = $height;

        # code...
    }



    /*---------------------------------------------------------------------*/
    /*------------------load conversations----------------------------------*/
    /*---------------------------------------------------------------------*/
    public function loadConversation(Conversation $conversation, EmployeeDetails $receiver)
    {
        $this->selectedConversation =  $conversation;
        $this->receiverInstance =  $receiver;
        $this->senderInstance = EmployeeDetails::find(auth()->id());
        $this->messages = Message::where('conversation_id',  $this->selectedConversation->id)->get();
        $this->dispatch('chatSelected');
        Message::where('conversation_id', $this->selectedConversation->id)
            ->where('receiver_id',  auth()->id())->update(['read' => 1]);


        $this->dispatch('broadcastMessageRead')->self();
        # code...
    }


    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
