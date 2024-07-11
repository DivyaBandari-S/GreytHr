<?php

namespace App\Livewire\Chat;

use App\Models\Chating;
use App\Models\Message;
use Livewire\Component;

class Chat extends Component
{

    public $query;
    public $selectedConversation;

    public function mount()
    {

        $this->selectedConversation= Chating::findOrFail($this->query);




       #mark message belogning to receiver as read
       Message::where('chating_id', $this->selectedConversation->id)
       ->where('receiver_id', auth()->user()->emp_id)
       ->whereNull('read_at')
       ->update(['read_at' => now()]);




    }

    public function render()
    {
        return view('livewire.chat.chat');
    }
}
