<div class="container-it" style="width:100%;padding:10px">

    <style>
        .cards {
            padding: 10px 10px;
            margin-top: 0px;
            border-radius: 2px;
            border: 1px solid silver;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }

        .card-main-text {
            font-weight: 500;
            font-size: 13px;
        }

        .totalamount {
            font-size: 13px;
        }

        p {
            margin: 0px;
        }

        .click_text {
            font-size: 10px;
            display: none;
        }

        .cards:hover .click_text {
            display: inline;
        }

        .toggleIcon {
            width: 5px;
        }

        .simple-cards {
            background-color: #a3b2c733;
            cursor: text;
            font-size: 13px;
        }

        .header_items {
            width: 150px;
            padding: 10px 20px;
            font-size: 13px;
            font-weight: 500;
            color: grey;

        }

        .header_items,
        td {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            text-align: end;
            border-bottom: none;
        }

        .ytd-columns {
            background-color: white;
        }

        .ytd-rows:hover,
        .ytd-rows:hover .ytd-columns {
            background-color: #eaf0f6;
        }
    </style>

    @if ($salaryRevision->isEmpty())
    <div style="align-items:center;justify-content:center;">
        <div class="homeCard6" style="width:80%;justify-content:center;align-items:center">
            <div class="py-2 px-3" style="height:400px;justify-content:center">
                <div class="d-flex justify-content-center">
                    <p style="font-size:20px;color:#778899;font-weight:500;align-items:center">IT Statements</p>

                </div>

                <div style="display:flex;align-items:center;flex-direction:column;">
                    <img src="https://th.bing.com/th/id/OIP.pdoKODCp_FelHFj7crhbCwHaEK?w=316&h=180&c=7&r=0&o=5&dpr=1.5&pid=1.7" alt="" style="height:300px;width:300px;">
                    <p style="color: #677A8E;  margin-bottom: 20px; font-size:12px;"> We are currently working on your IT Statements!</p>
                </div>
            </div>
        </div>
    </div>
    @else
    <div>
        <div class="d-flex justify-content-end">
            <button id="pdfLink2023_4" class="pdf-download btn-primary px-3 rounded ml-9" download style="display: inline-block;background:rgb(2, 17, 79); color:white"><i class="fas fa-download"></i></button>
        </div>
        <div class="row p-0 mt-2 mb-5 text-center m-0 d-flex align-items-center" style="margin: 0 auto;justify-content:space-evenly ">
            <div class="col-md-2 p-0 ml-2 mr-1 bg-white mb-3 mb-md-0" style="height:100px; border-radius: 5px;border:1px solid silver;width:160px">
                <p style="font-size:10px;color:#778899;margin-top:5px;margin-bottom:5px">TAX CALCULATED AS PER</p>
                <div style="padding:0;border-bottom:1px solid #ccc;margin-bottom:7px;"></div>
                <p style="font-size:12px;color:#41CD2A;">NEW TAX REGIME</p>
            </div>
            <div class="col-md-2 p-0 ml-2 mr-1 bg-white mb-3 mb-md-0" style="height:100px; border-radius: 5px;border:1px solid silver; width:160px">
                <p style="font-size:10px;color:#778899;margin-top:5px;margin-bottom:5px">NET TAX IN ₹</p>
                <div style="padding:0;border-bottom:1px solid #ccc;margin-bottom:7px;"></div>
                <strong style="font-size:15px;">0.00</strong>
            </div>
            <div class="col-md-2 p-0 ml-2 mr-1 bg-white mb-3 mb-md-0" style="height:100px; border-radius: 5px;border:1px solid silver;width:160px">
                <p style="font-size:10px;color:#778899;margin-top:5px;margin-bottom:5px">TOTAL TAX DUE IN ₹</p>
                <div style="padding:0;border-bottom:1px solid #ccc;margin-bottom:7px;"></div>
                <strong style="font-size:15px;">0.00</strong>
            </div>
            <div class="col-md-3 p-0 ml-2 mr-1 bg-white mb-3 mb-md-0" style="height:100px; border-radius: 5px;border:1px solid silver;width:160px">
                <p style="font-size:10px;color:#778899;margin-top:5px;margin-bottom:5px">TAX DEDUCTIBLE PER MONTH IN ₹</p>
                <div style="padding:0;border-bottom:1px solid #ccc;margin-bottom:7px;"></div>
                <strong style="font-size:15px;">0.00</strong>

            </div>
            <div class="col-md-3 p-0 ml-2 mr-1 bg-white mb-3 mb-md-0" style="height:100px; border-radius: 5px;border:1px solid silver;width:160px">
                <p style="font-size:10px;color:#778899;margin-top:5px;margin-bottom:5px;text-transform: uppercase;">Remaining Months (Dec 2024 onwards)</p>
                <div style="padding:0;border-bottom:1px solid #ccc;margin-bottom:7px;"></div>
                <strong style="font-size:15px;">4</strong>
            </div>
        </div>
        <div class="d-flex " style="align-items: center;">
            <a href="#" onclick='' id="collapseExpandBtn" style="width:100px;">Expand all</a>
            <p style="text-align:end;white-space: nowrap;width:100%;margin:0px; font-size: 13px;">Value in ₹</p>
        </div>
    </div>
    <div class="row bg-white ml-2 mt-1">

        <div id="expandButton" class="col-md-12 bg-white d-flex text-center cards">
            <span class="card-main-text"><span class="mx-2 toggleIcon" style="width: 10px; display: inline-block;">+</span> A. Income </span>
            <span class="click_text">click to view breakdown </span>
            <span class="totalamount">₹{{$totals['gross']}}</span>
        </div>
    </div>
    <div id="incomeContainers" class="income-containers row" style="display: none;">

        <div class="table-responsive mt-2" style="overflow-x: auto;   background-color: white;padding:0px">
            <table style="border-collapse: collapse; width:100%">
                <thead>
                    <tr style="border-bottom: 1px solid #c5bfbf !important;border-top: 1px solid #c5bfbf !important; background-color:#c3daf3">
                        <th class="p-0" colspan="2" style="padding: 0; position: sticky; left: 0; background-color: transparent;  height: 100%;">
                            <div style="display: flex; background-color:  #c3daf3; width: 100%; height: 100%;border-right: 1px solid #c5bfbf;">
                                <div class="header_items" style="flex: 1; text-align: left; padding-left: 10px; display: flex; align-items: center;">
                                    Item
                                </div>
                                <div class="header_items" style=" text-align: right; padding-right: 10px; display: flex; align-items: center;">
                                    Total In ₹.
                                </div>
                            </div>
                        </th>
                        @foreach(array_keys($salaryData) as $month)
                        <th class="header_items" style="width: 100px;">{{\Carbon\Carbon::parse($month)->format('M Y') }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr class="ytd-rows" style="border-top: 1px solid #c5bfbf !important;border-bottom: 1px solid #c5bfbf !important;">
                        <td style="font-weight:700; font-size:15px ;text-align:left;position: sticky; left: 0; background-color: white; z-index: 2;padding:0px"> <span style="align-items: center;display: flex; gap: 5px;padding:10px"><i id="expandIncome" style="cursor: pointer;" class="fas fa-sort-down"></i> Monthly Income</span></td>
                    </tr>

                    <tr class="income-rows p-0 ytd-rows" style="border-top: 1px solid #c5bfbf !important">
                        <td class="p-0" colspan="2" style="padding: 0; position: sticky; left: 0; background-color: transparent;  height: 100%;">
                            <div class="ytd-columns" style="display: flex; width: 100%; height: 100%; border-right: 1px solid #c5bfbf;padding:10px">
                                <div style="flex: 1; text-align: left; padding-left: 10px; display: flex; align-items: center;">
                                    Basic
                                </div>
                                <div style=" text-align: right; padding-right: 10px; display: flex; align-items: center;">
                                    {{$totals['basic']}}
                                </div>
                            </div>
                        </td>

                        @foreach($salaryData as $data)
                        <td style="width: 100px;">{{ $data['basic'] }}</td>
                        @endforeach

                    </tr>
                    <tr class="income-rows p-0 ytd-rows">
                        <td class="p-0" colspan="2" style="padding: 0; position: sticky; left: 0; background-color: transparent;  height: 100%;">
                            <div class="ytd-columns" style="display: flex; width: 100%; height: 100%; border-right: 1px solid #c5bfbf;padding:10px">
                                <div style="flex: 1; text-align: left; padding-left: 10px; display: flex; align-items: center;">
                                    HRA
                                </div>
                                <div style=" text-align: right; padding-right: 10px; display: flex; align-items: center;">
                                    {{$totals['hra']}}
                                </div>
                            </div>
                        </td>
                        @foreach($salaryData as $data)
                        <td style="width: 100px;">{{ $data['hra'] }}</td>
                        @endforeach
                    </tr>
                    <tr class="income-rows p-0 ytd-rows">
                        <td class="p-0" colspan="2" style="padding: 0; position: sticky; left: 0; background-color: transparent;  height: 100%;">
                            <div class="ytd-columns" style="display: flex; width: 100%; height: 100%; border-right: 1px solid #c5bfbf;padding:10px">
                                <div style="flex: 1; text-align: left; padding-left: 10px; display: flex; align-items: center;">
                                    Conveyance
                                </div>
                                <div style=" text-align: right; padding-right: 10px; display: flex; align-items: center;">
                                    {{$totals['conveyance']}}
                                </div>
                            </div>
                        </td>
                        @foreach($salaryData as $data)
                        <td style="width: 100px;">{{ $data['conveyance'] }}</td>
                        @endforeach
                    </tr>
                    <tr class="income-rows p-0 ytd-rows">

                        <td class="p-0" colspan="2" style="padding: 0; position: sticky; left: 0; background-color: transparent;  height: 100%;">
                            <div class="ytd-columns" style="display: flex; width: 100%; height: 100%; border-right: 1px solid #c5bfbf;padding:10px">
                                <div style="flex: 1; text-align: left; padding-left: 10px; display: flex; align-items: center;">
                                    Medical Allowance
                                </div>
                                <div style=" text-align: right; padding-right: 10px; display: flex; align-items: center;">
                                    {{$totals['medical_allowance']}}
                                </div>
                            </div>
                        </td>


                        @foreach($salaryData as $data)
                        <td style="width: 100px;">{{ $data['medical_allowance'] }}</td>
                        @endforeach
                    </tr>
                    <tr class="income-rows p-0 ytd-rows">

                        <td class="p-0" colspan="2" style="padding: 0; position: sticky; left: 0; background-color: transparent;  height: 100%;">
                            <div class="ytd-columns" style="display: flex;  width: 100%; height: 100%; border-right: 1px solid #c5bfbf;padding:10px">
                                <div style="flex: 1; text-align: left; padding-left: 10px; display: flex; align-items: center;">
                                    Special Allowance
                                </div>
                                <div style=" text-align: right; padding-right: 10px; display: flex; align-items: center;">
                                    {{$totals['special_allowance']}}
                                </div>
                            </div>
                        </td>

                        @foreach($salaryData as $data)
                        <td style="width: 100px;">{{ $data['special_allowance'] }}</td>
                        @endforeach
                    </tr>
                    <tr class="income-rows p-0 ytd-rows" style="background-color: #e9f0f8;font-weight:500;">


                        <td class="p-0" colspan="2" style="padding: 0; position: sticky; left: 0; background-color: transparent;  height: 100%;">
                            <div class="ytd-columns" style="display: flex; background-color:  #e9f0f8; width: 100%; height: 100%; border-right: 1px solid #c5bfbf;padding:10px">
                                <div style="flex: 1; text-align: left; padding-left: 10px; display: flex; align-items: center;">
                                    Sub Total
                                </div>
                                <div style=" text-align: right; padding-right: 10px; display: flex; align-items: center;">
                                    {{$totals['gross']}}
                                </div>
                            </div>
                        </td>


                        @foreach($salaryData as $data)
                        <td style="width: 100px;">{{ $data['gross'] }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row bg-white ml-2 mt-1 ">

        <div id="expandButton2" class="col-md-12 bg-white d-flex text-center cards">
            <span class="card-main-text"><span class="mx-2 toggleIcon" style="width: 10px; display: inline-block;">+</span>B. Deductions</span>
            <span class="click_text">click to view breakdown </span>
            <span class="totalamount">₹{{$totals['total_deductions']}}</span>
        </div>
    </div>
    <div id="incomeContainer2" class="income-container2 row" style="display: none;">
        <div class="table-responsive mt-2" style="overflow-x: auto;   background-color: white;padding:0px">
            <table style="border-collapse: collapse; width:100%">
                <thead>
                    <tr style="border-bottom: 1px solid #c5bfbf !important;border-top: 1px solid #c5bfbf !important; background-color:#c3daf3">


                        <th class="p-0" colspan="2" style="padding: 0; position: sticky; left: 0; background-color: transparent;  height: 100%;">
                            <div style="display: flex; background-color:  #c3daf3; width: 100%; height: 100%;border-right: 1px solid #c5bfbf;">
                                <div class="header_items" style="flex: 1; text-align: left; padding-left: 10px; display: flex; align-items: center;">
                                    Item
                                </div>
                                <div class="header_items" style=" text-align: right; padding-right: 10px; display: flex; align-items: center;">
                                    Total In ₹.
                                </div>
                            </div>
                        </th>
                        @foreach(array_keys($salaryData) as $month)
                        <th class="header_items" style="width: 100px;">{{\Carbon\Carbon::parse($month)->format('M Y') }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr class="deduction_row ytd-rows">
                        <td class="p-0" colspan="2" style="padding: 0; position: sticky; left: 0; background-color: transparent;  height: 100%;">
                            <div class="ytd-columns" style="display: flex;  width: 100%; height: 100%; border-right: 1px solid #c5bfbf;padding:10px">
                                <div style="flex: 1; text-align: left; padding-left: 10px; display: flex; align-items: center;">
                                    PF
                                </div>
                                <div style=" text-align: right; padding-right: 10px; display: flex; align-items: center;">
                                    {{$totals['pf']}}
                                </div>
                            </div>
                        </td>
                        @foreach($salaryData as $data)
                        <td style="width: 100px;">{{ $data['pf'] }}</td>
                        @endforeach
                    </tr>
                    <tr class="deduction_row ytd-rows">
                        <td class="p-0" colspan="2" style="padding: 0; position: sticky; left: 0; background-color: transparent;  height: 100%;">
                            <div class="ytd-columns" style="display: flex; width: 100%; height: 100%; border-right: 1px solid #c5bfbf;padding:10px">
                                <div style="flex: 1; text-align: left; padding-left: 10px; display: flex; align-items: center;">
                                    Prof Tax
                                </div>
                                <div style=" text-align: right; padding-right: 10px; display: flex; align-items: center;">
                                    {{$totals['professional_tax']}}
                                </div>
                            </div>
                        </td>

                        @foreach($salaryData as $data)
                        <td style="width: 100px;">{{ $data['professional_tax'] }}</td>
                        @endforeach
                    </tr>
                    <tr class="deduction_row" style="background-color: #e9f0f8;font-weight:500 ;border-bottom:1px solid #c5bfbf ">

                        <td class="p-0" colspan="2" style="padding: 0; position: sticky; left: 0; background-color: transparent;  height: 100%;">
                            <div style="display: flex; background-color:  #e9f0f8; width: 100%; height: 100%; border-right: 1px solid #c5bfbf;padding:10px">
                                <div style="flex: 1; text-align: left; padding-left: 10px; display: flex; align-items: center;">
                                    Total
                                </div>
                                <div style=" text-align: right; padding-right: 10px; display: flex; align-items: center;">
                                    {{$totals['total_deductions']}}
                                </div>
                            </div>
                        </td>
                        @foreach($salaryData as $data)
                        <td style="width: 100px;">{{ $data['total_deductions'] }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row bg-white ml-2 mt-1">
        <div id="expandButton3" class="col-md-12 bg-white d-flex text-center cards">
            <span class="card-main-text"><span class="mx-2 toggleIcon" style="width: 10px; display: inline-block;">+</span>C. Perquisites</span>
            <span class="click_text">click to view breakdown </span>
            <span class="totalamount">₹0.00</span>
        </div>
    </div>
    <div id="incomeContainer3" class="income-container3" style="display: none;">
        <div class="row">
            <div class="col-md-12 mt-2 ml-2 text-center bg-white  justify-content-center ">
                <p class="pt-2" style="height:40px;background:white; font-size: 13px;">No data to display !!!</p>
            </div>
        </div>
    </div>

    <div class="row bg-white ml-2 mt-1 ">
        <div id="expandButton4" class="col-md-12 bg-white d-flex text-center cards">
            <span class="card-main-text"><span class="mx-2 toggleIcon" style="width: 10px; display: inline-block;">+</span>D. Income Excluded From Tax</span>
            <span class="click_text">click to view breakdown </span>
            <span class="totalamount">₹0.00</span>
        </div>
    </div>

    <div id="incomeContainer4" class="income-container4" style="display: none;">
        <div class="row">
            <div class="col-md-12 mt-2 ml-2 text-center bg-white  justify-content-center ">
                <p class="pt-2" style="height:40px;background:white; font-size: 13px;">No data to display !!!</p>
            </div>
        </div>
    </div>
    <div class="row bg-white  mt-1 ">
        <div class="col-md-12  m-l-2 d-flex cards simple-cards" style=" border-radius:2px;border:1px solid silver;">
            <span class="card-main-text  mx-4">E. Gross Salary (A + C - D)</span>
            <p class="totalamount">₹{{$totals['gross']}}</p>
        </div>
    </div>
    <div class="row bg-white ml-2 mt-1 ">
        <div id="expandButton5" class="col-md-12 bg-white d-flex text-center cards">
            <span class="card-main-text"><span class="mx-2 toggleIcon" style="width: 10px; display: inline-block;">+</span>
                F. Exemption Under Section 10</span>
            <span class="click_text">click to view breakdown </span>
            <span class="totalamount">₹</span>
        </div>
    </div>
    <div id="incomeContainer5" class="income-container5 row" style="display: none;">
        <table  class="mt-1" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;border:1px solid silver">
            <thead>
                <!-- First Header Row -->
                <tr style="background-color: #c3daf3;">
                    <th colspan="2" style="text-align: left; padding: 10px; font-size:11px ;font-weight:500">Items</th>
                    <th style="text-align: right; padding: 10px;font-size:11px ;font-weight:500">Exemption</th>
                </tr>
                <!-- Second Header Row -->
                <tr style="border:1px solid silver">
                    <th style="text-align: left; padding: 10px;font-size:11px;font-weight:500">HOUSE RENT ALLOWANCE : SECTION10(13A)</th>
                    <th style="text-align: right; color: #007bff; cursor: pointer; padding: 10px;font-size:11px;border-right:1px solid silver">Show HRA Details</th>
                    <th style="text-align: right; padding: 10px;font-size:11px">0.00</th>
                </tr>
            </thead>
            <tbody>
                <!-- Body Rows -->
                <tr>
                    <td style="padding: 10px;text-align: left;">TOTAL RENT PAID P.A.</td>
                    <td style="padding: 10px; text-align: right;border-right:1px solid silver">0</td>
                    <td style="padding: 10px; text-align: right;"></td>
                </tr>
                <tr>
                    <td style="padding: 10px;text-align: left;">HRA RECEIVED</td>
                    <td style="padding: 10px; text-align: right;border-right:1px solid silver">0</td>
                    <td style="padding: 10px; text-align: right;"></td>
                </tr>
            </tbody>
            <tr>
                <td style="padding: 10px;text-align: left;">40% OF BASIC</td>
                <td style="padding: 10px; text-align: right;border-right:1px solid silver">0</td>
                <td style="padding: 10px; text-align: right;"></td>
            </tr>
            <tr>
                <td style="padding: 10px;text-align: left;">RENT PAID > 10% BASIC</td>
                <td style="padding: 10px; text-align: right;border-right:1px solid silver">0</td>
                <td style="padding: 10px; text-align: right;"></td>
            </tr>
        </table>

    </div>
    <div class="row bg-white ml-2 mt-1 ">
        <div id="expandButton6" class="col-md-12 bg-white d-flex text-center cards">
            <span class="card-main-text"><span class="mx-2 toggleIcon" style="width: 10px; display: inline-block;">+</span>G. Income From Previous Employer </span>
            <span class="click_text">click to view breakdown </span>
            <span class="totalamount">₹</span>
        </div>
    </div>
    <div id="incomeContainer6" class="income-container5 row" style="display: none;">
        <table  class="mt-1" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;border:1px solid silver">
            <thead>
                <!-- First Header Row -->
                <tr style="background-color: #c3daf3;">
                    <th  style="text-align: left; padding: 10px; font-size:11px ;font-weight:500">Items</th>
                    <th style="text-align: right; padding: 10px;font-size:11px ;font-weight:500">Amount</th>
                </tr>

            </thead>
            <tbody>
                <!-- Body Rows -->
                <tr>
                    <td style="padding: 10px;text-align: left;">TOTAL INCOME</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                </tr>
                <tr>
                    <td style="padding: 10px;text-align: left;">INCOME TAX</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                </tr>
            </tbody>
            <tr>
                <td style="padding: 10px;text-align: left;">PROFESSIONAL TAX</td>
                <td style="padding: 10px; text-align: right;">0.00</td>
            </tr>
            <tr>
                <td style="padding: 10px;text-align: left;">PROVIDENT FUND</td>
                <td style="padding: 10px; text-align: right;">0.00</td>
            </tr>
        </table>

    </div>
    <div class="row bg-white  mt-1 ">
        <div class="col-md-12  m-l-2 d-flex cards simple-cards" style=" border-radius:2px;border:1px solid silver;">
            <span class="card-main-text  mx-4">H. Income After Exemption(E - F + G)</span>
            <p class="totalamount">₹</p>
        </div>
    </div>

    <div class="row bg-white ml-2 mt-1 ">
        <div id="expandButton7" class="col-md-12 bg-white d-flex text-center cards">
            <span class="card-main-text"><span class="mx-2 toggleIcon" style="width: 10px; display: inline-block;">+</span>I. Less Deduction under Section 16</span>
            <span class="click_text">click to view breakdown </span>
            <span class="totalamount">₹ 75,000.00</span>
        </div>
    </div>
    <div id="incomeContainer7" class="income-container5 row" style="display: none;">
        <table  class="mt-1" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;border:1px solid silver">
            <thead>
                <!-- First Header Row -->
                <tr style="background-color: #c3daf3;">
                    <th  style="text-align: left; padding: 10px; font-size:11px ;font-weight:500">Items</th>
                    <th style="text-align: right; padding: 10px;font-size:11px ;font-weight:500">Amount</th>
                </tr>

            </thead>
            <tbody>
                <!-- Body Rows -->
                <tr>
                    <td style="padding: 10px;text-align: left;">TAX ON EMPLOYMENT : SEC 16(III)</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                </tr>
                <tr>
                    <td style="padding: 10px;text-align: left;">STANDARD DEDUCTION : SEC 16(IA)</td>
                    <td style="padding: 10px; text-align: right;">75,000.00</td>
                </tr>
            </tbody>

        </table>

    </div>
    <div class="row bg-white  mt-1 ">
        <div class="col-md-12  m-l-2 d-flex cards simple-cards" style=" border-radius:2px;border:1px solid silver;">
            <span class="card-main-text  mx-4">J. Income Chargeable Under The Head Salaries(H - I)</span>
            <p class="totalamount">₹</p>
        </div>
    </div>
    <div class="row bg-white ml-2 mt-1 ">
        <div id="expandButton8" class="col-md-12 bg-white d-flex text-center cards">
            <span class="card-main-text"><span class="mx-2 toggleIcon" style="width: 10px; display: inline-block;">+</span>
                K. Income From Other Sources (Including House Properties)</span>
            <span class="click_text">click to view breakdown </span>
            <span class="totalamount">₹</span>
        </div>
    </div>
    <div class="row bg-white  mt-1 ">
        <div class="col-md-12  m-l-2 d-flex cards simple-cards" style=" border-radius:2px;border:1px solid silver;">
            <span class="card-main-text  mx-4">L. Gross Total Income (J + K)</span>
            <p class="totalamount">₹</p>
        </div>
    </div>
    <div class="row bg-white ml-2 mt-1 ">
        <div id="expandButton9" class="col-md-12 bg-white d-flex text-center cards">
            <span class="card-main-text"><span class="mx-2 toggleIcon" style="width: 10px; display: inline-block;">+</span>
                M. Deduction Under Chapter VI A</span>
            <span class="click_text">click to view breakdown </span>
            <span class="totalamount">₹</span>
        </div>
    </div>
    <div id="incomeContainer9" class="income-container3" style="display: none;">
        <div class="row">
            <div class="col-md-12 mt-2 ml-2 text-center bg-white  justify-content-center ">
                <p class="pt-2" style="height:40px;background:white; font-size: 13px;">No data to display !!!</p>
            </div>
        </div>
    </div>
    <div class="row bg-white  mt-1 ">
        <div class="col-md-12  m-l-2 d-flex cards simple-cards" style=" border-radius:2px;border:1px solid silver;">
            <span class="card-main-text  mx-4">N. Taxable Income (L - M)</span>
            <p class="totalamount">₹</p>
        </div>
    </div>
    <div class="row bg-white ml-2 mt-1 ">
        <div id="expandButton10" class="col-md-12 bg-white d-flex text-center cards">
            <span class="card-main-text"><span class="mx-2 toggleIcon" style="width: 10px; display: inline-block;">+</span>
                O. Annual Tax</span>
            <span class="click_text">click to view breakdown </span>
            <span class="totalamount">₹</span>
        </div>
    </div>
    <div id="incomeContainer10" class="income-container5 row" style="display: none;">
        <table  class="mt-1" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;border:1px solid silver">
            <thead>
                <!-- First Header Row -->
                <tr style="background-color: #c3daf3;">
                    <th  style="text-align: left; padding: 10px; font-size:11px ;font-weight:500">Raw Tax</th>
                    <th style="text-align: right; padding: 10px;font-size:11px ;font-weight:500">Surcharge</th>
                    <th style="text-align: right; padding: 10px;font-size:11px ;font-weight:500">Health & Edu.Cess</th>
                    <th style="text-align: right; padding: 10px;font-size:11px ;font-weight:500">Total</th>
                </tr>

            </thead>
            <tbody>
                <!-- Body Rows -->
                <tr>
                    <td style="padding: 10px;text-align: left;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                </tr>

            </tbody>

        </table>

    </div>
    <div class="row bg-white ml-2 mt-1 ">
        <div id="expandButton11" class="col-md-12 bg-white d-flex text-center cards">
            <span class="card-main-text"><span class="mx-2 toggleIcon" style="width: 10px; display: inline-block;">+</span>
                P. Tax Paid Till Date</span>
            <span class="click_text">click to view breakdown </span>
            <span class="totalamount">₹</span>
        </div>
    </div>
    <div id="incomeContainer11" class="income-container5 row" style="display: none;">
        <table  class="mt-1" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;border:1px solid silver">
            <thead>
                <!-- First Header Row -->
                <tr style="background-color: #c3daf3;">
                    <th  style="text-align: left; padding: 10px; font-size:11px ;font-weight:500">Item</th>
                    <th  style="text-align: right; padding: 10px; font-size:11px ;font-weight:500">Raw Tax</th>
                    <th style="text-align: right; padding: 10px;font-size:11px ;font-weight:500">Surcharge</th>
                    <th style="text-align: right; padding: 10px;font-size:11px ;font-weight:500">Health & Edu.Cess</th>
                    <th style="text-align: right; padding: 10px;font-size:11px ;font-weight:500">Total</th>
                </tr>

            </thead>
            <tbody>
                <!-- Body Rows -->
                <tr>
                    <td style="padding: 10px;text-align: left;">Deduction Through Payroll</td>
                    <td style="padding: 10px;text-align: right;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                </tr>
                <tr>
                    <td style="padding: 10px;text-align: left;">Direct TDS</td>
                    <td style="padding: 10px;text-align: right;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                </tr>
                <tr>
                    <td style="padding: 10px;text-align: left;">Previous Employment</td>
                    <td style="padding: 10px;text-align: right;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                </tr>
                <tr style="background-color: #dfe8ee ;">
                    <td style="padding: 10px;text-align: left;">Total</td>
                    <td style="padding: 10px;text-align: right;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                </tr>

            </tbody>

        </table>

    </div>
    <div class="row bg-white ml-2 mt-1 ">
        <div id="expandButton12" class="col-md-12 bg-white d-flex text-center cards">
            <span class="card-main-text"><span class="mx-2 toggleIcon" style="width: 10px; display: inline-block;">+</span>
                Q. Balance Payable</span>
            <span class="click_text">click to view breakdown </span>
            <span class="totalamount">₹</span>
        </div>
    </div>
    <div id="incomeContainer12" class="income-container5 row" style="display: none;">
        <table  class="mt-1" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;border:1px solid silver">
            <thead>
                <!-- First Header Row -->
                <tr style="background-color: #c3daf3;">
                    <th  style="text-align: left; padding: 10px; font-size:11px ;font-weight:500">Raw Tax</th>
                    <th style="text-align: right; padding: 10px;font-size:11px ;font-weight:500">Surcharge</th>
                    <th style="text-align: right; padding: 10px;font-size:11px ;font-weight:500">Health & Edu.Cess</th>
                    <th style="text-align: right; padding: 10px;font-size:11px ;font-weight:500">Total</th>
                </tr>

            </thead>
            <tbody>
                <!-- Body Rows -->
                <tr>
                    <td style="padding: 10px;text-align: left;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                </tr>

            </tbody>

        </table>

    </div>


    <div class="row bg-white ml-2 mt-1 ">

        <div id="expandButton13" class="col-md-12 bg-white d-flex text-center cards">
            <span class="card-main-text"><span class="mx-2 toggleIcon" style="width: 10px; display: inline-block;">+</span>
                R. TDS Recovered in Current Month</span>
            <span class="click_text">click to view breakdown </span>
            <span class="totalamount">₹</span>
        </div>
    </div>
    <div id="incomeContainer13" class="income-container5 row" style="display: none;">
        <table  class="mt-1" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;border:1px solid silver">
            <thead>
                <!-- First Header Row -->
                <tr style="background-color: #c3daf3;">
                    <th colspan="4" style="text-align: left; padding: 10px; font-size:11px ;font-weight:500">(i) Monthly tax</th>
                </tr>
                <tr style="background-color: #c3daf3;">
                    <th  style="text-align: left; padding: 10px; font-size:11px ;font-weight:500">Raw Tax</th>
                    <th style="text-align: right; padding: 10px;font-size:11px ;font-weight:500">Surcharge</th>
                    <th style="text-align: right; padding: 10px;font-size:11px ;font-weight:500">Health & Edu.Cess</th>
                    <th style="text-align: right; padding: 10px;font-size:11px ;font-weight:500">Total</th>
                </tr>

            </thead>
            <tbody>
                <!-- Body Rows -->
                <tr>
                    <td style="padding: 10px;text-align: left;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                    <td style="padding: 10px; text-align: right;">0.00</td>
                </tr>

            </tbody>

        </table>

    </div>
</div>
@endif
<script>
    function toggleVisibility(buttonId, containerId) {
        const button = document.getElementById(buttonId);
        const container = document.getElementById(containerId);

        const toggleIcon = button.querySelector('.toggleIcon');
        button.addEventListener('click', function() {
            if (container.style.display === 'none' || container.style.display === '') {
                container.style.display = 'block';
                toggleIcon.textContent = '-';
            } else {
                container.style.display = 'none';
                toggleIcon.textContent = '+';
            }
        });
    }

    // Call the function for each button-container pair
    toggleVisibility('expandButton', 'incomeContainers');
    toggleVisibility('expandButton2', 'incomeContainer2');
    toggleVisibility('expandButton3', 'incomeContainer3');
    toggleVisibility('expandButton4', 'incomeContainer4');
    toggleVisibility('expandButton5', 'incomeContainer5');
    toggleVisibility('expandButton6', 'incomeContainer6');
    toggleVisibility('expandButton7', 'incomeContainer7');
    toggleVisibility('expandButton8', 'incomeContainer8');
    toggleVisibility('expandButton9', 'incomeContainer9');
    toggleVisibility('expandButton10', 'incomeContainer10');
    toggleVisibility('expandButton11', 'incomeContainer11');
    toggleVisibility('expandButton12', 'incomeContainer12');
    toggleVisibility('expandButton13', 'incomeContainer13');


    document.getElementById('expandIncome').addEventListener('click', function() {
        let incomeRows = document.querySelectorAll('.income-rows');
        incomeRows.forEach(function(row) {
            row.style.display = row.style.display === 'none' ? '' : 'none';
        });
        this.classList.toggle('fa-sort-down');
        this.classList.toggle('fa-sort-up');
    });



    collapseExpandBtn.addEventListener('click', function() {
        const isExpandAll = collapseExpandBtn.textContent === 'Expand all';

        // Update button text
        collapseExpandBtn.textContent = isExpandAll ? 'Collapse all' : 'Expand all';

        // Select all expand buttons and income containers
        const expandButtons = document.querySelectorAll("[id^='expandButton']");
        const incomeContainers = document.querySelectorAll("[id^='incomeContainer']");

        // Loop through each container and toggle visibility
        incomeContainers.forEach((container, index) => {
            const expandButton = expandButtons[index];
            const toggleIcon = expandButton.querySelector('.toggleIcon');

            if (isExpandAll) {
                container.style.display = 'block';
                toggleIcon.textContent = '-';
            } else {
                container.style.display = 'none';
                toggleIcon.textContent = '+';
            }
        });
    });
</script>
</div>
