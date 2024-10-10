<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <p>Hi, {{ ucwords(strtolower($employeeDetails->first_name)) }} {{ ucwords(strtolower($employeeDetails->last_name)) }} [{{ $employeeDetails->emp_id }}],</p>
    @if($leaveRequest->category_type === 'Leave')
    @if($leaveRequest->status === 'approved')
    <p>Your leave application has been accepted.</p>
    @else
    <p>Your leave application has been rejected.</p>
    @endif
    @elseif($leaveRequest->category_type === 'Leave Cancel')
    @if($$leaveRequest->cancel_status === 'approved')
    <p>Your leave cancel application has been accepted.</p>
    @else
    <p>Your leave cancel application has been rejected.</p>
    @endif
    @endif

    <table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Category Type</td>
                    <td>{{ $leaveRequest->category_type }}</td>
                </tr>
                <tr>
                    <td>Leave Type</td>
                    <td>{{ $leaveRequest->leave_type }}</td>
                </tr>
                <tr>
                    <td>From Date</td>
                    <td>{{ $leaveRequest->from_date->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td>To Date</td>
                    <td>{{ $leaveRequest->to_date->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td>From Session</td>
                    <td>{{ $leaveRequest->from_session }}</td>
                </tr>
                <tr>
                    <td>To Session</td>
                    <td>{{ $leaveRequest->to_session }}</td>
                </tr>
                <tr>
                    <td>Number of Days</td>
                    <td>{{ $numberOfDays }}</td>
                </tr>
                <tr>
                    <td>Reason</td>
                    <td>
                        @if($leaveRequest->category_type === 'Leave')
                        {{ $leaveRequest->reason }}
                        @else
                        {{ $leaveRequest->leave_cancel_reason }}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

    <p>Regards</p>

    <p>Note: This is an auto-generated mail. Please do not reply.</p>

    <p>PS: "This e-mail is generated from info@s6.payg-india.com"</p>
</body>

</html>