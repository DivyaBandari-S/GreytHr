<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\Finance;
use App\Models\Hr;
use App\Models\IT;
use Livewire\Component;

class ProfileCard extends Component
{
    public $hrDetails,$itDetails,$financeDetails,$employees;
    public function render()
    {
        if (auth()->guard('emp')->check()) {
        $this->employees = EmployeeDetails::where('emp_id',auth()->guard('emp')->user()->emp_id)->get();
        }
        elseif (auth()->guard('hr')->check()) {
        $this->hrDetails = Hr::where('hr_emp_id',auth()->guard('hr')->user()->hr_emp_id)->get();
        }
        elseif (auth()->guard('it')->check()) {
        $this->itDetails = IT::where('it_emp_id',auth()->guard('it')->user()->it_emp_id)->get();
        }
        elseif (auth()->guard('finance')->check()) {
        $this->financeDetails = Finance::where('fi_emp_id',auth()->guard('finance')->user()->fi_emp_id)->get();
        }
        return view('livewire.profile-card');
    }
}
