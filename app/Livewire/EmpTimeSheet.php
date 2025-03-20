<?php

namespace App\Livewire;
use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Carbon\Carbon;
use App\Helpers\FlashMessageHelper;
use App\Models\TimeSheet;
use App\Models\Task;
use App\Models\AssignProjects;
use App\Models\ClientDetails;
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

    public $defaultTimesheetEntry = "";

    public $activeTab ='timeSheets';
    public function setActiveTab($tab)
    {
        if ($tab === 'timeSheets') {
            $this->activeTab = 'timeSheets';
        } elseif ($tab === 'history') {
            $this->activeTab = 'history';
        }
    }

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
        $this->employeeName = EmployeeDetails::where('emp_id', $this->auth_empId)->first();
        $this->timesheets = Timesheet::where('emp_id', $this->auth_empId)->orderBy('created_at', 'desc')->get();
        $this->start_date_string = now()->startOfWeek(\Carbon\Carbon::MONDAY)->format('Y-m-d');
        $this->defaultTimeSheetaddTask();
    }
    public $timeSheetSubmitted = false;

    public function addTask()
    {
        $this->defaultTimesheetEntry = "ts";
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
        $existingRecord = TimeSheet::where('emp_id', $this->auth_empId)
            ->where(function ($query) {
                $query->where('start_date', '<=', $this->start_date->format('Y-m-d'))
                    ->where('end_date', '>=', $this->end_date->format('Y-m-d'));
            })
            ->first();
        if ($existingRecord) {
            if ($existingRecord->submission_status == '13') {
                $this->timeSheetSubmitted = true;
                FlashMessageHelper::flashError('A time sheet already exists for the selected date range.');
            }
        } else {
            $this->timeSheetSubmitted = false;
        }
        $this->clients = AssignProjects::with('client')->whereRaw(
            'JSON_CONTAINS(emp_id, ?)', 
            [json_encode([['emp_id' => $this->auth_empId]])]
        )->get();
        $clientIds = $this->clients->pluck('client_id');
        $this->client_names = ClientDetails::whereIn('client_id', $clientIds)->pluck('client_name');

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
                $hoursArray = is_array($hours) ? $hours : [(string)$hours];
                $tasksArray = is_array($tasks) ? $tasks : [(string)$tasks];
            }
            $empId = auth()->guard('emp')->user()->emp_id;
            // Add day with its default or existing data to date_and_day_with_tasks
            $this->tasks = Task::with('client')
                ->where('assignee', 'LIKE', "%$empId%")
                ->whereNotNull('client_id')
                ->get();
               

            $taskData = [
                'date' => $date->toDateString(),
                'day' => $date->format('l'),
                'hours' => $hoursArray,
                'tasks' => $tasksArray,
                'clients' => $this->client_names->toArray(),
                'remarks' => array_fill(0, count($this->client_names), []),
                'projects' => array_fill(0, count($this->client_names), []),
                'maxHeights' => [] // Added to store maximum heights
            ];
            foreach ($this->tasks as $task) {
                $taskStartDate = Carbon::parse($task->created_at);
                $taskEndDate = Carbon::parse($task->due_date);
                $taskDateRange = $taskStartDate->toPeriod($taskEndDate);

                foreach ($taskDateRange as $taskDate) {
                    if ($taskDate->toDateString() === $date->toDateString()) {
                        $clientName = $task->client ? $task->client->client_name : 'No Client';
                        $index = array_search($clientName, $this->client_names->toArray());

                        if ($index !== false) {
                            $taskData['remarks'][$index][] = $task->task_name;
                            $taskData['projects'][$index][] = $task->project_name;
                        }
                    }
                }
            }
            

            // Calculate max heights for each client
            foreach ($taskData['clients'] as $clientIndex => $client) {
                $projectsHeight = isset($taskData['projects'][$clientIndex])
                    ? count($taskData['projects'][$clientIndex]) * 30 // 24px per project item
                    : 0;

                $remarksHeight = isset($taskData['remarks'][$clientIndex])
                    ? count($taskData['remarks'][$clientIndex]) * 30 // 24px per remark item
                    : 0;

                // Determine maximum height
                $taskData['maxHeights'][$clientIndex] = max($projectsHeight, $remarksHeight);
            }

            $this->date_and_day_with_tasks[] = $taskData;
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
    public function exportCSV()
    {
        // Determine the timesheet data based on the entry type
        if ($this->defaultTimesheetEntry === "") {
            $timeSheetData = $this->default_date_and_day_with_tasks;
        } elseif ($this->defaultTimesheetEntry === "ts") {
            $timeSheetData = $this->date_and_day_with_tasks;
        } else {
            return response()->json(['error' => 'Invalid timesheet entry'], 400);
        }

        // Initialize CSV columns
        $csvColumns = ["Date", "Day", "Hours", "Tasks"];

        // Determine if clients, projects, or remarks should be included
        $includeClients = !empty(array_column($timeSheetData, 'clients'));
        $includeProjects = !empty(array_filter(array_column($timeSheetData, 'projects')));
        $includeRemarks = !empty(array_filter(array_column($timeSheetData, 'remarks')));

        if ($includeClients) $csvColumns[] = "Client";
        if ($includeProjects) $csvColumns[] = "Projects";
        if ($includeRemarks) $csvColumns[] = "Remarks";

        // Create the CSV header row
        $csvData = implode(',', array_map('strval', $csvColumns)) . "\n";

        // Populate the CSV data rows
        foreach ($timeSheetData as $task) {
            $hours = is_array($task['hours']) ? implode(';', $task['hours']) : $task['hours'];
            $tasks = is_array($task['tasks']) ? implode(';', $task['tasks']) : $task['tasks'];

            $rowData = [
                $task['date'],
                $task['day'],
                $hours,
                $tasks
            ];

            if ($includeClients) {
                $clients = is_array($task['clients']) ? implode(';', $task['clients']) : $task['clients'];
                $rowData[] = $clients;
            }
            if ($includeProjects) {
                $projects = is_array($task['projects']) ? implode(';', array_map(fn($p) => is_array($p) ? implode(';', $p) : $p, $task['projects'])) : $task['projects'];
                $rowData[] = $projects;
            }
            if ($includeRemarks) {
                $remarks = is_array($task['remarks']) ? implode(';', array_map(fn($r) => is_array($r) ? implode(';', $r) : $r, $task['remarks'])) : $task['remarks'];
                $rowData[] = $remarks;
            }

            // Escape double quotes and commas for CSV
            $csvData .= '"' . implode('","', array_map(fn($field) => str_replace('"', '""', $field), $rowData)) . '"' . "\n";
        }

        // Create a temporary file for the CSV data
        $filename = 'timesheet.csv';
        $tempFile = tempnam(sys_get_temp_dir(), $filename);
        file_put_contents($tempFile, $csvData);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    public function exportExcel()
    {
        // Determine the timesheet data based on the entry type
        if ($this->defaultTimesheetEntry === "") {
            $timeSheetData = $this->default_date_and_day_with_tasks;
        } elseif ($this->defaultTimesheetEntry === "ts") {
            $timeSheetData = $this->date_and_day_with_tasks;
        } else {
            return response()->json(['error' => 'Invalid timesheet entry'], 400);
        }

        // Create a new Excel file
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Initialize columns
        $columns = ['A' => 'Date', 'B' => 'Day', 'C' => 'Hours', 'D' => 'Tasks'];
        $colIndex = 4;

        // Determine if clients, projects, or remarks should be included
        $includeClients = !empty(array_column($timeSheetData, 'clients'));
        $includeProjects = !empty(array_filter(array_column($timeSheetData, 'projects')));
        $includeRemarks = !empty(array_filter(array_column($timeSheetData, 'remarks')));

        if ($includeClients) $columns[chr(++$colIndex + 64)] = 'Client';
        if ($includeProjects) $columns[chr(++$colIndex + 64)] = 'Projects';
        if ($includeRemarks) $columns[chr(++$colIndex + 64)] = 'Remarks';

        // Set the header row
        foreach ($columns as $col => $header) {
            $sheet->setCellValue("{$col}1", $header);
        }

        // Fill the data rows
        $row = 2;
        foreach ($timeSheetData as $task) {
            $sheet->setCellValue("A{$row}", $task['date']);
            $sheet->setCellValue("B{$row}", $task['day']);
            $sheet->setCellValue("C{$row}", is_array($task['hours']) ? implode(';', $task['hours']) : $task['hours']);
            $sheet->setCellValue("D{$row}", is_array($task['tasks']) ? implode(';', $task['tasks']) : $task['tasks']);

            if ($includeClients) {
                $sheet->setCellValue(chr(65 + ($includeClients ? 4 : 0)) . $row, is_array($task['clients']) ? implode(';', $task['clients']) : $task['clients']);
            }
            if ($includeProjects) {
                $sheet->setCellValue(chr(65 + ($includeClients ? 5 : 4)) . $row, is_array($task['projects']) ? implode(';', array_map(fn($p) => is_array($p) ? implode(';', $p) : $p, $task['projects'])) : $task['projects']);
            }
            if ($includeRemarks) {
                $sheet->setCellValue(chr(65 + ($includeClients ? ($includeProjects ? 6 : 5) : ($includeProjects ? 5 : 4))) . $row, is_array($task['remarks']) ? implode(';', array_map(fn($r) => is_array($r) ? implode(';', $r) : $r, $task['remarks'])) : $task['remarks']);
            }

            $row++;
        }

        // Create a temporary file for the Excel data
        $filename = 'timesheet.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $filename);

        // Write the Excel file to the temporary file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($tempFile);

        // Return the Excel file as a download response
        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    public function updatedStartDateString($value)
    {
        // This function will be called when the date changes
        if ($this->defaultTimesheetEntry === "") {
            $this->defaultTimesheetEntry = "ts"; // Update to "ts" when a date is selected
            $this->start_date_string = $value; // Update the start date string
        }
    }

    public $tasks, $dTasks;
    public function defaultTimeSheetaddTask()
    {
        $this->default_start_date_string = now()->startOfWeek(Carbon::MONDAY)->toDateString();
        $this->default_start_date = Carbon::parse($this->default_start_date_string)->startOfDay();

        if ($this->default_start_date->isFuture()) {
            $this->default_start_date = now()->startOfDay();
        }

        if ($this->default_time_sheet_type === 'default') {
            $this->default_start_date->startOfWeek(Carbon::MONDAY);
            $this->default_end_date = $this->default_start_date->copy()->addDays(6);
        }

        if ($this->default_end_date->isFuture()) {
            $this->default_end_date = now()->endOfDay();
        }
        $this->auth_empId = auth()->guard('emp')->user()->emp_id;

        
        $this->auth_empId = auth()->guard('emp')->user()->emp_id;
        $this->clients = AssignProjects::with('client')->whereRaw(
            'JSON_CONTAINS(emp_id, ?)', 
            [json_encode([['emp_id' => $this->auth_empId]])]
        )->get();
        // $this->clients = AssignProjects::with('client')->where('emp_id', $this->auth_empId)->get();
        $clientIds = $this->clients->pluck('client_id');
        $this->client_names = ClientDetails::whereIn('client_id', $clientIds)->pluck('client_name');

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
        $empId = auth()->guard('emp')->user()->emp_id;

        $this->dTasks = Task::with('client')
            ->where('assignee', 'LIKE', "%$empId%")
            ->whereNotNull('client_id')
            ->get();


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
                 $hoursArray = is_array($hours) ? $hours : [(string)$hours];
                 $tasksArray = is_array($tasks) ? $tasks : [(string)$tasks];
            }
            $empId = auth()->guard('emp')->user()->emp_id;
            // Add day with its default or existing data to date_and_day_with_tasks

            $defaultTaskData = [
                'date' => $date->toDateString(),
                'day' => $date->format('l'),
                'hours' => $hoursArray,
                'tasks' => $tasksArray,
                'clients' => $this->client_names->toArray(),
                'remarks' => array_fill(0, count($this->client_names), []),
                'projects' => array_fill(0, count($this->client_names), []),
                'maxHeights' => [] // Added to store maximum heights
            ];

            foreach ($this->dTasks as $task) {
                $taskStartDate = Carbon::parse($task->created_at);
                $taskEndDate = Carbon::parse($task->due_date);
                $taskDateRange = $taskStartDate->toPeriod($taskEndDate);

                foreach ($taskDateRange as $taskDate) {
                    if ($taskDate->toDateString() === $date->toDateString()) {
                        $clientName = $task->client ? $task->client->client_name : 'No Client';
                        $index = array_search($clientName, $this->client_names->toArray());

                        if ($index !== false) {
                            $defaultTaskData['remarks'][$index][] = $task->task_name;
                            $defaultTaskData['projects'][$index][] = $task->project_name;
                        }
                    }
                }
            }

            // Calculate max heights for each client
            foreach ($defaultTaskData['clients'] as $clientIndex => $client) {
                $projectsHeight = isset($defaultTaskData['projects'][$clientIndex])
                    ? count($defaultTaskData['projects'][$clientIndex]) * 30 // 24px per project item
                    : 0;

                $remarksHeight = isset($defaultTaskData['remarks'][$clientIndex])
                    ? count($defaultTaskData['remarks'][$clientIndex]) * 30 // 24px per remark item
                    : 0;

                // Determine maximum height
                $defaultTaskData['maxHeights'][$clientIndex] = max($projectsHeight, $remarksHeight);
            }

            $this->default_date_and_day_with_tasks[] = $defaultTaskData;
        }

        usort($this->default_date_and_day_with_tasks, function ($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });

        $this->defaultGetTotalDaysAndHours();
        $this->auth_empId = auth()->guard('emp')->user()->emp_id;
    }

    // Method to update hours based on input changes
    public function saveTimeSheet()
    {
        $this->getTotalDaysAndHours();

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
                    'max:24',
                ];
            }
        } else {
            $baseRules['date_and_day_with_tasks.*.hours'] = [
                'required',
                'numeric',
                'multiple_of:0.5',
                'min:0',
                'max:24',
            ];
        }

        // Custom error messages
        $customMessages = [];
        if (count($this->client_names) > 0) {
            foreach ($this->client_names as $clientIndex => $clientName) {
                $customMessages['date_and_day_with_tasks.*.hours.' . $clientIndex . '.required'] = 'Hours is required';
                $customMessages['date_and_day_with_tasks.*.hours.' . $clientIndex . '.numeric'] = 'Hours must be a number';
                $customMessages['date_and_day_with_tasks.*.hours.' . $clientIndex . '.multiple_of'] = 'Hours must be a multiple of 0.5';
                $customMessages['date_and_day_with_tasks.*.hours.' . $clientIndex . '.min'] = 'Hours must be at least 0';
                $customMessages['date_and_day_with_tasks.*.hours.' . $clientIndex . '.max'] = 'Hours should not be greater than 24';
            }
        } else {
            $customMessages['date_and_day_with_tasks.*.hours.required'] = 'Hours is required';
            $customMessages['date_and_day_with_tasks.*.hours.numeric'] = 'Hours must be a number';
            $customMessages['date_and_day_with_tasks.*.hours.multiple_of'] = 'Hours must be a multiple of 0.5';
            $customMessages['date_and_day_with_tasks.*.hours.min'] = 'Hours must be at least 0';
            $customMessages['date_and_day_with_tasks.*.hours.max'] = 'Hours should not be greater than 24';
        }

        // Validate with custom error messages
        $this->validate($baseRules, $customMessages);

        $this->auth_empId = auth()->guard('emp')->user()->emp_id;

        $existingRecord = TimeSheet::where('emp_id', $this->auth_empId)
            ->where(function ($query) {
                $query->where('start_date', '<=', $this->end_date->format('Y-m-d'))
                    ->where('end_date', '>=', $this->start_date->format('Y-m-d'));
            })
            ->first();
        if ($existingRecord) {
            if ($existingRecord->submission_status == '13') {
                FlashMessageHelper::flashError('A time sheet already exists for the selected date range.');
            }
        }
        // Further logic for saving timesheet can go here, e.g., checking for overlapping records
    }

    public function defaultSaveTimeSheet()
    {
        $this->defaultGetTotalDaysAndHours();

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
                    'max:24',
                ];
            }
        } else {
            $baseRules['default_date_and_day_with_tasks.*.hours'] = [
                'required',
                'numeric',
                'multiple_of:0.5',
                'min:0',
                'max:24',
            ];
        }

        // Custom error messages
        $customMessages = [];
        if (count($this->client_names) > 0) {
            foreach ($this->client_names as $clientIndex => $clientName) {
                $customMessages['default_date_and_day_with_tasks.*.hours.' . $clientIndex . '.required'] = 'Hours is required';
                $customMessages['default_date_and_day_with_tasks.*.hours.' . $clientIndex . '.numeric'] = 'Hours must be a number';
                $customMessages['default_date_and_day_with_tasks.*.hours.' . $clientIndex . '.multiple_of'] = 'Hours must be a multiple of 0.5';
                $customMessages['default_date_and_day_with_tasks.*.hours.' . $clientIndex . '.min'] = 'Hours must be at least 0';
                $customMessages['default_date_and_day_with_tasks.*.hours.' . $clientIndex . '.max'] = 'Hours should not be greater than 24';
            }
        } else {
            $customMessages['default_date_and_day_with_tasks.*.hours.required'] = 'Hours is required';
            $customMessages['default_date_and_day_with_tasks.*.hours.numeric'] = 'Hours must be a number';
            $customMessages['default_date_and_day_with_tasks.*.hours.multiple_of'] = 'Hours must be a multiple of 0.5';
            $customMessages['default_date_and_day_with_tasks.*.hours.min'] = 'Hours must be at least 0';
            $customMessages['default_date_and_day_with_tasks.*.hours.max'] = 'Hours should not be greater than 24';
        }

        // Validate with custom error messages
        $this->validate($baseRules, $customMessages);
        $this->auth_empId = auth()->guard('emp')->user()->emp_id;
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

    public function submit()
    {
        // Validate the data
        $this->saveTimeSheet();
        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);
        $daysDifference = $endDate->diffInDays($startDate);

        if ($daysDifference < 4) {
            FlashMessageHelper::flashError('Time sheet filling is not yet complete, you cannot submit at this time.');
            return; // Prevent further processing
        }
        if (count($this->client_names) > 0) {
            $exceedsLimit = $this->checkSubtotalExceedsLimit();

            if ($exceedsLimit) {
                // If subtotal exceeds limit, do not proceed further
                return;
            }
        }
        // Check if the date range is exactly 7 days
        $existingRecord = TimeSheet::where('emp_id', $this->auth_empId)
            ->where(function ($query) {
                $query->where('start_date', '<=', $this->end_date->format('Y-m-d'))
                    ->where('end_date', '>=', $this->start_date->format('Y-m-d'));
            })
            ->first();



        if ($existingRecord) {
            if ($existingRecord->submission_status == '13') {
                FlashMessageHelper::flashError('A time sheet already exists for the selected date range.');
            } elseif ($existingRecord->submission_status == '12') {
                // Insert a new record into the time_sheets table
                $existingRecord->update([
                    'date_and_day_with_tasks' => json_encode($this->date_and_day_with_tasks),
                    'submission_status' => '13',
                    'approval_status_for_manager' => '5',
                ]);
                $this->defaultTimesheetEntry = "";
                $this->default_time_sheet_type = "default";
                FlashMessageHelper::flashSuccess('Timesheet status has been updated to "Submitted".');
            }
        } else {
            TimeSheet::create([
                'emp_id' => $this->auth_empId,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'time_sheet_type' => "weekly",
                'date_and_day_with_tasks' => json_encode($this->date_and_day_with_tasks),
                'submission_status' => '13',
            ]);
            $this->defaultTimesheetEntry = "true";
            $this->default_time_sheet_type = "default";

            // Set flash message for adding new record
            FlashMessageHelper::flashSuccess('New time sheet added successfully!');
        }
        return redirect('/time-sheet');
        // Redirect to the timesheet page after saving
    }
    public function save()
    {
        // Validate the data
        $this->saveTimeSheet();
        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);
        $daysDifference = $endDate->diffInDays($startDate);


        if (count($this->client_names) > 0) {
            $exceedsLimit = $this->checkSubtotalExceedsLimit();

            if ($exceedsLimit) {
                // If subtotal exceeds limit, do not proceed further
                return;
            }
        }
        // Check if the date range is exactly 7 days

        // Check for overlapping records in the database
        $existingRecord = TimeSheet::where('emp_id', $this->auth_empId)
            ->where(function ($query) {
                $query->where('start_date', '<=', $this->end_date->format('Y-m-d'))
                    ->where('end_date', '>=', $this->start_date->format('Y-m-d'));
            })
            ->first();



        if ($existingRecord) {
            if ($existingRecord->submission_status == '13') {
                FlashMessageHelper::flashError('A time sheet already exists for the selected date range.');
            } elseif ($existingRecord->submission_status == '12') {
                $existingRecord->update([
                    'date_and_day_with_tasks' => json_encode($this->date_and_day_with_tasks),
                ]);
                $this->defaultTimesheetEntry = "true";
                $this->default_time_sheet_type = "default";

                // Set flash message for adding new record
                FlashMessageHelper::flashSuccess('Time sheet updated successfully!');
            }
        } else {
            TimeSheet::create([
                'emp_id' => $this->auth_empId,
                'start_date' => $this->start_date->format('Y-m-d'),
                'end_date' => $this->end_date->format('Y-m-d'),
                'time_sheet_type' => $this->time_sheet_type,
                'date_and_day_with_tasks' => json_encode($this->date_and_day_with_tasks),
                'submission_status' => '12',
            ]);
            $this->defaultTimesheetEntry = "true";
            $this->default_time_sheet_type = "default";

            // Set flash message for adding new record
            FlashMessageHelper::flashSuccess('Time sheet saved successfully!');
        }
        return redirect('/time-sheet');
    }

    public function defaultSubmit()
    {
        // Validate the data
        $this->defaultSaveTimeSheet();
        $startDate = Carbon::parse($this->default_start_date);
        $endDate = Carbon::parse($this->default_end_date);
        $daysDifference = $endDate->diffInDays($startDate);

        if ($daysDifference < 4) {
            FlashMessageHelper::flashError('Time sheet filling is not yet complete, you cannot submit at this time.');

            return; // Prevent further processing
        }

        if (count($this->client_names) > 0) {
            $exceedsLimit = $this->defaultCheckSubtotalExceedsLimit();

            if ($exceedsLimit) {
                // If subtotal exceeds limit, do not proceed further
                return;
            }
        }

        $startDate = Carbon::parse($this->default_start_date);
        $endDate = Carbon::parse($this->default_end_date);
        $daysDifference = $endDate->diffInDays($startDate);



        // Check for overlapping records in the database
        $existingRecord = TimeSheet::where('emp_id', $this->auth_empId)
            ->where(function ($query) {
                $query->where('start_date', '<=', $this->default_end_date->format('Y-m-d'))
                    ->where('end_date', '>=', $this->default_start_date->format('Y-m-d'));
            })
            ->first();


        if ($existingRecord) {

            if ($existingRecord->submission_status == '13') {
                FlashMessageHelper::flashError('A time sheet already exists for the selected date range.');
            } elseif ($existingRecord->submission_status == '12') {
                $updateExistingRecord = TimeSheet::where('start_date', $existingRecord->start_date)->first();
                $updateExistingRecord->update([
                    'date_and_day_with_tasks' => json_encode($this->default_date_and_day_with_tasks),
                    "submission_status" => '13',
                    'approval_status_for_manager' => '5',
                ]);
                FlashMessageHelper::flashSuccess('Time sheet status has been updated to "Submitted".');
            }
        } else {
            TimeSheet::create([
                'emp_id' => $this->auth_empId,
                'start_date' => $this->default_start_date->format('Y-m-d'),
                'end_date' => $this->default_end_date->format('Y-m-d'),
                'time_sheet_type' => "weekly",
                'date_and_day_with_tasks' => json_encode($this->default_date_and_day_with_tasks),
                'submission_status' => '13',
            ]);

            // Set flash message for adding new record
            FlashMessageHelper::flashSuccess('New time sheet added successfully!');
        }
        return redirect('/time-sheet');


        // Redirect to the timesheet page after saving
    }



    public function defaultSave()
    {
        // Validate the data
        $this->defaultSaveTimeSheet();
        $startDate = Carbon::parse($this->default_start_date);
        $endDate = Carbon::parse($this->default_end_date);
        $daysDifference = $endDate->diffInDays($startDate);


        if (count($this->client_names) > 0) {
            $exceedsLimit = $this->defaultCheckSubtotalExceedsLimit();

            if ($exceedsLimit) {
                // If subtotal exceeds limit, do not proceed further
                return;
            }
        }

        $startDate = Carbon::parse($this->default_start_date);
        $endDate = Carbon::parse($this->default_end_date);
        $daysDifference = $endDate->diffInDays($startDate);

        $existingRecord = TimeSheet::where('emp_id', $this->auth_empId)
            ->where(function ($query) {
                $query->where('start_date', '<=', $this->default_end_date->format('Y-m-d'))
                    ->where('end_date', '>=', $this->default_start_date->format('Y-m-d'));
            })
            ->first();

        if ($existingRecord) {
            if ($existingRecord->submission_status == '13') {
                FlashMessageHelper::flashError('A time sheet already exists for the selected date range.');
            } elseif ($existingRecord->submission_status == '12') {
                $existingRecord->update([
                    'date_and_day_with_tasks' => json_encode($this->default_date_and_day_with_tasks),
                ]);
                $this->defaultTimesheetEntry = "true";
                $this->default_time_sheet_type = "default";

                // Set flash message for adding new record
                FlashMessageHelper::flashSuccess('Time sheet updated successfully!');
            }
        } else {
            TimeSheet::create([
                'emp_id' => $this->auth_empId,
                'start_date' => $this->default_start_date->format('Y-m-d'),
                'end_date' => $this->default_end_date->format('Y-m-d'),
                'time_sheet_type' => $this->time_sheet_type,
                'date_and_day_with_tasks' => json_encode($this->default_date_and_day_with_tasks),
                'submission_status' => '12',
            ]);
            $this->defaultTimesheetEntry = "true";
            $this->default_time_sheet_type = "default";

            // Set flash message for adding new record
            FlashMessageHelper::flashSuccess('Time sheet saved successfully!');
        }
        // Redirect to the timesheet page after saving
        return redirect('/time-sheet');
    }
    public $timesheetEntry = false;
    public $initialTeamTimeSheets,$teamTimeSheets,$filteredTeamTimeSheets,$submission_status,$manager_approval,$hr_approval;
    public function teamTimeSheetsFilter()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;


        // Fetch all relevant timesheets first
        $this->filteredTeamTimeSheets = TimeSheet::with('employee', 'approvalStatusForManager')
            ->orderBy('start_date', 'desc')
            ->where('emp_id', $employeeId)
            ->whereRaw('DATEDIFF(end_date, start_date) >= 4')
            ->where(function ($query) {
                $query->where('approval_status_for_manager', '5')
                    ->orWhere('approval_status_for_manager', '2')
                    ->orWhere('approval_status_for_manager', '3')
                    ->orWhere('approval_status_for_manager', '14');
            })
            ->when($this->start_date, function ($query) {
                $query->where('start_date', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
                $query->where('end_date', '<=', $this->end_date);
            })
            ->when($this->time_sheet_type, function ($query) {
                $query->where('time_sheet_type', $this->time_sheet_type);
            })
            ->when($this->submission_status, function ($query) {
                $query->where('submission_status', $this->submission_status);
            })
            ->when($this->manager_approval, function ($query) {
                $query->where('approval_status_for_manager', $this->manager_approval);
            })
            ->when($this->hr_approval, function ($query) {
                $query->where('approval_status_for_hr', $this->hr_approval);
            })
            ->get();
    }
    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;

        // Initial timesheets
        $this->initialTeamTimeSheets = TimeSheet::with('employee', 'approvalStatusForManager')
            ->orderBy('start_date', 'desc')
            ->where('emp_id', $employeeId)
            ->whereRaw('DATEDIFF(end_date, start_date) >= 4')
            ->get();
        $this->teamTimeSheets = $this->filteredTeamTimeSheets ?? $this->initialTeamTimeSheets;
        return view('livewire.emp-time-sheet');
    }
    
    public $openAccordionIndex = null; // Store the currently open accordion index

   
    public function toggleAccordion($index)
    {
        if ($this->openAccordionIndex === $index) {
            $this->openAccordionIndex = null; // Close the currently open item if clicked again
        } else {
            $this->openAccordionIndex = $index; // Open the new item
        }
    }
}
