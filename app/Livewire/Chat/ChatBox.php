<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use App\Notifications\MessageRead;
use App\Notifications\MessageSent;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Crypt;
use Hashids;
class ChatBox extends Component
{

    public $selectedConversation;

    public $body = '';
    public $loadedMessages;
    public $attachment;
    public $searchTerm;
    public $file_path;
    public $isCalling = false;

    public $filePath;
    use WithFileUploads;
    public $paginate_var = 10;




    protected $listeners = [
        'loadMore'
    ];
    public function redirectToEncryptedLink($id)
    {
        $encryptedId = Hashids::encode($id);
        return redirect()->to(route('chat', $encryptedId));
    }
    protected function resetInputFields()
    {
        $this->body = '';
        $this->file_path = '';
    }



    public function getListeners()
    {

        $auth_id = auth()->user()->emp_id;

        return [

            'loadMore',
            "echo-private:users.{$auth_id},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'broadcastedNotifications'

        ];
    }

    public function broadcastedNotifications($event)
    {



        if ($event['type'] == MessageSent::class) {

            if ($event['chating_id'] == $this->selectedConversation->id) {

                $this->dispatchBrowserEvent('scroll-bottom');

                $newMessage = Message::find($event['message_id']);


                #push message
                $this->loadedMessages->push($newMessage);


                #mark as read
                $newMessage->read_at = now();

                $newMessage->save();

                #broadcast
                $this->selectedConversation->getReceiver()
                    ->notify(new MessageRead($this->selectedConversation->id));
            }
        }
    }




    public function loadMore(): void
    {


        #increment
        $this->paginate_var += 10;

        #call loadMessages()

        $this->loadMessages();


        #update the chat height
        $this->dispatchBrowserEvent('update-chat-height');
    }


    public function filter()
    {
        $trimmedSearchTerm = trim($this->searchTerm);
        $user = auth()->user();

        // Retrieve all conversations
        $conversations = $user->conversations()->latest('updated_at')->get();

        // Filter the conversations by the name of the receiver
        $filteredConversations = $conversations->filter(function ($conversation) use ($trimmedSearchTerm) {
            $receiver = $conversation->getReceiver();
            return $receiver && (
                stripos($receiver->first_name, $trimmedSearchTerm) !== false ||
                stripos($receiver->last_name, $trimmedSearchTerm) !== false ||
                stripos($receiver->department, $trimmedSearchTerm) !== false
            );
        });

        return $filteredConversations;
    }






    public function loadMessages()
    {

        $userId = auth()->user()->emp_id;

        #get count
        $count = Message::where('chating_id', $this->selectedConversation->id)
            ->where(function ($query) use ($userId) {

                $query->where('sender_id', $userId)
                    ->whereNull('sender_deleted_at');
            })->orWhere(function ($query) use ($userId) {

                $query->where('receiver_id', $userId)
                    ->whereNull('receiver_deleted_at');
            })
            ->count();

        #skip and query
        $this->loadedMessages = Message::where('chating_id', $this->selectedConversation->id)
            ->where(function ($query) {
                $query->where('sender_id', auth()->user()->emp_id)
                    ->orWhere('receiver_id', auth()->user()->emp_id);
            })
            ->get();


        return $this->loadedMessages;
    }



    public function sendMessage()
    {
        if (!$this->selectedConversation) {
            // Handle error when selectedConversation is null
            return;
        }

        // Validate the input
        $this->validate([
            'body' => 'required|string|max:255',
        ]);

        // Check if there's an attachment
        if ($this->attachment) {
            // Generate a unique file name
            $fileName = uniqid() . '_' . $this->attachment->getClientOriginalName();

            // Store the attachment
            // $this->attachment->storeAs('public/help-desk-files', $fileName);
            $this->attachment->storeAs('chating-files', $fileName);

            // Save the file path
            $filePath = 'chating-files/' . $fileName;
        } else {
            // No attachment provided
            $filePath = null;
        }

        // Create a new message
        $createdMessage = Message::create([
            'chating_id' => $this->selectedConversation->id,
            'sender_id' => auth()->User()->emp_id,
            'receiver_id' => optional($this->selectedConversation->getReceiver())->emp_id,
            'file_path' => $filePath,
            'body' => $this->body,
        ]);

        // Push the created message to the loadedMessages collection
        $this->loadedMessages->push($createdMessage);

        // Update the conversation model
        $this->selectedConversation->updated_at = now();
        $this->selectedConversation->save();

        // Reset the attachment property
        $this->attachment = null;

        // Reset the body property

        $this->body = '';

        $this->reset('body');

        // Broadcast notification
        optional($this->selectedConversation->getReceiver())
            ->notify(new MessageSent(
                auth()->user(),
                $createdMessage,
                $this->selectedConversation,
                optional($this->selectedConversation->getReceiver())->id
            ));
    }


    public $isStreaming = false;

    public function startStreaming()
    {
        $this->isStreaming = true;
    }

    public function stopStreaming()
    {
        $this->isStreaming = false;
    }
    public function mount()
    {


        $this->loadMessages();
    }




    public function render()
    {
        $user = auth()->user();
        // Retrieve all conversations
        $conversations = $user->conversations()->latest('updated_at')->get();
        if ($this->searchTerm) {
            $conversations = $this->filter();
        }

        return view('livewire.chat.chat-box', [
            'conversations' => $conversations,
        ]);
    }
}
