<div>

    <div style="text-align: center;display:flex;align-items:center;justify-content:end;">
        <button type="button" class="leave-balance-dowload mx-2 px-2 rounded " wire:click="downloadPdf">
            <i class="fas fa-download" style="color: white;"></i>
        </button>

        <div class="mx-2">
            <select class="dropdown-salary bg-white px-3 py-1" wire:model="selectedMonth" wire:change="changeMonth">
                @foreach($options as $value => $label)
                <option value="{{ $value }}" style="background-color: #fff; color: #333; font-size: 13px;">{{ $label }}</option>
@endforeach
</select>
</div>

</div>
<div class="row mt-4 mx-0 salary-slip-h6" style="display: flex;">
    @if (empty($salaryDivisions))
    <div class="col">
        <div class="homeCard5">
            <div class="py-2 px-3 h-100">
                <div class="d-flex justify-content-center">
                    <p class="text-center" style="font-size:20px;color:#778899;font-weight:500;">Payslip</p>
                </div>

                <div class="d-flex flex-column align-items-center">
                    <img src="https://th.bing.com/th/id/OIP.mahJODIeDJLFSbIYARY4WwAAAA?pid=ImgDet&w=178&h=178&c=7&dpr=1.5" alt="Payslip Image" class="img-fluid" style="max-width:100%; height:auto;">
                    <p class="text-center" style="color: #677A8E; margin-bottom: 20px; font-size:12px;">Payslip not available for the selected month.</p>
                </div>
            </div>
        </div>

    </div>
    @else
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-7 mb-2">
                <div class="bg-white earnings-tab rounded h-100 d-flex flex-column ">
                    <h6 class="px-3 mt-3 font-weight-500" style="color: #778899;">Earnings</h6>
                    <div class="emp-amount m-0 d-flex align-items-center justify-content-end px-3 py-2">
                        <p class="m-0" style="font-size: 12px;font-weight:500;color: #778899;">Amount in (₹)</p>
                    </div>
                    <div class=" earning-details">
                        <div class="column">
                            <span class="px-2 py-2">BASIC</span>
                            <span class="px-2 py-2">{{number_format($salaryDivisions['basic'],2)}} </span>
                        </div>

                        <div class="column">
                            <span class="px-2 py-2">HRA</span>
                            <span class="px-2 py-2">{{number_format($salaryDivisions['hra'],2)}} </span>
                        </div>

                        <div class="column">
                            <span class="px-2 py-2">CONVEYANCE</span>
                            <span class="px-2 py-2">{{number_format($salaryDivisions['conveyance'],2)}} </span>
                        </div>

                        <div class="column">
                            <span class="px-2 py-2">MEDICAL ALLOWANCE</span>
                            <span class="px-2 py-2">{{number_format($salaryDivisions['medical_allowance'],2)}} </span>
                        </div>

                        <div class="column">
                            <span class="px-2 py-2">SPECIAL ALLOWANCE</span>
                            <span class="px-2 py-2">{{number_format($salaryDivisions['special_allowance'],2)}} </span>
                        </div>

                    </div>

                    <div class="total-sal py-2 mt-auto">
                        <p class="mb-0 px-2">Total</p>
                        <p class="mb-0 px-2">₹ {{number_format($salaryDivisions['earnings'],2)}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5 mb-2">
                <div class="bg-white earnings-tab rounded h-100 d-flex flex-column">
                    <h6 class="px-3 mt-3 font-weight-500" style="color: #778899;">Deductions</h6>
                    <div class="emp-amount m-0 d-flex align-items-center justify-content-end px-3 py-2">
                        <p class="m-0" style="font-size: 12px;font-weight:500;color: #778899;">Amount in (₹)</p>
                    </div>
                    <div class=" earning-details mb-5">
                        <div class="column">
                            <span class="px-2 py-2">PF</span>
                            <span class="px-2 py-2">{{number_format($salaryDivisions['pf'],2)}}</span>
                        </div>

                        <div class="column">
                            <span class="px-2 py-2">ESI</span>
                            <span class="px-2 py-2">{{number_format($salaryDivisions['esi'],2)}}</span>
                        </div>

                        <div class="column">
                            <span class="px-2 py-2">PROF TAX</span>
                            <span class="px-2 py-2">{{number_format($salaryDivisions['professional_tax'],2)}}</span>
                        </div>
                    </div>

                    <div class="total-sal  py-2 mt-auto ">
                        <p class="mb-0 px-2">Total</p>
                        <p class="mb-0 px-2">₹ {{number_format($salaryDivisions['total_deductions'],2)}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mt-1">
        <div class="employee-details-container  px-3  rounded" style="background-color: #ffffe8;">
        <div class="mt-3 d-flex justify-content-between">
       <h6 style="color: #778899;font-weight:500;">Employee details</h6>
       <p style="font-size: 12px; cursor: pointer;color:deepskyblue;font-weight:500;" wire:click="toggleDetails">
        {{ $showDetails ? 'Hide' : 'Info' }}
    </p>
    </div>
            @if ($showDetails)
            <div class="row d-flex justify-content-between py-2">
                <div class="details-column">

                    <div class="detail" style="height:50px">
                        <p class="emp-details-p">Name <br>
                            <span class="emp-details-span">

                                {{ ucwords(strtolower($employeeDetails->first_name)) . ' ' . ucwords(strtolower($employeeDetails->last_name)) }}

                            </span>
                        </p>
                    </div>
                    <div class="detail">
                        <p class="emp-details-p">Joining Date <br>
                            <span class="emp-details-span">
                                {{ \Carbon\Carbon::parse($employeeDetails->hire_date)->format('d M, Y') }}
                            </span>
                        </p>
                    </div>

                    <div class="detail">
                        <p class="emp-details-p">Designation <br>
                            <span class="emp-details-span">
                                {{$employeeDetails->job_role}}
                            </span>
                        </p>
                    </div>
                    <div class="detail">
                        <p class="emp-details-p">Department <br>
                            <span class="emp-details-span">

                            </span>
                        </p>
                    </div>
                    <div class="detail">
                        <p class="emp-details-p">Location <br>
                            <span class="emp-details-span">{{$employeeDetails->job_location}}</span>
                        </p>
                    </div>
                    <div class="detail">
                        <p class="emp-details-p">Effective Work Days <br>
                            <span class="emp-details-span"></span>
                        </p>
                    </div>
                    <div class="detail mt-2">
                        <p class="emp-details-p">LOP <br>
                            <span class="emp-details-span">0.00</span>
                        </p>
                    </div>
                </div>
                <div class="details-column">
                    <div class="detail" style="height:50px">
                        <p class="emp-details-p">Employee No <br>
                            <span class="emp-details-span">{{$employeeDetails->emp_id}}</span>
                        </p>
                    </div>


                    <div class="detail">
                        <p class="emp-details-p">Bank Name <br>
                            <span class="emp-details-span">
                                {{$empBankDetails['bank_name']}}
                            </span>
                        </p>
                    </div>
                    <div class="detail">
                        <p class="emp-details-p">Bank Account No <br>
                            <span class="emp-details-span">
                                {{$empBankDetails['account_number']}}
                            </span>
                        </p>
                    </div>



                    <div class="detail">
                        <p class="emp-details-p">PAN Number <br>
                            <span class="emp-details-span"></span></span>
                        </p>
                    </div>
                    <div class="detail">
                        <p class="emp-details-p">PF No <br>
                            <span class="emp-details-span"></span></span>
                        </p>
                    </div>
                    <div class="detail">
                        <p class="emp-details-p">PF UAN <br>
                            <span class="emp-details-span"></span></span>
                        </p>
                    </div>
                </div>

            </div>
            @endif

        </div>
        <div class="total-count mt-3 bg-white py-1">
            <p style="font-size: 14px;">Net Pay for {{ \Carbon\Carbon::parse($selectedMonth)->format('M-Y') }}</p>

            @if ($salaryDivisions['net_pay'] > 0)
            <p style="font-size: 14px; color:green;font-weight:500;">₹ {{ number_format($salaryDivisions['net_pay'],2)}}</p>
            @else
            <p style="font-size: 12px;">-</p>
            @endif

            <p style="color:#778899;font-size:12px;margin-bottom:0;">{{ 'Rupees ' . ucwords( $this->convertNumberToWords($salaryDivisions['net_pay'])) . ' only' }}</p>

        </div>
    </div>
    @endif
</div>
</div>


