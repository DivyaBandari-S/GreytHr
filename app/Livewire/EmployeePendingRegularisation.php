<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\RegularisationDates;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EmployeePendingRegularisation extends Component
{
    public $pendingRegularisations;

    public $EmployeeDetails;

    public $openAccordionForPending=[];
    public function mount()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $employeeDetails = EmployeeDetails::where('emp_id', auth()->guard('emp')->user()->emp_id)->first();
        $empid = $employeeDetails->manager_id ?? null;
        $this->EmployeeDetails = $empid ? EmployeeDetails::where('emp_id', $empid)->first() : null;
        $this->pendingRegularisations = RegularisationDates::where('regularisation_dates.emp_id', $loggedInEmpId)
                ->where('regularisation_dates.status', 5)
                ->where('regularisation_dates.is_withdraw', 0)
                ->join('status_types', 'regularisation_dates.status', '=', 'status_types.status_code')
                ->select('regularisation_dates.*', 'status_types.status_name') // Select fields from both tables
                ->orderByDesc('regularisation_dates.updated_at')
                ->get();
    }
    
    public function togglePendingAccordion($id)
    {
      
        if (in_array($id, $this->openAccordionForPending)) {
                // Remove from open accordions if already open
                $this->openAccordionForPending = array_diff($this->openAccordionForPending, [$id]);
            } else {
                // Add to open accordions if not open
                $this->openAccordionForPending[] = $id;
            }
      
    }
    public function render()
    {
        return view('livewire.employee-pending-regularisation');
    }
}
