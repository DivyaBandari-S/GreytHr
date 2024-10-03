<div>
    @if($showAlert)
    <div class="alert alert-success w-50 position-absolute m-auto p-2" wire:poll.1s="hideAlert" style="right: 25%;top:18%;" id="success-alert">
        {{ session('message') }}
        <button type="button" class="alert-close" data-dismiss="alert" aria-label="Close">
            <span>X</span>
        </button>
    </div>
    @endif
    <div class="col" id="leavePending">
        <div class="row m-0 p-0 mt-3">
            <div class="reviewCountShow p-0">
                <div class="d-flex align-items-center gap-2">
                    @if($count > 0)
                    <span class="totalRequestCount">Total Leave Requests
                        <span class="leaveCountReview d-flex align-items-center justify-content-center">
                            {{ $count }}
                        </span>
                    </span>
                    @endif
                </div>
                <div class="search-container d-flex align-items-end justify-content-end p-2" style="position: relative;">
                    <input type="text" wire:model.debounce.500ms="filter" id="searchInput" placeholder="Search..." class="form-control placeholder-small border outline-none rounded" style="padding-right: 40px;">
                    <button wire:click="fetchPendingLeaveApplications" id="searchButtonReports">
                        <i class="fas fa-search" style="width: 16px; height: 16px;"></i>
                    </button>
                </div>

            </div>
        </div>
        @if(!empty($this->leaveApplications))
        @foreach($this->leaveApplications as $leaveRequest)
        <div class="approved-leave-container mt-1 px-1 rounded">
            <div class="accordion rounded mb-4 p-0">
                <div class="accordion-heading rounded m-0 p-0" onclick="toggleAccordion(this)">
                    <div class="accordion-title rounded m-0">
                        <!-- Display leave details here based on $leaveRequest -->
                        <div class="col accordion-content d-flex align-items-center">
                            <div class="accordion-profile d-flex gap-3 m-auto align-items-center justify-content-center">
                                @if(isset($leaveRequest['leaveRequest']->image) !== null && $leaveRequest['leaveRequest']->image !== 'null' && $leaveRequest['leaveRequest']->image != "Null" && $leaveRequest['leaveRequest']->image != "")
                                <img height="40" width="40" src="data:image/jpeg;base64,{{ ($leaveRequest['leaveRequest']->image) }}" style="border-radius: 50%;">
                                @else
                                @if($leaveRequest['leaveRequest']->gender === 'Female')
                                <img src="{{ asset('images/female-default.jpg') }}" alt="" height="40" width="40" style="border-radius: 50%;">
                                @elseif($leaveRequest['leaveRequest']->gender === 'Male')
                                <img src="{{ asset('images/male-default.jpg') }}" alt="" height="40" width="40" style="border-radius: 50%;">
                                @else
                                <img src="{{ asset('images/user.jpg') }}" alt="" height="40" width="40" style="border-radius: 50%;">
                                @endif
                                @endif
                                <div>
                                    @if(isset($leaveRequest['leaveRequest']->first_name))
                                    <p class="mb-0 employeeName" title="{{ ucwords(strtolower($leaveRequest['leaveRequest']->first_name)) }} {{ ucwords(strtolower($leaveRequest['leaveRequest']->last_name)) }}">
                                        {{ ucwords(strtolower($leaveRequest['leaveRequest']->first_name)) }} {{ ucwords(strtolower($leaveRequest['leaveRequest']->last_name)) }}
                                        <br>
                                        @if(isset($leaveRequest['leaveRequest']->emp_id))
                                        <span class="normalTextSmall text-start">#{{ $leaveRequest['leaveRequest']->emp_id }} </span>
                                        @endif
                                    </p>
                                    @else
                                    <p class="mb-0 normalTextSmall">Name Not Available</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col accordion-content d-flex align-items-center">
                            <p class="normalTextValue mb-0">Category <br>
                                @if(isset($leaveRequest['leaveRequest']->category_type))
                                <span class="normalText">{{ $leaveRequest['leaveRequest']->category_type }}</span>
                                @else
                                <span class="normalTextSmall">Leave Type Not Available</span>
                                @endif
                            </p>
                        </div>
                        <div class="col accordion-content d-flex align-items-center">
                            <p class="mb-0 normalTextValue">Leave Type <br>
                                @if(isset($leaveRequest['leaveRequest']->leave_type))
                                <span class="normalText">{{ $leaveRequest['leaveRequest']->leave_type }}</span>
                                @else
                                <span class="normalTextSmall">Leave Type Not Available</span>
                                @endif
                            </p>
                        </div>


                        <div class="col accordion-content d-flex align-items-center mb-0">
                            @php
                            $numberOfDays = $this->calculateNumberOfDays($leaveRequest['leaveRequest']->from_date, $leaveRequest['leaveRequest']->from_session, $leaveRequest['leaveRequest']->to_date, $leaveRequest['leaveRequest']->to_session,$leaveRequest['leaveRequest']->leave_type);
                            @endphp
                            <p class="normalTextValue mb-0">
                                Period <br>
                                @if($numberOfDays == 1)
                                <span class="normalText">
                                    @if(isset($leaveRequest['leaveRequest']->from_date))
                                    {{ $leaveRequest['leaveRequest']->from_date->format('d M Y') }}
                                    @else
                                    <span>Date Not Available</span>
                                    @endif
                                </span> <br>
                                <span class="normalTextSmall">Full Day</span>
                                @elseif($numberOfDays == 0.5)
                                <span class="normalText">
                                    @if(isset($leaveRequest['leaveRequest']->from_date))
                                    <span class="normalText "> {{ $leaveRequest['leaveRequest']->from_date->format('d M Y') }}<br><span class="normalTextSmall">{{$leaveRequest['leaveRequest']->from_session }}</span></span>
                                    @else
                                    <span>Date Not Available</span>
                                    @endif
                                </span> <br>
                                <span class="normalTextSmall">Half Day</span>
                                @else
                                <span class="normalText">
                                    @if(isset($leaveRequest['leaveRequest']->from_date))
                                    <div class="d-flex text-center gap-2">
                                        <span class="normalText fw-600"> {{ $leaveRequest['leaveRequest']->from_date->format('d M Y') }}<br><span class="normalTextSmall">{{$leaveRequest['leaveRequest']->from_session }}</span></span>
                                        <span>-</span>
                                        <span class="normalText fw-600"> {{ $leaveRequest['leaveRequest']->to_date->format('d M Y') }}<br><span class="normalTextSmall">{{$leaveRequest['leaveRequest']->to_session }}</span></span>
                                    </div>
                                    @else
                                    <span> Date Not Available</span>
                                    @endif
                                </span>
                                @endif
                            </p>
                        </div>
                        <!-- Add other details based on your leave request structure -->
                        <div class="arrow-btn ">
                            <i class="fa fa-angle-down"></i>
                        </div>
                    </div>
                </div>

                <div class="accordion-body m-0 p-0">
                    <div class="horizontalLine"></div>
                    <div class="content1 px-4">
                        <span class="normalTextValue">No. of days :</span>
                        @if(isset($leaveRequest['leaveRequest']->from_date))
                        <span class="normalText font-weight-400">
                            {{ $this->calculateNumberOfDays($leaveRequest['leaveRequest']->from_date, $leaveRequest['leaveRequest']->from_session, $leaveRequest['leaveRequest']->to_date, $leaveRequest['leaveRequest']->to_session,$leaveRequest['leaveRequest']->leave_type) }}
                        </span>
                        @else
                        <span class="normalText font-weight-400">No. of days not available</span>
                        @endif
                    </div>
                    <div class="content1 px-4">
                        <span class="normalTextValue">Reason :</span>
                        @if(isset($leaveRequest['leaveRequest']->reason))
                        <span class="normalText font-weight-400">{{ ucfirst($leaveRequest['leaveRequest']->reason) }}</span>
                        @else
                        <span class="normalText font-weight-400">Reason Not Available</span>
                        @endif
                    </div>
                    <div class="horizontalLine"></div>
                    <div class="approvedLeaveDetails d-flex justify-content-between align-items-center px-3">
                        <div class="content1">
                            <span class="normalTextValue">Applied On <br>
                                @if(isset($leaveRequest['leaveRequest']->created_at))
                                <span class="normalText">
                                    {{ $leaveRequest['leaveRequest']->created_at->format('d M, Y') }}
                                </span>
                                @else
                                <span class="normalText fw-400">No. of days not available</span>
                                @endif
                            </span>
                        </div>
                        <div class="content2">
                            <span class="normalTextValue">Leave Balance:</span>
                            @if(!empty($leaveRequest['leaveBalances']))
                            <div class="d-flex align-items-center justify-content-center">

                                <!-- Sick Leave -->

                                <div class="sickLeaveCircle">

                                    <span class="sickLeaveBal">SL</span>

                                </div>

                                <span class="sickLeaveValue">{{ $leaveRequest['leaveBalances']['sickLeaveBalance'] }}</span>

                                <!-- Casual Leave  -->

                                <div class="casLeaveCircle">

                                    <span class="casLeaveBal">CL</span>

                                </div>

                                <span class="casLeaveValue">{{ $leaveRequest['leaveBalances']['casualLeaveBalance'] }}</span>

                                <!-- Casual Leave  Probation-->
                                @if($leaveRequest['leaveRequest']->leave_type === 'Casual Leave Probation' && isset($leaveRequest['leaveBalances']['casualProbationLeaveBalance']))
                                <div class="probLeave">

                                    <span class="probLeaveBal">CLP</span>

                                </div>
                                <span class="probLeaveValue">{{ $leaveRequest['leaveBalances']['casualProbationLeaveBalance'] }}</span>

                                <!-- Loss of Pay -->

                                @elseif($leaveRequest['leaveRequest']->leave_type === 'Loss Of Pay' && isset($leaveRequest['leaveBalances']['lossOfPayBalance']))

                                <div class="lossLeave">

                                    <span class="lossLeaveBal">LOP</span>

                                </div>
                                @if(($leaveRequest['leaveBalances']['lossOfPayBalance'])>0)
                                <span class="lossLeaveValue">&minus;{{ $leaveRequest['leaveBalances']['lossOfPayBalance'] }}</span>
                                @else
                                <span class="lossLeaveValue">{{ $leaveRequest['leaveBalances']['lossOfPayBalance'] }}</span>
                                @endif
                                @elseif($leaveRequest['leaveRequest']->leave_type === 'Marriage Leave' && isset($leaveRequest['leaveBalances']['marriageLeaveBalance']))

                                <div class="marriageLeave">

                                    <span class="marriageLeaveBal">MRL</span>

                                </div>

                                <span class="marriageLeaveValue">{{ $leaveRequest['leaveBalances']['marriageLeaveBalance'] }}</span>

                                @elseif($leaveRequest['leaveRequest']->leave_type === 'Petarnity Leave' && isset($leaveRequest['leaveBalances']['paternityLeaveBalance']))

                                <div class="petarnityLeave">

                                    <span class="petarnityLeaveBal">PL</span>

                                </div>

                                <span class="petarnityLeaveValue">{{ $leaveRequest['leaveBalances']['paternityLeaveBalance'] }}</span>

                                @elseif($leaveRequest['leaveRequest']->leave_type === 'Maternity Leave' && isset($leaveRequest['leaveBalances']['maternityLeaveBalance']))

                                <div class="maternityLeave">

                                    <span class="maternityLeaveBal">ML</span>

                                </div>

                                <span class="maternityLeaveValue">{{ $leaveRequest['leaveBalances']['maternityLeaveBalance'] }}</span>

                                @endif

                            </div>
                            @endif
                        </div>
                        <div class="content1">
                            <a href="{{ route('view-details', ['leaveRequestId' => $leaveRequest['leaveRequest']->id]) }}" class="anchorTagDetails">View Details</a>
                            @if($leaveRequest['leaveRequest']->category_type === 'Leave')
                            <button class="rejectBtn" wire:click="rejectLeave({{ $loop->index }})">Reject</button>
                            @else
                            <button class="rejectBtn" wire:click="rejectLeaveCancel({{ $loop->index }})" title="Reject Leave Cancel">Reject</button>
                            @endif

                            @if($leaveRequest['leaveRequest']->category_type === 'Leave')
                            <button class="approveBtn" wire:click="approveLeave({{ $loop->index }})">Approve</button>
                            @else
                            <button class="approveBtn" wire:click="approveLeaveCancel({{ $loop->index }})" title="Approve Request For Leave Cancel">Approve</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="leave-pending">
            <img src="/images/pending.png" alt="Pending Image" class="m-auto" width="200">
            <p class="normalTextValue fw-normal">There are no pending records of any leave transaction to Review</p>
        </div>
        @endif
    </div>
    <script>
        function toggleAccordion(element) {
            const accordionBody = element.nextElementSibling;
            if (accordionBody.style.display === 'block') {
                accordionBody.style.display = 'none';
                element.classList.remove('active'); // Remove active class
            } else {
                accordionBody.style.display = 'block';
                element.classList.add('active'); // Add active class
            }
        }
    </script>

</div>