<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <style>
        .leave-transctions {
            background: #fff;
            margin: 0 auto;
            box-shadow: 0 3px 10px 0 rgba(0, 0, 0, 0.2);
        }

        .pdf-heading {
            text-align: center;
        }

        /* Header Styles */
        .pdf-heading h2 {
            color: black;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .pdf-heading span p {
            font-size: 0.700rem;
            font-weight: 500;
            margin-top: 2px;
            color: #36454F;
        }

        .pdf-heading h3 {
            font-weight: 500;
            margin-top: -5px;
            font-size: 0.925rem;
        }




        .header {
            text-align: center;
            font-size: 20px;
            font-weight: 500;
        }

        .header1 {
            text-align: center;
            font-size: 18px;
            font-weight: 500;
        }

        .paragraph {
            font-size: 14px;
            text-align: center;
        }

        .details {
            margin-bottom: 20px;
        }

        .details div {
            margin-bottom: 5px;
        }

        .emp-details {
            padding: 20px;

        }

        .emp-details p {
            font-weight: 500;
            font-size: 0.875rem;
            color: black;
        }

        .emp-details span {
            font-weight: 400;
            font-size: 0.855rem;
            color: #333;
        }

        .emp-info {
            display: flex;
            justify-content: center;
            border: 1px solid #333;
            margin: 20px 0;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1.5px solid #808080;
            padding: 8px;
            text-align: left;
        }

        td {
            font-size: 0.825rem;
        }

        th {
            font-size: 0.875rem;
            background-color: #C0C0C0;
        }
        .leavesdate{
            font-weight:500;
            font-size:12px ;
        }
    </style>
    <div class="leave-transctions">
        <div class="pdf-heading">
            @php
            // Check if company_id is an array or JSON
            $companyIds = is_array($employeeDetails->company_id) ? $employeeDetails->company_id : json_decode($employeeDetails->company_id, true);
        @endphp
             @if (in_array('XSS-12345', $companyIds))
            <img src="https://media.licdn.com/dms/image/C4D0BAQHZsEJO8wdHKg/company-logo_200_200/0/1677514035093/xsilica_software_solutions_logo?e=2147483647&v=beta&t=rFgO4i60YIbR5hKJQUL87_VV9lk3hLqilBebF2_JqJg" alt="" style="width:200px;height:125px;">
            <div>
                <h2>XSILICA SOFTWARE SOLUTIONS P LTD <br>
                    <span>
                        <p>3rd Floor, Unit No.4, Kapil Kavuri Hub IT Block, Nanakramguda Main Road, Hyderabad, Rangareddy, <br> Telangana, 500032</p>
                    </span>
                </h2>
                <h3>Day wise Leave Transaction Report Between {{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }} to {{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}</h3>
            </div>
            <!-- payglogo -->
            @elseif (in_array('PAYG-12345', $companyIds))
            <img src="https://play-lh.googleusercontent.com/qUGkF93p010_IHxbn8FbnFWZfqb2lk_z07i6JkpOhC9zf8hLzxTdRGv2oPpNOOGVaA=w600-h300-pc0xffffff-pd" style="width:200px;height:125px;">
            <div>
                <h2> PayG <br>
                    <span>
                        <p>3rd Floor, Unit No.4, Kapil Kavuri Hub IT Block, Nanakramguda Main Road, Hyderabad, Rangareddy, <br> Telangana, 500032</p>
                    </span>
                </h2>
                <h3>Day wise Leave Transaction Report Between {{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }} to {{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}</h3>
            </div>
            <!-- attune golabal logo -->
            @elseif (in_array('AGS-12345', $companyIds))
            <img src="https://images.crunchbase.com/image/upload/c_lpad,h_256,w_256,f_auto,q_auto:eco,dpr_1/rxyycak6d2ydcybdbb3e" alt="" style="width:200px;height:125px;">
            <div>
                <h2>Attune Global Solutions<br>
                    <span>
                        <p>3rd Floor, Unit No.4, Kapil Kavuri Hub IT Block, Nanakramguda Main Road, Hyderabad, Rangareddy, <br> Telangana, 500032</p>
                    </span>
                </h2>
                <h3>Day wise Leave Transaction Report Between {{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }} to {{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}</h3>
            </div>
            @endif
        </div>
    </div>

    <table class="table table-bordered table-responsive">
        <thead>
            <tr>
                <th>SI.No</th>
                <th>Employee No </th>
                <th>Name </th>
                <th>Manager No</th>
                <th>Manager Name</th>
                <th>Leave Type</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Transaction Type</th>
                <th >Days</th>
                <th>Reason</th>
            </tr>
        </thead>
        <tbody>
            @if($leaveTransactions->isEmpty())
            <tr>
                <td  class="leavesdate" colspan="11" style="text-align: center;  font-weight:600;   font-size:15px ;">No data found</td>
            </tr>
            @else
            @foreach($leaveTransactions as $onedaytransaction)
            <tr >
                <td  class="leavesdate" colspan='11'> {{ $onedaytransaction['date'] }}</td>
             </tr>

            @foreach ($onedaytransaction['details'] as $transaction)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $transaction['emp_id' ]}}</td>
                <td>{{ucwords(strtolower($transaction['first_name']))}} {{ucwords(strtolower($transaction['last_name']))}} </td>
                <td>{{ $employeeDetails->emp_id}}</td>
                <td>{{ ucwords(strtolower($employeeDetails->first_name))}} {{ ucwords(strtolower($employeeDetails->last_name))}}</td>
                <td>{{ $transaction['leave_type']}}</td>
                <td>{{ \Carbon\Carbon::parse($transaction['leave_from_date'])->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($transaction['leave_to_date'])->format('d M Y') }}</td>
                {{-- <td>{{ ucwords(strtolower($transaction['leave_status'])) }}</td> --}}
                <td>
                    @php
                        $leaveStatus = $transaction['leave_status'];
                        switch ($leaveStatus) {
                            case 2:
                                $status = 'Availed';
                                break;
                            case 3:
                                $status = 'Rejected';
                                break;
                            case 4:
                                $status = 'Withdrawn';
                                break;
                            case 'Granted':
                                $status = 'Granted';
                                break;
                            case 'Lapsed':
                                $status = 'Lapsed';
                                break;
                            default:
                                $status = 'Unknown Status';
                        }
                    @endphp
                    {{ ucwords(strtolower($status)) }}
                </td>
                
                <td>{{ $transaction['leave_days'] }}</td>
                <td>{{ ucwords(strtolower($transaction['reason'])) }}</td>
            </tr>
            @endforeach
            @endforeach
            @endif
        </tbody>
    </table>
</body>

</html>
