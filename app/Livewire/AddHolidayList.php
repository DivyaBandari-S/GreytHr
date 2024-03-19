<?php

namespace App\Livewire;

use App\Models\HolidayCalendar;
use Livewire\Component;
use Illuminate\Validation\Rule;

class AddHolidayList extends Component
{
    public $day;
    public $date;
    public $month;
    public $year;
    public $festivals;

    protected $rules = [
        'day' => 'required|string',
        'date' => 'required|date',
        'month' => 'required|string',
        'year' => 'required|string',
        'festivals' => 'required|string',
    ];

    // Save holiday to the database
    public function saveHoliday()
    {
        $this->validate();

        HolidayCalendar::create([
            'day' => $this->day,
            'date' => $this->date,
            'month' => (int) $this->month, // Cast to integer if necessary
            'year' => (int) $this->year,
            'festivals' => $this->festivals,
        ]);

        // Clear form fields after saving
        $this->reset(['day', 'date', 'month', 'year', 'festivals']);
    }

    public function render()
    {
        return view('livewire.add-holiday-list');
    }
}
