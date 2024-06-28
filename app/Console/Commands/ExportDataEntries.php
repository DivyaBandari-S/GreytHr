<?php

namespace App\Console\Commands;

use App\Mail\WeeklyDataEntries;
use App\Models\DataEntry;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExportDataEntries extends Command
{
    protected $signature = 'export:data-entries';
    protected $description = 'Export data entries and send email every Friday at 12:00 PM';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Retrieve email addresses and subject
        $emailData = DB::table('email_addresses')->find(1);
        if (!$emailData) {
            $this->error('Email addresses not set.');
            return;
        }

        $toEmail = $emailData->to_email;
        $ccEmail = $emailData->cc_email;
        $subject = $emailData->subject;

        $filePath = storage_path('app/public/data_entries.xlsx');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $fillableAttributes = (new DataEntry())->getFillable();
        $headers = array_map(function ($attribute) {
            return ucwords(str_replace('_', ' ', $attribute));
        }, $fillableAttributes);

        $sheet->fromArray($headers, null, 'A1');
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->getFont()->setBold(true);

        $dataEntries = DataEntry::all()->map(function ($dataEntry) use ($fillableAttributes) {
            $row = [];
            foreach ($fillableAttributes as $attribute) {
                if (in_array($attribute, ['start_date', 'sow_end_date'])) {
                    $row[] = $dataEntry->{$attribute} ? Carbon::parse($dataEntry->{$attribute})->format('d M, Y') : '';
                } else {
                    $row[] = $dataEntry->{$attribute};
                }
            }
            return $row;
        })->toArray();

        $sheet->fromArray($dataEntries, null, 'A2');

        foreach (range('A', $sheet->getHighestColumn()) as $columnID) {
            $sheet->getColumnDimension($columnID)->setWidth(20);
        }

        $headerStyleArray = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFA0A0A0'],
            ],
        ];
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray($headerStyleArray);

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        $fromAddress = 'info@w3.payg-india.com';
        $mail = new WeeklyDataEntries($filePath, $fromAddress, $subject);

        if ($ccEmail) {
            Mail::to($toEmail)->cc($ccEmail)->send($mail);
        } else {
            Mail::to($toEmail)->send($mail);
        }

        $this->info('Data entries exported and email sent successfully.');
    }
}
