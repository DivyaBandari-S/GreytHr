<?php

namespace App\Livewire;

use App\Models\EmpBankDetail;
use App\Models\EmployeeDetails;
use App\Models\SalaryRevision;
use Livewire\Component;
use DateTime;
use Barryvdh\DomPDF\Facade\Pdf;
class Payroll extends Component
{
    public $employeeDetails;
    public $salaryRevision;
    public $empBankDetails;
    public $showDetails = true;
    public $selectedMonth;
    public $netPay;
    public $showPopup=false;
    public function toggleDetails()
    {
        $this->showDetails = !$this->showDetails;
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
    // public function downloadPdf()
    // {

    //     $employeeId = auth()->guard('emp')->user()->emp_id;
    //     $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->get();
    //     $this->salaryRevision = SalaryRevision::where('emp_id', $employeeId)->get();
    //     $this->empBankDetails = EmpBankDetail::where('emp_id', $employeeId)->get();

    //     $data = [
    //         'employees' => $this->employeeDetails,
    //         'salaryRevision' => $this->salaryRevision,
    //         'empBankDetails' => $this->empBankDetails,
    //         'netPay' => $this->calculateNetPay()
    //     ];

    //          // Generate PDF using the fetched data
    //          $pdf = Pdf::loadView('download-pdf', [
    //           $data
    //         ]);
    //     return response()->streamDownload(function() use($pdf){
    //         echo $pdf->stream();
    //     }, 'payslip.pdf');


    // }
    public function downloadPdf(){
        $this->showPopup=true;
        // $this->text=$text;
        // dd($text);
        }
        public function cancel(){
            $this->showPopup=false;
            }




    public function convertNumberToWords($number)
    {
        // Array to represent numbers from 0 to 19 and the tens up to 90
        $words = [
            0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five',
            6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten',
            11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen',
            20 => 'twenty', 30 => 'thirty', 40 => 'forty', 50 => 'fifty',
            60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
        ];

        // Handle special cases
        if ($number < 0) {
            return 'minus ' . $this->convertNumberToWords(-$number);
        }

        // Handle numbers less than 100
        if ($number < 100) {
            if ($number < 20) {
                return $words[$number];
            } else {
                $tens = $words[10 * (int) ($number / 10)];
                $ones = $number % 10;
                if ($ones > 0) {
                    return $tens . ' ' . $words[$ones];
                } else {
                    return $tens;
                }
            }
        }

        // Handle numbers greater than or equal to 100
        if ($number < 1000) {
            $hundreds = $words[(int) ($number / 100)] . ' hundred';
            $remainder = $number % 100;
            if ($remainder > 0) {
                return $hundreds . ' ' . $this->convertNumberToWords($remainder);
            } else {
                return $hundreds;
            }
        }

        // Handle larger numbers
        if ($number < 1000000) {
            $thousands = $this->convertNumberToWords((int) ($number / 1000)) . ' thousand';
            $remainder = $number % 1000;
            if ($remainder > 0) {
                return $thousands . ' ' . $this->convertNumberToWords($remainder);
            } else {
                return $thousands;
            }
        }

        // Handle even larger numbers
        if ($number < 1000000000) {
            $millions = $this->convertNumberToWords((int) ($number / 1000000)) . ' million';
            $remainder = $number % 1000000;
            if ($remainder > 0) {
                return $millions . ' ' . $this->convertNumberToWords($remainder);
            } else {
                return $millions;
            }
        }

        // Handle numbers larger than or equal to a billion
        return 'number too large to convert';
    }

    public function render()
    {
        $currentYear = date('Y');
        $lastMonth = date('n')-1;

        // Generate options for months from January of the previous year to the current month of the current year
        $options = [];
        for ($year = $currentYear; $year >= $currentYear - 1; $year--) {
            $startMonth = ($year == $currentYear) ? $lastMonth : 12; // Start from the current month or December
            $endMonth = ($year == $currentYear - 1) ? 1 : 1; // End at January

            for ($month = $startMonth; $month >= $endMonth; $month--) {
                // Format the month and year to display
                $dateObj = DateTime::createFromFormat('!m', $month);
                $monthName = $dateObj->format('F');
                $options["$year-$month"] = "$monthName $year";
            }
        }

        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::select('employee_details.*', 'emp_departments.department')
        ->leftJoin('emp_departments', 'employee_details.dept_id', '=', 'emp_departments.dept_id')
        ->where('employee_details.emp_id', $employeeId)
        ->get();
        $this->salaryRevision = SalaryRevision::where('emp_id', $employeeId)->get();
        $salaryRevision = new SalaryRevision();

        // Calculate total allowance and deductions
        $totalGrossPay = 0;
        $totalDeductions = 0;

        foreach ($this->salaryRevision as $revision) {
            $totalGrossPay += $revision->calculateTotalAllowance();
            $totalDeductions += $revision->calculateTotalDeductions();
        }

        $this->netPay = $totalGrossPay - $totalDeductions;
        $this->empBankDetails = EmpBankDetail::where('emp_id', $employeeId)->get();
        $this->empBankDetails = EmpBankDetail::where('emp_id', $employeeId)->get();
        return view('livewire.payroll', [
            'employees' => $this->employeeDetails,
            'salaryRevision' => $this->salaryRevision,
            'empBankDetails' => $this->empBankDetails,
            'options' => $options,
            'netPay' => $this->netPay
        ]);
    }
}
