<div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application Notification</title>
</head>
<body>
    <h2>Leave Application Notification</h2>

    <p>Hello Manager,</p>

    <p>An employee has submitted a leave application. Here are the details:</p>

    <ul>
    @if($leaveDetails)
        <li><strong>Leave Type:</strong> {{ $leaveDetails['leave_type'] }}</li>
        <li><strong>From Date:</strong> {{ $leaveDetails['from_date'] }}</li>
        <!-- Add more details as needed -->
    @else
        <li>No leave details available.</li>
    @endif
</ul>


    <p>Please review and take appropriate action.</p>

    <p>Thank you.</p>
</body>
</html>

</div>