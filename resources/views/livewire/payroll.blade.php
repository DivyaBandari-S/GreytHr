<div>
    <div class="position-absolute" wire:loading
        wire:target="viewPdf,downloadPdf,cancel,breadcrumb-item,documentCenter">
        <div class="loader-overlay">
            <div class="loader">
                <div></div>
            </div>

        </div>
    </div>

    <style>
        .doc-card {
            background-color: white;
            /* Default background color */
            padding: 10px;
            /* Add padding to make it more spacious */

            /* Margin between cards */
            display: flex;
            flex-direction: column;
            /* Make it flexible */

            /* Center items vertically */

            /* Add a border for clarity */

            /* Rounded corners */
            cursor: pointer;
            /* Indicate it's clickable */
            transition: background-color 0.3s ease;
            /* Smooth hover transition */


        }

        .doc-card:hover {
            background-color: aliceblue;
            /* Hover background color */
        }

        .doc-card .container-a {
            display: flex;
            /* Flex container for inner elements */
            flex-direction: row;
            /* Arrange elements vertically */
            width: 100%;
            /* Occupy full width */
        }

        .payslip-main-row {
            width: 80%;
            margin-left: 40px;
            padding: 10px;
        }

        @media screen and (max-width: 600px) {
            .payslip-main-row {
                width: 100%;
                margin: 0px;
                padding: 2px;
            }
        }
    </style>

    <ul class="breadcrumb">
        <li class="breadcrumb-item" ><a href="/document" wire:click.prevent="documentCenter">Document Center</a></li>
        <li class="breadcrumb-item active" aria-current="page">Payslips</li>

    </ul>
    <p style="margin-left: 40px; font-family: Open Sans, sans-serif; margin-top: 10px;font-weight:medium;font-size:16px;text-decoration:underline">Payslips</p>

    <div class="row payslip-main-row  " wire:ignore style="border: 1px solid grey;border-radius:5px ;max-height: 500px; overflow-y: auto;">
        @if(count($allSalaryDetails)>0)
        <div class="col-2 col-md-3">
            @foreach ($allSalaryDetails as $financialYear => $salaryGroup)
            <p>
                <a href="#financialYear{{ $financialYear }}" style="text-decoration: none; color: inherit; cursor: pointer;">
                    {{ $financialYear }}
                </a>
            </p>
            @endforeach
        </div>
        <div class="col-10 col-md-9">

            @foreach ($allSalaryDetails as $financialYear => $salaryGroup)
            <div id="financialYear{{ $financialYear }}" class="financial-year-section" style="margin-bottom: 20px;">
                <div class="f" style="background:white;  border:1px solid silver; border-radius:5px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);margin-bottom: 10px;">
                    <div style="padding: 5px 0px;margin-left:20px;">
                        {{$financialYear}}
                    </div>
                    <hr style="margin: 0px;">
                    @foreach ($salaryGroup as $monthSalary )
                    <div class="container-a">
                        <div class="doc-card " style="padding-left: 20px;padding-bottom: 5px;">

                            <div class=" d-flex w-100" style="cursor: pointer;" onclick="togglePdf('pdfContainer{{$monthSalary->month_of_sal}}')">
                                <div _ngcontent-etd-c530="" class="card-left ">
                                    <i _ngcontent-etd-c530="" class="fa fa-caret-right" style=" font-size: 20px; padding-right:10px"></i>
                                </div>
                                <div _ngcontent-etd-c530="" class="card-right w-100">
                                    <div style="display: flex; align-items: center;">
                                        <span class="text-black text-5 text-regular" style="font-size: 12px; display: inline-block;">
                                            {{ \Carbon\Carbon::parse($monthSalary->month_of_sal)->format('M Y')}}
                                        </span>
                                        <span style="margin-left: auto; font-size: 12px; white-space: nowrap; display: inline-block;padding-right:5px">
                                            Last updated on {{ \Carbon\Carbon::parse($monthSalary->month_of_sal)->format('d M, Y')}}
                                        </span>
                                    </div>
                                    <p class="text-secondary text-regular text-6 card-desc" style="font-size:10px;margin:0px">
                                        Payroll for the month of {{ \Carbon\Carbon::parse($monthSalary->month_of_sal)->format('M Y')}}
                                    </p>
                                </div>
                            </div>

                            <div id="pdfContainer{{$monthSalary->month_of_sal}}" style="background-color:white; border-radius: 5px; width: 200px; display: none; flex: 1; align-items: center; padding: 5px; border: 1px solid silver; margin: 5px 5px 5px 20px;cursor:text">
                                <span class="text-black text-5 text-regular" style="font-size: 12px; margin-right: 10px;">
                                    {{ \Carbon\Carbon::parse($monthSalary->month_of_sal)->format('M Y')}}.pdf
                                </span>
                                <i class="fas fa-eye" wire:click.prevent="viewPdf('{{$monthSalary->month_of_sal}}')" style=" font-size: 16px; margin-right: 10px;cursor: pointer;    margin-left: auto;"></i>
                                <i class="fas fa-download" wire:click.prevent="downloadPdf('{{$monthSalary->month_of_sal}}')" style="font-size: 16px; cursor: pointer;"></i>
                            </div>
                        </div>

                    </div>
                    @endforeach





                </div>
            </div>
            @endforeach

        </div>
        @else
        <div class="d-flex flex-column align-items-center">
            <img src="https://th.bing.com/th/id/OIP.mahJODIeDJLFSbIYARY4WwAAAA?pid=ImgDet&w=178&h=178&c=7&dpr=1.5" alt="Payslip Image" class="img-fluid" style="max-width:100%; height:auto;">
            <p class="text-center" style="color: #677A8E; margin-bottom: 20px; font-size:12px;">Payslip not found.</p>
        </div>
        @endif
    </div>


    @if( $showPopup == true)
    <div class="modal" id="logoutModal" tabindex="4" style="display: block;">
        <div class="modal-dialog modal-dialog-centered w-80" style="width: 850px;max-width:850px">
            <div class="modal-content" style="overflow-x: auto; white-space: nowrap;max-width: 100%; box-sizing: border-box; ">

                <div class="modal-body text-center" style="font-size: 16px;">

                    <div style="font-family: 'Montserrat', sans-serif;">
                        <style>
                            .lableValues {
                                width: 50%;
                                font-size: 11px;
                                font-weight: 500;
                            }

                            .Labels {
                                padding-left: 3px;
                            }

                            .table_headers {
                                font-size: 11px;
                                font-weight: 600;
                            }

                            th,
                            td,
                            tr {
                                padding: 1px;
                                border: none;
                            }
                        </style>
                        <div style="border: 1px solid #000; width: 100%;">
                            <div style="position: relative; width: 100%; margin-bottom: 20px;">
                                <!-- Company Logo -->
                                <div style="position: absolute; left: 1%; top: 60%; transform: translateY(-50%);">
                                    <img src="https://media.licdn.com/dms/image/C4D0BAQHZsEJO8wdHKg/company-logo_200_200/0/1677514035093/xsilica_software_solutions_logo?e=2147483647&v=beta&t=rFgO4i60YIbR5hKJQUL87_VV9lk3hLqilBebF2_JqJg" alt="Company Logo" style="width: 90px;">
                                </div>

                                <!-- Company Details -->
                                <div style="text-align: center; margin: 0 auto; width: 100%; position: relative;">
                                    <h2 style="font-weight: 700; font-size: 18px; margin: 0;">XSILICA SOFTWARE SOLUTIONS P LTD</h2>
                                    <p style="font-size: 9px; margin: 0;">3rd Floor, Unit No.4, Kapil Kavuri Hub IT Block, Nanakramguda Main Road, Hyderabad, Rangareddy,</p>
                                    <p style="font-size: 9px; margin: 0;">500032, Telangana, India</p>
                                    <h6 style="font-weight: 600; margin-top: 10px;">Payslip for the month of {{$salMonth}}</h6>
                                </div>
                            </div>

                            <div>
                                <table style="width:100%;">
                                    <tbody style="width:100%;">
                                        <tr style="width:100%;">
                                            <td class="w-50 p-0" style="width:50%;border-top: 1px solid #000; border-right: 1px solid #000;">

                                                <table style="width:100%; border: none;">
                                                    <tr>
                                                        <td class="lableValues Labels ">Name:</td>
                                                        <td class="lableValues Labels"> {{ ucwords(strtolower($employeeDetails->first_name)) . ' ' . ucwords(strtolower($employeeDetails->last_name)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="lableValues Labels">Joining Date:</td>
                                                        <td class="lableValues Labels"> {{ \Carbon\Carbon::parse($employeeDetails->hire_date)->format('d M, Y') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="lableValues Labels">Designation:</td>
                                                        <td class="lableValues Labels"> {{$employeeDetails->job_role}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="lableValues Labels">Department:</td>
                                                        <td class="lableValues Labels">Technology</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="lableValues Labels">Location:</td>
                                                        <td class="lableValues Labels">{{$employeeDetails->job_location}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="lableValues Labels"> Effective Work Days:</td>
                                                        <td class="lableValues Labels">-</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="lableValues Labels">LOP:</td>
                                                        <td class="lableValues Labels">-</td>
                                                    </tr>
                                                </table>

                                            </td>
                                            <td class="w-50 p-0" style="width:50%;border-top: 1px solid #000;vertical-align: top;">
                                                <table style="width:100%; border: none;">
                                                    <tr>
                                                        <td class="lableValues Labels"> Employee No:</td>
                                                        <td class="lableValues Labels"> {{$employeeDetails->emp_id}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="lableValues Labels">Bank Name:</td>
                                                        <td class="lableValues Labels"> {{$empBankDetails['bank_name']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="lableValues Labels">Bank Account No:</td>
                                                        <td class="lableValues Labels"> {{$empBankDetails['account_number']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="lableValues Labels">PAN Numbe:</td>
                                                        <td class="lableValues Labels">- </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="lableValues Labels">PF No:</td>
                                                        <td class="lableValues Labels"> -</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="lableValues Labels"> PF UAN:</td>
                                                        <td class="lableValues Labels">-</td>
                                                    </tr>

                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w-50 p-0" style="width:50%; border-top: 1px solid #000; border-right: 1px solid #000;">
                                                <table style="width:100%; table-layout: fixed; border-collapse: collapse;">
                                                    <tr style="padding-right:3px;">
                                                        <td class="table_headers" style="width:40%; text-align: center;">Earnings</td>
                                                        <td class="table_headers" style="width:30%; text-align: right;">Full</td>
                                                        <td class="table_headers" style="width:30%; text-align: right;padding-right:3px">Actual</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td class="w-50 p-0" style="width:50%;border-top: 1px solid #000;vertical-align: top;">
                                                <table style="width:100%; table-layout: fixed; border-collapse: collapse;">
                                                    <tr style="padding-right:3px;">
                                                        <td class="table_headers" style="width:50%; text-align: center;">Deductions</td>
                                                        <td class="table_headers" style="width:50%; text-align: right;padding-right:3px">Actual</td>

                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w-50 p-0" style="width:50%; border-top: 1px solid #000; border-right: 1px solid #000;">
                                                <table style="width:100%; table-layout: fixed; border-collapse: collapse;">
                                                    <tr style="padding-left:3px;">
                                                        <td class="lableValues Labels" style="width:40%; text-align: left;">BASIC</td>
                                                        <td class="lableValues Labels" style="width:30%; text-align: right;">{{number_format($salaryDivisions['basic'],2)}}</td>
                                                        <td class="lableValues Labels" style="width:30%; text-align: right;padding-right:3px">{{number_format($salaryDivisions['basic'],2)}}</td>
                                                    </tr>
                                                    <tr style="padding-left:3px;">
                                                        <td class="lableValues Labels" style="width:40%; text-align: left;">HRA</td>
                                                        <td class="lableValues Labels" style="width:30%; text-align: right;">{{number_format($salaryDivisions['hra'],2)}}</td>
                                                        <td class="lableValues Labels" style="width:30%; text-align: right;padding-right:3px">{{number_format($salaryDivisions['hra'],2)}}</td>
                                                    </tr>
                                                    <tr style="padding-left:3px;">
                                                        <td class="lableValues Labels" style="width:40%; text-align: left;">CONVEYANCE</td>
                                                        <td class="lableValues Labels" style="width:30%; text-align: right;">{{number_format($salaryDivisions['conveyance'],2)}}</td>
                                                        <td class="lableValues Labels" style="width:30%; text-align: right;padding-right:3px">{{number_format($salaryDivisions['conveyance'],2)}}</td>
                                                    </tr>
                                                    <tr style="padding-left:3px;">
                                                        <td class="lableValues Labels" style="width:40%; text-align: left;"> MEDICAL ALLOWANCE</td>
                                                        <td class="lableValues Labels" style="width:30%; text-align: right;">{{number_format($salaryDivisions['medical_allowance'],2)}}</td>
                                                        <td class="lableValues Labels" style="width:30%; text-align: right;padding-right:3px">{{number_format($salaryDivisions['medical_allowance'],2)}}</td>
                                                    </tr>
                                                    <tr style="padding-left:3px;">
                                                        <td class="lableValues Labels" style="width:40%; text-align: left;">SPECIAL ALLOWANCE</td>
                                                        <td class="lableValues Labels" style="width:30%; text-align: right;">{{number_format($salaryDivisions['special_allowance'],2)}}</td>
                                                        <td class="lableValues Labels" style="width:30%; text-align: right;padding-right:3px">{{number_format($salaryDivisions['special_allowance'],2)}}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td class="w-50 p-0" style="width:50%;border-top: 1px solid #000;vertical-align: top;">
                                                <table style="width:100%; table-layout: fixed; border-collapse: collapse;">
                                                    <tr style="padding-right:3px;">
                                                        <td class="lableValues Labels" style="width:50%; text-align: left;">PF</td>
                                                        <td class="lableValues Labels" style="width:50%; text-align: right;padding-right:3px">{{number_format($salaryDivisions['pf'],2)}}</td>

                                                    </tr>
                                                    <tr style="padding-right:3px;">
                                                        <td class="lableValues Labels" style="width:50%; text-align: left;">ESI</td>
                                                        <td class="lableValues Labels" style="width:50%; text-align: right;padding-right:3px">{{number_format($salaryDivisions['esi'],2)}}</td>

                                                    </tr>
                                                    <tr style="padding-right:3px;">
                                                        <td class="lableValues Labels" style="width:50%; text-align: left;">PROF TAX</td>
                                                        <td class="lableValues Labels" style="width:50%; text-align: right;padding-right:3px">{{number_format($salaryDivisions['professional_tax'],2)}}</td>

                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="w-50 p-0" style="width:50%; border-top: 1px solid #000; border-right: 1px solid #000;">
                                                <table style="width:100%; table-layout: fixed; border-collapse: collapse;">
                                                    <tr style="padding-right:3px;">
                                                        <td class="lableValues Labels" style="width:40%; text-align: left;">Total Earnings:INR.</td>
                                                        <td class="lableValues Labels" style="width:30%; text-align: right;">{{number_format($salaryDivisions['earnings'],2)}}</td>
                                                        <td class="lableValues Labels" style="width:30%; text-align: right;padding-right:3px">{{number_format($salaryDivisions['earnings'],2)}}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td class="w-50 p-0" style="width:50%;border-top: 1px solid #000;vertical-align: top;">
                                                <table style="width:100%; table-layout: fixed; border-collapse: collapse;">
                                                    <tr style="padding-right:3px;">
                                                        <td class="lableValues Labels" style="width:70%; text-align: left;">Total Deductions:INR.</td>
                                                        <td class="lableValues Labels" style="width:30%; text-align: right;padding-right:3px">{{number_format($salaryDivisions['total_deductions'],2)}}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div style="border: 1px solid #000; width: 100%;border-top:none;">
                            <p class="text-start" style="font-size:11px;width:100%;padding-left:3px;margin-bottom:0px; "> Net Pay for the month ( Total Earnings - Total Deductions): <span style="font-weight: 600;">{{ number_format($salaryDivisions['net_pay'],2)}}</span></p>
                            <p class="text-start" style="font-size:11px;width:100%;padding-left:3px;margin-bottom:0px;">(Rupees {{$rupeesInText}} only) </p>
                        </div>
                        <p style="font-size: 11px;text-align: center;">
                            This is a system generated payslip and does not require signature
                        </p>
                    </div>
                </div>
                <div class="d-flex justify-content-center p-3" style="gap: 10px;">
                    <!-- <button type="button" class="submit-btn mr-3" wire:click="confirmLogout">Logout</button> -->
                    <button type="button" class="submit-btn" wire:click="downloadPdf('{{\Carbon\Carbon::parse($salMonth)->format('Y-m') }}')">Download</button>
                    <button type="button" class="cancel-btn1" wire:click="cancel">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif

    <script>
        function togglePdf(containerId) {
            var container = document.getElementById(containerId);
            var icon = document.querySelector(`[onclick="togglePdf('${containerId}')"] i`);

            if (container.style.display === 'none' || container.style.display === '') {
                container.style.display = 'flex'; // Show container
                icon.classList.remove('fa-caret-right');
                icon.classList.add('fa-caret-down');
            } else {
                container.style.display = 'none'; // Hide container
                icon.classList.remove('fa-caret-down');
                icon.classList.add('fa-caret-right');
            }
        }
    </script>



</div>
