<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Company;
use App\Models\EmployeeDetails;
use App\Models\SalaryRevision;
use App\Models\EmpBankDetail;
use App\Models\EmpSalaryRevision;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;

class DownloadPdf extends Component
{
    public $employeeDetails;
    public $salaryRevision;
    public $empBankDetails;
    public $companies;
    public function downloadPdf()
    {

        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->get();
        $this->salaryRevision = EmpSalaryRevision::where('emp_id', $employeeId)->get();
        $this->empBankDetails = EmpBankDetail::where('emp_id', $employeeId)->get();

        $data = [
            'employees' => $this->employeeDetails,
            'salaryRevision' => $this->salaryRevision,
            'empBankDetails' => $this->empBankDetails,
            'netPay' => $this->calculateNetPay()
        ];

        $dompdf = new Dompdf();
        $dompdf->set_option('font_dir', storage_path('fonts'));
        $dompdf->set_option('font_cache', storage_path('fonts/cache'));
        $dompdf->loadHtml(view('download-pdf', $data)->render());
        $dompdf->render();

        return $dompdf->stream('salary-slips.pdf');
    }

    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->get();
        $this->salaryRevision = EmpSalaryRevision::where('emp_id', $employeeId)->get();
        $this->empBankDetails = EmpBankDetail::where('emp_id', $employeeId)->get();
        $this->companies = Company::join('employee_details', 'companies.company_id', '=', 'employee_details.company_id')
            ->where('employee_details.emp_id', $employeeId)
            ->orderBy('employee_details.created_at', 'desc')
            ->get();

        return view('livewire.download-pdf', [
            'employees' => $this->employeeDetails,
            'salaryRevision' => $this->salaryRevision,
            'empBankDetails' => $this->empBankDetails,
            'companies' => $this->companies
        ]);
    }


    private function calculateNetPay()
    {
        $totalGrossPay = 0;
        $totalDeductions = 0;

        foreach ($this->salaryRevision as $revision) {
            $totalGrossPay += $revision->calculateTotalAllowance();
            $totalDeductions += $revision->calculateTotalDeductions();
        }

        return $totalGrossPay - $totalDeductions;
    }
}
