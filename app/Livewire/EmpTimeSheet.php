<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\TimeSheet;
use App\Models\ClientsEmployee;
use App\Models\Client;
use App\Models\EmployeeDetails;

class EmpTimeSheet extends Component
{
    public $date_and_day_with_tasks = [];
    public $time_sheet_type = "weekly";
    public $start_date_string = "";
    public $start_date;
    public $end_date;
    public $auth_empId;
    public $clients;
    public $client_names = [];
    public $previous_time_sheet_type;

    public $timeSheet, $timesheets, $employeeName;
    public $tab = "timeSheet";

    public $defaultTimesheetEntry = "true";

    public $allTotalHours, $totalDays, $allDefaultTotalHours, $defaultTotalDays;


    public function getTotalDaysAndHours()
    {
        $totalHours = 0;
        $days = [];

        foreach ($this->date_and_day_with_tasks as $task) {
            if (is_array($task['hours'])) {
                // Scenario 1: If hours are stored as an array
                foreach ($task['hours'] as $hour) {
                    $hours = floatval($hour);
                    $totalHours += $hours;
                }
            } else {
                // Scenario 2: If hours are a single value
                $hours = floatval($task['hours']);
                $totalHours += $hours;
            }

            $days[] = $task['day'];
        }

        // Set the total hours property
        $this->allTotalHours = $totalHours;
        $this->totalDays = count($days);
    }

    public function defaultGetTotalDaysAndHours()
    {
        $totalHours = 0;
        $days = [];

        foreach ($this->default_date_and_day_with_tasks as $task) {
            if (is_array($task['hours'])) {
                // Scenario 1: If hours are stored as an array
                foreach ($task['hours'] as $hour) {
                    $hours = floatval($hour);
                    $totalHours += $hours;
                }
            } else {
                // Scenario 2: If hours are a single value
                $hours = floatval($task['hours']);
                $totalHours += $hours;
            }

            $days[] = $task['day'];
        }

        // Set the total hours property
        $this->allDefaultTotalHours = $totalHours;
        $this->defaultTotalDays = count($days);
    }
    public function mount()
    {
        $this->auth_empId = auth()->guard('emp')->user()->emp_id;
        $this->employeeName = EmployeeDetails::where('emp_id', $this->auth_empId )->first();
        $this->timesheets = Timesheet::where('emp_id', $this->auth_empId)->orderBy('created_at', 'desc')->get();
        $this->defaultTimeSheetaddTask();
    }

    public function addTask()
    {
        $this->defaultTimesheetEntry = "false";
        $this->default_time_sheet_type = "";
        $this->date_and_day_with_tasks = [];
        // Parse start date and validate
        $this->start_date = Carbon::parse($this->start_date_string)->startOfDay();

        $this->validate([
            'time_sheet_type' => 'required|in:weekly,semi-monthly,monthly',
            'start_date' => 'required',
        ]);

        // Adjust start date if it's in the future
        if ($this->start_date->isFuture()) {
            $this->start_date = now()->startOfDay();
        }

        // Determine end date based on time sheet type
        if ($this->time_sheet_type === 'weekly') {
            $this->start_date->startOfWeek(Carbon::MONDAY);
            $this->end_date = $this->start_date->copy()->addDays(6);
        } elseif ($this->time_sheet_type === 'semi-monthly') {
            $midMonthDay = ceil($this->start_date->daysInMonth / 2);
            if ($this->start_date->day <= $midMonthDay) {
                $this->start_date->startOfMonth();
                $this->end_date = $this->start_date->copy()->addDays($midMonthDay - 1)->endOfDay();
            } else {
                $this->start_date->startOfMonth()->addDays($midMonthDay);
                $this->end_date = $this->start_date->copy()->endOfMonth();
            }
        } elseif ($this->time_sheet_type === 'monthly') {
            $this->start_date->startOfMonth();
            $this->end_date = $this->start_date->copy()->endOfMonth();
        }
        // Ensure end date is not in the future
        if ($this->end_date->isFuture()) {
            $this->end_date = now()->endOfDay();
        }

        // Retrieve client names for the authenticated employee
        $this->auth_empId = auth()->guard('emp')->user()->emp_id;
        $this->clients = ClientsEmployee::with('client')->where('emp_id', $this->auth_empId)->get();
        $clientIds = $this->clients->pluck('client_id');
        $this->client_names = Client::whereIn('client_id', $clientIds)->pluck('client_name');

        // Fetch existing time sheet data from the database if needed
        $this->timeSheet = TimeSheet::where('emp_id', $this->auth_empId)
            ->where(function ($query) {
                $query->whereBetween('start_date', [
                    $this->start_date->format('Y-m-d'),
                    $this->end_date->format('Y-m-d')
                ])
                    ->orWhereBetween('end_date', [
                        $this->start_date->format('Y-m-d'),
                        $this->end_date->format('Y-m-d')
                    ])
                    ->orWhere(function ($query) {
                        $query->where('start_date', '<=', $this->start_date->format('Y-m-d'))
                            ->where('end_date', '>=', $this->end_date->format('Y-m-d'));
                    });
            })
            ->first();

        // Initialize days based on the selected time_sheet_type
        for ($date = $this->start_date->copy(); $date->lte($this->end_date); $date->addDay()) {
            // Set default hours based on the day of the week
            $defaultHours = $date->isWeekend() ? 0 : 9;

            // Initialize hours and tasks
            $hours = $defaultHours;
            $tasks = '';

            if ($this->timeSheet && $this->timeSheet->date_and_day_with_tasks) {
                $existingTasks = json_decode($this->timeSheet->date_and_day_with_tasks, true);

                // Check if there is existing data for the current date
                foreach ($existingTasks as $task) {
                    if ($task['date'] === $date->toDateString()) {
                        // Populate hours and tasks from existing data
                        $hours = isset($task['hours']) ? $task['hours'] : $hours;
                        $tasks = isset($task['tasks']) ? $task['tasks'] : $tasks;
                        break;
                    }
                }
            }

            // Handle the case where there are no clients
            if (count($this->client_names) > 0) {
                // Convert hours and tasks to arrays for clients
                $hoursArray = is_array($hours) ? $hours : array_fill(0, count($this->client_names), $hours);
                $tasksArray = is_array($tasks) ? $tasks : array_fill(0, count($this->client_names), $tasks);
            } else {
                // Set hours and tasks as strings
                // Set hours and tasks as strings
                $hoursArray = (string)$hours;
                $tasksArray = (string)$tasks;
            }

            // Add day with its default or existing data to date_and_day_with_tasks
            $this->date_and_day_with_tasks[] = [
                'date' => $date->toDateString(),
                'day' => $date->format('l'), // Format day name (e.g., Monday)
                'hours' => $hoursArray,
                'tasks' => $tasksArray,
                'clients' => $this->client_names->toArray(), // Convert collection to array if needed
            ];
        }

        // Sort the array based on dates if necessary
        usort($this->date_and_day_with_tasks, function ($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });

        // Calculate total hours and other necessary calculations
        $this->getTotalDaysAndHours();
    }

    public $default_date_and_day_with_tasks = [];
    public $default_start_date, $default_end_date, $defaultTimeSheet;
    public $default_start_date_string = "";
    public $default_time_sheet_type = "default";

    public function defaultTimeSheetaddTask()
    {
        $this->default_date_and_day_with_tasks = [];
        $this->default_start_date_string = now()->startOfWeek(Carbon::MONDAY)->toDateString();
        // Parse start date and validate
        $this->default_start_date = Carbon::parse($this->default_start_date_string)->startOfDay();

        // Adjust start date if it's in the future
        if ($this->default_start_date->isFuture()) {
            $this->default_start_date = now()->startOfDay();
        }

        // Determine end date based on time sheet type
        if ($this->default_time_sheet_type === 'default') {
            $this->default_start_date->startOfWeek(Carbon::MONDAY);
            $this->default_end_date = $this->default_start_date->copy()->addDays(6);
        }
        // Ensure end date is not in the future
        if ($this->default_end_date->isFuture()) {
            $this->default_end_date = now()->endOfDay();
        }

        // Retrieve client names for the authenticated employee
        $this->auth_empId = auth()->guard('emp')->user()->emp_id;
        $this->clients = ClientsEmployee::with('client')->where('emp_id', $this->auth_empId)->get();
        $clientIds = $this->clients->pluck('client_id');
        $this->client_names = Client::whereIn('client_id', $clientIds)->pluck('client_name');

        // Fetch existing time sheet data from the database if needed
        $this->defaultTimeSheet = TimeSheet::where('emp_id', $this->auth_empId)
            ->where(function ($query) {
                $query->whereBetween('start_date', [
                    $this->default_start_date->format('Y-m-d'),
                    $this->default_end_date->format('Y-m-d')
                ])
                    ->orWhereBetween('end_date', [
                        $this->default_start_date->format('Y-m-d'),
                        $this->default_end_date->format('Y-m-d')
                    ])
                    ->orWhere(function ($query) {
                        $query->where('start_date', '<=', $this->default_start_date->format('Y-m-d'))
                            ->where('end_date', '>=', $this->default_end_date->format('Y-m-d'));
                    });
            })
            ->first();

        // Initialize days based on the selected time_sheet_type
        for ($date = $this->default_start_date->copy(); $date->lte($this->default_end_date); $date->addDay()) {
            // Set default hours based on the day of the week
            $defaultHours = $date->isWeekend() ? 0 : 9;

            // Initialize hours and tasks
            $hours = $defaultHours;
            $tasks = '';

            if ($this->defaultTimeSheet && $this->defaultTimeSheet->date_and_day_with_tasks) {
                $existingTasks = json_decode($this->defaultTimeSheet->date_and_day_with_tasks, true);

                // Check if there is existing data for the current date
                foreach ($existingTasks as $task) {
                    if ($task['date'] === $date->toDateString()) {
                        // Populate hours and tasks from existing data
                        $hours = isset($task['hours']) ? $task['hours'] : $hours;
                        $tasks = isset($task['tasks']) ? $task['tasks'] : $tasks;
                        break;
                    }
                }
            }

            // Handle the case where there are no clients
            if (count($this->client_names) > 0) {
                // Convert hours and tasks to arrays for clients
                $hoursArray = is_array($hours) ? $hours : array_fill(0, count($this->client_names), $hours);
                $tasksArray = is_array($tasks) ? $tasks : array_fill(0, count($this->client_names), $tasks);
            } else {
                // Set hours and tasks as strings
                // Set hours and tasks as strings
                $hoursArray = (string)$hours;
                $tasksArray = (string)$tasks;
            }

            // Add day with its default or existing data to date_and_day_with_tasks
            $this->default_date_and_day_with_tasks[] = [
                'date' => $date->toDateString(),
                'day' => $date->format('l'), // Format day name (e.g., Monday)
                'hours' => $hoursArray,
                'tasks' => $tasksArray,
                'clients' => $this->client_names->toArray(), // Convert collection to array if needed
            ];
        }

        // Sort the array based on dates if necessary
        usort($this->default_date_and_day_with_tasks, function ($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });

        // Calculate total hours and other necessary calculations
        $this->defaultGetTotalDaysAndHours();
    }
    // Method to update hours based on input changes

    public function saveTimeSheet()
    {
        $this->getTotalDaysAndHours();

        // Validate subtotal hours first
        // Base validation rules
        $baseRules = [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'time_sheet_type' => 'required',
            'date_and_day_with_tasks' => 'required|array|min:1',
            'date_and_day_with_tasks.*.date' => 'required|date',
            'date_and_day_with_tasks.*.day' => 'required|string',
        ];

        // Validate hours for each client if client names are present
        if (count($this->client_names) > 0) {
            foreach ($this->client_names as $clientIndex => $clientName) {
                $baseRules['date_and_day_with_tasks.*.hours.' . $clientIndex] = [
                    'required',
                    'numeric',
                    'multiple_of:0.5',
                    'min:0',
                    'max:24.0',
                ];
            }
        } else {
            $baseRules['date_and_day_with_tasks.*.hours'] = [
                'required',
                'numeric',
                'multiple_of:0.5',
                'min:0',
                'max:24.0',
            ];
        }

        // Custom error messages
        $customMessages = [];
        if (count($this->client_names) > 0) {
            foreach ($this->client_names as $clientIndex => $clientName) {
                $customMessages['date_and_day_with_tasks.*.hours.' . $clientIndex . '.required'] = 'The hour field is required.';
                $customMessages['date_and_day_with_tasks.*.hours.' . $clientIndex . '.numeric'] = 'The hour field must be a number.';
                $customMessages['date_and_day_with_tasks.*.hours.' . $clientIndex . '.multiple_of'] = 'The hour field must be a multiple of 0.5.';
                $customMessages['date_and_day_with_tasks.*.hours.' . $clientIndex . '.min'] = 'The hour field must be at least 0.';
                $customMessages['date_and_day_with_tasks.*.hours.' . $clientIndex . '.max'] = 'The hour field may not be greater than 24.0.';
            }
        } else {
            $customMessages['date_and_day_with_tasks.*.hours.required'] = 'The hour field is required.';
            $customMessages['date_and_day_with_tasks.*.hours.numeric'] = 'The hour field must be a number.';
            $customMessages['date_and_day_with_tasks.*.hours.multiple_of'] = 'The hour field must be a multiple of 0.5.';
            $customMessages['date_and_day_with_tasks.*.hours.min'] = 'The hour field must be at least 0.';
            $customMessages['date_and_day_with_tasks.*.hours.max'] = 'The hour field may not be greater than 24.0.';
        }

        // Validate with custom error messages
        $this->validate($baseRules, $customMessages);

        // Further logic for saving timesheet can go here, e.g., checking for overlapping records
    }


    public function defaultSaveTimeSheet()
    {
        $this->defaultGetTotalDaysAndHours();

        // Validate subtotal hours first
        // Base validation rules
        $baseRules = [
            'default_start_date' => 'required|date',
            'default_end_date' => 'required|date',
            'default_time_sheet_type' => 'required',
            'default_date_and_day_with_tasks' => 'required|array|min:1',
            'default_date_and_day_with_tasks.*.date' => 'required|date',
            'default_date_and_day_with_tasks.*.day' => 'required|string',
        ];

        // Validate hours for each client if client names are present
        if (count($this->client_names) > 0) {
            foreach ($this->client_names as $clientIndex => $clientName) {
                $baseRules['default_date_and_day_with_tasks.*.hours.' . $clientIndex] = [
                    'required',
                    'numeric',
                    'multiple_of:0.5',
                    'min:0',
                    'max:24.0',
                ];
            }
        } else {
            $baseRules['default_date_and_day_with_tasks.*.hours'] = [
                'required',
                'numeric',
                'multiple_of:0.5',
                'min:0',
                'max:24.0',
            ];
        }

        // Custom error messages
        $customMessages = [];
        if (count($this->client_names) > 0) {
            foreach ($this->client_names as $clientIndex => $clientName) {
                $customMessages['default_date_and_day_with_tasksdate_and_day_with_tasks.*.hours.' . $clientIndex . '.required'] = 'The hour field is required.';
                $customMessages['default_date_and_day_with_tasksdate_and_day_with_tasks.*.hours.' . $clientIndex . '.numeric'] = 'The hour field must be a number.';
                $customMessages['default_date_and_day_with_tasksdate_and_day_with_tasks.*.hours.' . $clientIndex . '.multiple_of'] = 'The hour field must be a multiple of 0.5.';
                $customMessages['default_date_and_day_with_tasksdate_and_day_with_tasks.*.hours.' . $clientIndex . '.min'] = 'The hour field must be at least 0.';
                $customMessages['default_date_and_day_with_tasksdate_and_day_with_tasks.*.hours.' . $clientIndex . '.max'] = 'The hour field may not be greater than 24.0.';
            }
        } else {
            $customMessages['default_date_and_day_with_tasksdate_and_day_with_tasks.*.hours.required'] = 'The hour field is required.';
            $customMessages['default_date_and_day_with_tasksdate_and_day_with_tasks.*.hours.numeric'] = 'The hour field must be a number.';
            $customMessages['default_date_and_day_with_tasksdate_and_day_with_tasks.*.hours.multiple_of'] = 'The hour field must be a multiple of 0.5.';
            $customMessages['default_date_and_day_with_tasksdate_and_day_with_tasks.*.hours.min'] = 'The hour field must be at least 0.';
            $customMessages['default_date_and_day_with_tasksdate_and_day_with_tasks.*.hours.max'] = 'The hour field may not be greater than 24.0.';
        }

        // Validate with custom error messages
        $this->validate($baseRules, $customMessages);

        // Further logic for saving timesheet can go here, e.g., checking for overlapping records
    }

    public function checkSubtotalExceedsLimit()
    {
        $exceedsLimit = false;

        // Calculate subtotal hours
        foreach ($this->date_and_day_with_tasks as $task) {
            $totalHours = array_sum($task['hours']);
            if ($totalHours > 24) {
                $exceedsLimit = true;
                break; // No need to check further if limit exceeded
            }
        }

        return $exceedsLimit;
    }

    public function defaultCheckSubtotalExceedsLimit()
    {
        $exceedsLimit = false;

        // Calculate subtotal hours
        foreach ($this->default_date_and_day_with_tasks as $task) {
            $totalHours = array_sum($task['hours']);
            if ($totalHours > 24) {
                $exceedsLimit = true;
                break; // No need to check further if limit exceeded
            }
        }

        return $exceedsLimit;
    }

    // Example method to handle form submission
    public function submit()
    {
        // Validate the data
        $this->saveTimeSheet();
        if (count($this->client_names) > 0) {
            $exceedsLimit = $this->checkSubtotalExceedsLimit();

            if ($exceedsLimit) {
                // If subtotal exceeds limit, do not proceed further
                return;
            }
        }

        // Check for overlapping records in the database
        $existingRecord = TimeSheet::where('emp_id', $this->auth_empId)
            ->where(function ($query) {
                $query->where('start_date', '<=', $this->end_date)
                    ->where('end_date', '>=', $this->start_date);
            })
            ->first();



        if ($existingRecord) {
            // Update the existing record
            $existingRecord->update([
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'time_sheet_type' => $this->time_sheet_type,
                'date_and_day_with_tasks' => json_encode($this->date_and_day_with_tasks),
                'submission_status' => 'submitted',
            ]);
            $this->defaultTimeSheet = "true";
            $this->default_time_sheet_type = "default";
            // Set flash message for updating existing record
            session()->flash('message', 'Time sheet updated successfully!');
        } else {
            // Insert a new record into the time_sheets table
            TimeSheet::create([
                'emp_id' => $this->auth_empId,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'time_sheet_type' => $this->time_sheet_type,
                'date_and_day_with_tasks' => json_encode($this->date_and_day_with_tasks),
                'submission_status' => 'submitted',
            ]);
            $this->defaultTimeSheet = "true";
            $this->default_time_sheet_type = "default";

            // Set flash message for adding new record
            session()->flash('message', 'New time sheet added successfully!');
        }

        // Redirect to the timesheet page after saving
        return redirect('/timesheet-page');
    }

    public function defaultSubmit()
    {
        // Validate the data
        $this->defaultSaveTimeSheet();
        if (count($this->client_names) > 0) {
            $exceedsLimit = $this->defaultCheckSubtotalExceedsLimit();

            if ($exceedsLimit) {
                // If subtotal exceeds limit, do not proceed further
                return;
            }
        }

        // Check for overlapping records in the database
        $existingRecord = TimeSheet::where('emp_id', $this->auth_empId)
            ->where(function ($query) {
                $query->where('start_date', '<=', $this->end_date)
                    ->where('end_date', '>=', $this->start_date);
            })
            ->first();



        if ($existingRecord) {
            // Update the existing record
            $existingRecord->update([
                'start_date' => $this->default_start_date,
                'end_date' => $this->default_end_date,
                'time_sheet_type' => $this->default_time_sheet_type,
                'date_and_day_with_tasks' => json_encode($this->default_date_and_day_with_tasks),
                'submission_status' => 'submitted',
            ]);

            // Set flash message for updating existing record
            session()->flash('message', 'Time sheet updated successfully!');
        } else {
            // Insert a new record into the time_sheets table
            TimeSheet::create([
                'emp_id' => $this->auth_empId,
                'start_date' => $this->default_start_date,
                'end_date' => $this->default_end_date,
                'time_sheet_type' => $this->default_time_sheet_type,
                'date_and_day_with_tasks' => json_encode($this->default_date_and_day_with_tasks),
                'submission_status' => 'submitted',
            ]);

            // Set flash message for adding new record
            session()->flash('message', 'New time sheet added successfully!');
        }

        // Redirect to the timesheet page after saving
        return redirect('/timesheet-page');
    }

    public function render()
    {
        return view('livewire.emp-time-sheet');
    }
}
