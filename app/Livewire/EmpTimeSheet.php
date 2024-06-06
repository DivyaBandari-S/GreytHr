<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TimeSheet;
use Carbon\Carbon;

class EmpTimeSheet extends Component
{
    public $tab = "timeSheet";
    public $emp_id;
    public $start_date;
    public $end_date;
    public $date_and_day_with_tasks = [];
    public $auth_empId;
    public $timeSheet;

    public function updatedStartDate()
    {
        $this->fetchExistingData();
    }

    public function updatedEndDate()
    {
        $this->fetchExistingData();
    }

    public function fetchExistingData()
    {
        if ($this->auth_empId && $this->start_date && $this->end_date) {
            // Check if the time sheet belongs to the authenticated employee
            if ($this->timeSheet && $this->timeSheet->emp_id == $this->auth_empId) {
                // Filter tasks based on selected date range
                $this->date_and_day_with_tasks = array_filter($this->date_and_day_with_tasks, function ($task) {
                    return Carbon::parse($task['date'])->between($this->start_date, $this->end_date);
                });
                $this->getTotalDaysAndHours();
            } else {
                // Fetch the time sheet data from the database for the authenticated employee and selected date range
                $this->timeSheet = TimeSheet::where('emp_id', $this->auth_empId)
                    ->where(function ($query) {
                        $query->whereBetween('start_date', [$this->start_date, $this->end_date])
                            ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                            ->orWhere(function ($query) {
                                $query->where('start_date', '<=', $this->start_date)
                                    ->where('end_date', '>=', $this->end_date);
                            });
                    })
                    ->first();

                if ($this->timeSheet) {
                    $dateAndDayWithTasks = json_decode($this->timeSheet->date_and_day_with_tasks, true); // Decode the JSON string into an associative array
                    // Filter tasks based on selected date range
                    $this->date_and_day_with_tasks = array_filter($dateAndDayWithTasks, function ($task) {
                        return Carbon::parse($task['date'])->between($this->start_date, $this->end_date);
                    });
                } else {
                    // If no time sheet is found, reset the tasks array
                    $this->date_and_day_with_tasks = [];
                }
                $this->getTotalDaysAndHours();
            }
        }
    }


    public function addTask()
    {
        // Parse the start and end dates
        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);

        // Loop through each date between the start and end dates
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            // Check if the date is already in the array
            $exists = false;
            foreach ($this->date_and_day_with_tasks as $task) {
                if ($task['date'] === $date->toDateString()) {
                    $exists = true;
                    break;
                }
            }

            if (!$exists) {
                // Add a new task with the date and day
                $this->date_and_day_with_tasks[] = [
                    'date' => $date->toDateString(),
                    'day' => $date->format('l'), // Format day name (e.g., Monday)
                    'hours' => 0,
                    'tasks' => ''
                ];
            }
        }

        // Sort the array based on dates
        usort($this->date_and_day_with_tasks, function ($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });
        $this->getTotalDaysAndHours();
    }


    public function removeTask($index)
    {
        // Check if the index exists in the array
        if (isset($this->date_and_day_with_tasks[$index])) {
            // Remove the task at the given index
            unset($this->date_and_day_with_tasks[$index]);
            $this->getTotalDaysAndHours();
        }
        $this->getTotalDaysAndHours();
    }
    public function saveTimeSheet()
    {
        $this->getTotalDaysAndHours();
        $this->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'date_and_day_with_tasks' => 'required|array|min:1',
            'date_and_day_with_tasks.*.date' => 'required|date',
            'date_and_day_with_tasks.*.day' => 'required|string',
            'date_and_day_with_tasks.*.tasks' => 'required|string',
            'date_and_day_with_tasks.*.hours' => [
                'required',
                'numeric',
                'multiple_of:0.5',
                'min:0',
                'max:24.0',
            ]
        ]);
        // Check for overlapping records in the database
    }

    public function submit()
    {
        $this->addTask();
        $existingRecord = TimeSheet::where('emp_id', $this->auth_empId)
            ->where(function ($query) {
                $query->where('start_date', '<=', $this->end_date)
                    ->where('end_date', '>=', $this->start_date);
            })
            ->first();

        if ($existingRecord) {
            // Update the existing record
            $existingRecord->update([
                'date_and_day_with_tasks' => json_encode($this->date_and_day_with_tasks),
                'submission_status' => 'submitted',
            ]);

            // Set flash message for updating existing record
            session()->flash('message', 'Time sheet updated successfully!');
        } else {
            // Insert a new record into the time_sheets table
            TimeSheet::create([
                'emp_id' => $this->auth_empId,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'date_and_day_with_tasks' => json_encode($this->date_and_day_with_tasks),
                'submission_status' => 'submitted',
            ]);

            // Set flash message for adding new record
            session()->flash('message', 'New time sheet added successfully!');
        }

        // Redirect to the timesheet page after saving
        return redirect('/timesheet-page');
    }


    public $totalHours, $totalDays;
    public function getTotalDaysAndHours()
    {
        $totalHours = 0;
        $days = array();
        foreach ($this->date_and_day_with_tasks as $task) {
            // Add the hours from each task to the total
            $hours = floatval($task['hours']);
            $totalHours += $hours;
            $days[] = $task['day'];
        }

        // Set the total hours property
        $this->totalHours = $totalHours;
        $this->totalDays = count($days);
    }

    public $timesheets;
    public function render()
    {
        // Calculate total days and total working hours
        $this->auth_empId = auth()->guard('emp')->user()->emp_id;
        $this->timesheets = Timesheet::where('emp_id', $this->auth_empId)->orderBy('created_at', 'desc')->get();

        return view('livewire.emp-time-sheet');
    }
}
