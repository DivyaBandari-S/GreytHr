<div>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
                font-family: 'Arial', sans-serif;
                line-height: 1.6;
                margin: 0;
                padding: 0;
                background-color: #f8f9fa;
            }

            .container {
                max-width: 600px;
                margin: 20px auto;
                padding: 20px;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            }

            h1 {
                color: #343a40;
                text-align: center;
            }

            p {
                margin-bottom: 15px;
                color: #555;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            table,
            th,
            td {
                border: 1px solid #e9ecef;
            }

            th,
            td {
                padding: 15px;
                text-align: left;
            }

            .signature {
                margin-top: 20px;
                text-align: right;
            }

            .signature img {
                max-width: 150px;
                height: auto;
                border-radius: 4px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <h1>{{$company}}</h1>

            <p>Dear <strong>{{$recipientName}}</strong>,</p>

            <p>We are pleased to offer you the position of <strong>{{$jobPosition}}</strong> at <strong>{{$jobPosition}}</strong> with a start date of <strong>{{$startDate}}</strong> and an annual salary of <strong>₹ {{$salary}}</strong>.</p>

            <table>
                <tr>
                    <th>Position</th>
                    <td>{{$jobPosition}}</td>
                </tr>
                <tr>
                    <th>Start Date</th>
                    <td>{{$startDate}}</td>
                </tr>
                <tr>
                    <th>Salary</th>
                    <td>₹ {{$salary}} per annum</td>
                </tr>
            </table>

            <p>Your employment with us will be at-will, allowing either party to terminate the relationship at any time. This offer is contingent upon the successful completion of background and reference checks.</p>

            <p>To accept this offer, please sign and return a copy of this letter by {{$informDate}}. If you have any questions or need further clarification, please contact <strong>{{$senderName}}</strong> at <strong>{{$fromAddress}}</strong> or <strong>{{$contactPhone}}</strong>.</p>

            <div class="signature">
                <div>{{$signature}}</div>
                <div>Signature</div>
            </div>

            <p>Sincerely,<br>
                {{$senderName}}<br>
                HR Manager<br>
                {{$company}}
            </p>
        </div>
    </body>

    </html>
    @livewireScripts
</div>