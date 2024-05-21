<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EmployeeDetails;
use App\Models\RegularisationNew1;
use Carbon\Carbon;
use App\Models\Regularisations;
class RegularisationPending extends Component
{
    public $data;
    
    public $regularisationrequest=[];

    public $ManagerId;
    public $ManagerName;

    public $totalEntries;
    public $regularisationEntries;

    public $id;
    public function mount($id)
    {
        $this->regularisationrequest = RegularisationNew1::with('employee')->find($id);
        $this->ManagerId=$this->regularisationrequest->employee->manager_id;
        $this->ManagerName=EmployeeDetails::select('first_name','last_name')->where('emp_id',$this->ManagerId)->first();
        $this->regularisationEntries = json_decode($this->regularisationrequest->regularisation_entries, true);
        $this->regularisationEntries = array_reverse($this->regularisationEntries);
        $this->totalEntries = count($this->regularisationEntries);
       
        
    }
 
    public function render()
    {
        $this->data = Regularisations::where('is_withdraw',0)->get();
        $today = Carbon::today();
   
        return view('livewire.regularisation-pending',['regularisationrequest'=>$this->regularisationrequest,'today'=>$today]);
    }
}
