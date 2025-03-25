<?php

namespace App\Exports;

use App\Models\SwipeRecord;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SwipeDataExport implements FromCollection,WithHeadings
{
    protected $swipeData;
    protected $title;

    protected $startDate;
    protected $headerColumns;

    public function __construct(array $swipeData, string $title, string $startDate)
    {
        $this->swipeData = collect($swipeData);
        $this->title = $title;
        $this->startDate=$startDate;
    }

    public function collection()
    {
        return $this->swipeData;
    }

   

    public function title(): string
    {
        return $this->title;
    }

    public function headings(): array
    {
        return [
            ['List of Late Arrival Employees on ' . Carbon::parse($this->startDate)->format('jS F, Y')],
            ['Employee ID', 'Name', 'Sign In Time', 'Late By (HH:MM)'],
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [ // Header row styles
                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']], // Green background
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}
