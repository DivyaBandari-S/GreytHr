<?php

namespace App\Livewire;

use Livewire\Component;

class AdminDashboard extends Component
{
    public $show= false;
    public function open(){
        $this->show= true;
    }
    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}
