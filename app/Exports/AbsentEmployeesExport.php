<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsentEmployeesExport implements  FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $employees;
    protected $currentDate;

    public function __construct($employees, $currentDate)
    {
        $this->employees = $employees;
        $this->currentDate = $currentDate;
    }

    public function collection()
    {
        return collect($this->employees)->map(function ($employee) {
            return [
                'emp_id' => $employee->emp_id,
                'name' => ucwords(strtolower($employee->first_name)) . ' ' . ucwords(strtolower($employee->last_name)),
                'shift_start_time' => $employee->shift_start_time,
            ];
        });
    }

    public function headings(): array
    {
        return [
            ['List of Absent Employees on ' . Carbon::parse($this->currentDate)->format('jS F, Y')],
            ['Employee ID', 'Name', 'Shift Start Time'],
        ];
    }
}
