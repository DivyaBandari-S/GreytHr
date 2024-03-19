<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EmployeeDetails;
use App\Models\LeaveRequest;

class LeaveTransctionPdf extends Component
{
    public $leaveTransactions;
    public $employeeDetails;
    public $employeeId;
    public $leaveType;
    public $status;

    public function generatePdf()
    {
        // Fetch data based on selected criteria
        $this->leaveTransactions = LeaveRequest::where('emp_id', $this->employeeId)
            ->where('status', $this->status)
            ->get();

        // Pass data to PDF view
        $pdf = PDF::loadView('livewire.leave-transction-pdf', [
            'employeeDetails' => $this->employeeDetails,
            'leaveTransactions' => $this-> $this->leaveTransactions,
        ]);
        // Download the PDF
        return $pdf->download('leave-transction-pdf');
    }
}
