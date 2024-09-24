<!DOCTYPE html>
<html>
<head>
    <title>Manager Notification</title>
</head>
<body>
    <h1>Notification Regarding regularisation</h1>
    <p>{{ $details['message'] }}</p>
    <p>From: {{ $details['sender_name'] }}</p>
    <div style="margin-bottom: 20px;">
        <table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse:collapse;">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Date</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>
            @if(!empty($details['regularisationRequests']) && is_array($details['regularisationRequests']))
                    @foreach($details['regularisationRequests'] as $entry)
                        <tr>
                            <td>{{ $details['sender_id']}}</td>
                            <td> {{ \Carbon\Carbon::parse($entry['date'])->format('jS F Y') }} </td>
                            <td>{{ htmlspecialchars($entry['from']) }}</td>
                            <td>{{ htmlspecialchars($entry['to']) }}</td>
                            <td>{{ htmlspecialchars($entry['reason']) }}</td>
                        </tr>
                    @endforeach
            @else
                <tr>
                    <td colspan="5">No regularisation entries available.</td>
                </tr>
            @endif
            </tbody>
            </table>
            </div>
</body>
</html>
