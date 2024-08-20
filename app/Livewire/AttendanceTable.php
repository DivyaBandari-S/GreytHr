<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\HolidayCalendar;
use App\Models\SwipeRecord;
use Carbon\Carbon;
use Livewire\Component;

class AttendanceTable extends Component
{
    public $distinctDates;

    public $todaysDate;
    public $viewDetailsInswiperecord;

    public $viewDetailsOutswiperecord;
    public $moveCaretLeftSession1 = false;

    public $viewDetailsswiperecord;
    public $moveCaretLeftSession2 = false;
    public $holiday;

    public $swiperecord;

    public $date;

    public $showAlertDialog = false;

    public  string $year;

    public  string $start;

    public $employeeDetails;
    public string $end;

    public $legend=true;
    public $showSR = false;

    protected $listeners = [
        'update',
    ];


    public function mount()
    {
        // First initialize
        $this->year = Carbon::now()->format('Y');
        $this->start = Carbon::now()->year($this->year)->firstOfMonth()->format('Y-m-d');
        $this->end = Carbon::now()->year($this->year)->lastOfMonth()->format('Y-m-d');
        $this->employeeDetails=EmployeeDetails::where('emp_id',auth()->guard('emp')->user()->emp_id)->select('emp_id','first_name','last_name')->first();
    }
    public function openlegend()
    {
        $this->legend=!$this->legend;
    }
    public function update($start, $end) 
    {
        $this->year = carbon::parse($start)->format('Y');
        $this->start = $start;
        $this->end = $end;
    }

    public function changeYear()
    {
        $this->start = Carbon::parse($this->start)->year($this->year)->format('Y-m-d');
        $this->end = Carbon::parse($this->end)->year($this->year)->format('Y-m-d');
    }
    public function toggleCaretDirectionForSession1()
    {
        $this->moveCaretLeftSession1 = !$this->moveCaretLeftSession1;
    }

    public function viewDetails($i)
    {
        $this->showAlertDialog = true;
        $this->date = $i;
        $this->viewDetailsswiperecord = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->whereDate('created_at', $this->date)->get();
        $this->viewDetailsInswiperecord = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->where('in_or_out', 'IN')->whereDate('created_at', $this->date)->first();
       
        $this->viewDetailsOutswiperecord = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->where('in_or_out', 'OUT')->whereDate('created_at', $this->date)->first();
        
    }
    public function close()
    {
        $this->viewDetailsInswiperecord = null;
        $this->viewDetailsOutswiperecord = null;
        $this->showAlertDialog = false;
    }
    public function toggleCaretDirectionForSession2()
    {
        $this->moveCaretLeftSession2 = !$this->moveCaretLeftSession2;
    }
    public function render()
    {
        $this->todaysDate = date('Y-m-d');
        $employeeId = auth()->guard('emp')->user()->emp_id;

        $this->swiperecord = SwipeRecord::where('emp_id', $employeeId)->where('is_regularised', 1)->get();
        $currentMonth = date('F');
        $currentYear = date('Y');
        $this->holiday = HolidayCalendar::where('month', $currentMonth)
            ->where('year', $currentYear)
            ->pluck('date')
            ->toArray();

        $swipeRecords = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->get();
        $groupedDates = $swipeRecords->groupBy(function ($record) {
            return Carbon::parse($record->created_at)->format('Y-m-d');
        });
        $this->distinctDates = $groupedDates->mapWithKeys(function ($records, $key) {
            $inRecord = $records->where('in_or_out', 'IN')->first();
            $outRecord = $records->where('in_or_out', 'OUT')->last();

            return [
                $key => [
                    'in' => "IN",
                    'first_in_time' => optional($inRecord)->swipe_time,
                    'last_out_time' => optional($outRecord)->swipe_time,
                    'out' => "OUT",
                ]
            ];
        });
        return view('livewire.attendance-table');
    }
}
