<?php

namespace App\Livewire;

use Livewire\Component;

class AttendanceChart extends Component
{
    public $absent;
    public $present;
    public $leaveTaken;
    public $holidays;

    public function mount()
    {
        // Initialize your data here
        $this->absent = 10;
        $this->present = 20;
        $this->leaveTaken = 5;
        $this->holidays = 3;
    }

    public function render()
    {
        return view('livewire.attendance-chart');
    }
}
