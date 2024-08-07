<?php

namespace App\Livewire;
use App\Models\ITStatement;
use Livewire\Component;
use App\Models\AddDeclaration;
use App\Models\Salaryslip;
use App\Models\EmployeeDetails;
use App\Models\SalaryRevision;
use App\Models\EmpBankDetail;

use Illuminate\Support\Facades\Response;
use PDF;
class Itstatement1 extends Component
{
    public $resumeData;
    public $employee;
    public $itStatements;
    public $monthlyIncomeType ;
    public $employeeDetails;
    public $salaryRevision;
    public $empBankDetails;
 
    public $filteredData;
   public $activePreview;
    public function mount()
    {
        // Retrieve data for the specified monthly_income_type
       // $this->filteredData = ITStatement::all('monthly_income_type', $this->monthlyIncomeType);

    }
 

    public function generatePDF()
    {
        // Generate your PDF content using a PDF package like dompdf or TCPDF
        $pdf = PDF::loadView('pdf.itform'); // Load the PDF view
       
        return $pdf->download('itform.pdf'); // Download the PDF
    }

  
    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
    
        try {
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->get();
        } catch (\Exception $e) {
            $this->employeeDetails = collect();
        }
    
        try {
            $this->salaryRevision = SalaryRevision::where('emp_id', $employeeId)->get();
        } catch (\Exception $e) {
            $this->salaryRevision = collect();
        }
    
        try {
            $this->empBankDetails = EmpBankDetail::where('emp_id', $employeeId)->get();
        } catch (\Exception $e) {
            $this->empBankDetails = collect();
        }
    
        $totalGrossPay = 0;
        $totalDeductions = 0;
    
        if ($this->salaryRevision->isNotEmpty()) {
            foreach ($this->salaryRevision as $revision) {
                $totalGrossPay += $revision->calculateTotalAllowance();
                $totalDeductions += $revision->calculateTotalDeductions();
            }
        }
    
  
    
        try {
            $this->itStatements = ITStatement::all();
        } catch (\Exception $e) {
            $this->itStatements = collect();
        }

        return view('livewire.itstatement1',['employees' => $this->employeeDetails],['salaryRevision' => $this->salaryRevision],['empBankDetails' => $this->empBankDetails] ,['itStatements' => $this->itStatements],);
    }
    
}