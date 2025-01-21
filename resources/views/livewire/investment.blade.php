<div class="container-fluid">
    <style>
        .side-page-nav-item {
            cursor: pointer;
            padding: 5px 10px;
            display: flex;
            align-items: center;
            height: 30px;
            /* font-size: 15px; */
            /* transition: all 0.3s ease; */
        }

        .prrofattachment {
            cursor: pointer;
            padding: 5px 10px;
            display: flex;
            align-items: center;
            height: 30px;
            /* font-size: 15px; */
            /* transition: all 0.3s ease; */
        }


        .side-page-nav-item.active {
            border-left: 3px solid black;
            /* Blue border for selected item */
            /* font-size: 15px; */
            /* Larger font size for selected item */
            background-color: #f8f9fa;
            /* Light background for better contrast */
            font-weight: bold;
            /* Bold text for emphasis */
            color: black;
        }

        .info {
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            /* Ensure it stays inline */
            white-space: nowrap;
            /* Prevent wrapping */
            overflow: hidden;
            /* Hide overflow */
            text-overflow: ellipsis;
            /* Show ellipsis for overflow */
            width: 100%;
            /* Set a width for the span to enforce truncation */
            max-width: 200px;
            /* Optional: Set a max width */
            cursor: pointer;
            /* Show pointer cursor for better UX */
            color: #9ca5ae;
        }

        .prrofattachment-text:hover {
            color: black;
        }

        .prrofattachment-text {
            color: #007bff;
        }

        .side-page-nav-item:hover {
            background-color: #e9ecef;
        }

        .side-page-nav-item.active .info {
            font-size: 13px;
            /* Increase font size for the info class in the active item */
            color: black;
        }

        .components_names {
            display: flex;
            justify-content: space-between;
            padding: 5px 10px;
            font-size: 13px;
            font-weight: 600;
            color: #7c8b9a;
            align-items: center;
            border-top: 1px solid silver
        }

        .components_arrows {
            font-weight: bold;
            color: #7c8b9a;
            font-size: 20px;
            cursor: pointer
        }

        .section-title {
            font-weight: bold;
            color: #747171;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
            font-size: 14px;
        }

        .row-item {
            border-bottom: 1px solid #dee2e6;
            padding: 10px 10px;
            display: flex;
            align-items: center;
            gap: 3px;
            color: #9ca5ae;
            font-size: 13px;
        }

        .info-icon {
            color: #3498db;
            font-size: 16px;
            cursor: pointer;
        }

        .code {
            font-weight: bold;
            color: #747171;
        }

        .color-text {
            color: #fda256;
        }

        /* sidepage styles */
        .side-page {
            position: fixed;
            top: 0;
            right: -100%;
            /* Hidden by default */
            width: 350px;
            height: 100%;
            background-color: #f4f4f4;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.3);
            overflow-y: auto;
            transition: right 0.3s ease;
            z-index: 1000;
        }

        .side-page-header {
            background-color: #e9eef4;
            color: #333;
            padding: 5px 16px;
            font-size: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }

        .side-page-header h2 {
            margin: 0;
            font-size: 18px;
        }

        .side-page-content {
            padding: 20px;
        }

        .side-page-content h6 {
            color: #778899;
            font-size: 13px;
        }

        .close-btn {
            font-size: 24px;
            cursor: pointer;
            color: #666;
            border: none;
            background: none;
        }

        .timeline {
            margin-top: 20px;
            position: relative;

            border-left: 2px solid #ddd;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
            padding-left: 20px;
        }

        .timeline-item .dot {
            position: absolute;
            top: 0;
            left: -9px;
            width: 16px;
            height: 16px;
            background-color: silver;
            border-radius: 50%;

            box-shadow: 0 0 0 2px #ddd;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -2px;
            top: 16px;
            /* Start below the dot */
            bottom: 0;
            width: 2px;
            background-color: #ddd;
        }

        .timeline-item:last-child::before {
            display: none;
            /* Remove the vertical line for the last dot */
        }

        .timeline-content {
            /* background-color: #f9f9f9; */
            /* border: 1px solid #ddd; */
            padding: 5px 5px;
            border-radius: 5px;
            /* box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); */
        }

        .timeline-content h5 {
            margin: 0;
            font-size: 14px;
            color: #333;
        }

        .timeline-content h5 span {
            font-size: 14px;
            color: #333;
        }

        .timeline-content p {
            margin: 5px 0 0;
            font-size: 12px;
            color: #777;
        }

        textarea {
            width: 100%;
            margin-top: 10px;
            padding: 8px;
            font-size: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            resize: none;
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            /* padding: 20px; */
            border-radius: 8px;
            width: 60%;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;

        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: white;
        }
        .member-remove-btn{
            border: none;
            background-color: white;
        }
        .form-add-buttons, .form-save-buttons{
            border:none;
            font-size: 15px;
            padding: 5px;
            background-color: rgb(2, 17, 79);
            color:white;
            border-radius: 5px;
            font-weight: 500;

        }
    </style>
    <div class="d-flex justify-content-end">
        <div class="investment dropdown3 justify-content-end" style="position: relative; display: flex; margin-right: 20px;gap:10px ;align-items:center">
            <a href="javascript:void(0)" onclick="openSidePage()" style="cursor: pointer;font-size:13px">POI Timeline</a>
            <select name="financial_year" id="financial_year" class="form-select" wire:model="selectedFinancialYear" wire:change='SelectedFinancialYear' style=" width: fit-content;">
                @foreach ($financialYears as $year)
                <option value="{{ $year['start_date'] }}|{{ $year['end_date'] }}">
                    {{ \Carbon\Carbon::parse($year['start_date'])->format('Y') }} - {{ \Carbon\Carbon::parse($year['end_date'])->format('Y') }}
                </option>
                @endforeach
            </select>

            <!-- sidepage  -->
            <div id="sidePage" class="side-page">
                <div class="side-page-header">
                    <h2>Review History</h2>
                    <span onclick="closeSidePage()" class="close-btn">&times;</span>
                </div>
                <div class="side-page-content">
                    <h6>Application Timeline</h6>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="dot"></div>
                            <div class="timeline-content" style="border-bottom: 1px solid silver;">
                                <h5>Under Review <span>by Raja</span></h5>
                                <p>08 Jan, 2025 13:34:27</p>
                                <input class="form-control" placeholder="Write comment"></input>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="dot"></div>
                            <div class="timeline-content">
                                <h5>Submitted <span>by Raja</span></h5>
                                <p>08 Jan, 2025 13:34:27</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="dot"></div>
                            <div class="timeline-content">
                                <h5>Considered for Payroll <span>by Raja</span></h5>
                                <p>08 Jan, 2025 13:15:44</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="dot"></div>
                            <div class="timeline-content">
                                <h5>Reviewed <span>by system</span></h5>
                                <p>21 Dec, 2024 05:48:33</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="dot"></div>
                            <div class="timeline-content">
                                <h5>Released <span>by Meena</span></h5>
                                <p>06 Nov, 2024 13:01:58</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" style="width:100%">
        <div class="col-md-12 mt-3  bg-white" style="border-bottom:1px solid silver;border-left:3px solid #007bff;padding:5px 10px">
            <div class=" d-flex justify-content-between" style="align-items:center">
                <h6 class="mt-3" id="poi-status" style="color: #778899; font-weight: 500; font-size: 12px;">
                    POI Status: <span id="selectedYear">2022 - 2023</span> : <span style="color:#fda256;">Pending for Review</span>
                </h6>
                <p class="" style="font-size: 12px; cursor: pointer; color: deepskyblue; font-weight: 500;" wire:click="toggleDetails">
                    {{ $showDetails ? 'Hide' : 'Info' }}
                </p>
            </div>
            @if ($showDetails)
            <p style="font-size:12px">Proof of investment is an yearly process, where you have to provide necessary document as a proof for your investments.</p>
            @endif
        </div>

        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-md-12 bg-white text-center mt-3" id="content-2022-2023" style="border-radius: 5px; border: 1px solid silver; display: none;">
                    <img src="https://th.bing.com/th/id/OIP.vwV51NMNZ8YgCdZ__BSFkQAAAA?pid=ImgDet&rs=1" class="img-fluid" style="height: 200px; width: auto;">
                    <p>Sigh! POI is not yet released</p>
                    <p style="font-size: 12px;">You can now seamlessly submit your investment proof here.</p>
                </div>
            </div>


            <div id="content-2023-2024">

                <div class=" d-flex" style="gap: 10px;">
                    <div class="col-md-2 p-0">
                        <div class="text-muted" style="height: fit-content;">
                            <p class="m-0" style="font-size: 13px;color:#aba7a7">POI COMPONENTS</p>
                        </div>
                        <ul class="side-page-nav mt-3" style="text-align:start; padding:0px">
                            @foreach ($items as $index => $item)
                            <li class="side-page-nav-item {{ $selectedItem === $item ? 'active' : '' }}"
                                wire:click="selectItem('{{ $item }}')">
                                <span class="info text-truncate" title="{{ $item }}">
                                    {{ $loop->iteration }}. {{ $item }}
                                </span>
                            </li>
                            @endforeach

                            <li class="prrofattachment {{ $selectedItem === 'Proof Attachment' ? 'active' : '' }}"
                                wire:click="selectItem('Proof Attachment')">
                                <span class="info prrofattachment-text  text-truncate" title=" Proof Attachment">
                                    Proof Attachment
                                </span>
                            </li>
                            <div class="text-muted" style="height: fit-content;">
                                <p class="m-0" style="font-size: 13px;color:#aba7a7">Summary</p>
                            </div>

                            <li class="side-page-nav-item {{ $selectedItem === 'Overview' ? 'active' : '' }}"
                                wire:click="selectItem('Overview')">
                                <span class="info text-truncate" title="Overview">
                                    Overview
                                </span>
                            </li>
                        </ul>
                    </div>

                    @if($selectedItem=='Overview')
                    <div class="col-md-10">
                        <div class="d-flex mt-4 " style="justify-content:end ;align-items:center">
                            <a href="/downloadform" id="pdfLink2023_4" class="pdf-download text-align-end" download style=" display: inline-block;font-size:14px">Download Form 12BB</a>
                        </div>
                        <div class="mt-2 ml-6 bg-white" style="border-radius:5px;border:1px solid silver;">
                            <div class="d-flex" style="flex-direction:column; border-top:none;align-items:center;padding:10px">
                                <div style="border:1.5px solid blue;border-radius: 50%;width: 20px;display: flex;justify-content: center;align-items: center;height: 20px;padding: 2px;">
                                    <i class="fa fa-info" style="color: blue;font-size:12px"></i>
                                </div>

                                <p class="m-0" style="font-size: 12px;">You have not declared any of the items.</p>
                            </div>
                            <div class="components_names">
                                <p class="m-0">Section 80C</p>
                                <a class="components_arrows" wire:click="selectItem('Section 80C')">&rarr; </a>
                            </div>

                            <div class="components_names">
                                <p class="m-0">Other Chapter VI-A Deductions</p>
                                <a class="components_arrows" wire:click="selectItem('Other Chapter VI-A Deductions')">&rarr; </a>
                            </div>

                            <div class="components_names">
                                <p class="m-0">House Rent Allowance</p>
                                <a class="components_arrows" wire:click="selectItem('House Rent Allowance')">&rarr; </a>
                            </div>
                            <div class="components_names">
                                <p class="m-0">Medical (Sec 80D)</p>
                                <a class="components_arrows" wire:click="selectItem('Medical (Sec 80D)')">&rarr; </a>
                            </div>

                            <div class="components_names">
                                <p class="m-0">Income/loss from House Property</p>
                                <a class="components_arrows" wire:click="selectItem('Income/loss from House Property')">&rarr; </a>
                            </div>


                            <div class="components_names">
                                <p class="m-0">Salary Allowance</p>
                                <a class="components_arrows" wire:click="selectItem('Salary Allowance')">&rarr; </a>
                            </div>

                            <div class="components_names">
                                <p class="m-0">Other Income</p>
                                <a class="components_arrows" wire:click="selectItem('Other Income')">&rarr; </a>
                            </div>
                            <div class="components_names">
                                <p class="m-0">TCS/TDS Deduction</p>
                                <a class="components_arrows" wire:click="selectItem('TCS/TDS Deduction')">&rarr; </a>
                            </div>
                        </div>
                    </div>
                    @elseif($selectedItem=='Section 80C')
                    <div class="col-md-10">

                        <div class="d-flex mt-4 " style="justify-content:space-between ;align-items:center">
                            <select name="financial_year" id="financial_year" class="form-select" style=" width: fit-content;">
                                <option value="all">All Items</option>
                                <option value="declared">Declared Items</option>

                            </select>
                            <a href="#" id="pdfLink2023_4" class="pdf-download text-align-end" wire:click="showFamilyDetails" style=" display: inline-block;font-size:14px">Family Details</a>
                            @if($show_family_details )
                            <div class="modal">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 >Family Details</h6>
                                        <button class="close-btn" wire:click="hideFamilyDetails">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <table style="width: 100%;border:1px solid silver">
                                            <thead style="background-color:#e9f7ff;width:100%">
                                                <tr style="gap: 10px;padding:5px">
                                                    <th style="padding: 5px;" >Name</th>
                                                    <th style="padding: 5px;">Relationship</th>
                                                    <th style="padding: 5px;">DOB</th>
                                                    <th style="padding: 5px;">Dependent</th>
                                                    <th style="padding: 5px;">Remove</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($familyMembers as $index => $member)
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control" wire:model="familyMembers.{{ $index }}.name">
                                                    </td>
                                                    <td>
                                                        <select wire:model="familyMembers.{{ $index }}.relationship" class="form-select">
                                                            <option value="Self">Self</option>
                                                            <option value="Father">Father</option>
                                                            <option value="Mother">Mother</option>
                                                            <option value="Spouse">Spouse</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="date" wire:model="familyMembers.{{ $index }}.dob">
                                                    </td>
                                                    <td>
                                                        <input  class="form-check-input" type="checkbox" wire:model="familyMembers.{{ $index }}.dependent"> Yes
                                                    </td>
                                                    <td>
                                                        <button class="member-remove-btn" wire:click="removeFamilyMember({{ $index }})">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="form-add-buttons" wire:click="addFamilyMember">Add Member</button>
                                        <button class="form-save-buttons" wire:click="save">Save</button>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="mt-2 ml-6 bg-white" style="border-radius:5px;border:1px solid silver;">
                            <div class="container p-0">
                                <!-- Header -->
                                <div class="  d-flex p-0">
                                    <div class=" text-end" style="border-right:1px solid silver;width:20%;font-size: 12px;  color:#9ca5ae">
                                        <div class="p-2">
                                            <span>Total Declared in ₹</span>
                                            <div class="code">0.00</div>
                                        </div>

                                    </div>
                                    <div class=" text-start">
                                        <div class="p-1 " style="margin-left: 20px;font-size: 12px;color:#9ca5ae">
                                            <span>Max limit in ₹</span>
                                            <div class="code">1,50,000.00</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 80C -->
                                <div class="section-title" style="border-top: 1px solid silver;padding:10px;background-color:#c8d1da">Section 80C</div>
                                <div class="row-item">
                                    <div><span class="code">80C</span> Deposit in Scheduled Bank</div>
                                    <i
                                        class="info-icon fa fa-info-circle"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="a) The investment shall be made during the period Apr to Mar
b) Investment should be in the name of the employee">
                                    </i>
                                </div>
                                <div class="row-item">
                                    <div><span class="code">80C</span> Children Tuition Fees</div>
                                    <i
                                        class="info-icon fa fa-info-circle"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="a) The investment shall be made during the period Apr to Mar
b) Investment should be in the name of the employee">
                                    </i>
                                </div>
                                <div class="row-item">
                                    <div><span class="code">80CCD(1)</span> Employee Contribution to NPS</div>
                                    <i
                                        class="info-icon fa fa-info-circle"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top">
                                    </i>
                                </div>
                                <div class="row-item">
                                    <div><span class="code">80CCc</span> Contribution to Pension Fund</div>
                                    <i
                                        class="info-icon fa fa-info-circle"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="a)Premium paid for Dependents can also be considered
b) Premium to be paid for pension fund only">
                                    </i>
                                </div>
                                <div class="row-item">
                                    <div><span class="code">80C</span> Deposit in NSC</div>
                                    <i
                                        class="info-icon fa fa-info-circle"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="a) The investment shall be made during the period Apr to Mar
b) Investment should be in the name of the employee">
                                    </i>
                                </div>
                                <div class="row-item">
                                    <div><span class="code">80C</span> Deposit in NSs</div>
                                    <i
                                        class="info-icon fa fa-info-circle"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="a) The investment shall be made during the period Apr to Mar
b) Investment should be in the name of the employee">
                                    </i>
                                </div>
                                <div class="row-item">
                                    <div><span class="code">80C</span> Deposit in Post Office Savings Schemes </div>
                                    <i
                                        class="info-icon fa fa-info-circle"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="a) The investment shall be made during the period Apr to Mar
b) Investment should be in the name of the employee">
                                    </i>
                                </div>
                                <div class="row-item">
                                    <div><span class="code">80C</span> Equity Linked Savings Scheme ( ELSS ) </div>
                                    <i
                                        class="info-icon fa fa-info-circle"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="a) The investment shall be made during the period Apr to Mar
b) Investment should be in the name of the employee">
                                    </i>
                                </div>
                                <div class="row-item">
                                    <div><span class="code">80C</span> Interest on NSC Reinvested</div>
                                    <i
                                        class="info-icon fa fa-info-circle"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="a) The investment shall be made during the period Apr to Mar
b) Investment should be in the name of the employee">
                                    </i>
                                </div>
                                <div class="row-item">
                                    <div><span class="code">80C</span> Interest on NSC Reinvested</div>
                                    <i
                                        class="info-icon fa fa-info-circle"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="a) The investment shall be made during the period Apr to Mar
b) Investment should be in the name of the employee">
                                    </i>
                                </div>
                                <div class="row-item">
                                    <div><span class="code">80C</span> Life Insurance Premium</div>
                                    <i
                                        class="info-icon fa fa-info-circle"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="a) The investment shall be made during the period Apr to Mar
b) Investment should be in the name of the employee">
                                    </i>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($selectedItem=='Other Chapter VI-A Deductions')
                    <div class="col-md-10">

                        <div class="d-flex mt-4 " style="justify-content:space-between ;align-items:center">
                            <select name="financial_year" id="financial_year" class="form-select" style=" width: fit-content;">
                                <option value="all">All Items</option>
                                <option value="declared">Declared Items</option>

                            </select>
                            <a href="#" id="pdfLink2023_4" class="pdf-download text-align-end" wire:click="showFamilyDetails" style=" display: inline-block;font-size:14px">Family Details</a>
                        </div>
                        <div class="mt-2 ml-6 bg-white" style="border-radius:5px;border:1px solid silver;">
                            <div class="container p-0">
                                <!-- Header -->
                                <!-- <div class="  d-flex p-0">
                                    <div class=" text-end" style="border-right:1px solid silver;width:20%;font-size: 12px;  color:#9ca5ae">
                                        <div class="p-2">
                                            <span>Total Declared in ₹</span>
                                            <div class="code">0.00</div>
                                        </div>

                                    </div>
                                    <div class=" text-start">
                                        <div class="p-1 " style="margin-left: 20px;font-size: 12px;color:#9ca5ae">
                                            <span>Max limit in ₹</span>
                                            <div class="code">1,50,000.00</div>
                                        </div>
                                    </div>
                                </div> -->

                                <!-- Section 80C -->
                                <div class="section-title" style="border-top: 1px solid silver;padding:10px;background-color:#c8d1da">Other Chapter VI-A Deductions</div>
                                <div style="height: 300px;display:flex;flex-direction:column; justify-content:center;align-items:center;">
                                    <div style="border:1.5px solid silver;border-radius: 50%;width: 20px;display: flex;justify-content: center;align-items: center;height: 20px;padding: 2px;color:silver">
                                        !
                                    </div>
                                    <p style="font-size: 12px;color:silver">
                                        You have not declared any item under Other Chapter VI-A Deductions
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($selectedItem=='House Rent Allowance')
                    <div class="col-md-10">

                        <div class="d-flex mt-4 " style="justify-content:space-between ;align-items:center">
                            <select name="financial_year" id="financial_year" class="form-select" style=" width: fit-content;">
                                <option value="all">All Items</option>
                                <option value="declared">Declared Items</option>

                            </select>
                            <a href="#" id="pdfLink2023_4" class="pdf-download text-align-end" wire:click="showFamilyDetails" style=" display: inline-block;font-size:14px">Family Details</a>
                        </div>
                        <div class="mt-2 ml-6 bg-white" style="border-radius:5px;border:1px solid silver;">
                            <div class="container p-0">
                                <!-- Header -->
                                <div class="  d-flex p-0">
                                    <div class=" text-end" style="border-right:1px solid silver;width:20%;font-size: 12px;  color:#9ca5ae">
                                        <div class="p-2">
                                            <span>Total Declared in ₹</span>
                                            <div class="code">0.00</div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Section 80C -->
                                <div class="section-title" style="border-top: 1px solid silver;padding:10px;background-color:#c8d1da">House Rent Paid</div>
                                <div style="height: 300px;display:flex;flex-direction:column; justify-content:center;align-items:center;">
                                    <div style="border:1.5px solid silver;border-radius: 50%;width: 20px;display: flex;justify-content: center;align-items: center;height: 20px;padding: 2px;color:silver">
                                        !
                                    </div>
                                    <p style="font-size: 12px;color:silver">
                                        You have not declared any item under House Rent Allowance
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($selectedItem=='Medical (Sec 80D)')
                    <div class="col-md-10">

                        <div class="d-flex mt-4 " style="justify-content:space-between ;align-items:center">
                            <select name="financial_year" id="financial_year" class="form-select" style=" width: fit-content;">
                                <option value="all">All Items</option>
                                <option value="declared">Declared Items</option>

                            </select>
                            <a href="#" id="pdfLink2023_4" class="pdf-download text-align-end" wire:click="showFamilyDetails" style=" display: inline-block;font-size:14px">Family Details</a>
                        </div>
                        <div class="mt-2 ml-6 bg-white" style="border-radius:5px;border:1px solid silver;">
                            <div class="container p-0">

                                <!-- Section 80C -->
                                <div class="section-title" style="border-top: 1px solid silver;padding:10px;background-color:#c8d1da">Medical (Sec 80D)</div>
                                <div style="height: 300px;display:flex;flex-direction:column; justify-content:center;align-items:center;">
                                    <div style="border:1.5px solid silver;border-radius: 50%;width: 20px;display: flex;justify-content: center;align-items: center;height: 20px;padding: 2px;color:silver">
                                        !
                                    </div>
                                    <p style="font-size: 12px;color:silver">
                                        You have not declared any item under Medical (Sec 80D)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($selectedItem=='Income/loss from House Property')
                    <div class="col-md-10">

                        <div class="d-flex mt-4 " style="justify-content:space-between ;align-items:center">
                            <select name="financial_year" id="financial_year" class="form-select" style=" width: fit-content;">
                                <option value="all">All Items</option>
                                <option value="declared">Declared Items</option>

                            </select>
                            <a href="#" id="pdfLink2023_4" class="pdf-download text-align-end" wire:click="showFamilyDetails" style=" display: inline-block;font-size:14px">Family Details</a>
                        </div>
                        <div class="mt-2 ml-6 bg-white" style="border-radius:5px;border:1px solid silver;">
                            <div class="container p-0">
                                <!-- Header -->
                                <div class="  d-flex p-0">
                                    <div class=" text-end" style="border-right:1px solid silver;width:20%;font-size: 12px;  color:#9ca5ae">
                                        <div class="p-2">
                                            <span> <span class="color-text">c.</span>Total Income/loss From House Property In ₹</span>
                                            <div class="code">0.00</div>
                                        </div>
                                    </div>
                                    <div class=" text-start d-flex" style="align-items:center; width:80%">
                                        <div class="" style="font-size: 12px;color:#9ca5ae;width: 100%;">
                                            <div>
                                                <div style="margin-left: 20px;">
                                                    <span><span class="color-text">a. </span> Interest on Housing Loan (Self- Occupied) <span class="code">0</span> </span>
                                                </div>
                                                <span style="margin-left: 20px;"><span class="color-text">b. </span> Total Income/Loss from Let-out Property <span class="code">0</soan> </span>
                                            </div>
                                            <div style="border-top:1px solid silver">
                                                <span style="margin-left: 20px;">If<span class="color-text">(a + b) </span>is less than -200000 then -200000 will be exempted. </span>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Section 80C -->
                                <div class="section-title" style="border-top: 1px solid silver;padding:10px;background-color:#c8d1da"><span>a.</span> Income from Self-Occupied Property</div>
                                <div style="height: 300px;display:flex;flex-direction:column; justify-content:center;align-items:center;">
                                    <div style="border:1.5px solid silver;border-radius: 50%;width: 20px;display: flex;justify-content: center;align-items: center;height: 20px;padding: 2px;color:silver">
                                        !
                                    </div>
                                    <p style="font-size: 12px;color:silver">
                                        You have not declared any item under Income from Self-Occupied Property
                                    </p>
                                </div>
                                <div class="section-title" style="border-top: 1px solid silver;padding:10px;background-color:#c8d1da"><span>b.</span> Income from Let Out Property</div>
                                <div style="height: 300px;display:flex;flex-direction:column; justify-content:center;align-items:center;">
                                    <div style="border:1.5px solid silver;border-radius: 50%;width: 20px;display: flex;justify-content: center;align-items: center;height: 20px;padding: 2px;color:silver">
                                        !
                                    </div>
                                    <p style="font-size: 12px;color:silver">
                                        You have not declared any item under Income from Let Out Property
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($selectedItem=='Salary Allowance')
                    <div class="col-md-10">

                        <div class="d-flex mt-4 " style="justify-content:space-between ;align-items:center">
                            <select name="financial_year" id="financial_year" class="form-select" style=" width: fit-content;">
                                <option value="all">All Items</option>
                                <option value="declared">Declared Items</option>

                            </select>
                            <a href="#" id="pdfLink2023_4" class="pdf-download text-align-end" wire:click="showFamilyDetails" style=" display: inline-block;font-size:14px">Family Details</a>
                        </div>
                        <div class="mt-2 ml-6 bg-white" style="border-radius:5px;border:1px solid silver;">
                            <div class="container p-0">


                                <!-- Section 80C -->
                                <div class="section-title" style="border-top: 1px solid silver;padding:10px;background-color:#c8d1da">Salary Components</div>
                                <div style="height: 300px;display:flex;flex-direction:column; justify-content:center;align-items:center;">
                                    <div style="border:1.5px solid silver;border-radius: 50%;width: 20px;display: flex;justify-content: center;align-items: center;height: 20px;padding: 2px;color:silver">
                                        !
                                    </div>
                                    <p style="font-size: 12px;color:silver">
                                        You have not declared any item under Salary Allowance
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($selectedItem=='Other Income')
                    <div class="col-md-10">

                        <div class="d-flex mt-4 " style="justify-content:space-between ;align-items:center">
                            <select name="financial_year" id="financial_year" class="form-select" style=" width: fit-content;">
                                <option value="all">All Items</option>
                                <option value="declared">Declared Items</option>

                            </select>
                            <a href="#" id="pdfLink2023_4" class="pdf-download text-align-end" wire:click="showFamilyDetails" style=" display: inline-block;font-size:14px">Family Details</a>
                        </div>
                        <div class="mt-2 ml-6 bg-white" style="border-radius:5px;border:1px solid silver;">
                            <div class="container p-0">
                                <!-- Header -->
                                <div class="  d-flex p-0">
                                    <div class=" text-end" style="border-right:1px solid silver;width:20%;font-size: 12px;  color:#9ca5ae">
                                        <div class="p-2">
                                            <span>Total Declared in ₹</span>
                                            <div class="code">0.00</div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Section 80C -->
                                <div class="section-title" style="border-top: 1px solid silver;padding:10px;background-color:#c8d1da">Other Income</div>
                                <div style="height: 300px;display:flex;flex-direction:column; justify-content:center;align-items:center;">
                                    <div style="border:1.5px solid silver;border-radius: 50%;width: 20px;display: flex;justify-content: center;align-items: center;height: 20px;padding: 2px;color:silver">
                                        !
                                    </div>
                                    <p style="font-size: 12px;color:silver">
                                        You have not declared any item under Other Income
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($selectedItem=='TCS/TDS Deduction')
                    <div class="col-md-10">

                        <div class="d-flex mt-4 " style="justify-content:space-between ;align-items:center">
                            <select name="financial_year" id="financial_year" class="form-select" style=" width: fit-content;">
                                <option value="all">All Items</option>
                                <option value="declared">Declared Items</option>

                            </select>
                            <a href="#" id="pdfLink2023_4" class="pdf-download text-align-end" wire:click="showFamilyDetails" style=" display: inline-block;font-size:14px">Family Details</a>
                        </div>
                        <div class="mt-2 ml-6 bg-white" style="border-radius:5px;border:1px solid silver;">
                            <div class="container p-0">
                                <!-- Header -->
                                <div class="  d-flex p-0">
                                    <div class=" text-end" style="border-right:1px solid silver;width:20%;font-size: 12px;  color:#9ca5ae">
                                        <div class="p-2">
                                            <span>Total Declared in ₹</span>
                                            <div class="code">0.00</div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Section 80C -->
                                <div class="section-title" style="border-top: 1px solid silver;padding:10px;background-color:#c8d1da">TCS/TDS Deduction</div>
                                <div style="height: 300px;display:flex;flex-direction:column; justify-content:center;align-items:center;">
                                    <div style="border:1.5px solid silver;border-radius: 50%;width: 20px;display: flex;justify-content: center;align-items: center;height: 20px;padding: 2px;color:silver">
                                        !
                                    </div>
                                    <p style="font-size: 12px;color:silver">
                                        You have not declared any item under TCS/TDS Deduction
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($selectedItem=='Proof Attachment')
                    <div class="col-md-10">

                        <div class="d-flex mt-4 " style="justify-content:end ;align-items:center">

                            <a href="#" id="pdfLink2023_4" class="pdf-download text-align-end" wire:click="showFamilyDetails" style=" display: inline-block;font-size:14px">Family Details</a>
                        </div>
                        <div class="mt-2 ml-6 bg-white" style="border-radius:5px;border:1px solid silver;">
                            <div class="container p-0">
                                <!-- Header -->


                                <!-- Section 80C -->
                                <div class="section-title" style="padding:10px;background-color:#c8d1da">Proof Attachment</div>
                                <div style="height: 300px;display:flex;flex-direction:column; justify-content:center;align-items:center;">
                                    <div style="border:1.5px solid silver;border-radius: 50%;width: 20px;display: flex;justify-content: center;align-items: center;height: 20px;padding: 2px;color:silver">
                                        !
                                    </div>
                                    <p style="font-size: 12px;color:silver">
                                        You have not submitted attachment under Proof Attachment
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endif




                </div>

            </div>
        </div>
    </div>

    <script>
        function openSidePage() {
            document.getElementById('sidePage').style.right = '0'; // Slide in the side page
            console.log('ok');
        }

        function closeSidePage() {
            document.getElementById('sidePage').style.right = '-100%'; // Slide out the side page
        }

        document.addEventListener("DOMContentLoaded", function() {
            var button = document.getElementById("yearDropdown");
            var dropdownContent = document.querySelector(".dropdown-content3");
            var selectedYear = document.getElementById("selectedYear");

            button.addEventListener("click", function() {
                dropdownContent.style.display = dropdownContent.style.display === "none" ? "block" : "none";
            });

            dropdownContent.addEventListener("click", function(event) {
                if (!event.target.matches(".dropdown-item")) return;
                var year = event.target.dataset.year;
                button.innerText = year;
                selectedYear.textContent = year; // Update selectedYear content
                dropdownContent.style.display = "none";

                // Show content based on selected year

            });
        });
    </script>
