<div>

 <div style="text-align: center;display:flex;align-items:center;justify-content:end;">

 <button type="button" class="dowload mx-2 px-2 rounded" style="background-color: rgb(2, 17, 79)">
    <a href="#" wire:click.prevent="downloadPdf" class="pdf-download btn-primary px-3 rounded d-flex align-items-center" style="color: white; text-decoration: none;">
        <i class="bx bx-download" style="color: white;"></i>
       
    </a>
</button>


   
        <div class="mx-2">
            <select class="dropdown-salary bg-white px-3 py-1" wire:model="selectedMonth">
                @foreach($options as $value => $label)
                    <option value="{{ $value }}" style="background-color: #fff; color: #333; font-size: 13px;">{{ $label }}</option>
                @endforeach
            </select>
        </div>

</div>
<div class ="row mt-4 mx-0 salary-slip-h6" style="display: flex;" >
    <div class="col">
    @if ($salaryRevision->isEmpty())
    <div class="homeCard5">
                            <div class="py-2 px-3" style="height:400px">
                                <div class="d-flex justify-content-center">
                                    <p style="font-size:20px;color:#778899;font-weight:500;align-items:center">Payslip</p>
                                    
                                </div>

                                <div style="display:flex;align-items:center;flex-direction:column;">
                                        <img src="https://cdn3.iconfinder.com/data/icons/human-resources-70/133/9-512.png" alt="" style="height:300px;width:300px;">
                                    <p style="color: #677A8E;  margin-bottom: 20px; font-size:12px;"> We are working on your payslip!</p>
                                </div>
                            </div>
                        </div>
    <!-- <div class="message-container" style="background-color: white; border: 1px solid #ccc; border-radius: 5px; padding: 20px; margin-bottom: 20px; width: 600px; height: 400px; font-family: Montserrat; text-align: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <img src="https://static.vecteezy.com/system/resources/previews/005/950/625/original/modern-design-icon-of-pay-slip-vector.jpg" style="height: 250px; width: 250px; justify-content: center; margin-top: 0px;">
    <br>
    <p class="message" style="font-size: 18px; color: #3b4452; text-align: center; margin-top: 20px; font-weight: 600;">Currently working on Payslip.</p>
</div> -->

</div>
@else
    </div>

@foreach($salaryRevision as $employee)

<div class="col-md-4 mb-2">
   <div class="bg-white earnings-tab rounded">
        <h6 class="px-3 mt-3 font-weight-500" style="color: #778899;">Earnings</h6>
        <div class="emp-amount m-0 d-flex align-items-center justify-content-end px-3 py-2">
           <p class="m-0" style="font-size: 12px;font-weight:500;color: #778899;">Amount in (₹)</p>
        </div>
        <div class="px-3 py-2 earning-details">
            <div class="column" style="display: flex; justify-content: space-between;">
                <p>BASIC</p>
                <span>{{ number_format($employee->basic, 2) }} </span>
            </div>

            <div class="column" style="display: flex; justify-content: space-between;">
                <p>HRA</p>
                <span>{{ number_format($employee->hra, 2) }} </span>
            </div>

            <div class="column" style="display: flex; justify-content: space-between;">
                <p>CONVEYANCE</p>
                <span>{{ number_format($employee->conveyance, 2) }} </span>
            </div>

            <div class="column" style="display: flex; justify-content: space-between;">
                <p>MEDICAL ALLOWANCE</p>
                <span>{{ number_format($employee->medical, 2) }} </span>
            </div>

            <div class="column" style="display: flex; justify-content: space-between;">
                <p>SPECIAL ALLOWANCE</p>
                <span>{{ number_format($employee->special, 2) }}</span>
            </div>

        </div>

        <div class="total-sal px-3 py-2" style="display: flex; color:black;font-weight:500;font-size:13px; text-align: center;justify-content: space-between;background:#e8f0f8;align-items:center;   border-bottom-left-radius: 5px;   border-bottom-right-radius: 5px;">
                <p class="mb-0">Total</p>
                <p class="mb-0">{{ number_format($employee->calculateTotalAllowance(), 2) }}</p>
        </div>
    </div>
</div>

<div class="col-md-4 mb-2">
    <div class="bg-white earnings-tab rounded">
        <h6 class="px-3 mt-3 font-weight-500" style="color: #778899;">Deductions</h6>
        <div class="emp-amount m-0 d-flex align-items-center justify-content-end px-3 py-2">
           <p class="m-0" style="font-size: 12px;font-weight:500;color: #778899;">Amount in (₹)</p>
        </div>
        <div class="px-3 py-2 earning-details mb-5">
            <div class="column" style="display: flex; justify-content: space-between;">
                <p>PF</p>
                <span>{{ number_format($employee->calculatePf(), 2) }}</span>
            </div>

            <div class="column" style="display: flex; justify-content: space-between;">
                <p>ESI</p>
                <span>{{ number_format($employee->calculateEsi(), 2) }}</span>
            </div>

            <div class="column" style="display: flex; justify-content: space-between;">
                <p>PROF TAX</p>
                <span>150.00</span>
            </div>
        </div>

        <div class="total-sal px-3 py-2 mt-4" style="display: flex; color:black;font-weight:500;font-size:13px; text-align: center;justify-content: space-between;background:#e8f0f8;align-items:center;   border-bottom-left-radius: 5px;   border-bottom-right-radius: 5px;">
                <p class="mb-0">Total</p>
                <p class="mb-0">{{ number_format($employee->calculateTotalDeductions(), 2) }}</p>
        </div>
    </div>
</div>
@endforeach
@endif

<div class="col-md-4 mb-2">
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
  @foreach($employees as $employee)
        <div class="detail">
            <p class="emp-details-p">Name <br>
                <span class="emp-details-span">{{ ucwords(strtolower($employee->first_name)) }} {{ ucwords(strtolower($employee->last_name)) }}</span>
            </p>
        </div>
        <div class="detail">
           <p class="emp-details-p">Joining Date <br>
                <span class="emp-details-span">{{ date('d M Y', strtotime($employee->hire_date)) }}</span>
            </p>
        </div>
        <div class="detail">
           <p class="emp-details-p">Designation <br>
                <span class="emp-details-span">{{ empty($employee->job_title) ? '-' : ucwords(strtolower($employee->job_title)) }}</span>
            </p>
        </div>
        <div class="detail">
           <p class="emp-details-p">Department <br>
           <span class="emp-details-span">
                {{ empty($employee->department) ? '-' : ucwords(strtolower($employee->department)) }}
            </span>
            </p>
        </div>
        <div class="detail">
           <p class="emp-details-p">Location <br>
                <span class="emp-details-span">{{ empty($employee->job_location) ? '-' : ucwords(strtolower($employee->job_location)) }}</span>
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
        <div class="detail">
            <p class="emp-details-p">Employee No <br>
                <span class="emp-details-span">{{ empty($employee->emp_id) ? '-' : ucwords(strtoupper($employee->emp_id)) }}</span>
            </p>
        </div>
        @if($empBankDetails->isEmpty())
            <div class="detail">
                <p class="emp-details-p">Bank Name <br>
                    <span class="emp-details-span">N/A</span>
                </p>
            </div>
            <div class="detail">
                <p class="emp-details-p">Bank Account No <br>
                    <span class="emp-details-span">N/A</span>
                </p>
            </div>
        @else
            @foreach($empBankDetails as $bankDetail)
                <div class="detail">
                    <p class="emp-details-p">Bank Name <br>
                        <span class="emp-details-span">
                            {{ empty($bankDetail->bank_name) ? 'N/A' : ucwords(strtolower($bankDetail->bank_name)) }}
                        </span>
                    </p>
                </div>
                <div class="detail">
                    <p class="emp-details-p">Bank Account No <br>
                        <span class="emp-details-span">
                            {{ empty($bankDetail->account_number) ? 'N/A' : ucwords(strtolower($bankDetail->account_number)) }}
                        </span>
                    </p>
                </div>
            @endforeach
        @endif

        <div class="detail">
           <p class="emp-details-p">PAN Number <br>
                <span class="emp-details-span">{{ empty($employee->pan_no) ? '-' : $employee->pan_no }}</span></span>
            </p>
        </div>
        <div class="detail">
           <p class="emp-details-p">PF No <br>
                <span class="emp-details-span">{{ empty($employee->pf_no) ? '-' : $employee->pf_no }}</span></span>
            </p>
        </div>
        <div class="detail">
           <p class="emp-details-p">PF UAN <br>
                <span class="emp-details-span">{{ empty($employee->pf_uan) ? '-' : $employee->pf_uan }}</span></span>
            </p>
        </div>
    </div>
@endforeach
    </div>
    @endif

</div>
    <div class="total-count mt-3 bg-white py-1">
        <p style="font-size: 14px;">Net Pay for Dec 2023</p>
            <!-- Display the net pay -->
            @if ($netPay > 0)
                <p style="font-size: 14px; color:green;font-weight:500;">₹ {{ number_format($netPay, 2) }}</p>
            @else
                <p style="font-size: 12px;">-</p>
            @endif

            <p style="color:#778899;font-size:12px;margin-bottom:0;">{{ 'Rupees ' . ucwords( $this->convertNumberToWords($netPay)) . ' Only' }}</p>
    </div>
</div>
</div>
</div>
  </div>

 
 </div>