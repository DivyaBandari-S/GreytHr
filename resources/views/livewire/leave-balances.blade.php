<div class="position-relative">
    <div class="position-absolute" wire:loading
        wire:target="yearDropDown,showPopupModal,closeModal,generatePdf">
        <div class="loader-overlay">
            <div class="loader">
                <div></div>
            </div>
        </div>
    </div>
    <div class="buttons-container d-flex justify-content-end mt-2 px-3 ">
        <button class="submit-btn  py-2 px-4  rounded" onclick="window.location.href='/leave-form-page'">Apply</button>
        <button type="button" class="submit-btn mx-2 px-4 rounded " wire:click="showPopupModal">
            <i class="fas fa-download"></i>
        </button>

        <select class="dropdown bg-white rounded" wire:model="selectedYear" wire:change="yearDropDown">
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
    <div wire:ignore.self class="modal fade show d-block" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Download Leave Transaction Report</h6>
                    <button type="button" class="btn-close" aria-label="Close"
                        wire:click="closeModal">
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
                                        <input type="date" wire:model="fromDateModal" class="form-control input-placeholder-small" id="fromDateModal" name="fromDateModal">
                                    </div>
                                    @error('fromDateModal') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="required-field label-style">To date</label>
                                    <div class="input-group date">
                                        <input type="date" wire:model="toDateModal" class="form-control input-placeholder-small" id="toDateModal" name="toDateModal">
                                    </div>
                                    @error('toDateModal') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="label-style">Leave type</label>
                                    <select name="leaveType" wire:model="leaveType" class="form-control input-placeholder-small">
                                        <option value="all">All Leaves</option>
                                        <option value="casual_probation">Casual Leave</option>
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
                                        <option value="lapsed">Lapsed</option>
                                        <option value="withdrawn">Withdrawn</option>
                                        <option value="rejected">Rejected</option>
                                        {{-- <option value="approved">Approved</option> --}}
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
                        <button type="button" class="cancel-btn" wire:click="resetFields"
                            style="border:1px solid rgb(2,17,79);">Clear</button>
                        <!-- <button type="button" class="cancel-btn1" data-dismiss="modal" wire:click="closeModal">Cancel</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif

    <!-- current year defualt -->
    <div>
        <div class="bal-container">
            <div class="row my-3 mx-auto">
                <div class="col-md-4 containerBalanceHeight mb-2">
                    <div class="leave-bal mb-2 bg-white   ">
                        <div class="balance d-flex flex-row justify-content-between ">
                            <div class="field">
                                <span class="leaveTypeTitle font-weight-500">Loss Of Pay</span>
                            </div>
                            <div>
                                <span class="leave-grane font-weight-500">Granted: <span class="leave-grane font-weight-500">{{$lossOfPayPerYear}}</span></span>
                            </div>
                        </div>
                        <div class="center d-flex flex-column align-items-center justify-content-center text-center">
                            @if($lossOfPayBalance > 0)
                            <h5 class="mb-0">
                                &minus;{{($lossOfPayBalance)}}
                            </h5>
                            @else
                            <h5 class="mb-0">
                                0
                            </h5>
                            @endif
                            <p class="mb-0 remaining">Balance</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 containerBalanceHeight mb-2">
                    <div class="leave-bal mb-2 bg-white  ">
                        <div class="balance d-flex flex-row justify-content-between ">
                            <div class="field">
                                <span class="leaveTypeTitle font-weight-500">
                                    @if($gender === 'FEMALE')
                                    Maternity Leave
                                    @elseif($gender === 'MALE')
                                    Paternity Leave
                                    @else
                                    Leave Type
                                    @endif
                                </span>
                            </div>
                            <div>
                                <span class="leave-gran font-weight-500">Granted:
                                    <span class="leave-gran font-weight-500">
                                        @if($gender === 'FEMALE')
                                        {{ $maternityLeaves }}
                                        @elseif($gender === 'MALE')
                                        {{ $paternityLeaves }}
                                        @else
                                        0
                                        @endif
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="center text-center d-flex flex-column align-items-center justify-content-center">
                            <h5 class="mb-0">
                                @if($gender === 'FEMALE')
                                {{$maternityLeaves}}
                                @elseif($gender === 'MALE')
                                {{$paternityLeaves}}
                                @else
                                0
                                @endif
                            </h5>
                            <p class="mb-0 remaining">Balance</p>
                            @if($paternityLeaves > 0 || $maternityLeaves > 0)
                            @if($gender === 'FEMALE')
                            <a href="/leave-balances/maternityleavebalance?year={{ $selectedYear }}" class="anchorTagDetails">View Details</a>
                            @else
                            <a href="/leave-balances/paternityleavebalance?year={{ $selectedYear }}" class="anchorTagDetails">View Details</a>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
                @if($hideCasualLeave === true)
                <div class="col-md-4 containerBalanceHeight mb-2">
                    <div class="leave-bal mb-2 bg-white ">
                        <div class="balance mb-2 d-flex flex-row justify-content-between ">
                            <div class="field">
                                <span class="leaveTypeTitle font-weight-500">Casual Leave
                            </div>
                            <div>
                                <span class="leave-gran font-weight-500">Granted: <span class="leave-gran font-weight-500">{{$casualLeavePerYear}}</span></span>
                            </div>
                        </div>
                        <div class="center text-center d-flex flex-column align-items-center justify-content-center">
                            <h5 class="mb-0">
                                @if($currentYear == $selectedYear)
                                {{ $casualLeaveBalance }}
                                @else
                                0
                                @endif
                            </h5>
                            <p class="mb-0 remaining">Balance</p>
                            @if($casualLeavePerYear)
                            <a href="/leave-balances/casualleavebalance?year={{ $selectedYear }}" class="anchorTagDetails">View Details</a>
                            @endif
                        </div>
                        @if($casualLeavePerYear > 0 )
                        <div class="px-3">
                            <div class="tube-container">
                                <p class="consumedContent mb-0">
                                    @if($consumedCasualLeaves > 0 && $currentYear == $selectedYear)
                                    {{ $consumedCasualLeaves }} of {{ $casualLeavePerYear }} Consumed
                                    @elseif($consumedCasualLeaves > 0 && $currentYear != $selectedYear)
                                    {{ $casualLeavePerYear }} of {{ $casualLeavePerYear }} Consumed
                                    @else
                                    0 of {{ $casualLeavePerYear }} Consumed
                                    @endif
                                </p>
                                <div class="tube" style="width: {{ $percentageCasual }}%; background-color: {{ $this->getTubeColor($consumedCasualLeaves, $casualLeavePerYear, 'Casual Leave') }};"></div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                <div class="col-md-4 containerBalanceHeight mb-2">
                    <div class="leave-bal mb-2 bg-white   ">
                        <div class="balance d-flex flex-row justify-content-between">
                            <div class="field">
                                <span class="leaveTypeTitle font-weight-500">Sick Leave</span>
                            </div>
                            <div>
                                <span class="leave-gran font-weight-500">Granted: <span class="leave-gran font-weight-500">{{ $sickLeavePerYear }}</span></span>
                            </div>
                        </div>
                        <div class="center text-center d-flex flex-column align-items-center justify-content-center">
                            <h5 class="mb-0">{{ $sickLeaveBalance }}</h5>
                            <p class="mb-0 remaining">Balance</p>
                            @if($sickLeavePerYear > 0)
                            <a href="/leave-balances/sickleavebalance?year={{$selectedYear}}" class="anchorTagDetails">View Details</a>
                            @endif
                        </div>
                        @if($sickLeavePerYear > 0)
                        <div class="px-3">
                            <div class="tube-container">
                                <p class="mb-0 consumedContent">
                                    @if($consumedSickLeaves > 0)
                                    {{ $consumedSickLeaves }} of {{ $sickLeavePerYear }} Consumed
                                    @else
                                    0 of {{ $sickLeavePerYear }} Consumed
                                    @endif
                                </p>
                                <div class="tube" style="width: {{ $percentageSick }}%; background-color: {{ $this->getTubeColor($consumedSickLeaves, $sickLeavePerYear, 'Sick Leave') }};"></div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @if( $showCasualLeaveProbation || $showCasualLeaveProbationYear)
                <div class="col-md-4 containerBalanceHeight mb-2">
                    <div class="leave-bal mb-2 bg-white   ">
                        <div class="balance d-flex flex-row justify-content-between">
                            <div class="field">
                                <span class="leaveTypeTitle font-weight-500">Casual Leave Probation</span>
                            </div>
                            <div>
                                <span class="leave-gran font-weight-500">Granted: {{ $casualProbationLeavePerYear }}</span>
                            </div>
                        </div>
                        <div class="center text-center d-flex flex-column align-items-center justify-content-center">
                            <h5 class="mb-0">{{ $casualProbationLeaveBalance }}</h5>
                            <p class="mb-0 remaining">Balance</p>
                            @if($casualProbationLeavePerYear > 0)
                            <a href="/leave-balances/casualprobationleavebalance?year={{$currentYear}}" class="anchorTagDetails">View Details</a>
                            @endif
                        </div>
                        @if($casualProbationLeavePerYear > 0)
                        <div class="px-3">
                            <div class="tube-container">
                                <p class="mb-0 consumedContent">
                                    @if($consumedProbationLeaveBalance > 0)
                                    {{ $consumedProbationLeaveBalance }} of {{ $casualProbationLeavePerYear }} Consumed
                                    @else
                                    0 of {{ $casualProbationLeaveBalance }} Consumed
                                    @endif
                                </p>
                                <div class="tube" style="width: {{ $percentageCasualProbation }}%; background-color: {{ $this->getTubeColor($consumedProbationLeaveBalance, $casualProbationLeavePerYear, 'Casual Leave Probation') }};"></div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                <div class="col-md-4 containerBalanceHeight mb-2">
                    <div class="leave-bal mb-2 bg-white   ">
                        <div class="balance d-flex flex-row justify-content-between">
                            <div class="field">
                                <span class="leaveTypeTitle font-weight-500">Marriage Leave</span>
                            </div>
                            <div>
                                <span class="leave-gran font-weight-500">Granted: <span class="leave-gran font-weight-500">{{ $marriageLeaves }}</span></span>
                            </div>
                        </div>
                        <div class="center text-center d-flex flex-column align-items-center justify-content-center">
                            <h5 class="mb-0">{{ $marriageLeaveBalance }}</h5>
                            <p class="mb-0 remaining">Balance</p>
                            @if($marriageLeaves > 0)
                            <a href="/leave-balances/marriageleavebalance?year={{$selectedYear}}" class="anchorTagDetails">View Details</a>
                            @endif
                        </div>
                        @if($marriageLeaves > 0)
                        <div class="px-3">
                            <div class="tube-container">
                                <p class="mb-0 consumedContent">
                                    @if($consumedMarriageLeaves > 0)
                                    {{ $consumedMarriageLeaves }} of {{ $marriageLeaves }} Consumed
                                    @else
                                    0 of {{ $marriageLeaves }} Consumed
                                    @endif
                                </p>
                                <div class="tube" style="width: {{ $percentageMarriageLeaves }}%; background-color: {{ $this->getTubeColor($consumedMarriageLeaves, $marriageLeaves, 'Casual Leave Probation') }};"></div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @if($earnedLeavesPeryear != 0)
                <div class="col-md-4 containerBalanceHeight mb-2">
                    <div class="leave-bal mb-2 bg-white   ">
                        <div class="balance d-flex flex-row justify-content-between">
                            <div class="field">
                                <span class="leaveTypeTitle font-weight-500">Earned Leave</span>
                            </div>
                            <div>
                                <span class="leave-gran font-weight-500">Granted: <span class="leave-gran font-weight-500">{{ $marriageLeaves }}</span></span>
                            </div>
                        </div>
                        <div class="center text-center d-flex flex-column align-items-center justify-content-center">
                            <h5 class="mb-0">{{ $marriageLeaveBalance }}</h5>
                            <p class="mb-0 remaining">Balance</p>
                            @if($marriageLeaves > 0)
                            <a href="/leave-balances/marriageleavebalance?year={{$selectedYear}}" class="anchorTagDetails">View Details</a>
                            @endif
                        </div>
                        @if($marriageLeaves > 0)
                        <div class="px-3">
                            <div class="tube-container">
                                <p class="mb-0 consumedContent">
                                    @if($consumedMarriageLeaves > 0)
                                    {{ $consumedMarriageLeaves }} of {{ $marriageLeaves }} Consumed
                                    @else
                                    0 of {{ $marriageLeaves }} Consumed
                                    @endif
                                </p>
                                <div class="tube" style="width: {{ $percentageMarriageLeaves }}%; background-color: {{ $this->getTubeColor($consumedMarriageLeaves, $marriageLeaves, 'Casual Leave Probation') }};"></div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</body>

</div>