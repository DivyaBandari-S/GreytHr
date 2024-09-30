<!DOCTYPE html>
<html>
<head>
    <title>Leave Application Submitted</title>
</head>
<body>
    <h1>Leave Application Details</h1>
    <p><strong>Leave Type:</strong> {{ $leaveRequest->leave_type }}</p>
    <p><strong>From Date:</strong> {{ $leaveRequest->from_date }}</p>
    <p><strong>To Date:</strong> {{ $leaveRequest->to_date }}</p>
    <p><strong>Reason:</strong> {{ $leaveRequest->reason }}</p>
    
    <h2>Manager Details</h2>
    @foreach($applyingToDetails as $manager)
        <p><strong>Report To:</strong> {{ $manager['report_to'] }}</p>
    @endforeach
    
    <h2>CC</h2>
    @foreach($ccToDetails as $cc)
        <p>{{ $cc['full_name'] }}</p>
    @endforeach

    <p>This leave will be auto-approved by the system on {{ \Carbon\Carbon::parse($leaveRequest->to_date)->addDays(5)->format('d M Y') }}. Kindly take action before the mentioned date.</p>
</body>
</html>
