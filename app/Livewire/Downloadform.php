<?php

namespace App\Livewire;

use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\EmployeeDetails;
class Downloadform extends Component
{
    public $employeeDetails;
 
    
    public function render()
    {
        $this->employeeDetails = EmployeeDetails::where('emp_id',auth()->guard('emp')->user()->emp_id)->get();
        return view('livewire.downloadform',['employees' => $this->employeeDetails]);

    }
}