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

use Carbon\Carbon;
use Livewire\Component;
use App\Models\HolidayCalendar;
use Illuminate\Support\Facades\DB;

class HolidayCalender extends Component
{
    public $selectedYear;
    public $initialSelectedYear;
    public $calendarData;
    public $previousYear;
    public $nextYear;
    
    public function mount()
    {
        // Set the default year to the current year
        $this->selectedYear = Carbon::now()->year;
        $this->initialSelectedYear = $this->selectedYear; // Store the initial selected year
        $this->previousYear = $this->selectedYear - 1;
        $this->nextYear = $this->selectedYear + 1;
        $this->fetchCalendarData($this->selectedYear);
    }
    
    public function selectYear($selected_Year)
    {
        // Update the calendar data only if the selected year changes
        if ($this->selectedYear != $selected_Year) {
            $this->selectedYear = $selected_Year;
            $this->fetchCalendarData($selected_Year);
        }
    }
    
    public function fetchCalendarData($year)
    {
        try {
            // Fetch data for the selected year
            $this->calendarData = HolidayCalendar::where('year', $year)->get();
            $uniqueDates = $this->calendarData->unique('date');

            // Update the calendar data with unique dates
            $this->calendarData = $uniqueDates;
        } catch (\Exception $e) {
            // Handle the exception, log it, or display an error message
            \Log::error('Error fetching calendar data: ' . $e->getMessage());
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
