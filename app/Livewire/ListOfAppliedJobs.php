<?php

namespace App\Livewire;

use App\Models\AppliedJob;
use App\Models\company;
use Livewire\Component;

class ListOfAppliedJobs extends Component
{
    public function render()
    {
        $companyId = auth()->guard('com')->user()->company_id;

        $appliedJobs = AppliedJob::where('company_name', $companyId->company_name)->get();
        
        return view('livewire.list-of-applied-jobs');
    }
}
