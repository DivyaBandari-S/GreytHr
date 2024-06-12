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
use Illuminate\Support\Facades\Log;

class HolidayCalender extends Component
{
    public $selectedYear;
    public $initialSelectedYear;
    public $calendarData;
    public $previousYear;
    public $nextYear;

    public function mount()
    {
        try {
            // Set the default year to the current year
            $this->selectedYear = Carbon::now()->year;
            $this->initialSelectedYear = $this->selectedYear; // Store the initial selected year
            $this->previousYear = $this->selectedYear - 1;
            $this->nextYear = $this->selectedYear + 1;
            $this->fetchCalendarData($this->selectedYear);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in mount method: ' . $e->getMessage());
            // Display a friendly error message to the user
            session()->flash('error', 'An error occurred while loading the calendar data. Please try again later.');
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
            // Log the error
            Log::error('Error in selectYear method: ' . $e->getMessage());
            // Display a friendly error message to the user
            session()->flash('error', 'An error occurred while updating the calendar data. Please try again later.');
            // Redirect the user to a safe location
            return redirect()->back();
        }
    }


    //fetch the calendar data from database
    public function fetchCalendarData($year)
    {
        try {
            // Fetch data for the selected year
            $this->calendarData = HolidayCalendar::where('year', $year)->get();
            $uniqueDates = $this->calendarData->unique('date');
    
            // Update the calendar data with unique dates
            $this->calendarData = $uniqueDates;
    
            // Check if calendar data is empty
            if ($this->calendarData->isEmpty()) {
                session()->flash('error', 'Calendar data not found for the selected year.');
            }
        } catch (\Exception $e) {
            // Handle the exception, log it, or display an error message
            Log::error('Error fetching calendar data: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while fetching calendar data. Please try again later.');
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
