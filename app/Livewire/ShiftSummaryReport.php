<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        try
        {
            $this->shiftSummary = []; 
        }
        catch (\Exception $e) {
            Log::error('Error updating selected year: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while updating the selected year. Please try again.');
        }     
    }
  
    public function updatefromDate()
    {
        try{
            $this->fromDate = $this->fromDate;
        }catch (\Exception $e) {
            Log::error('Error updating selected year: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while updating the selected year. Please try again.');
        }     
    
        
    }
    public function updatetoDate()
    {
        try
        {
            $this->toDate = $this->toDate;
        }catch (\Exception $e) {
            Log::error('Error updating selected year: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while updating the selected year. Please try again.');
        }   
      
    }
    public function getDatesAndWeeknames()
    {
        try
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
        }catch (\Exception $e) {
            Log::error('Error updating selected year: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while updating the selected year. Please try again.');
        }
    }

   
    public function searchfilter()
    {
       try
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
       catch (\Exception $e) {
        Log::error('Error updating selected year: ' . $e->getMessage());
        session()->flash('error', 'An error occurred while updating the selected year. Please try again.');
        }
    }
    public function downloadShiftSummaryReportInExcel()
    {
        try
        {
          if(empty($this->shiftSummary))
          {
            return redirect()->back()->with('error', 'Select at least one employee detail');
          }
          elseif(empty($this->fromDate) && empty($this->toDate))
           {
              return redirect()->back()->with('error', 'Please select FromDate and ToDate');
           }
           elseif(empty($this->fromDate))
           {
              return redirect()->back()->with('error', 'Please select FromDate');
           }
           elseif(empty($this->toDate))
           {
              return redirect()->back()->with('error', 'Please select toDate');
           }
          else
          {
            $employees1 = EmployeeDetails::whereIn('emp_id', $this->shiftSummary)->select('emp_id', 'first_name', 'last_name','shift_type','shift_start_time','shift_end_time')->get();
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
                    ['Employee ID', 'Name', 'Total Days', 'Work Days', 'Off Day', 'Shift Scheme'],

             ];
             foreach ($employees1 as $s1) {
                    

                if($s1['shift_type']=='ES')
                {
                    $data[] = [$s1['emp_id'], $s1['first_name'] . ' ' . $s1['last_name'], $this->totalDayCount, $this->workingDayCount, $this->offDayCount,Carbon::parse($s1['shift_start_time'])->format('H:i a') . ' to ' . Carbon::parse($s1['shift_end_time'])->format('H:i a') ];
                }
                elseif($s1['shift_type']=='AS')
                {
                    $data[] = [$s1['emp_id'], $s1['first_name'] . ' ' . $s1['last_name'], $this->totalDayCount, $this->workingDayCount, $this->offDayCount, Carbon::parse($s1['shift_start_time'])->format('H:i a') . ' to ' . Carbon::parse($s1['shift_end_time'])->format('H:i a')];
                }
                elseif($s1['shift_type']=='GS')
                {
                    $data[] = [$s1['emp_id'], $s1['first_name'] . ' ' . $s1['last_name'], $this->totalDayCount, $this->workingDayCount, $this->offDayCount, Carbon::parse($s1['shift_start_time'])->format('H:i a') . ' to ' . Carbon::parse($s1['shift_end_time'])->format('H:i a')];
                }
             }

             $filePath = storage_path('app/shift_summary_report.xlsx');
             SimpleExcelWriter::create($filePath)->addRows($data);
             return response()->download($filePath, 'shift_summary_report.xlsx');
          }
        }
        catch (\Exception $e) {
            Log::error('Error updating selected year: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while updating the selected year. Please try again.');
        }
    }
    public function resetFields()
    {
        $this->shiftSummary=[];
        $this->fromDate='';
        $this->toDate='';
        $this->search='';
    }
    public function render()
    {
        try
        {
            $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $this->employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name','employee_status')->orderBy('first_name')->get();
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
 
        }catch (\Exception $e) {
            // Handle the exception (e.g., log the error, set an error message, etc.)
            $this->notFound = true; // or set another flag indicating an error occurred
            // Log the exception message or handle it as per your application requirements
            Log::error('Error fetching employee details: ' . $e->getMessage());
        }
        return view('livewire.shift-summary-report');
    }
}
