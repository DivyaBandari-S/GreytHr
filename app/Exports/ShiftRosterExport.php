<?php

namespace App\Exports;

use App\Models\EmployeeDetails;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ShiftRosterExport implements FromArray,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;
    
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function headings(): array
    {
        return $this->data[0]; // First row as headings
    }

    public function array(): array
    {
        return array_slice($this->data, 1); // Remove first row which is the title
    }
}
