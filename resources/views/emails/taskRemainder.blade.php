<!-- resources/views/emails/taskReminder.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .footer {
            margin-top: 20px;
            font-size: 0.8em;
            color: #888;
        }
    </style>
</head>
<body>
    <p>Hi <strong>{{ $task->assignee }}</strong>,</p>
    <p><strong>Task Name: </strong> {{ strtoupper($task->task_name) }}</p>
    <p><strong>Description:</strong> {{ $task->description }}</p>
    <p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</p>

    <p> <strong>Today</strong> is the last day to complete your task: UI. Please make sure to finish it by the end of the day<strong>(EOD)</strong>.

    </p>
    <p><a href="https://s6.payg-india.com/tasks">Click here</a> to view the Task.</p>
    <div class="footer">
        <p>Note: This is an auto-generated email. Please do not reply.</p>
        <p>PS: "This e-mail is generated from info@s6.payg-india.com"</p>
    </div>
    
</body>
</html>
