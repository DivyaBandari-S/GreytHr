<!DOCTYPE html>
<html>
<head>
    <title>Regularization Rejection Mail</title>
</head>
<body>

    <h1>Regularization Rejection Mail</h1>
    <p>Your regularization request has been rejected for the following dates.</p>
    
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
            @if(!empty($details['regularisationRequests']) && is_array($details['regularisationRequests']))
                    @foreach($details['regularisationRequests'] as $entry)
                        <tr>
                            <td style="text-align:center; padding:5px;">{{ $details['sender_id'] }}</td>
                            <td style="text-align:center; padding:5px;">{{ ucwords(strtolower($details['sender_first_name'])) }} {{ ucwords(strtolower($details['sender_last_name'])) }} </td>
                            <td style="text-align:center; padding:5px;">{{ \Carbon\Carbon::parse($entry['date'])->format('jS M, Y') }}</td>
                            <td style="text-align:center; padding:5px;">{{ htmlspecialchars($entry['from']) }}</td>
                            <td style="text-align:center; padding:5px;">{{ htmlspecialchars($entry['to']) }}</td>
                            <td style="text-align:center; padding:10px;">{{ htmlspecialchars($entry['reason']) }}</td>
                        </tr>
                    @endforeach
                  
            @else
                <tr>
                    <td colspan="5">No regularization entries available.</td>
                </tr>
            @endif
        
            </tbody>
            </table>
            @if(!empty($details['regularisationRequests']) && is_array($details['regularisationRequests']))
           
                
                    <p style="text-align:start;font-weight:bold;">Employee Remarks:<span class="text-center"style="font-weight:400;"> {{ $details['sender_remarks']}}</span></p>
                    
                
             
           
            
            
            @endif
            @if(!empty($details['regularisationRequests']) && is_array($details['regularisationRequests']))
            
                    <p style="text-align:start;font-weight:bold;">Approver Remarks:
                        <span class="text-center"style="font-weight:400;">
                            @if(empty($details['receiver_remarks']))
                                NA
                            @else    
                              {{ $details['receiver_remarks']}}
                            @endif 
                        </span></p>
                    
               
            @endif
            <p style="font-size: 12px; color: gray; margin-top: 20px;">
                <strong>Note:</strong> This is an auto-generated mail. Please do not reply.
            </p>
            </div>
</body>
</html>
