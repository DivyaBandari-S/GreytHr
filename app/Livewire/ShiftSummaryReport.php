<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ShiftSummaryReport extends Component
{
    public $employees;
    public $search;
    public $searching = 0;

    public $offDayCount = 0;

    public $filteredEmployees;

    public $notFound;

    public $fromDate;
    public $toDate;
    public $workingDayCount = 0;

    public $totalDayCount = 0;
    public $shiftSummary = [];

    public function mount()
    {
        // Initialize with any preselected employee IDs if necessary
        $this->shiftSummary = []; // Example: [1, 2, 3]
    }
    public function updatefromDate()
    {
        $this->fromDate = $this->fromDate;
    }
    public function updatetoDate()
    {
        $this->toDate = $this->toDate;
    }
    public function getDatesAndWeeknames()
    {
        $fromDate = Carbon::parse($this->fromDate);
        $toDate = Carbon::parse($this->toDate);

        $period = new DatePeriod(
            new DateTime($fromDate->toDateString()),
            new DateInterval('P1D'),
            (new DateTime($toDate->toDateString()))->modify('+1 day')
        );

        $datesAndWeeknames = [];

        foreach ($period as $date) {
            $datesAndWeeknames[] = [
                'date' => $date->format('Y-m-d'),
                'weekname' => $date->format('D') // D gives the day of the week in short form (Mon, Tue, etc.)
            ];
        }

        return $datesAndWeeknames;
    }

    public function updateshiftSummary()
    {
    }
    public function searchfilter()
    {
        $this->searching = 1;
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->get();
        $nameFilter = $this->search;

        $filteredEmployees = $employees->filter(function ($employee) use ($nameFilter) {
            return stripos($employee->first_name, $nameFilter) !== false ||
                stripos($employee->last_name, $nameFilter) !== false ||
                stripos($employee->emp_id, $nameFilter) !== false ||
                stripos($employee->job_title, $nameFilter) !== false ||
                stripos($employee->city, $nameFilter) !== false ||
                stripos($employee->state, $nameFilter) !== false;
        });

        if ($filteredEmployees->isEmpty()) {
            $this->notFound = true;
        } else {
            $this->notFound = false;
        }
    }
    public function downloadShiftSummaryReportInExcel()
    {
        $employees1 = EmployeeDetails::whereIn('emp_id', $this->shiftSummary)->select('emp_id', 'first_name', 'last_name')->get();
        $datesAndWeeknames = $this->getDatesAndWeeknames();
        foreach ($datesAndWeeknames as $daw) {
            if ($daw['weekname'] == 'Sat' || $daw['weekname'] == 'Sun') {
                $this->offDayCount++;
            } else {
                $this->workingDayCount++;
            }
        }
        $this->totalDayCount = $this->offDayCount + $this->workingDayCount;
        $data = [
            ['Shift Summary Report from' . Carbon::parse($this->fromDate)->format('jS F, Y') . 'to' . Carbon::parse($this->toDate)->format('jS F, Y')],
            ['Employee ID', 'Name', 'Total Days', 'Work Days', 'Off Day', '10:00 Am to 07:00 Pm'],

        ];
        foreach ($employees1 as $s1) {
            $data[] = [$s1['emp_id'], $s1['first_name'] . ' ' . $s1['last_name'], $this->totalDayCount, $this->workingDayCount, $this->offDayCount, $this->workingDayCount];
        }

        $filePath = storage_path('app/shift_summary_report.xlsx');
        SimpleExcelWriter::create($filePath)->addRows($data);
        return response()->download($filePath, 'shift_summary_report.xlsx');
    }
    public function render()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $this->employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();
        if ($this->searching == 1) {
            $nameFilter = $this->search; // Assuming $this->search contains the name filter
            $this->filteredEmployees = $this->employees->filter(function ($employee) use ($nameFilter) {
                return stripos($employee->first_name, $nameFilter) !== false ||
                    stripos($employee->last_name, $nameFilter) !== false ||
                    stripos($employee->emp_id, $nameFilter) !== false ||
                    stripos($employee->job_title, $nameFilter) !== false ||
                    stripos($employee->city, $nameFilter) !== false ||
                    stripos($employee->state, $nameFilter) !== false;
            });

            if ($this->filteredEmployees->isEmpty()) {
                $this->notFound = true; // Set a flag indicating that the name was not found
            } else {
                $this->notFound = false;
            }
        } else {
            $this->filteredEmployees = $this->employees;
        }
        return view('livewire.shift-summary-report');
    }
}
