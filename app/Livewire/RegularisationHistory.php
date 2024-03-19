<?php

namespace App\Livewire;
use App\Models\Regularisations;
use Livewire\Component;
use Carbon\Carbon;

class RegularisationHistory extends Component
{
    public $regularisationdescription;
 
    public $regularisationdescrip;
    public function mount($id)
    {
        $this->regularisationdescription = Regularisations::find($id);
    }

    public function render()
    {
        $today = Carbon::today();
        return view('livewire.regularisation-history',['regularisationdesc'=>$this->regularisationdescription,'today'=>$today]);
    }
}
