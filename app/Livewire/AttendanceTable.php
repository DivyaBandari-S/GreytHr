<?php

namespace App\Livewire;

use App\Models\HolidayCalendar;
use App\Models\SwipeRecord;
use Carbon\Carbon;
use Livewire\Component;

class AttendanceTable extends Component
{
    public $distinctDates;

    public $todaysDate;

    public $moveCaretLeftSession1=false;

    public $moveCaretLeftSession2=false;
    public $holiday;

    public $swiperecord;

    public $date;

    public $showAlertDialog = false;

    public $showSR=false;
   
    public function toggleCaretDirectionForSession1()
    {
        $this->moveCaretLeftSession1= !$this->moveCaretLeftSession1;
    }
    public function viewDetails($i)
    {
        $this->showAlertDialog = true;
        $this->date=$i;
    }
    public function close()
    {
        $this->showAlertDialog = false;
    }
    public function toggleCaretDirectionForSession2()
    {
        $this->moveCaretLeftSession2= !$this->moveCaretLeftSession2;
    }
    public function render()
    {
        $this->todaysDate = date('Y-m-d');
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->swiperecord=SwipeRecord::where('emp_id',$employeeId)->where('is_regularised',1)->get();
        $currentMonth = date('F');
        $currentYear=date('Y');
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
