<div>

    <div class="buttons-container d-flex justify-content-end mt-2 px-3 ">
        <button class="leaveApply-balance-buttons  py-2 px-4  rounded" onclick="window.location.href='/leave-page'">Apply</button>
        <button type="button" class="leave-balance-dowload mx-2 px-2 rounded " wire:click="showPopupModal">
            <i class="fas fa-download" style="color: white;"></i>
        </button>

        <select class="dropdown w-20 bg-white rounded" wire:model="selectedYear" wire:change="yearDropDown">
            <?php
            // Get the current year
            $currentYear = date('Y');
            // Generate options for current year, previous year, and next year
            $options = [$currentYear - 2, $currentYear - 1, $currentYear, $currentYear + 1];
            ?>
            @foreach($options as $year)
            <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>
    </div>


    <!-- modal -->
    @if($showModal)
    <div wire:ignore.self class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display:block;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Download Leave Transaction Report</h6>
                    <button type="button" class="btn-close" wire:click="closeModal" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form novalidate class="ng-valid ng-touched ng-dirty" wire:submit.prevent="generatePdf">
                    @csrf
                    <div class="modal-body">
                        @if($dateErrorMessage)
                        <div class="alert alert-danger">
                            {{ $dateErrorMessage }}
                        </div>
                        @endif
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="required-field label-style">From date</label>
                                    <div class="input-group date">
                                        <input type="date" wire:model="fromDateModal" class="form-control input-placeholder-small" id="fromDate" name="fromDate" style="color: #778899;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="required-field label-style">To date</label>
                                    <div class="input-group date">
                                        <input type="date" wire:model="toDateModal" class="form-control input-placeholder-small" id="fromDate" name="fromDate" style="color: #778899;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="label-style">Leave type</label>
                                    <select name="leaveType" wire:model="leaveType" class="form-control input-placeholder-small">
                                        <option value="all">All Leaves</option>
                                        <option value="casual_probation">Casual Leave Probation</option>
                                        <option value="maternity">Maternity Leave</option>
                                        <option value="paternity">Paternity Leave</option>
                                        <option value="sick">Sick Leave</option>
                                        <option value="lop">Loss of Pay</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="label-style">Transaction</label>
                                    <select name="transactionType" wire:model="transactionType" class="form-control input-placeholder-small">
                                        <option value="all">All Transactions</option>
                                        <option value="granted">Granted</option>
                                        <option value="availed">Availed</option>
                                        <option value="cancelled">Cancelled</option>
                                        <option value="withdrawn">Withdrawn</option>
                                        <option value="rejected">Rejected</option>
                                        <option value="approved">Approved</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="label-style">Sort by</label>
                                    <select name="sortBy" wire:model="sortBy" class="form-control input-placeholder-small" id="sortBySelect">
                                        <option value="oldest_first">Date (Oldest First)</option>
                                        <option value="newest_first" selected>Date (Newest First)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="submit-btn">Download</button>
                        <!-- <button type="button" class="cancel-btn1" data-dismiss="modal" wire:click="closeModal">Cancel</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif


    <!-- 2022 year -->
    @if($selectedYear == (date('Y') - 2))
    <div>
        <div class="bal-container">
            <div class="row my-3 mx-auto">
                <div class="col-md-4 mb-2">
                    <div class="leave-bal mb-2 bg-white rounded   ">
                        <div class="balance d-flex flex-row justify-content-between mb-4">
                            <div class="field">
                                <span class="leaveTypeTitle font-weight-500">Loss Of Pay</span>
                            </div>
                            <div>
                                <span class="leave-gran font-weight-500">Granted:0</span>
                            </div>
                        </div>
                        <div class="center text-center" style="margin-top:30px;">
                            <h5 style="font-size:16px;">0</h5>
                            <p class=" mb-0" style="margin-top:-13px;font-size:11px;color:#778899;"><span class="remaining">Balance</span></p>
                        </div>
                    </div>
                </div>
                <!-- ... (previous code) ... -->
                <div class="col-md-4 mb-2">
                    <div class="leave-bal mb-2 bg-white rounded  ">
                        <div class="balance d-flex flex-row justify-content-between mb-4">
                            <div class="field">
                                <span class="leaveTypeTitle font-weight-500">
                                    @if($gender === 'Female')
                                    Maternity Leave
                                    @elseif($gender === 'Male')
                                    Paternity Leave
                                    @else
                                    Leave Type
                                    @endif
                                </span>
                            </div>
                            <div>
                                <span class="leave-gran font-weight-500">Granted:0</span>
                            </div>
                        </div>
                        <div class="center text-center" style="margin-top:30px;">
                            <h5 style="font-size:16px;">0</h5>
                            <p class="mb-0" style="margin-top:-13px;font-size:11px;color:#778899;"><span class="remaining">Balance</span></p>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="leave-bal mb-2 bg-white rounded  ">
                        <div class="balance d-flex flex-row justify-content-between mb-4">
                            <div class="field">
                                <span class="leaveTypeTitle font-weight-500">Casual Leave
                            </div>
                            <div>
                                <span class="leave-gran font-weight-500">Granted:0</span>
                            </div>
                        </div>
                        <div class="center text-center" style="margin-top:30px;">
                            <h5 style="font-size:16px;">0</h5>
                            <p class="mb-0" style="margin-top:-13px;font-size:11px;color:#778899;"><span class="remaining">Balance</span></p>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="leave-bal mb-2 bg-white rounded  ">
                        <div class="balance d-flex flex-row justify-content-between mb-4 ">
                            <div class="field">
                                <span class="leaveTypeTitle font-weight-500">Sick Leave
                            </div>
                            <div>
                                <span class="leave-gran font-weight-500">Granted:0</span>
                            </div>
                        </div>
                        <div class="center text-center" style="margin-top:30px;">
                            <h5 style="font-size:16px;">0</h5>
                            <p class="mb-0" style="margin-top:-13px;font-size:11px;color:#778899;"><span class="remaining">Balance</span></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<!-- leave  -->
@if($selectedYear == (date('Y') - 1))
<div class="bal-container">
    <div class="row my-3 mx-auto">
        <div class="col-md-4 mb-2">
            <div class="leave-bal mb-2 bg-white rounded  ">
                <div class="balance d-flex flex-row justify-content-between ">
                    <div class="field">
                        <span class="leaveTypeTitle font-weight-500">Loss Of Pay</span>
                    </div>
                    <div>
                        <span class="leave-gran font-weight-500">Granted:0</span>
                    </div>
                </div>
                <div class="center text-center" style="margin-top:30px;">
                    <h5 style="font-size:16px;">0 </h5>
                    <p class="mb-0" style="margin-top:-13px;font-size:11px;color:#778899;"><span class="remaining">Balance</span></p>
                </div>
            </div>
        </div>
        <!-- ... (previous code) ... -->
        <div class="col-md-4 mb-2">
            <div class="leave-bal mb-2 bg-white rounded  ">
                <div class="balance d-flex flex-row justify-content-between ">
                    <div class="field">
                        <span class="leaveTypeTitle font-weight-500">
                            @if($gender === 'Female')
                            Maternity Leave
                            @elseif($gender === 'Male')
                            Paternity Leave
                            @else
                            Leave Type
                            @endif
                        </span>
                    </div>
                    <div>
                        <span class="leave-gran font-weight-500">Granted:{{ $grantedLeave }}</span>
                    </div>
                </div>
                <div class="center text-center" style="margin-top:30px;">
                    <h5 style="font-size:16px;">0</h5>
                    <p class="mb-0" style="margin-top:-13px;font-size:11px;color:#778899;"><span class="remaining">Balance</span></p>
                </div>

            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="leave-bal mb-2 bg-white rounded  ">
                <div class="balance d-flex flex-row justify-content-between ">
                    <div class="field">
                        <span class="leaveTypeTitle font-weight-500">Casual Leave
                    </div>
                    <div>
                        <span class="leave-gran font-weight-500">Granted:{{ $casualLeavePerYear }} </span>
                    </div>
                </div>
                <div class="center text-center" style="margin-top:30px;">
                    <h5 style="font-size:16px;">{{ $casualLeavePerYear }} </h5>
                    <p class="mb-0" style="margin-top:-13px;font-size:11px;color:#778899;"><span class="remaining">Balance</span></p>
                </div>

            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="leave-bal mb-2 bg-white rounded  ">
                <div class="balance d-flex flex-row justify-content-between ">
                    <div class="field">
                        <span class="leaveTypeTitle font-weight-500">Sick Leave
                    </div>
                    <div>
                        <span class="leave-gran font-weight-500">Granted:{{ $sickLeavePerYear }}</span>
                    </div>
                </div>
                <div class="center text-center" style="margin-top:30px;">
                    <h5 style="font-size:16px;">{{ $sickLeavePerYear }}</h5>
                    <p class="mb-0" style="margin-top:-13px;font-size:11px;color:#778899;"><span class="remaining">Balance</span></p>
                </div>

            </div>
        </div>
    </div>
</div>

</div>
@endif

<!-- 2024 -->
@if($selectedYear == date('Y'))
<div>
    <div class="bal-container">
        <div class="row my-3 mx-auto">
            <div class="col-md-4 mb-2">
                <div class="leave-bal mb-2 bg-white rounded  ">
                    <div class="balance d-flex flex-row justify-content-between ">
                        <div class="field">
                            <span class="leaveTypeTitle font-weight-500">Loss Of Pay</span>
                        </div>
                        <div>
                            <span class="leave-grane font-weight-500">Granted:{{$lossOfPayPerYear}}</span>
                        </div>
                    </div>
                    <div class="center text-center" style="margin-top:30px;">
                        <h5 style="font-size:16px;">
                            {{$lossOfPayBalance}}
                        </h5>
                        <p class="mb-0" style="margin-top:-14px;font-size:11px;color:#778899;"><span class="remaining">Balance</span></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="leave-bal mb-2 bg-white rounded ">
                    <div class="balance d-flex flex-row justify-content-between ">
                        <div class="field">
                            <span class="leaveTypeTitle font-weight-500">
                                @if($gender === 'Female')
                                Maternity Leave
                                @elseif($gender === 'Male')
                                Paternity Leave
                                @else
                                Leave Type
                                @endif
                            </span>
                        </div>
                        <div>
                            <span class="leave-gran font-weight-500">Granted:
                                @if($gender === 'Female')
                                {{$maternityLeaves}}
                                @elseif($gender === 'Male')
                                {{$paternityLeaves}}
                                @else
                                0
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="center text-center" style="margin-top:30px;">
                        <h5 style="font-size:16px;"> @if($gender === 'Female')
                            {{$maternityLeaves}}
                            @elseif($gender === 'Male')
                            {{$paternityLeaves}}
                            @else
                            0
                            @endif
                        </h5>
                        <p class="mb-0" style="margin-top:-13px;font-size:11px;color:#778899;"><span class="remaining">Balance</span></p>
                        @if($gender === 'Female' && $maternityLeaves > 0)
                        <a href="#" style="font-size:12px;">View Details</a>
                        @elseif($gender === 'Male' && $paternityLeaves > 0)
                        <a href="#" style="font-size:12px;">View Details</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="leave-bal mb-2 bg-white rounded">
                    <div class="balance mb-2 d-flex flex-row justify-content-between ">
                        <div class="field">
                            <span class="leaveTypeTitle font-weight-500">Casual Leave
                        </div>
                        <div>
                            <span class="leave-gran font-weight-500">Granted:{{$casualLeavePerYear}}</span>
                        </div>
                    </div>
                    <div class="center text-center" style="margin-top:30px;">
                        <h5 style="font-size:16px;">{{$casualLeaveBalance}}</h5>
                        <p class="mb-0" style="margin-top:-13px;font-size:11px;color:#778899;"><span class="remaining">Balance</span></p>
                        @if($casualLeavePerYear)
                        <a href="/casualleavebalance?year={{ $currentYear }}" style="font-size:12px;">View Details</a>
                        @endif
                    </div>
                    <div class="px-3 py-2">
                        <div class="tube-container">
                            <p style="color: #778899; font-size: 10px; text-align:start; margin-top:-15px;font-weight: 400;">
                                @if($consumedCasualLeaves > 0)
                                {{ $consumedCasualLeaves }} of {{ $casualLeavePerYear }} Consumed
                                @else
                                0 of {{ $casualLeavePerYear }} Consumed
                                @endif
                            </p>
                            <div class="tube" style="width: {{ $percentageCasual }}%; background-color: {{ $this->getTubeColor($consumedCasualLeaves, $casualLeavePerYear, 'Casual Leave Probation') }};"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="leave-bal mb-2 bg-white rounded  ">
                    <div class="balance d-flex flex-row justify-content-between">
                        <div class="field">
                            <span class="leaveTypeTitle font-weight-500">Sick Leave</span>
                        </div>
                        <div>
                            <span class="leave-gran font-weight-500">Granted:{{ $sickLeavePerYear }}</span>
                        </div>
                    </div>
                    <div class="center text-center" style="margin-top:30px;">
                        <h5 style="font-size:16px;">{{ $sickLeaveBalance }}</h5>
                        <p class="mb-0" style="margin-top:-13px;font-size:11px;color:#778899;"><span class="remaining">Balance</span></p>
                        @if($sickLeavePerYear > 0)
                        <a href="/sickleavebalance?year={{$currentYear}}" style="font-size:12px;">View Details</a>
                        @endif
                    </div>
                    <div class="px-3 py-2">
                    <div class="tube-container">
                        <p style="color: #778899; font-size: 10px; text-align: start; margin-top: -15px; font-weight: 400;">
                            @if($consumedSickLeaves > 0)
                            {{ $consumedSickLeaves }} of {{ $sickLeavePerYear }} Consumed
                            @else
                            0 of {{ $sickLeavePerYear }} Consumed
                            @endif
                        </p>
                        <div class="tube" style="width: {{ $percentageSick }}%; background-color: {{ $this->getTubeColor($consumedSickLeaves, $sickLeavePerYear, 'Sick Leave') }};"></div>
                    </div>
                    </div>
                </div>
            </div>
            @if( $casualProbationLeavePerYear > 0)
            <div class="col-md-4 mb-2">
                <div class="leave-bal mb-2 bg-white rounded  ">
                    <div class="balance d-flex flex-row justify-content-between">
                        <div class="field">
                            <span class="leaveTypeTitle font-weight-500">Casual Leave Probation</span>
                        </div>
                        <div>
                            <span class="leave-gran font-weight-500">Granted:{{ $casualProbationLeavePerYear }}</span>
                        </div>
                    </div>
                    <div class="center text-center" style="margin-top:30px;">
                        <h5 style="font-size:16px;">{{ $casualProbationLeaveBalance }}</h5>
                        <p class="mb-0" style="margin-top:-13px;font-size:11px;color:#778899;"><span class="remaining">Balance</span></p>
                        @if($casualProbationLeavePerYear > 0)
                        <a href="/casualprobationleavebalance" style="font-size:12px;">View Details</a>
                        @endif
                    </div>
                    <div class="px-3 py-2">
                    <div class="tube-container">
                        <p style="color: #778899; font-size: 10px; text-align: start; margin-top: -15px; font-weight: 400;">
                            @if($consumedProbationLeaveBalance > 0)
                            {{ $consumedProbationLeaveBalance }} of {{ $casualProbationLeavePerYear }} Consumed
                            @else
                            0 of {{ $casualProbationLeaveBalance }} Consumed
                            @endif
                        </p>
                        <div class="tube" style="width: {{ $percentageCasualProbation }}%; background-color: {{ $this->getTubeColor($consumedProbationLeaveBalance, $casualProbationLeavePerYear, 'Casual Leave Probation') }};"></div>
                    </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-4 mb-2">
            <div class="leave-bal mb-2 bg-white rounded  ">
                <div class="balance d-flex flex-row justify-content-between">
                    <div class="field">
                        <span class="leaveTypeTitle font-weight-500">Marriage Leave</span>
                    </div>
                    <div>
                        <span class="leave-gran font-weight-500">Granted:{{ $marriageLeaves }}</span>
                    </div>
                </div>
                <div class="center text-center" style="margin-top:30px;">
                    <h5 style="font-size:16px;">{{ $marriageLeaves }}</h5>
                    <p class="mb-0" style="margin-top:-13px;font-size:11px;color:#778899;"><span class="remaining">Balance</span></p>
                    @if($marriageLeaves > 0)
                    <a href="#" style="font-size:12px;">View Details</a>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
</div>
</div>
@endif

@if($selectedYear == (date('Y') + 1))
<div class="bal-container">
    <div class="row my-3 mx-auto">
        <div class="col-md-4 mb-2">
            <div class="leave-bal mb-2 bg-white rounded  ">
                <div class="balance d-flex flex-row justify-content-between mb-4">
                    <div class="field">
                        <span class="leaveTypeTitle font-weight-500">Loss Of Pay</span>
                    </div>
                    <div>
                        <span class="leave-gran font-weight-500">Granted:0</span>
                    </div>
                </div>
                <div class="center text-center" style="margin-top:30px;">
                    <h5 style="font-size:16px;">0 </h5>
                    <p class="mb-0" style="margin-top:-13px;font-size:11px;color:#778899;"><span class="remaining">Balance</span></p>
                </div>
            </div>
        </div>
        <!-- ... (previous code) ... -->
        <div class="col-md-4 mb-2">
            <div class="leave-bal mb-2 bg-white rounded  ">
                <div class="balance d-flex flex-row justify-content-between mb-4">
                    <div class="field">
                        <span class="leaveTypeTitle font-weight-500">
                            @if($gender === 'Female')
                            Maternity Leave
                            @elseif($gender === 'Male')
                            Paternity Leave
                            @else
                            Leave Type
                            @endif
                        </span>
                    </div>
                    <div>
                        <span class="leave-gran font-weight-500">Granted:{{ $grantedLeave }}</span>
                    </div>
                </div>
                <div class="center text-center" style="margin-top:30px;">
                    <h5 style="font-size:16px;">0</h5>
                    <p class="mb-0" style="margin-top:-13px;font-size:11px;color:#778899;"><span class="remaining">Balance</span></p>
                </div>

            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="leave-bal mb-2 bg-white rounded  ">
                <div class="balance d-flex flex-row justify-content-between mb-4">
                    <div class="field">
                        <span class="leaveTypeTitle font-weight-500">Casual Leave
                    </div>
                    <div>
                        <span class="leave-gran font-weight-500">Granted:0</span>
                    </div>
                </div>
                <div class="center text-center" style="margin-top:30px;">
                    <h5 style="font-size:16px;">0</h5>
                    <p class="mb-0" style="margin-top:-13px;font-size:11px;color:#778899;"><span class="remaining">Balance</span></p>
                </div>

            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="leave-bal mb-2 bg-white rounded  ">
                <div class="balance d-flex flex-row justify-content-between mb-4">
                    <div class="field">
                        <span class="leaveTypeTitle font-weight-500">Sick Leave
                    </div>
                    <div>
                        <span class="leave-gran font-weight-500">Granted:{{ $sickLeavePerYear }}</span>
                    </div>
                </div>
                <div class="center text-center" style="margin-top:30px;">
                    <h5 style="font-size:16px;">0</h5>
                    <p class="mb-0" style="margin-top:-13px;font-size:11px;color:#778899;"><span class="remaining">Balance</span></p>
                </div>

            </div>
        </div>
    </div>
</div>

</div>
@endif


</body>

</div>
