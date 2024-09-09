<?php

namespace App\Livewire;

use App\Models\RegularisationDates;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PendingRegularisationForView extends Component
{
    public $pendingRegularisations;

    public $openAccordionForPending = null;
    public $withdrawModal=false;
    public function openWithdrawModal()
    {
        $this->withdrawModal=true;
    }
    public function togglePendingAccordion($id)
    {
        
        if ($this->openAccordionForPending === $id) {
            $this->openAccordionForPending = null; // Close if already open
        } else {
            $this->openAccordionForPending = $id; // Set to open
        }
    }
    public function render()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $this->pendingRegularisations= RegularisationDates::where('emp_id', $loggedInEmpId)
        ->where('status', 'pending')
        ->where('is_withdraw', 0)
        ->orderByDesc('id')
        ->get();
        return view('livewire.pending-regularisation-for-view');
    }
}
