<div class="row p-0 m-0 mt-3 p-2">
@if(session()->has('emp_error'))
    <div class="alert alert-danger">
        {{ session('emp_error') }}
    </div>
    @endif
    <div class="col-md-3">
        <div class="d-flex flex-column mb-2" style="line-height:2;">
            <span style="color:#b1b1b1;font-size:12px;" class="mt-2" class="mt-2" class="mt-2">ATTENDANCE</span>
            <a class="px-1" wire:click="showContent('Attendance Regularization')" style="text-decoration:none; margin-top:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px; {{ $currentSection === 'Attendance Regularization' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : '' }}">
                Attendance Regularization
                @if($this->countofregularisations>0)

                <span class="count-pending -leaves text-center my-0 mx-1 font-weight-500" style=" background: #FAE392; border-radius:50%;font-size:8px;color: #2f363d;padding:2px 5px;">

                    {{$countofregularisations}}

                </span>

                @endif
            </a>
        </div>

        <div class="d-flex flex-column mb-2" style="line-height:2;">
            <span style="color:#b1b1b1;font-size:12px;" class="mt-2" class="mt-2">LEAVE</span>
            <a class="px-1" wire:click="showContent('Leave')" style="text-decoration:none;margin-bottom:5px;cursor:pointer;color:#778899;font-weight:500;font-size:12px;{{ $currentSection === 'Leave' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : '' }}">Leave
                @if(($this->count) > 0)
                <span class="count-pending -leaves text-center my-0 mx-1 font-weight-500" style=" background: #FAE392; border-radius:50%;font-size:8px;color: #2f363d;padding:2px 5px;">
                    {{$count}}
                </span>
                @endif
            </a>
            <a class="px-1" wire:click="showContent('Leave Cancel')" style="text-decoration:none;margin-bottom:5px;cursor:pointer;color:#778899;font-weight:500;font-size:12px;{{ $currentSection === 'Leave Cancel' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : '' }}">Leave Cancel</a>
            <a class="px-1" wire:click="showContent('Leave Comp Off')" style="text-decoration:none;margin-bottom:5px;cursor:pointer;color:#778899;font-weight:500;font-size:12px;{{ $currentSection === 'Leave Comp Off' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : '' }}">Leave Comp Off</a>
            <a class="px-1" wire:click="showContent('Restricted Holiday')" style="text-decoration:none;cursor:pointer;color:#778899;font-weight:500;font-size:12px;{{ $currentSection === 'Restricted Holiday' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : '' }}">Restricted Holiday</a>
        </div>
        <!-- <div class="d-flex flex-column mb-2 d-none" style="line-height:2.2; ">
            <span style="color:#b1b1b1;font-size:12px;"  class="mt-2">EMPINFO</span>
            <a class="px-1" wire:click="showContent('Confirmation')"
                style="text-decoration:none;margin-bottom:5px;cursor:pointer;color:#778899;font-weight:500; font-size:12px; {{ $currentSection === 'Confirmation' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : '' }}">
                Confirmation
            </a>
            <a class="px-1" wire:click="showContent('Resignations')" style="text-decoration:none;margin-bottom:5px;cursor:pointer;color:#778899;font-weight:500;font-size:12px;{{ $currentSection === 'Resignations' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : '' }}">Resignations</a>
            <a class="px-1" wire:click="showContent('Helpdesk')" style="text-decoration:none;cursor:pointer;color:#778899;font-weight:500;font-size:12px;{{ $currentSection === 'Helpdesk' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;color:black;font-size:12px;' : '' }}">Helpdesk</a>
        </div> -->
    </div>
    <div class="col-md-9 mx-0 px-0">
        @if($currentSection === 'Attendance Regularization')
        <div class="d-flex align-items-center justify-content-center gap-3">
            <button wire:click="toggleActiveContent('Attendance Regularization')" class="btn" style="font-size:12px;background-color: {{ $activeButton['Attendance Regularization'] ? 'rgb(2, 17, 79)' : 'white' }};
                            color: {{ $activeButton['Attendance Regularization'] ? 'white' : 'black' }}">
                Active
            </button>
            <button wire:click="toggleClosedContent('Attendance Regularization')" class="btn" style="border: 1px solid rgb(2,17,79);font-size:12px;background-color: {{ $activeButton['Attendance Regularization'] ? 'white' : 'rgb(2, 17, 79)' }};
                            color: {{ $activeButton['Attendance Regularization'] ? 'rgb(2, 17, 79)' : 'white' }}">
                Closed
            </button>
        </div>
        
        <div class="mt-5">
        
            @if($activeButton['Attendance Regularization'])
               
            <div class="reviewList">
                @livewire('view-regularisation-pending')
            </div>

            @else
            @if(count($approvedRegularisationRequestList))
            @foreach($approvedRegularisationRequestList as $arrl)

            @php
            // Decode the JSON string into an array
            $regularisationEntries = json_decode($arrl->regularisation_entries, true);
            // Count the number of elements in the array
            $numberOfEntries = count($regularisationEntries);
            // Initialize variables for minimum and maximum dates
            $minDate = null;
            $maxDate = null;
            // Iterate through each entry to find the minimum and maximum dates
            foreach ($regularisationEntries as $entry) {
            // Check if the entry contains the 'date' key
            if (isset($entry['date'])) {
            $date = strtotime($entry['date']);

            // Set the initial values for min and max dates
            if ($minDate === null || $date < $minDate) { $minDate=$date; } if ($maxDate===null || $date> $maxDate) {
                $maxDate = $date;
                }
                } else {
                }
                }

                // Convert timestamps back to date strings
                $minDate = $minDate !== null ? date('Y-m-d', $minDate) : null;
                $maxDate = $maxDate !== null ? date('Y-m-d', $maxDate) : null;
                @endphp


                <div class="accordion bg-white border mb-2 rounded">
                    <div class="accordion-heading rounded "  onclick="toggleAccordion(this)">

                        <div class="accordion-title p-2 rounded">

                            <!-- Display leave details here based on $leaveRequest -->

                            <div class="col accordion-content">

                                <span style="color: #778899; font-size: 12px; font-weight: 500; max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: inline-block;" data-toggle="tooltip" data-placement="top" title="{{ ucwords(strtolower($arrl->first_name)) }} {{ ucwords(strtolower($arrl->last_name)) }}">{{ ucwords(strtolower($arrl->first_name)) }}&nbsp;{{ ucwords(strtolower($arrl->last_name)) }}</span>

                                <span style="color: #36454F; font-size: 12px; font-weight: 500;text-align:left">{{$arrl->emp_id}}</span>

                            </div>

                            <div class="col accordion-content">

                                <span style="color: #778899; font-size: 12px; font-weight: 500;">No. of Days</span>

                                <span style="color: #36454F; font-size: 12px; font-weight: 500;">
                                    {{$numberOfEntries}}
                                </span>

                            </div>
                            <!-- Add other details based on your leave request structure -->

                            <div class="col accordion-content">
                                @if($arrl->status=='approved')
                                <span style="margin-top:0.625rem; font-size: 12px; font-weight: 400; color:green;text-transform:uppercase;">{{$arrl->status}}</span>
                                @elseif($arrl->status=='rejected') <span style="margin-top:0.625rem; font-size: 12px; font-weight: 400; color:#f66;text-transform:uppercase;">{{$arrl->status}}</span>

                                @endif
                            </div>

                            <div class="arrow-btn">
                                <i class="fa fa-angle-down"></i>
                            </div>

                        </div>

                    </div>
                    <div class="accordion-body m-0 p-0">

                        <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>

                        <div class="content px-4">

                            <span style="color: #778899; font-size: 12px; font-weight: 500;">Dates Applied:</span>

                            <span style="font-size: 11px;">

                                <span style="font-size: 11px; font-weight: 500;"></span>

                                {{ date('d M, Y', strtotime($minDate)) }}
                                @if($numberOfEntries>1)
                                -
                                @endif
                                <span style="font-size: 11px; font-weight: 500;"></span>

                                @if($numberOfEntries>1)
                                {{ date('d M, Y', strtotime($maxDate)) }}
                                @endif
                            </span>

                        </div>



                        <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>

                        <div style="display:flex; flex-direction:row; justify-content:space-between;">

                            <div class="content px-4">

                                <span style="color: #778899; font-size: 12px; font-weight: 500;">Applied on:</span>

                                <span style="color: #333; font-size:12px; font-weight: 500;">{{ \Carbon\Carbon::parse($arrl->created_at)->format('d M, Y') }}
                                </span>

                            </div>

                            <div class="content px-4">
                                <a href="{{ route('review-closed-regularation', ['id' => $arrl->id]) }}" style="color:#007BFF;font-size:11px;">View Details</a>

                            </div>

                        </div>
                    </div>
                </div>

                @endforeach
                @else
                <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                    <img src="/images/pending.png" alt="Pending Image" style="width:60%; margin:0 auto;">
                    <p style="color:#969ea9; font-size:13px; font-weight:400; ">Hey, you have no closed regularization records to view</p>
                </div>
                @endif
                @endif
        </div>

        @elseif($currentSection === 'Confirmation')
        <div class="d-flex align-items-center justify-content-center gap-4 ">
            <button wire:click="toggleActiveContent('Confirmation')" class="btn btn-sm btn-primary active-btn">Active</button>
            <button wire:click="toggleClosedContent('Confirmation')" class="btn btn-sm btn-danger">Closed</button>
        </div>
        <div class="mt-5">
            @if($activeButton['Confirmation'])
            <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
                <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no confirmation records to view</p>
            </div>
            @else
            <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
                <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no closed confirmation records to view</p>
            </div>
            @endif
        </div>
        @elseif($currentSection === 'Resignations')
        <div class="d-flex align-items-center justify-content-center gap-4">
            <button wire:click="toggleActiveContent('Resignations')" class="btn btn-sm btn-primary active-btn">Active</button>
            <button wire:click="toggleClosedContent('Resignations')" class="btn btn-sm btn-danger">Closed</button>
        </div>
        <div class="mt-5">
            @if($activeButton['Resignations'])
            <div class="d-flex flex-column justify-content-center bg-white rounded border text-center ">
                <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
                <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no Resignations records to view</p>
            </div>
            @else
            <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
                <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no closed Resignations records to view</p>
            </div>
            @endif
        </div>
        @elseif($currentSection === 'Helpdesk')
        <div class="d-flex align-items-center justify-content-center gap-4">
            <button wire:click="toggleActiveContent('Helpdesk')" class="btn btn-sm btn-primary active-btn">Active</button>
            <button wire:click="toggleClosedContent('Helpdesk')" class="btn btn-sm btn-danger">Closed</button>
        </div>
        <div class="mt-5">
            @if($activeButton['Helpdesk'])
            <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
                <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no Helpdesk records to view</p>
            </div>
            @else
            <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
                <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no closed Helpdesk records to view</p>
            </div>
            @endif
        </div>
        @elseif($currentSection === 'Leave')
        <div class="d-flex align-items-center justify-content-center gap-4 ">
            <button wire:click="toggleActiveContent('Leave')" class="btn" style="font-size:12px;background-color: {{ $activeButton['Leave'] ? 'rgb(2, 17, 79)' : 'white' }};
                            color: {{ $activeButton['Leave'] ? 'white' : 'black' }}">
                Active
            </button>
            <button wire:click="toggleClosedContent('Leave')" class="btn" style="border:1px solid rgb(2, 17, 79);font-size:12px;background-color: {{ $activeButton['Leave'] ? 'white' : 'rgb(2, 17, 79)' }};
                            color: {{ $activeButton['Leave'] ? 'rgb(2, 17, 79)' : 'white' }}">
                Closed
            </button>
        </div>
        <div class="row m-0 p-0 mt-3">
            <div class="search-container d-flex align-items-end justify-content-end p-1">
                <input type="text" wire:model.debounce.500ms="searchQuery" id="searchInput" placeholder="Enter employee name" class="border outline-none rounded">
                <button wire:click="searchPendingLeave" id="searchButton" style="border:none;outline:none;background:#fff;border-radius:5px;padding:1px 10px;"><i class="fas fa-search" style="width:7px;height:7px;"></i></button>
            </div>
        </div>
        <div class="mt-3">
            @if($activeButton['Leave'])
            <div class="pending-leaves-container" style="width:100%; max-height:400px; overflow-y:auto; margin-top:10px;">
                @if($this->leaveApplications)
                <div class="reviewList">
                    @livewire('view-pending-details', ['searchQuery' => $searchQuery])
                </div>
                @else
                <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                    <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
                    <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no leave records to view</p>
                </div>
                @endif
            </div>
            @else
            @php
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $isManager = DB::table('employee_details')->where('manager_id', $employeeId)->exists();
            @endphp
            @if($isManager)
            <div class="closed-leaves-container px-2" style="width:100%; max-height:400px; overflow-y:auto; margin:10px auto;">
                @if(!empty($approvedLeaveApplicationsList))
                @foreach($approvedLeaveApplicationsList as $leaveRequest)
                <div class="accordion rounded mb-3">
                    <div class="accordion-heading rounded p-1" onclick="toggleAccordion(this)">
                        <div class="accordion-head rounded d-flex justify-content-between m-auto p-2">
                            <!-- Display leave details here based on $leaveRequest -->
                            <div class="col accordion-content">
                                <div class="accordion-profile" style="display:flex; gap:7px; margin:auto 0;align-items:center;justify-content:center;">
                                    @if(isset($leaveRequest['approvedLeaveRequest']->image))
                                    <img src="{{ asset('storage/' . $leaveRequest['approvedLeaveRequest']->image) }}" alt="" style="background:#f3f3f3;border:1px solid #ccc;width: 40px; height: 40px; border-radius: 50%;">
                                    @else
                                    <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars.png" alt="Default User Image" style="background:#f3f3f3;border:1px solid #ccc;width: 40px; height: 40px; border-radius: 50%;">
                                    @endif
                                    <div>
                                        @if(isset($leaveRequest['approvedLeaveRequest']->first_name))
                                        <p style="font-size: 12px; font-weight: 500; text-align: start; margin: 0 auto;">
                                            <span style="display: inline-block; width: 110px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ ucwords(strtolower($leaveRequest['approvedLeaveRequest']->first_name)) }} {{ ucwords(strtolower($leaveRequest['approvedLeaveRequest']->last_name)) }}">
                                                {{ ucwords(strtolower($leaveRequest['approvedLeaveRequest']->first_name)) }} {{ ucwords(strtolower($leaveRequest['approvedLeaveRequest']->last_name)) }}
                                            </span>

                                            @if(isset($leaveRequest['approvedLeaveRequest']->emp_id))
                                            <span style="color: #778899; font-size: 10px; text-align: start;">
                                                #{{ $leaveRequest['approvedLeaveRequest']->emp_id }}
                                            </span>
                                            @endif
                                        </p>

                                        @else
                                        <p style="font-size: 12px; font-weight: 500; text-align: center;">Name Not Available</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col accordion-content">
                                <span style="color: #778899; font-size: 12px; font-weight: 500;">Leave Type</span>
                                <span class="leave-type-hide" title="{{ $leaveRequest['approvedLeaveRequest']->leave_type }}">{{ $leaveRequest['approvedLeaveRequest']->leave_type }}</span>
                            </div>

                            <div class="col accordion-content">
                                <span style="color: #778899; font-size:12px; font-weight: 500;">No. of Days</span>
                                <span style="color: #36454F; font-size:12px; font-weight: 500;">
                                    {{ $this->calculateNumberOfDays($leaveRequest['approvedLeaveRequest']->from_date, $leaveRequest['approvedLeaveRequest']->from_session, $leaveRequest['approvedLeaveRequest']->to_date, $leaveRequest['approvedLeaveRequest']->to_session) }}
                                </span>
                            </div>
                            <div class="col accordion-content">
                                @if(strtoupper($leaveRequest['approvedLeaveRequest']->status) == 'APPROVED')
                                <span style=" font-size: 12px; font-weight: 500; color:#32CD32;">{{ strtoupper($leaveRequest['approvedLeaveRequest']->status) }}</span>
                                @elseif(strtoupper($leaveRequest['approvedLeaveRequest']->status) == 'REJECTED')
                                <span style=" font-size: 12px; font-weight: 500; color:#FF0000;">{{ strtoupper($leaveRequest['approvedLeaveRequest']->status) }}</span>
                                @else
                                <span style=" font-size: 12px; font-weight: 500; color:#778899;">{{ strtoupper($leaveRequest['approvedLeaveRequest']->status) }}</span>
                                @endif
                            </div>

                            <div class="arrow-btn px-1">
                                <i class="fa fa-angle-down"></i>
                            </div>
                        </div>

                    </div>

                    <div class="accordion-body m-0 p-0">

                        <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:5px;"></div>

                        <div class="review-content" style="display: flex;justify-content:start;align-items: center;gap:7px;padding:5px;margin-bottom: 3px;">

                            <span style="color: #778899; font-size: 12px; font-weight: 500;">Duration:</span>

                            <span style="font-size: 12px;">

                                <span style="font-size: 12px; font-weight: 500;">{{ $leaveRequest['approvedLeaveRequest']->formatted_from_date }}</span>

                                ({{ $leaveRequest['approvedLeaveRequest']->from_session }} ) to

                                <span style="font-size: 12px; font-weight: 500;">{{ $leaveRequest['approvedLeaveRequest']->formatted_to_date }}</span>

                                ( {{ $leaveRequest['approvedLeaveRequest']->to_session }} )

                            </span>

                        </div>

                        <div class="review-content" style="display: flex;justify-content:start;align-items: center;gap:7px;padding:5px;margin-bottom: 3px;">

                            <span style="color: #778899; font-size: 12px; font-weight: 500;">Reason:</span>

                            <span style="font-size: 12px;">{{ucfirst( $leaveRequest['approvedLeaveRequest']->reason) }}</span>

                        </div>

                        <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>

                        <div style="display:flex; flex-direction:row; justify-content:space-between;">

                            <div class="review-content" style="display: flex;justify-content:start;align-items: center;gap:7px;padding:5px;margin-bottom: 3px;">

                                <span style="color: #778899; font-size: 12px; font-weight: 400;">Applied on:</span>

                                <span style="color: #333; font-size: 11px; font-weight: 500;">{{ $leaveRequest['approvedLeaveRequest']->created_at->format('d M, Y') }}</span>

                            </div>
                            <div class="review-content" style="display: flex;justify-content:start;align-items: center;gap:7px;padding:5px;margin-bottom: 3px;">
                                <span style="color: #778899; font-size: 12px; font-weight: 500;">Leave Balance:</span>
                                @if(!empty($leaveRequest['leaveBalances']))
                                <div style=" flex-direction:row; display: flex; align-items: center;justify-content:center;">
                                    <!-- Sick Leave -->
                                    <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #e6e6fa; display: flex; align-items: center; justify-content: center; margin-left:15px;">
                                        <span style="font-size: 10px; color: #50327c;font-weight:500;">SL</span>
                                    </div>
                                    <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['sickLeaveBalance'] }}</span>
                                    <!-- Casual Leave -->
                                    <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #e7fae7; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                        <span style="font-size: 10px; color: #1d421e;font-weight:500;">CL</span>
                                    </div>
                                    <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['casualLeaveBalance'] }}</span>
                                    <!-- Casual Leave Probation-->
                                    <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #e7fae7; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                        <span style="font-size: 10px; color: #1d421e;font-weight:500;">CLP</span>
                                    </div>
                                    <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['casualProbationLeaveBalance'] }}</span>
                                    <!-- Loss of Pay -->
                                    @if($leaveRequest['approvedLeaveRequest']->leave_type === 'Loss of Pay')
                                    <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                        <span style="font-size: 10px; color: #890000;font-weight:500;">LOP</span>
                                    </div>
                                    <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['lossOfPayBalance'] }}</span>
                                    @elseif($leaveRequest['approvedLeaveRequest']->leave_type === 'Maternity Leave')
                                    <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                        <span style="font-size: 10px; color: #890000;font-weight:500;">ML</span>
                                    </div>
                                    <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['maternityLeaveBalance'] }}</span>
                                    @elseif($leaveRequest['approvedLeaveRequest']->leave_type === 'Marriage Leave')
                                    <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                        <span style="font-size: 10px; color: #890000;font-weight:500;">MRL</span>
                                    </div>
                                    <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['marriageLeaveBalance'] }}</span>
                                    @elseif($leaveRequest['approvedLeaveRequest']->leave_type === 'Petarnity Leave')
                                    <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                        <span style="font-size: 10px; color: #890000;font-weight:500;">PL</span>
                                    </div>
                                    <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['paternityLeaveBalance'] }}</span>

                                    @endif
                                </div>
                                @else
                                <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">0</span>
                                @endif
                            </div>

                            <div class="review-content" style="display: flex;justify-content:start;align-items: center;gap:7px;padding:5px;margin-bottom: 3px;">

                                <a href="{{ route('approved-details', ['leaveRequestId' => $leaveRequest['approvedLeaveRequest']->id]) }}">
                                    <span style="color: #3a9efd; font-size: 11px; font-weight: 500;">View Details</span>
                                </a>

                            </div>

                        </div>

                    </div>

                </div>
                @endforeach
            </div>
            <!-- if loginid is a normal employee they can view their leave history -->
            @else
            <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                <img src="/images/pending.png" alt="Pending Image" style="width:50%; margin:0 auto;">
                <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no closed leave records to view</p>
            </div>
            @endif
            @else
            <div class="closed-leaves-container px-2" style="width:100%; max-height:400px; overflow-y:auto; margin:10px auto;">
                @if($empLeaveRequests->isNotEmpty())
                @foreach($empLeaveRequests->whereIn('status', ['approved', 'rejected','Withdrawn']) as $leaveRequest)
                <div class="accordion rounded mb-3">
                    <div class="accordion-heading rounded p-2" onclick="toggleAccordion(this)">
                        <div class="accordion-head rounded d-flex justify-content-between m-auto ">
                            <!-- Display leave details here based on $leaveRequest -->
                            <div class="col accordion-content">
                                <div class="accordion-profile" style="display:flex; gap:7px; margin:auto 0;align-items:center;justify-content:center;">
                                    @if(isset($leaveRequest->employee->image))
                                    <img src="{{ asset('storage/' . $leaveRequest->employee->image) }}" alt="" style="background:#f3f3f3;border:1px solid #ccc;width: 40px; height: 40px; border-radius: 50%;">
                                    @else
                                    <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars.png" alt="" style="background:#f3f3f3;border:1px solid #ccc;width: 40px; height: 40px; border-radius: 50%;">
                                    @endif
                                    <div>
                                        <p style="font-size: 12px; font-weight: 500; text-align: start; margin: 0 auto;">
                                            @if(isset($leaveRequest->employee->first_name))
                                            <span style="display: inline-block; width: 110px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ ucwords(strtolower($leaveRequest->employee->first_name)) }} {{ ucwords(strtolower($leaveRequest->employee->last_name)) }}">
                                                {{ ucwords(strtolower($leaveRequest->employee->first_name)) }} {{ ucwords(strtolower($leaveRequest->employee->last_name)) }}
                                            </span>
                                            @endif
                                            @if(isset($leaveRequest->emp_id))
                                            <span style="color: #778899; font-size: 10px; text-align: start;">
                                                #{{ $leaveRequest->emp_id }}
                                            </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col accordion-content">
                                <span style="color: #778899; font-size: 12px; font-weight: 500;">Leave Type</span>
                                <span class="leave-type-hide" title="{{ $leaveRequest->leave_type }}">{{ $leaveRequest->leave_type }}</span>
                            </div>

                            <div class="col accordion-content">
                                <span style="color: #778899; font-size:12px; font-weight: 500;">No. of Days</span>
                                <span style="color: #36454F; font-size:12px; font-weight: 500;">
                                    {{ $this->calculateNumberOfDays($leaveRequest->from_date, $leaveRequest->from_session, $leaveRequest->to_date, $leaveRequest->to_session) }}
                                </span>
                            </div>
                            <div class="col accordion-content">
                                @if(strtoupper($leaveRequest->status) == 'APPROVED')
                                <span style=" font-size: 12px; font-weight: 500; color:#32CD32;">{{ strtoupper($leaveRequest->status) }}</span>
                                @elseif(strtoupper($leaveRequest->status) == 'REJECTED')
                                <span style=" font-size: 12px; font-weight: 500; color:#FF0000;">{{ strtoupper($leaveRequest->status) }}</span>
                                @else
                                <span style=" font-size: 12px; font-weight: 500; color:#778899;">{{ strtoupper($leaveRequest->status) }}</span>
                                @endif
                            </div>

                            <div class="arrow-btn px-1">
                                <i class="fa fa-angle-down"></i>
                            </div>
                        </div>

                    </div>

                    <div class="accordion-body m-0 p-0">

                        <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:5px;"></div>

                        <div class="review-content" style="display: flex;justify-content:start;align-items: center;gap:7px;padding:5px;margin-bottom: 3px;">

                            <span style="color: #778899; font-size: 12px; font-weight: 500;">Duration:</span>

                            <span style="font-size: 12px;">

                                <span style="font-size: 12px; font-weight: 500;">{{ $leaveRequest->formatted_from_date }}</span>

                                ({{ $leaveRequest->from_session }} ) to

                                <span style="font-size: 12px; font-weight: 500;">{{ $leaveRequest->formatted_to_date }}</span>

                                ( {{ $leaveRequest->to_session }} )

                            </span>

                        </div>

                        <div class="review-content" style="display: flex;justify-content:start;align-items: center;gap:7px;padding:5px;margin-bottom: 3px;">

                            <span style="color: #778899; font-size: 12px; font-weight: 500;">Reason:</span>

                            <span style="font-size: 12px;">{{ucfirst( $leaveRequest->reason) }}</span>

                        </div>

                        <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>

                        <div style="display:flex; flex-direction:row; justify-content:space-between;">

                            <div class="review-content" style="display: flex;justify-content:start;align-items: center;gap:7px;padding:5px;margin-bottom: 3px;">

                                <span style="color: #778899; font-size: 12px; font-weight: 400;">Applied on:</span>

                                <span style="color: #333; font-size: 11px; font-weight: 500;">{{ $leaveRequest->created_at->format('d M, Y') }}</span>

                            </div>


                            <div class="review-content" style="display: flex;justify-content:start;align-items: center;gap:7px;padding:5px;margin-bottom: 3px;">

                                <a href="{{ route('approved-details', ['leaveRequestId' => $leaveRequest->id]) }}">
                                    <span style="color: #3a9efd; font-size: 11px; font-weight: 500;">View Details</span>
                                </a>

                            </div>

                        </div>

                    </div>

                </div>
                @endforeach
            </div>
            <!-- if loginid is a normal employee they can view their leave history -->
            @else
            <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                <img src="/images/pending.png" alt="Pending Image" style="width:50%; margin:0 auto;">
                <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no closed leave records to view</p>
            </div>
            @endif
        </div>
        @endif
    </div>
    @endif
</div>
@elseif($currentSection === 'Leave Cancel')
<div class="d-flex align-items-center justify-content-center gap-4">
    <button wire:click="toggleActiveContent('Leave Cancel')" class="btn" style="font-size:12px;background-color: {{ $activeButton['Leave Cancel'] ? 'rgb(2, 17, 79)' : 'white' }};
                            color: {{ $activeButton['Leave Cancel'] ? 'white' : 'black' }}">
        Active
    </button>
    <button wire:click="toggleClosedContent('Leave Cancel')" class="btn" style="border:1px solid rgb(2, 17, 79);font-size:12px;background-color: {{ $activeButton['Leave Cancel'] ? 'white' : 'rgb(2, 17, 79)' }};
                            color: {{ $activeButton['Leave Cancel'] ? 'rgb(2, 17, 79)' : 'white' }}">
        Closed
    </button>
</div>
<div class="mt-5">
    @if($activeButton['Leave Cancel'])
    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
        <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
        <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no Leave Cancel records to view</p>
    </div>
    @else
    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
        <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
        <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no closed Leave Cancel records to view</p>
    </div>
    @endif
</div>
@elseif($currentSection === 'Leave Comp Off')
<div class="d-flex align-items-center justify-content-center gap-4">
    <button wire:click="toggleActiveContent('Leave Comp Off')" class="btn" style="font-size:12px;background-color: {{ $activeButton['Leave Comp Off'] ? 'rgb(2, 17, 79)' : 'white' }};
                            color: {{ $activeButton['Leave Comp Off'] ? 'white' : 'black' }}">
        Active
    </button>
    <button wire:click="toggleClosedContent('Leave Comp Off')" class="btn" style="border:1px solid rgb(2, 17, 79);font-size:12px;background-color: {{ $activeButton['Leave Comp Off'] ? 'white' : 'rgb(2, 17, 79)' }};
                            color: {{ $activeButton['Leave Comp Off'] ? 'rgb(2, 17, 79)' : 'white' }}">
        Closed
    </button>
</div>
<div class="mt-5">
    @if($activeButton['Leave Comp Off'])
    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
        <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
        <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no Leave Comp Off records to view</p>
    </div>
    @else
    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
        <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
        <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no closed Leave Comp Off records to view</p>
    </div>
    @endif
</div>
@elseif($currentSection === 'Restricted Holiday')
<div class="d-flex align-items-center justify-content-center gap-4">
    <button wire:click="toggleActiveContent('Restricted Holiday')" class="btn" style="font-size:12px;background-color: {{ $activeButton['Restricted Holiday'] ? 'rgb(2, 17, 79)' : 'white' }};
                            color: {{ $activeButton['Restricted Holiday'] ? 'white' : 'black' }}">
        Active
    </button>
    <button wire:click="toggleClosedContent('Restricted Holiday')" class="btn" style="border:1px solid rgb(2, 17, 79); font-size:12px;background-color: {{ $activeButton['Restricted Holiday'] ? 'white' : 'rgb(2, 17, 79)' }};
                            color: {{ $activeButton['Restricted Holiday'] ? 'rgb(2, 17, 79)' : 'white' }}">
        Closed
    </button>
</div>
<div class="mt-5">
    @if($activeButton['Restricted Holiday'])
    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
        <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
        <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no Restricted Holiday records to view</p>
    </div>
    @else
    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
        <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
        <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no closed Restricted Holiday records to view</p>
    </div>
    @endif
</div>
@endif
</div>
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