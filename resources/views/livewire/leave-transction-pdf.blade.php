
<div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Transactions Report</title>
    <style>
        .leave-transctions{
            background:#fff;
            margin:0 auto;
            padding:20px 30px;
            box-shadow: 0 3px 10px 0 rgba(0, 0, 0, 0.2);
        }
        .pdf-heading{
            text-align:center;
        }

        /* Header Styles */
       .pdf-heading h2 {
            color: black;
            font-size:1.1rem;
            font-weight:600;
        }
       .pdf-heading span p{
            font-size:0.700rem;
            font-weight:500;
            margin-top:2px;
            color:#36454F;
        }
       .pdf-heading h3 {
            font-weight:500;
            margin-top:-5px;
            font-size:0.925rem;
        }
        .emp-details{
            padding: 5px 10px;
        }
        .emp-details p{
          font-weight:500;
          font-size:0.875rem;
          color:black;
        }
        .emp-details span{
            font-weight:400;
            font-size:0.855rem;
            color:#333;
        }
        .emp-info{
            display:flex;
            flex-direction:row;
            border:1px solid #333;
            justify-content:start;
            gap:100px;
            margin-top:20px;
        }
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1.5px solid #808080;
            padding: 8px;
            text-align: left;
        }
        td{
            font-size:0.825rem;
        }
        th {
            font-size:0.875rem;
            background-color: #C0C0C0;
        }
    </style>
</head>
<body>
    <div class="leave-transctions">
        <div class="pdf-heading">
            <h2>XSILICA SOFTWARE SOLUTIONS P LTD <br>
        <span><p>3rd Floor, Unit No.4, Kapil Kavuri Hub IT Block, Nanakramguda Main Road, Hyderabad, Rangareddy, <br> Telangana, 500032</p></span></h2>
       
            <h3>Leave Transactions From 01 Jan 2023 To 31 Dec 2023</h3>
        </div>

        <!-- Employee Details -->
      <div class="emp-info">
        <div class="emp-details">
                <p> Name: <span>{{ $employeeDetails->first_name ?? '' }}</span></p>
                <p>Date of Join: <span>02 Jan 2023</span></p>
                <p>Reporting Manager: <span>GYAN PRABODH 
DASARI(XSS-0307) </span></p>
        </div>
        <div class="emp-details">
                <p>Employee No: <span>XSS-0480</span></p>
                <p>Date of Birth: <span>18 Apr 1999</span></p>
                <p>Gender: <span>Female</span></p>
        </div>
      </div>
        <!-- Add more details as needed -->

        <!-- Leave Transactions Table -->
        <table>
            <thead>
                <tr>
                    <th>SI No</th>
                    <th>Posted Date</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Days</th>
                    <th>Leave Type</th>
                    <th>Transaction Type</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through leave transactions and populate the table -->
                @foreach($leaveTransactions as $transaction)
                    <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $transaction->created_at }}</td>
                    <td>{{ $transaction->from_date }}</td>
                    <td>{{ $transaction->to_date }}</td>
                    <td>days</td>
                    <td>{{ $transaction->leave_type }}</td>
                    <td>{{ $transaction->status }}</td>
                    <td>{{ $transaction->reason }}</td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>

</div>
