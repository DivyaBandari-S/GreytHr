<?php

namespace App\Console\Commands;

use App\Mail\WeeklyDataEntries;
use App\Models\DataEntry;
use App\Models\SentEmail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExportDataEntries extends Command
{
    protected $signature = 'export:data-entries {--subject=}';

    protected $description = 'Export data entries and send email every Friday at 12:00 PM';

    public function handle()
{
    $subject = $this->option('subject');
    $currentTime = now();
    
    // Fetch all email entries where `sent_at` is null
    // and where `scheduled_time` is null or matches the current time (hour and minute)
    $emailDataList = SentEmail::whereNull('sent_at')
        ->where(function ($query) use ($currentTime) {
            $query->whereNull('scheduled_time')
                  ->orWhere(function ($query) use ($currentTime) {
                      $query->whereDate('scheduled_time', $currentTime->format('Y-m-d'))
                            ->whereTime('scheduled_time', $currentTime->format('H:i'));
                  });
        })
        ->get();
    
    if ($emailDataList->isEmpty()) {
        $this->info('No emails found to process.');
        return;
    }

    foreach ($emailDataList as $emailData) {
        $toEmail = $emailData->to_email;
        $ccEmail = $emailData->cc_email;
        $subject = $subject ?? $emailData->subject;
        $filePath = storage_path('app/data/data_entries_' . $emailData->id . '.xlsx'); // Unique file path for each record
    
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Get fillable attributes from the DataEntry model
        $fillableAttributes = (new DataEntry())->getFillable();
        $headers = array_map(function ($attribute) {
            return ucwords(str_replace('_', ' ', $attribute));
        }, $fillableAttributes);
    
        // Add headers to the first row and apply bold font
        $sheet->fromArray($headers, null, 'A1');
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->getFont()->setBold(true);
    
        // Fetch data entries and add rows to the Excel file
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
    
        // Update the email details in the database and set status based on email sending
        $status = $this->sendEmailAndReturnStatus($toEmail, $ccEmail, $subject, $filePath);
    
        $emailData->update([
            'file_path' => $filePath,
            'status' => $status,
            'sent_at' => $status === 'sent' ? $currentTime : $emailData->sent_at, // Update sent_at only if status is 'sent'
        ]);

        $this->info('Data entries exported and email sent successfully for ID ' . $emailData->id . ' with status: ' . $status);
    }
}


    protected function sendEmailAndReturnStatus($toEmail, $ccEmail, $subject, $filePath)
    {
        $fromAddress = 'info@w3.payg-india.com'; // Replace with your desired "from" address
        $mail = new WeeklyDataEntries($filePath, $toEmail, $subject);

        try {
            $mail->from($fromAddress); // Set the "from" address
            if ($ccEmail) {
                Mail::to($toEmail)->cc($ccEmail)->send($mail);
            } else {
                Mail::to($toEmail)->send($mail);
            }
            return 'sent';
        }  catch (\Exception $e) {
            Log::error('Error sending email: ' . $e->getMessage());
            return 'failed'; // or 'failed' depending on your error handling logic
        }
    }
}
