<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class Declaration extends Component
{
    public $showDetails = true;
    public $employeeDetails;
    public function downloadPdf()
    {
       
       
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->get();
     
    
        $data = [
            'employees' => $this->employeeDetails,
        
        ];
  
             // Generate PDF using the fetched data
             $pdf = Pdf::loadView('downloadform', [
              $data
            ]);
        return response()->streamDownload(function() use($pdf){
            echo $pdf->stream();
        }, 'IT Declaration.pdf');
    
       
    }
    
    public function toggleDetails()
    {
        $this->showDetails = !$this->showDetails;
    }
    public function render()
    {
        return view('livewire.declaration');
    }
}
