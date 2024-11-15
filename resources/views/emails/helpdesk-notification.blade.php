<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            line-height: 1.6;
            color: #333;
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
    <div class="content">
    
            <p>Hi <strong>   
    
 </strong>,
</p>
            <p>A New Request Created</strong>. You can follow up on their progress.</p>
 
        
        <p>Below are the New Request details:</p>
        
        <ul>

          
            <li><strong>Employee ID:</strong> {{ $helpDesk->emp_id }}</li>
     
            <li><strong>Subject:</strong> {{ $helpDesk->subject }}</li>
            <li><strong>Description:</strong> {{ $helpDesk->description }}</li>
            <li><strong>Category:</strong> {{ $helpDesk->category }}</li>
        </ul>

     
            <p><a href="https://s6.payg-india.com/HelpDesk">Click here</a>  View Request .</p>
           
    
    </div>

    <div class="footer">
        <p>Note: This is an auto-generated email. Please do not reply.</p>
        <p>PS: "This e-mail is generated from info@s6.payg-india.com"</p>
    </div>
</body>

</html>
