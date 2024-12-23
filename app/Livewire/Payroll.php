<?php

namespace App\Livewire;

use App\Models\EmpBankDetail;
use App\Models\EmployeeDetails;
use App\Models\EmpPersonalInfo;
use App\Models\EmpSalary;
use App\Models\EmpSalaryRevision;
use Livewire\Component;
use DateTime;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Payroll extends Component
{
    public $employeeDetails;
    public $salaryRevision;
    public $allSalaryDetails;
    public $empBankDetails;
    public $showDetails = true;
    public $netPay;
    public $showPopup = false;
    public $pdfUrl;
    public $empSalaryDetails;
    public $salaryDivisions;
    public $employeePersonalDetails;
    public $pdfPath;
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

    public function cancel()
    {
        $this->showPopup = false;
    }




    public function convertNumberToWords($number)
    {
        // Array to represent numbers from 0 to 19 and the tens up to 90
        $words = [
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety'
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

    public function documentCenter()
{
    // Handle logic here, e.g., redirect or perform an action
    return redirect('/document');
}

    public function mount()
    {
        $this->allSalaryDetails = $this->getSalaryDetails();

        $employeeId = auth()->guard('emp')->user()->emp_id;


        $this->employeeDetails = EmployeeDetails::select('employee_details.*', 'emp_departments.department')
            ->leftJoin('emp_departments', 'employee_details.dept_id', '=', 'emp_departments.dept_id')
            ->leftJoin('emp_personal_infos', 'employee_details.emp_id', '=', 'emp_personal_infos.emp_id')
            ->where('employee_details.emp_id', $employeeId)
            ->first();
    }

    public function downloadPdf($month)
    {
        $salaryDivisions = [];
        $empBankDetails=[];
        $employeeId = auth()->guard('emp')->user()->emp_id;

        $empSalaryDetails = EmpSalary::join('salary_revisions', 'emp_salaries.sal_id', '=', 'salary_revisions.id')
            ->where('salary_revisions.emp_id', $employeeId)
            ->where('month_of_sal', 'like',  $month . '%')
            ->first();


        if ($empSalaryDetails) {
            $salaryDivisions = $empSalaryDetails->calculateSalaryComponents($empSalaryDetails->salary);
            $empBankDetails = EmpBankDetail::where('emp_id', $employeeId)
                ->where('id', $empSalaryDetails->bank_id)->first();
            $employeePersonalDetails = EmpPersonalInfo::where('emp_id', $employeeId)->first();
            // dd( $this->employeePersonalDetails);
        } else {
            // Handle the null case (e.g., log an error or set a default value)
            $salaryDivisions = [];
        }

        // Generate PDF using the fetched data
        $pdf = Pdf::loadView('download-pdf', [
            'employees' =>  $this->employeeDetails,
            'salaryRevision' =>  $salaryDivisions,
            'empBankDetails' => $empBankDetails,
            'rupeesInText' => $this->convertNumberToWords($salaryDivisions['net_pay']),
            'salMonth' => Carbon::parse($month)->format('F Y')
        ]);

        $name = Carbon::parse($month)->format('MY');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'payslip-' . $name . '.pdf');
    }
    public $rupeesInText;
    public $salMonth;
    public $month;
    public function viewPdf($month)
    {

        $employeeId = auth()->guard('emp')->user()->emp_id;

        $empSalaryDetails = EmpSalary::join('salary_revisions', 'emp_salaries.sal_id', '=', 'salary_revisions.id')
            ->where('salary_revisions.emp_id', $employeeId)
            ->where('month_of_sal', 'like',  $month . '%')
            ->first();

        if ($empSalaryDetails) {
            $this->salaryDivisions = $empSalaryDetails->calculateSalaryComponents($empSalaryDetails->salary);
            $this->empBankDetails = EmpBankDetail::where('emp_id', $employeeId)
                ->where('id', $empSalaryDetails->bank_id)->first();
            $this->employeePersonalDetails = EmpPersonalInfo::where('emp_id', $employeeId)->first();
            $this->rupeesInText = $this->convertNumberToWords($this->salaryDivisions['net_pay']);
        } else {
            $this->salaryDivisions = [];
        }

        $this->salMonth = Carbon::parse($month)->format('F Y');
        $this->month = $empSalaryDetails->month_of_sal;




        // Emit event to open modal
        $this->showPopup=true;
    }

    public function getSalaryDetails()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;

        // Querying the database directly using the DB facade
        $salaryDetails = DB::table('emp_salaries')
            ->join('salary_revisions', 'emp_salaries.sal_id', '=', 'salary_revisions.id')
            ->where('salary_revisions.emp_id', $employeeId)
            ->selectRaw("
                emp_salaries.*,
                salary_revisions.*,
                CASE
                    WHEN MONTH(month_of_sal) >= 4
                        THEN YEAR(month_of_sal)
                    ELSE YEAR(month_of_sal) - 1
                END as financial_year_start
            ")
            ->orderBy('financial_year_start', 'desc')
            ->get();

        // Group the results manually by the financial_year_start
        $grouped = $salaryDetails->groupBy('financial_year_start');

        return $grouped;
    }


    public function render()
    {
        return view('livewire.payroll');
    }

}
