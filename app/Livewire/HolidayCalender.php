<?php
// File Name                       : HolidayCalender.php
// Description                     : This file contains the implementation of displaying the holiday list for a year
// Creator                         : Bandari Divya,
// Modified By                     : Venkata Naga Leela Adithya Ramisetty, Uttej Chilakala
// Email                           : bandaridivya1@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-26
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : HolidayCalendar
namespace App\Livewire;

use App\Helpers\FlashMessageHelper;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\HolidayCalendar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HolidayCalender extends Component
{
    public $selectedYear;
    public $initialSelectedYear;
    public $calendarData;
    public $previousYear;
    public $previousYears = [];
    public $nextYear;
    public $noHolidaysFlag = false;

    public function mount()
    {
        try {

            $this->selectedYear = Carbon::now()->year;
            $this->initialSelectedYear = $this->selectedYear;

            // Generate previous 4 years
            $this->previousYears = array_reverse(range($this->selectedYear - 3, $this->selectedYear - 1));




            // Next year
            $this->nextYear = $this->selectedYear + 1;
            $this->fetchCalendarData($this->selectedYear);
        } catch (\Exception $e) {
            // Display a friendly error message to the user
            FlashMessageHelper::flashError('An error occurred while loading the calendar data. Please try again later.');
            // Redirect the user to a safe location
            return redirect()->back();
        }
    }

    //fetch the data according to year selection
    public function selectYear($selected_Year)
    {
        try {
            // Update the calendar data only if the selected year changes
            if ($this->selectedYear != $selected_Year) {
                $this->selectedYear = $selected_Year;
                $this->fetchCalendarData($selected_Year);
            }
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('An error occurred while updating the calendar data. Please try again later.');
            // Redirect the user to a safe location
            return redirect()->back();
        }
    }


    //fetch the calendar data from database
    public function fetchCalendarData($year)
    {
        try {
            // Fetch data for the selected year

            $this->calendarData = HolidayCalendar::where('year', $year)
                ->where('status', 2)
                ->get();

            $uniqueDates = $this->calendarData->unique('date');

            // Update the calendar data with unique dates
            $this->calendarData = $uniqueDates;
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('An error occurred while fetching calendar data. Please try again later.');
            $this->calendarData = [];
        }
    }


    public function render()
    {
        return view('livewire.holiday-calender', [
            //'selectedYear' => $this->selectedYear,
            'previousYear' => $this->previousYear,
            'nextYear' => $this->nextYear,
            'calendarData' => $this->calendarData,
        ]);
    }
}
