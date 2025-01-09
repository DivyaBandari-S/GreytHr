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

        <p>Hi <strong>{{ $delegateName }}</strong>,</p>
        <p>You have been assigned as a delegate for the workflow: {$workflow}.</p>
        <p>Below are the workflow details:</p>

        <ul>
            <li><strong>Workflow:</strong> {{($workflow)}}</li>
            <li><strong>Assigned By: </strong> {{ $addedBy }}</li>
            <li><strong>From Date: </strong> {{ $fromDate }}</li>
            <li><strong>To Date: </strong> {{$toDate}}</li>
        </ul>


        <p>For more details <a href="https://s6.payg-india.com/delegates">click here</a>.</p>

    </div>

    <div class="footer">
        <p>Note: This is an auto-generated email. Please do not reply.</p>
        <p>PS: "This e-mail is generated from info@s6.payg-india.com"</p>
    </div>
</body>

</html>
