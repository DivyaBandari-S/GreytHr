<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Task;
use App\Mail\TaskReminderMail;  // A custom Mailable that you'll need to create
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

    /**
     * The console command description.
     *
     * @var string
     */
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
                            ->get();

          Log::info("tasks: " . $tasksDueToday); 
        foreach ($tasksDueToday as $task) {
            Log::info("Processing task: " . $task->task_name); // Log task being processed
    
            // Check if created_at and due_date are on the same day
            $taskCreatedDate = Carbon::parse($task->created_at)->format('Y-m-d');
            Log::info("tasks: " . $taskCreatedDate); 
            $taskDueDate = Carbon::parse($task->due_date)->format('Y-m-d');
            Log::info("tasks: " . $taskDueDate); 
            
            // Case 1a: If created_at and due_date are the same, send reminder 3 hours after creation
            if ($taskCreatedDate == $taskDueDate) {
                $taskCreatedTime = Carbon::parse($task->created_at);
                Log::info("tasks: " . $taskCreatedTime); 
                $sendReminderTime = $taskCreatedTime->addHours(3); 
                Log::info("tasks: " . $sendReminderTime); 
                
                if ($now->gte($sendReminderTime)) {
                    preg_match('/\#\((.*?)\)/', $task->assignee, $matches);
    
                    if (isset($matches[1])) {
                        $empId = $matches[1];
                        $assignee = EmployeeDetails::where('emp_id', $empId)->first();
    
                        if ($assignee && $assignee->email) {
                            try {
                                Mail::to($assignee->email)->send(new TaskReminderMail($task));
                                $this->info('Reminder sent to ' . $assignee->email . ' for task: ' . $task->task_name);
                            } catch (\Exception $e) {
                                $this->error('Failed to send reminder: ' . $e->getMessage());
                            }
                        }
                    }
                } else {
                    Log::info('Waiting for 3 hours for task: ' . $task->task_name);
                }
            }
            
            // Case 1b: If created_at and due_date are not the same, send reminder at assignee's shift start time
            if ($taskCreatedDate != $taskDueDate) {
                preg_match('/\#\((.*?)\)/', $task->assignee, $matches);
            
                if (isset($matches[1])) {
                    $empId = $matches[1];
                    $assignee = EmployeeDetails::where('emp_id', $empId)->first();
            
                    if ($assignee && $assignee->email) {
                        $shiftStartTime = Carbon::parse($assignee->shift_start_time); // Assignee's shift start time
                        Log::info("Assignee's shift start time: " . $shiftStartTime);  // Log shift start time
                        
                        // Only send an email if the current time is >= shift start time (in the same day)
                        if ($now->isSameDay($shiftStartTime) && $now->gte($shiftStartTime)) {
                            try {
                                Mail::to($assignee->email)->send(new TaskReminderMail($task));
                                $this->info('Reminder sent to ' . $assignee->email . ' for task: ' . $task->task_name);
                            } catch (\Exception $e) {
                                $this->error('Failed to send reminder: ' . $e->getMessage());
                            }
                        } else {
                            Log::info('Waiting for shift start time for task: ' . $task->task_name);
                        }
                    } else {
                        $this->warning('No assignee or email for task: ' . $task->task_name);
                    }
                }
            }
        }
    }
    

}
