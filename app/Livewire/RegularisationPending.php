<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EmployeeDetails;
use Carbon\Carbon;
use App\Models\Regularisations;
class RegularisationPending extends Component
{
    public $data;
    
    public $regularisationrequest=[];

    public $id;
    public function mount($id)
    {
        $this->regularisationrequest = Regularisations::with('employee')->find($id);
      

     
        
    }
 
    public function render()
    {
        $this->data = Regularisations::where('is_withdraw',0)->get();
        $today = Carbon::today();
   
        return view('livewire.regularisation-pending',['regularisationrequest'=>$this->regularisationrequest,'today'=>$today]);
    }
}
