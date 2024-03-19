<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;
class ReviewRegularizations extends Component
{
    public $reviews1;
    public function render()
    {
        $this->reviews1=Review::all();
        return view('livewire.review-regularizations');
    }
}
