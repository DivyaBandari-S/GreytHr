<?php

namespace App\Livewire\Chat;

use Livewire\Component;

class Chat extends Component
{
    public $senderId;
    public $receiverId;

    // public function mount()
    // {
    //     // Check if session data is passed, if so, call the method
    //     $this->senderId = auth()->id();
    //     $this->receiverId = session('receiverId');
    // }


    public function render()
    {

        return view('livewire.chat.chat');
    }
}
