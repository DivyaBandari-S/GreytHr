<?php

namespace App\Exports;

use App\Models\SwipeRecord;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LateArrivalsExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $swipes;
    protected $currentDate;

    public function __construct($swipes, $currentDate)
    {
        $this->swipes = $swipes;
        $this->currentDate = $currentDate;
    }

    public function collection()
    {
        return collect($this->swipes)->map(function ($employee) {
            $swipeTime = Carbon::parse($employee->swipe_time);
            $shiftStartTime = $employee->shift_start_time;
            $lateArrivalTime = $swipeTime->diff(Carbon::parse($shiftStartTime))->format('%H:%I:%S');

            $isLateBy10AM = $swipeTime->format('H:i') >= $shiftStartTime;
            if ($isLateBy10AM) {
                return [
                    'emp_id' => $employee->emp_id,
                    'name' => ucwords(strtolower($employee->first_name)) . ' ' . ucwords(strtolower($employee->last_name)),
                    'sign_in_time' => $employee->swipe_time,
                    'late_by' => $lateArrivalTime,
                ];
            }
        })->filter(); // Remove null values
    }

    public function headings(): array
    {
        return [
            ['List of Late Arrival Employees on ' . Carbon::parse($this->currentDate)->format('jS F, Y')],
            ['Employee ID', 'Name', 'Sign In Time', 'Late By (HH:MM)'],
        ];
    }
}
