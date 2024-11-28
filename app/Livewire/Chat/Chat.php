<?php

namespace App\Livewire\Chat;

use Livewire\Component;

class Chat extends Component
{
    // protected $listeners = ['sendMessage'];
    // public function sendMessage($message)
    // {
    //     // Process the message (e.g., save it to the database)
    //     session()->flash('success', $message);
    //     $this->dispatch('show-toast', ['message' => $message]);
    // }

    public function render()
    {
        return view('livewire.chat.chat');
    }
}
