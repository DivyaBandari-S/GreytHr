<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Task;
use App\Mail\TaskReminderMail;
use Carbon\Carbon;
use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Log;

class SendTaskReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-task-reminder';

    protected $description = 'Send a reminder email for tasks due today';

    /**
     * Execute the console command.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now(); // Current time
        $today = Carbon::today(); // Today's date (no time part)

        // Case 1: Tasks that are due today
        $tasksDueToday = Task::whereDate('due_date', $today) // Check for today's due tasks
            ->where('status', '!=', 11) // Ensure task is not completed
            ->where('reminder_sent', false)
            ->get();
        foreach ($tasksDueToday as $task) {

            // Check if created_at and due_date are on the same day
            $taskCreatedDate = Carbon::parse($task->created_at)->format('Y-m-d');
            $taskDueDate = Carbon::parse($task->due_date)->format('Y-m-d');

            // Case 1a: If created_at and due_date are the same, send reminder 3 hours after creation
            if ($taskCreatedDate == $taskDueDate) {
                $taskCreatedTime = Carbon::parse($task->created_at);
                $sendReminderTime = $taskCreatedTime->addHours(3);

                if ($now->gte($sendReminderTime)) {
                    preg_match('/\#\((.*?)\)/', $task->assignee, $matches);

                    if (isset($matches[1])) {
                        $empId = $matches[1];
                        $assignee = EmployeeDetails::where('emp_id', $empId)->first();

                        if ($assignee && $assignee->email) {
                            try {
                                Mail::to($assignee->email)->send(new TaskReminderMail($task));
                                $this->info('Reminder sent to ' . $assignee->email . ' for task: ' . $task->task_name);
                                $task->reminder_sent = true;
                                $task->save();
                            } catch (\Exception $e) {
                                $this->error('Failed to send reminder: ' . $e->getMessage());
                            }
                        }
                    }
                } else {
                }
            }

            // Case 1b: If created_at and due_date are not the same, send reminder at assignee's shift start time
            if ($taskCreatedDate != $taskDueDate) {
                preg_match('/\#\((.*?)\)/', $task->assignee, $matches);

                if (isset($matches[1])) {
                    $empId = $matches[1];
                    // $assignee = EmployeeDetails::where('emp_id', $empId)->first();
                    $assignee = EmployeeDetails::where('emp_id', $empId)
                        ->join('company_shifts', 'company_shifts.shift_name', '=', 'employee_details.shift_type')
                        ->select('employee_details.*', 'company_shifts.shift_start_time') // Select the relevant columns
                        ->first();

                    if ($assignee && $assignee->email) {
                        $shiftStartTime = Carbon::parse($assignee->shift_start_time);

                        // Get the current time
                        $now = Carbon::now();
                        // Format both the shift start time and current time to "H:i" (hours and minutes only)
                        $shiftStartTimeFormatted = $shiftStartTime->format('H:i');
                        $nowFormatted = $now->format('H:i');
                        // Only send an email if the current time is >= shift start time (in the same day)
                        if ($nowFormatted === $shiftStartTimeFormatted) {
                            try {
                                Mail::to($assignee->email)->send(new TaskReminderMail($task));
                                $this->info('Reminder sent to ' . $assignee->email . ' for task: ' . $task->task_name);
                                $task->reminder_sent = true;
                                $task->save();
                            } catch (\Exception $e) {
                                $this->error('Failed to send reminder: ' . $e->getMessage());
                            }
                        } else {
                        }
                    } else {
                        $this->warning('No assignee or email for task: ' . $task->task_name);
                    }
                }
            }
        }
    }
}
