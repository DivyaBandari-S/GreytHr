<?php

namespace App\Livewire;

use Livewire\Component;

class LoadingIndicator extends Component
{
    public function render()
    {
        return view('laravel-livewire-loader::loading-indicator');
    }
}
