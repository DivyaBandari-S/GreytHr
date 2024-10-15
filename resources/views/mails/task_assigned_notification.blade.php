<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .header {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
        }

        .content {
            margin: 20px;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.8em;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Task Assigned Notification</h1>
    </div>
    <div class="content">
     
                <p>Hi {{ ucwords(strtolower($assignee)) }},</p>

                <p>You have been assigned a new task:</p>
                {{-- @if (!empty($searchData[0])) --}}
               
                <ul>
                    {{-- <li><strong>Task ID: </strong> T-{{ $record->id }} </li> --}}
                    <li><strong>Task Name: </strong> {{ strtoupper($taskName) }}</li>
                    <li><strong>Description: </strong> {{ $description }}</li>
                    <li><strong>Due Date: </strong>
                        @if($dueDate && \Carbon\Carbon::createFromFormat('Y-m-d', $dueDate))
                            {{ \Carbon\Carbon::parse($dueDate)->format('M d, Y') }}
                        @else
                            N/A
                        @endif 
                    </li>
                    <li><strong>Priority: </strong> {{ $priority }}</li>
                    <li><strong>Assigned By: </strong> {{ ucwords(strtolower($assignedBy)) }}</li>
                    {{-- @endforeach --}}
                </ul>
                <p>Please make sure to complete it by the {{ \Carbon\Carbon::parse($dueDate)->format('M d, Y') }}</p>
        
        {{-- @else
            <p>No tasks assigned.</p>
        @endif --}}
    </div>

    <div class="footer">
        <p>Note: This is an auto-generated email. Please do not reply.</p>
        <p>PS: "This e-mail is generated from info@s6.payg-india.com"</p>
    </div>
</body>

</html>
