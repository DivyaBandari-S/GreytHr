<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LeaveRequest;
use Carbon\Carbon;

class CasualViewDetails extends Component
{
    public function render()
    {
        return view('livewire.casual-view-details');
    }
}
