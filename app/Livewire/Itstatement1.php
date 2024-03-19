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
        $this->employeeDetails =  EmployeeDetails::where('emp_id', $employeeId)->get();
        $this->salaryRevision =  SalaryRevision::where('emp_id', $employeeId)->get();
        $this-> empBankDetails=  EmpBankDetail::where('emp_id', $employeeId)->get();
         $this->itStatements = ITStatement::all();
        // Fetch the data from the ITStatement model
        try {
            $this->itStatements = ITStatement::all();
        } catch (\Exception $e) {
            // Handle any exceptions here, such as database connection errors
            // You can log the error or handle it in a way that makes sense for your application
            // For now, you can set $this->itStatements to an empty array or null to avoid the error
            $this->itStatements = [];
        }

        return view('livewire.itstatement1',['employees' => $this->employeeDetails],['salaryRevision' => $this->salaryRevision],['empBankDetails' => $this->empBankDetails] ,['itStatements' => $this->itStatements],);
    }
    
}