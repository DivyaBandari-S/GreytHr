<?php

namespace App\Livewire;

use App\Models\Finance;
use App\Models\Hr;
use App\Models\Admin;
use App\Models\Company;
use App\Models\EmployeeDetails;
use App\Models\IT;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CompanyLogo extends Component
{
    // public $companyLogo;
    // public $mimeType;

    // public function mount()
    // {
    //     // Get authenticated employee details
    //     $employee = EmployeeDetails::where('emp_id', Auth::user()->emp_id)->first();

    //     if (!$employee) {
    //         session()->flash('error', 'Employee not found');
    //         return;
    //     }

    //     // Directly use company_id since it's already an array
    //     $companyIds = $employee->company_id; // No need for json_decode()
    //     $firstCompanyId = $companyIds[0] ?? null;

    //     if (!$firstCompanyId) {
    //         session()->flash('error', 'No assigned company found');
    //         return;
    //     }

    //     // Retrieve the first company's logo
    //     $company = Company::where('company_id', $firstCompanyId)->first();

    //     if ($company && $company->company_logo) {
    //         $binaryLogo = $company->company_logo;

    //         // Detect MIME type
    //         $finfo = finfo_open(FILEINFO_MIME_TYPE);
    //         $this->mimeType = finfo_buffer($finfo, $binaryLogo);
    //         finfo_close($finfo);

    //         // Convert binary to Base64
    //         $this->companyLogo = base64_encode($binaryLogo);
    //     }
    // }

    public function render()
    {
        return view('livewire.company-logo');
    }
}
