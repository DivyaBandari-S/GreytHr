<?php

namespace App\Livewire;

use App\Models\Leavereview;
use Livewire\Component;

class ReviewLeave extends Component
{
    public  $leavereviews= [];
    public function render()
    {
        $this->leavereviews = Leavereview::all();
        return view('livewire.review-leave',['leavereviews' => $this->leavereviews]);
    }
}
