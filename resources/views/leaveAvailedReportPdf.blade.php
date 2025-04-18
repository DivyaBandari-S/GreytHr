

<div>
    <style>
        .leave-transctions {
            background: #fff;
            margin: 0px;
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
            padding: 5px;
            text-align: left;
            width: auto;
        }

        .approver-column {
            font-size: 0.8rem;
            /* Slightly smaller font size */
            white-space: normal;
            /* Allow text wrapping */
            word-wrap: break-word;
        }

        th.approver-column,
        td.approver-column {
            width: 15%;
            /* Adjust percentage as necessary */
        }

        td {
            font-size: 0.825rem;
        }

        th {
            font-size: 0.875rem;
            background-color: #C0C0C0;
        }

        .leavesdate {
            font-weight: 500;
            font-size: 12px;
        }
    </style>
    <div class="leave-transctions">
        <div class="pdf-heading">
            @php
                use App\Models\EmployeeDetails;
                use App\Models\Company;
                $employeeId = auth()->guard('emp')->user()->emp_id;

                // Fetch the company_ids for the logged-in employee
                $companyIds = EmployeeDetails::where('emp_id', $employeeId)->value('company_id');

                // Check if companyIds is an array; decode if it's a JSON string
                $companyIdsArray = is_array($companyIds) ? $companyIds : json_decode($companyIds, true);
            @endphp
            @foreach ($companyIdsArray as $companyId)
                @php
                    // Fetch the company by company_id
                    $company = Company::where('company_id', $companyId)->where('is_parent', 'yes')->first();
                @endphp

                @if ($company)
                    <!-- Display company details if a matching company is found -->
                    @if ($company->company_id === 'XSS-12345')
                        <img src="data:image/jpeg;base64,{{ $company->company_logo }}">
                        <div>
                            <h2>XSILICA SOFTWARE SOLUTIONS P LTD <br>
                                <span>
                                    <p>3rd Floor, Unit No.4, Kapil Kavuri Hub IT Block, Nanakramguda Main Road,
                                        Hyderabad, Rangareddy, <br> Telangana, 500032</p>
                                </span>
                            </h2>
                            <h3>Leave Availed Transactions Between

                                {{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }} to
        
                                {{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}</h3>
                        </div>
                    @elseif($company->company_id === 'PAYG-12345')
                        <img src="data:image/jpeg;base64,{{ $company->company_logo }}"
                            style="width:200px;height:125px;">
                        <div>
                            <h2> PayG <br>
                                <span>
                                    <p>3rd Floor, Unit No.4, Kapil Kavuri Hub IT Block, Nanakramguda Main Road,
                                        Hyderabad, Rangareddy, <br> Telangana, 500032</p>
                                </span>
                            </h2>
                            <h3>Leave Availed Transactions Between

                                {{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }} to
        
                                {{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}</h3>
                        </div>
                    @elseif($company->company_id === 'AGS-12345')
                        <img src="data:image/jpeg;base64,{{ $company->company_logo }}" alt=""
                            style="width:200px;height:125px;">
                        <div>
                            <h2>Attune Global Solutions<br>
                                <span>
                                    <p>3rd Floor, Unit No.4, Kapil Kavuri Hub IT Block, Nanakramguda Main Road,
                                        Hyderabad, Rangareddy, <br> Telangana, 500032</p>
                                </span>
                            </h2>
                            <h3>Leave Availed Transactions Between

                                {{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }} to
        
                                {{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}</h3>
                        </div>
                    @endif
                @endif
            @endforeach
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
                <th>Days</th>
                <th>Reason</th>
                <th>Applied Date</th>
                <th>Approved Date</th>
                <th class="approver-column">Approver</th>
            </tr>
        </thead>
        <tbody>
            @if ($leaveTransactions->isEmpty())
                <tr>
                    <td class="leavesdate" colspan="13"
                        style="text-align: center;  font-weight:600;   font-size:15px ;">No data found</td>
                </tr>
            @else
            @php $siNo = 1; @endphp  
                @foreach ($leaveTransactions as $leaveTransaction)
                    @foreach ($leaveTransaction['details'] as $transaction)
                        <tr>
                            <td>{{ $siNo++ }}</td>
                            <td>{{ $transaction['emp_id'] }}</td>
                            <td>{{ ucwords(strtolower($transaction['first_name'])) }}
                                {{ ucwords(strtolower($transaction['last_name'])) }}</td>
                            <td>{{ $employeeDetails->emp_id }}</td>
                            <td>{{ ucwords(strtolower($employeeDetails->first_name)) }}
                                {{ ucwords(strtolower($employeeDetails->last_name)) }}</td>
                            <td>{{ $transaction['leave_type'] }}</td>


                            <td>{{ \Carbon\Carbon::parse($transaction['leave_from_date'])->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction['leave_to_date'])->format('d M Y') }}</td>
                            <td>{{ $transaction['leave_days'] }}</td>
                            <td>{{ ucwords(strtolower($transaction['reason'])) }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction['created_at'])->format('d M Y h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction['updated_at'])->format('d M Y h:i A') }}</td>
                            <td class="approver-column">{{ ucwords(strtolower($employeeDetails->first_name)) }}
                                {{ ucwords(strtolower($employeeDetails->last_name)) }}</td>
                        </tr>
                    @endforeach
                @endforeach

            @endif
        </tbody>
    </table>
</div>


