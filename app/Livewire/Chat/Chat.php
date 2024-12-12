<?php

namespace App\Livewire\Chat;

use Livewire\Component;

class Chat extends Component
{

    public function render()
    {
        // $receiverId = session('receiverId');

        return view('livewire.chat.chat');
    }
}
