<?php

namespace App\Livewire;

use App\Models\EmpBankDetail;
use App\Models\EmployeeDetails;
use App\Models\ParentDetail;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class ProfileInfo extends Component
{
    public $parentDetails;
    public $empBankDetails;

    public $employeeDetails;
    public function render()
    {
        $this->employeeDetails = EmployeeDetails::where('emp_id', auth()->guard('emp')->user()->emp_id)->get();
        $this->parentDetails = ParentDetail::where('emp_id', auth()->guard('emp')->user()->emp_id)->get();
        $this->empBankDetails = EmpBankDetail::where('emp_id', auth()->guard('emp')->user()->emp_id)->get();

        return view('livewire.profile-info');
    }
}
