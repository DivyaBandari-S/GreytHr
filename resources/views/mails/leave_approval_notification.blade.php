<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <p>Hi, {{ ucwords(strtolower($employeeDetails->first_name)) }} {{ ucwords(strtolower($employeeDetails->last_name)) }} [{{ $employeeDetails->emp_id }}],</p>

    @if($leaveCategory === 'Leave')
    @if($status === 'approved')
    <p>Your leave cancel application has been accepted.</p>
    @else
    <p>Your leave cancel application has been rejected.</p>
    @endif
    @else
    @if($cancelStatus === 'approved')
    <p>Your leave application has been accepted.</p>
    @else
    <p>Your leave application has been rejected.</p>
    @endif
    @endif


    <ul>
        <li>Category type: {{ $leaveRequest->category_type }}</li>
        <li>Leave type: {{ $leaveRequest->leave_type }}</li>
        <li>From Date: {{ $leaveRequest->from_date->format('d M Y') }}</li>
        <li>To Date: {{ $leaveRequest->to_date->format('d M Y') }}</li>
        <li>Number of days: {{ $numberOfDays }}</li>
        <!-- <li>Leave Balance: {{ $leaveRequest->leave_balance }}</li> -->
        <li>From Session: {{ $leaveRequest->from_session }}</li>
        <li>To Session: {{ $leaveRequest->to_session }}</li>
    </ul>
    <p>Regards</p>

    <p>Note: This is an auto-generated mail. Please do not reply.</p>

    <p>PS: "This e-mail is generated from info@s6.payg-india.com"</p>
</body>
</html>