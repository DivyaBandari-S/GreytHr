<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use App\Models\Notification;
use App\Notifications\MessageRead;
use App\Notifications\MessageSent;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
// use Hashids;
use Vinkla\Hashids\Facades\Hashids;
class ChatBox extends Component
{

    public $selectedConversation;

    public $body = '';
    public $fileContent;
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
        // $hashids = new Hashids('default-salt', 50);
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
        $user = Auth::User();

        $auth_id = auth()->user()->emp_id;
        // dd( $auth_id);

        return [

            'loadMore',
            "echo-private:users.{$auth_id},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'broadcastedNotifications'

        ];
    }

    public function broadcastedNotifications($event)
    {



        if ($event['type'] == MessageSent::class) {

            if ($event['conversation_id'] == $this->selectedConversation->id) {

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
        // Validate input data
        $this->validate([
            'body' => 'required|string|max:255',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:40960',
        ]);
    
        // Initialize variables
        $fileContent = null;
        $mimeType = null;
        $fileName = null;
    
        // Store the file as binary data if provided
        if ($this->file_path) {
            $fileContent = file_get_contents($this->file_path->getRealPath());
            
            if ($fileContent === false) {
                Log::error('Failed to read the uploaded file.', [
                    'file_path' => $this->file_path->getRealPath(),
                ]);
                session()->flash('error', 'Failed to read the uploaded file.');
                return;
            }
    
            // Check if the file content is too large
            if (strlen($fileContent) > 16777215) { // 16MB for MEDIUMBLOB
                session()->flash('error', 'File size exceeds the allowed limit.');
                return;
            }
    
            $mimeType = $this->file_path->getMimeType();
            $fileName = $this->file_path->getClientOriginalName();
        }
    
        // Create the message record
        $createdMessage = Message::create([
            'chating_id' => $this->selectedConversation->id,
            'sender_id' => auth()->user()->emp_id,
            'receiver_id' => optional($this->selectedConversation->getReceiver())->emp_id,
            'file_path' => $fileContent,  // Store the binary data in the database
            'body' => $this->body,
            'file_name' => $fileName,
            'mime_type' => $mimeType,
        ]);
    
        // Create a notification if the receiver is different from the sender
        if (auth()->user()->emp_id != optional($this->selectedConversation->getReceiver())->emp_id) {
            Notification::create([
                'chatting_id' => $this->selectedConversation->id,
                'notification_type' => 'message',
                'emp_id' => auth()->user()->emp_id,
                'receiver_id' => optional($this->selectedConversation->getReceiver())->emp_id,
                'body' => $this->body,
            ]);
        }
    
        // Reset input fields
        $this->reset('body', 'file_path'); // Reset file_path if that’s what you meant
    
        // Scroll to bottom of the chat
        $this->dispatch('scroll-bottom');
    
        // Push the message to the list
        $this->loadedMessages->push($createdMessage);
    
        // Update the conversation model
        $this->selectedConversation->updated_at = now();
        $this->selectedConversation->save();
    
        // Refresh the chat list
        $this->dispatch('chat.chat-list', 'refresh');
    
        // Broadcast the message
        $this->selectedConversation->getReceiver()
            ->notify(new MessageSent(
                auth()->user(),
                $createdMessage,
                $this->selectedConversation,
                $this->selectedConversation->getReceiver()->id
            ));
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
