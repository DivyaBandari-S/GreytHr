<!DOCTYPE html>
<html>
<head>
    <title>Regularization Rejection Mail</title>
</head>
<body>

    <h1>Regularisation Rejection Mail</h1>
    <p>Your regularisation request has been rejected for the following dates.</p>
    
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
                            <td class="text-center">{{ $details['sender_id']}}</td>
                            <td class="text-center"> {{ \Carbon\Carbon::parse($entry['date'])->format('jS F Y') }} </td>
                            <td class="text-center">{{ htmlspecialchars($entry['from']) }}</td>
                            <td class="text-center">{{ htmlspecialchars($entry['to']) }}</td>
                            <td class="text-center">{{ htmlspecialchars($entry['reason']) }}</td>
                        </tr>
                    @endforeach
                  
            @else
                <tr>
                    <td colspan="5">No regularisation entries available.</td>
                </tr>
            @endif
        
            </tbody>
            </table>
            @if(!empty($details['regularisationRequests']) && is_array($details['regularisationRequests']))
            <table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse:collapse;">
            <thead>
                <tr colspan="5">
                    <th>Employee Remarks:</th>
                    
                </tr>
             
            </thead>
            <tbody>
            
                 
                        <tr>
                            <td style="text-align:center;"> {{ $details['sender_remarks']}}</td>
                          
                        </tr>
                 
                  
            
           
        
            </tbody>
            </table>
            @endif
            @if(!empty($details['regularisationRequests']) && is_array($details['regularisationRequests']))
            <table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse:collapse;">
            <thead>
                <tr colspan="5">
                    <th>Approver Remarks:</th>
                    
                </tr>
             
            </thead>
            <tbody>
            
                 
                        <tr>
                            <td style="text-align:center;">{{ $details['receiver_remarks']}}</td>
                          
                        </tr>
                 
                  
            
           
        
            </tbody>
            </table>
            @endif
            <p style="font-size: 12px; color: gray; margin-top: 20px;">
                <strong>Note:</strong> This is an auto-generated mail. Please do not reply.
            </p>
            </div>
</body>
</html>
