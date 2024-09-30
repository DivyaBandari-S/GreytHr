<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <h2>Leave Application Notification</h2>

    <p>Hi,</p>
    @if($leaveCategory == 'Leave')
    @if($status === 'Withdrawn')
    <p><strong>{{ ucwords(strtolower($employeeDetails->first_name)) }} {{ ucwords(strtolower($employeeDetails->last_name)) }} [{{ $employeeDetails->emp_id }}]</strong>has withdrawn the leave.</p>
    @else
    <p><strong>{{ ucwords(strtolower($employeeDetails->first_name)) }} {{ ucwords(strtolower($employeeDetails->last_name)) }} [{{ $employeeDetails->emp_id }}]</strong> has applied for a leave.</p>
    <p>Please log on to and review the leave application.</p>
    @endif
    @else
    @if($cancelStatus === 'Withdrawn')
    <p><strong>{{ ucwords(strtolower($employeeDetails->first_name)) }} {{ ucwords(strtolower($employeeDetails->last_name)) }} [{{ $employeeDetails->emp_id }}]</strong>has withdrawn the leave.</p>
    @else
    <p><strong>{{ ucwords(strtolower($employeeDetails->first_name)) }} {{ ucwords(strtolower($employeeDetails->last_name)) }} [{{ $employeeDetails->emp_id }}]</strong> has applied for a leave.</p>
    <p>Please log on to and review the leave application.</p>
    @endif
    @endif

    <h3>Following are the leave details:</h3>
    <ul>
        <li>Leave type: {{ $leaveRequest->leave_type }}</li>
        <li>From Date: {{ $leaveRequest->from_date->format('d M Y') }}</li>
        <li>To Date: {{ $leaveRequest->to_date->format('d M Y') }}</li>
        <li>Number of days: {{ $numberOfDays }}</li>
        <!-- <li>Leave Balance: {{ $leaveRequest->leave_balance }}</li> -->
        <li>From Session: {{ $leaveRequest->from_session }}</li>
        <li>To Session: {{ $leaveRequest->to_session }}</li>
    </ul>
    @if($status === 'Withdrawn')
    <p></p>
    @else
    <p><a href="https://s6.payg-india.com/employees-review">Click here </a>to approve/reject this request.</p>
    @endif
    <p>Regards</p>

    <p>Note: This is an auto-generated mail. Please do not reply.</p>

    <p>PS: "This e-mail is generated from info@s6.payg-india.com"</p>
</body>

</html>