<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include Bootstrap CSS -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"
        integrity="sha512-RgHh2hAiqIyb7OiXJ2mdyvgcmQ4jaixn1KJZ9T2EyNeIeeULenpVi+v3XnRxkoi0JvUHyja0kXgQVDiRhTskwQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
</head>

<body style="font-family: 'Montserrat', sans-serif;">
    <style>
        /* html,
        body {
            margin: 10px 10px;
            padding: 0;
            width: 100%;
            height: 100%;
            background-color: grey;

        } */

        .lableValues {
            width: 50%;
            font-size: 10px;
            font-weight: 500;

        }

        .Labels {
            padding-left: 3px;
            font-size: 9px;

        }

        .values {
            margin-left: 10px;
        }

        .main-table {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .POI-table {
            border: 1px solid black;
            border-collapse: collapse;
        }


        .main-table th,
        .main-table td {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 10px;
            text-align: end;
            padding: 0px 3px;
        }

        .POI-table th,
        .POI-table td {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 11px;
            text-align: end;
            padding: 2px 3px;
        }
        .POI-table th{
            text-align: center;
        }

        .main-table td {

            text-align: right;
        }

        .main-row {
            font-size: 11px;
        }

        .main-row td:first-child {
            font-weight: bold;
        }

        .main-row td:nth-child(2),
        .main-table td:nth-child(2) {
            text-align: left;
        }

        .POI_details td:nth-child(even) {
            font-weight: bold;
            text-align: left;

        }

        .POI_Details_second-page {
            page-break-before: always;
            /* Forces the table to start on a new page */
        }
    </style>
    <div style=" width: 100%;">
        <div style="position: relative; width: 100%; margin-bottom: 20px;">
            <div style="text-align: center; margin: 0 auto; width: 100%; position: relative;">
                <h2 style="font-weight: 600; font-size: 18px; margin: 0;">FORM NO.12BB</h2>
                <p style="font-size: 9px; margin: 0;">(See rule 26C)</p>
                <p style="font-size: 13px; margin: 0;font-weight:600">Statement showing particulars of claims by an employee for deduction of tax under section 192</p>
            </div>
        </div>
        <div>
            <table style="width:100%;">
                <tbody style="width:100%;">
                    <tr style="width:100%;">
                        <td class="w-50 p-0" style="width:100%;">
                            <table style="width:100%; border: none;">
                                <tr>
                                    <td class="lableValues Labels align-top">1.Name and address of the employee</td>
                                    <td class="lableValues Labels">:
                                        <span class="values">
                                            <span> {{ ucwords(strtolower($employees->first_name)) . ' ' . ucwords(strtolower($employees->last_name)) }}</span>
                                            <div style=" margin-left: 13px;">-</div>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="lableValues Labels">2.Permanent Account Number of the employee</td>
                                    <td class="lableValues Labels">: <span class="values">AEOPO6387G</span> </td>
                                </tr>
                                <tr>
                                    <td class="lableValues Labels">3.Financial year:</td>
                                    <td class="lableValues Labels">: <span class="values">{{$financial_year}}</span> </td>
                                </tr>
                                <tr>
                                    <td class="lableValues Labels">4.Tax Regime</td>
                                    <td class="lableValues Labels">: <span class="values">New Tax Regime</span> </td>
                                </tr>

                            </table>

                        </td>
                    </tr>
                </tbody>
            </table>
            <table  class="main-table" style="width:100%;border-collapse: collapse;">
                <thead>
                    <tr class="main-table">
                        <th colspan="4" class="text-center"> Details of claims and evidence thereof</th>
                    </tr>
                    <tr class="main-table">
                        <th class="text-center">Sl.No.</th>
                        <th class="text-center">Nature of claim</th>
                        <th class="text-center">Amount (Rs.)</th>
                        <th class="text-center">Evidence / particulars</th>
                    </tr>
                    <tr class="main-table">
                        <th class="text-center">(1)</th>
                        <th class="text-center">(2)</th>
                        <th class="text-center">(3)</th>
                        <th class="text-center">(4)</th>
                    </tr>
                </thead>
                <tbody border='1' style="width:100%;">
                    <tr class="main-row" style="width:100%;">
                        <td>1.</td>
                        <td>House Rent Allowance:</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-table" style="width:100%;">
                        <td></td>
                        <td>Note: Permanent Account Number shall be furnished if the aggregate rent paid during the
                            previous year exceeds one lakh rupees</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-row" style="width:100%;">
                        <td>2.</td>
                        <td>Leave travel concessions or assistance</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-row" style="width:100%;">
                        <td>3.</td>
                        <td>Deduction of interest on borrowing: Intererst on Housing Loan (Self occupied)</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-table" style="width:100%;">
                        <td></td>
                        <td>(i) Interest payable/paid to the lender</td>
                        <td>0</td>
                        <td></td>
                    </tr>
                    <tr class="main-table" style="width:100%;">
                        <td></td>
                        <td>(ii)Name of the lender</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-table" style="width:100%;">
                        <td></td>
                        <td>(iii) Address of the lender</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-table" style="width:100%;">
                        <td></td>
                        <td>(iv) Permanent Account Number of the lender</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-table" style="width:100%;">
                        <td></td>
                        <td>(a) Financial Institutions(if available)</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-table" style="width:100%;">
                        <td></td>
                        <td>(b) Employer(if available)</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-table" style="width:100%;">
                        <td></td>
                        <td>(c) Others</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-row" style="width:100%;">
                        <td></td>
                        <td>Total Income/Loss from let out Property</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-table" style="width:100%;">
                        <td></td>
                        <td>(i) Income/Loss from Let out Property</td>
                        <td>0</td>
                        <td></td>
                    </tr>
                    <tr class="main-table" style="width:100%;">
                        <td></td>
                        <td>(ii)Name of the lender</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-table" style="width:100%;">
                        <td></td>
                        <td>(iii) Permanent Account Number of the lender</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-row" style="width:100%;">
                        <td>4.</td>
                        <td>Deduction under Chapter VI-A</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-table" style="width:100%;">
                        <td></td>
                        <td>(A) Section 80C,80CCC and 80CCD</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-table" style="width:100%;">
                        <td></td>
                        <td>(i) Section 80C</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-table" style="width:100%;">
                        <td></td>
                        <td>(ii) Section 80CCC</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-table" style="width:100%;">
                        <td></td>
                        <td>(iii) Section 80CCD</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-table" style="width:100%;">
                        <td></td>
                        <td>(B) Other sections (e.g. 80E, 80G, 80TTA, etc.) under Chapter VI-A.</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-row" style="width:100%;">
                        <td>5.</td>
                        <td>.Other Income</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-row" style="width:100%;">
                        <td>6.</td>
                        <td>TCS/TDS Deduction</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="main-table" style="width:100%;">
                        <td></td>
                        <td colspan="3"><span style="font-weight:bold">Note:</span> If you have declared under any of the above sections and opted for the new regime, then those declarations won't be considered for tax computations.
                            This is because none of the above deductions are allowed in the new regime.</td>
                    </tr>
                    <tr class="main-table">
                        <th></th>
                        <th colspan="3" class="text-center"> Verification</th>
                    </tr>
                    <tr class="main-row" style="width:100%;">
                        <td rowspan="4"></td>
                        <td colspan="3"> I, K R Omshankar son/daughter of KR Raghupathi do hereby certify that the information given above is complete and correct.</td>

                    </tr>
                    <tr style="width:100%;">
                        <td class="text-start"> Place:</td>
                        <td class="text-center align-bottom" style="padding: 0px 5px;" colspan="2" rowspan="2"> (Signature of the employee)</td>

                    </tr>
                    <tr style="width:100%;">
                        <td class="text-start"> Date:</td>
                    </tr>
                    <tr style="width:100%;">
                        <td class="text-start">Designation: Software Engineer</td>
                        <td colspan="2"> Full Name: K R Omshankar </td>
                    </tr>

                </tbody>

            </table>
        </div>
    </div>
    <div class="mt-5 POI_Details_second-page" style=" width: 100%; text-align:center">
        <div style="position: relative; width: 100%; margin-bottom: 15px;">
            <div style="text-align: center; margin: 0 auto; width: 100%; position: relative;">
                <h2 style="font-weight: 700; font-size: 16px; margin: 0;">XSILICA SOFTWARE SOLUTIONS P LTD</h2>
                <h5 style="font-weight: 600; margin-top: 10px;font-size: 12px;"> POI for the period of Apr 2024 To Mar 2025</h5>
            </div>
        </div>
        <div>
            <table  class="POI-table mt-3" style="width:100%;border-collapse: collapse;">
                <tr class="POI_details">
                    <td> Name : </td>
                    <td> {{ ucwords(strtolower($employees->first_name)) . ' ' . ucwords(strtolower($employees->last_name)) }}</td>
                    <td>Employee No : </td>
                    <td>{{$employees->emp_id}}</td>
                </tr>
                <tr class="POI_details">
                    <td> Date Of Join :</td>
                    <td>  {{ \Carbon\Carbon::parse($employees->hire_date)->format('d M, Y') }}</td>
                    <td>Permanent Account Number :</td>
                    <td>AEOPO6387G</td>
                </tr>
            </table>

            <table  class="POI-table mt-3" style="width:100%;border-collapse: collapse;">

                <tr class="POI_tables" style="background-color: grey;">
                    <th> Sl.No :</th>
                    <th> Month</th>
                    <th> Location Indicator</th>
                    <th> Rent per month (Rs.)</th>
                    <th> Approved Amount</th>
                    <th> Status</th>
                    <th> Remarks</th>
                </tr>
            </table>
            <table  class="POI-table mt-3" style="width:100%;border-collapse: collapse;">

                <tr class="POI_tables" style="background-color: grey;">
                    <th> Sl.No :</th>
                    <th> Particulars</th>
                    <th> Amount (Rs.)</th>
                    <th> Approved Amount</th>
                    <th> Status</th>
                    <th> No of Doc</th>
                    <th> Proof</th>
                    <th> Remarks</th>
                </tr>
                <tr class="POI_tables_data">
                    <td colspan="8"> Deduction Under Section 24</td>

                </tr>
            </table>
            <p style="font-size: 10px;text-align:left;font-weight:bold">Note:</p>
        </div>
    </div>

</body>


</html>
