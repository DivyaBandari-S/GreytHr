<!DOCTYPE html>
<html>
<head>
    <title>Regularization Withdrawal Mail</title>
</head>
<body>

    <h1>Regularization Withdrawal Mail</h1>
    <p>Your regularization request has been withdrawn for the following dates.</p>
   
    <div style="margin-bottom: 20px;">
        <table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse:collapse;">
            <thead>
                <tr>
                    <th style="width:10%; padding:5px; text-align:center;">Employee ID</th>
                    <th style="width:20%; padding:5px; text-align:center;">Employee Name</th>
                    <th style="width:15%; padding:5px; text-align:center;">Date</th>
                    <th style="width:10%; padding:5px; text-align:center;">From</th>
                    <th style="width:10%; padding:5px; text-align:center;">To</th>
                    <th style="width:55%; padding:10px; text-align:center;">Reason</th>
                </tr>
             
            </thead>
            <tbody>
            @if(!empty($details['regularisationRequests1']) && is_array($details['regularisationRequests1']))
                    @foreach($details['regularisationRequests1'] as $entry)
                        <tr>
                            <td style="text-align:center; padding:5px;">{{ $details['employee_id'] }}</td>
                            <td style="text-align:center; padding:5px;">{{ $details['employee_name'] }}</td>
                            <td style="text-align:center; padding:5px;">{{ \Carbon\Carbon::parse($entry['date'])->format('jS M, Y') }}</td>
                            <td style="text-align:center; padding:5px;">{{ htmlspecialchars($entry['from']) }}</td>
                            <td style="text-align:center; padding:5px;">{{ htmlspecialchars($entry['to']) }}</td>
                            <td style="text-align:center; padding:10px;">{{ htmlspecialchars($entry['reason']) }}</td>
                        </tr>
                    @endforeach
                  
            @else
                <tr>
                    <td colspan="12">No regularization entries available.</td>
                </tr>
            @endif
        
            </tbody>
            </table>
            
            <p style="font-size: 12px; color: gray; margin-top: 20px;">
                <strong>Note:</strong> This is an auto-generated mail. Please do not reply.
            </p>
            </div>
</body>
</html>
