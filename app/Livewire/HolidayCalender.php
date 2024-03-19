<?php
// File Name                       : HolidayCalender.php
// Description                     : This file contains the implementation of displaying the holiday list for a year
// Creator                         : Bandari Divya
// Email                           : bandaridivya1@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : HolidayCalendar
namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\HolidayCalendar;
use Illuminate\Support\Facades\DB;

class HolidayCalender extends Component
{
    public $year;
    public $currentYear = 'true';
    public $previousYear = 'false';
    public $nextYear = 'false';

    public function mount()
    {
        // Set the default year to the current year
        $this->year = Carbon::now()->year;
        $this->currentYear = true;
    }

    public function selectYear($selectedYear)
    {
        // Set the flags based on the selected year
        $this->year = $selectedYear;

        if ($selectedYear == $this->year) {
            $this->currentYear = true;
            $this->previousYear = false;
            $this->nextYear = false;
        } elseif ($selectedYear == $this->year - 1) {
            $this->currentYear = false;
            $this->previousYear = true;
            $this->nextYear = false;
        } elseif ($selectedYear == $this->year + 1) {
            $this->currentYear = false;
            $this->previousYear = false;
            $this->nextYear = true;
        }

        $this->render();
    }


    public function render()
    {
        try {
            $currentYear = Carbon::now()->year;

            // Fetch data for the current year
            $calendarData = HolidayCalendar::where('year', $this->year)->get();

            // Fetch data for the previous year
            $calendarDataPrevious = HolidayCalendar::where('year', $currentYear - 1)->get();

            // Fetch data for the next year
            $calendarDataNext = HolidayCalendar::where('year', $currentYear + 1)->get();

            // Merge the data for all years
            $calendarData = $calendarData->concat($calendarDataPrevious)->concat($calendarDataNext);
        } catch (\Exception $e) {
            // Handle the exception, log it, or display an error message
            \Log::error('Error fetching calendar data: ' . $e->getMessage());

            $calendarData = [];
        }

        return view('livewire.holiday-calender', [
            'calendarData' => $calendarData,
        ]);
    }
}
