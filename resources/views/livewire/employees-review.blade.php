<div>
    <style>
        .emp-side-page-nav-item-group {
            font-weight: 600;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
            font-weight: normal;
            padding-left: 1rem;
            font-size: 0.75rem;
            color: rgba(127, 143, 164, .5);
        }

        .emp-side-page-nav-item {
            padding-left: 1rem;
            margin-bottom: 0.5rem;
            align-items: center;
        }

        .emp-side-page-nav-item .nav-link {
            cursor: pointer;
            color: #778899;
            text-decoration: none;
            padding: 0px;
        }

        .emp-side-page-nav-item .nav-link:hover {
            border-radius: 0px;

        }

        .nav-link.active {
            font-weight: 600;
            color: rgb(2, 17, 79);
            border-left: 2px solid rgb(2, 17, 79);
            padding: 0.3rem;
            white-space: nowrap;
            border-radius: none;
        }

        .emp-info {
            white-space: nowrap;
            border-radius: none;
        }


        .emp-input-with-icon {
            position: relative;

        }

        .emp-search {
            color: #778899;
        }

        .emp-input-with-icon input {

            padding-right: 30px;
            box-sizing: border-box;
            border: 1px solid #ccc;
        }

        .emp-input-with-icon i {
            position: absolute;
            right: 25px;
            top: 55%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .workflow-list-view-empty {
            margin-top: 30px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            width: 100%;
            height: 60vh;
            min-height: calc(90vh - 200px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #a3b2c7;

        }

        .emp-leave-count {
            display: inline-flex;
        }

        .leaveCountReview {
            height: 15px;
            margin: 3px;
            font-size: 0.6rem;
            width: 15px;
            border-radius: 50%;
            background-color: #FAE392;
            padding: 5px;
        }

        .image-scheme-empty-state {
            width: 300px;
            height: 150px;
            background: url(https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcS8OnbtjxKr4x4YdVfTg3g4MWT4WR6BJFIhIGQuhZkUyZt8zd4t) no-repeat 50%;
            margin-bottom: 20px;
        }
    </style>



    <div class="row m-0 p-0">

        <div class="sidenav col-md-3 col-lg-2">
            <div>
                <ul class="nav flex-column side-page-nav">
                    <label class="emp-side-page-nav-item-group">LEAVE</label>
                    <li class="nav-item emp-side-page-nav-item d-flex gap-1" tabindex="0">
                        <p class="emp-leave-count mb-0 ">
                            <span class="nav-link emp-info {{ $activeTab === 'leave' ? 'active' : '' }}" wire:click="setActiveTab('leave')">
                                Leave
                            </span>
                        </p>
                    </li>
                    <li class="nav-item emp-side-page-nav-item" tabindex="0">
                        <span class="nav-link emp-info {{ $activeTab === 'attendance' ? 'active' : '' }}" wire:click="setActiveTab('attendance')">
                            Attendance Regularization
                        </span>
                    </li>
                </ul>
            </div>
        </div>


        @if($showattendance )
        <div class="col-md-9 col-lg-9 py-2x ml-3x">

            <div class="nav-buttons d-flex justify-content-center" style="margin-top: 15px;">
                <ul class="nav custom-nav-tabs border">
                    <li class="custom-item m-0 p-0 flex-grow-1">
                        <div style="border-top-left-radius:5px;border-bottom-left-radius:5px;" class="custom-nav-link {{ $attendenceActiveTab === 'active' ? 'active' : '' }}" wire:click.prevent="$set('attendenceActiveTab', 'active')">Active</div>
                    </li>
                    <li class="custom-item m-0 p-0 flex-grow-1">
                        <a href="#" style="border-top-right-radius:5px;border-bottom-right-radius:5px;" class="custom-nav-link {{ $attendenceActiveTab === 'closed' ? 'active' : '' }}" wire:click.prevent="$set('attendenceActiveTab', 'closed')">Closed</a>
                    </li>
                </ul>
            </div>

            @if ($attendenceActiveTab == "active")

            <div class="row p-0 m-0 mt-3" style="display:flex; justify-content: end;">

                <!-- <div class="col-3 emp-input-with-icon">
                    <input autocomplete="off" placeholder="Select date range" name="searchKey"
                        typeaheadoptionfield="name" typeaheadwaitms="300"
                        class="form-control text-overflow ng-untouched ng-pristine ng-valid" aria-exp anded="false"
                        aria-autocomplete="list">

                </div> -->




            </div>



            <div class="reviewList" style="margin:30px auto;">
                @livewire('view-regularisation-pending-new')
            </div>



            @else

            <div class="row p-0 mt-3" style="display:flex; justify-content: end;">

                <!-- <div class="col-3 emp-input-with-icon">
                    <input autocomplete="off" placeholder="Select date range" name="searchKey"
                        typeaheadoptionfield="name" typeaheadwaitms="300"
                        class="form-control text-overflow ng-untouched ng-pristine ng-valid" aria-exp anded="false"
                        aria-autocomplete="list">

                </div> -->


                <div class="row m-0 p-0 mt-3">
                    <div class="search-container d-flex align-items-end justify-content-end p-1">
                        <input type="text" wire:model.debounce.500ms="searchQuery" id="searchInput" placeholder="Enter employee name" class="border outline-none rounded">
                        <button wire:click="searchApprovedLeave" id="searchButton" style="border:none;outline:none;background:#fff;border-radius:5px;padding:1px 10px;">
                            <i class="fas fa-search" style="width:7px;height:7px;"></i>
                        </button>
                    </div>
                </div>


            </div>


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
                    <div class="accordion-heading rounded " onclick="toggleAccordion(this)">

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
                    <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
                    <p style="color:#969ea9; font-size:12px; font-weight:400; "> Hey, you have no closed regularization records
                        to view
                    </p>
                </div>
                @endif

                @endif

        </div>

        @endif

        @if($showleave)

        <div class="col-md-9 col-lg-9 py-2x ml-3x">

            <div class="nav-buttons d-flex justify-content-center" style="margin-top: 15px;">
                <ul class="nav custom-nav-tabs border">
                    <li class="custom-item m-0 p-0 flex-grow-1">
                        <div style="border-top-left-radius:5px;border-bottom-left-radius:5px;" class="custom-nav-link {{ $leaveactiveTab === 'active' ? 'active' : '' }}" wire:click.prevent="$set('leaveactiveTab', 'active')">Active</div>
                    </li>
                    <li class="custom-item m-0 p-0 flex-grow-1">
                        <a href="#" style="border-top-right-radius:5px;border-bottom-right-radius:5px;" class="custom-nav-link {{ $leaveactiveTab === 'closed' ? 'active' : '' }}" wire:click.prevent="$set('leaveactiveTab', 'closed')">Closed</a>
                    </li>
                </ul>
            </div>

            @if ($leaveactiveTab === "active")
            <!--
            <div class="row p-0 mt-3" style="display:flex; justify-content: end;"> -->

            <!-- <div class="col-3 emp-input-with-icon">
                    <input autocomplete="off" placeholder="Select date range" name="searchKey"
                        typeaheadoptionfield="name" typeaheadwaitms="300"
                        class="form-control text-overflow ng-untouched ng-pristine ng-valid" aria-exp anded="false"
                        aria-autocomplete="list">

                </div> -->

            <!-- </div> -->


            <div class="pending-leavves-container" style="width:100%; max-height:100vh; overflow-y:auto; margin-top:50px;">
                @if($count > 0)
                <div class="reviewList">
                    @livewire('view-pending-details')
                </div>
                @else
                <div class=" bg-white rounded border text-center" style="width:80%;margin:30px auto;">
                    <div class="d-flex flex-column justify-content-center">
                        <img src="/images/pending.png" alt="Pending Image" style="width:50%; margin:0 auto;">
                        <p style="color:#969ea9; font-size:12px; font-weight:400;">Hey, you have no leave records to view
                        </p>
                    </div>
                </div>
                @endif
            </div>


            @else
            <div class="row p-0 m-0 mt-3" style="display:flex; justify-content: end;">

                <!-- <div class="col-3 emp-input-with-icon">
                    <input autocomplete="off" placeholder="Select date range" name="searchKey"
                        typeaheadoptionfield="name" typeaheadwaitms="300"
                        class="form-control text-overflow ng-untouched ng-pristine ng-valid" aria-exp anded="false"
                        aria-autocomplete="list">
                </div> -->

                <div class="row m-0 p-0 mt-3 d-flex align-items-end justify-content-end">
                    <div class="col-md-4 m-0 p-0">
                        <div class=" search-container  p-2" style="position: relative;">
                            <input type="text" wire:model.debounce.500ms="searchQuery" id="searchInput" placeholder="Search..." class="form-control placeholder-small border outline-none rounded" style="padding-right: 40px;">
                            <button wire:click="searchPendingLeave" id="searchButtonReview">
                                <i class="fas fa-search" style="width: 16px; height: 16px;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @php
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $isManager = DB::table('employee_details')->where('manager_id', $employeeId)->exists();
            @endphp
            @if($isManager)
            <div class="closed-leaves-container px-2" style="width:100%; max-height:100vh; overflow-y:auto; margin:20px auto;">
                @if(!empty($approvedLeaveApplicationsList))
                @foreach($approvedLeaveApplicationsList as $leaveRequest)
                <div class="accordion rounded mb-3">
                    <div class="accordion-heading rounded p-1" onclick="toggleAccordion(this)">
                        <div class="accordion-head rounded m-0">
                            <!-- Display leave details here based on $leaveRequest -->
                            <div class="col accordion-content">
                                <div class="accordion-profile d-flex align-items-center justify-content-center" style="gap:7px; margin:auto 0;">
                                    @if(isset($leaveRequest['approvedLeaveRequest']->image) && $leaveRequest['approvedLeaveRequest']->image !== 'null')
                                    <img height="40" width="40" src="{{ 'data:image/jpeg;base64,' . base64_encode($leaveRequest['approvedLeaveRequest']->image)}}" style="border-radius: 50%;">
                                    @else
                                    @if($leaveRequest['approvedLeaveRequest']->gender === 'Female')
                                    <img src="{{ asset('images/user.jpg') }}" alt="" height="40" width="40" style="border-radius: 50%;">
                                    @elseif($leaveRequest['approvedLeaveRequest']->gender === 'Male')
                                    <img src="{{ asset('images/user.jpg') }}" alt="" height="40" width="40" style="border-radius: 50%;">
                                    @else
                                    <img src="{{ asset('images/user.jpg') }}" alt="" height="40" width="40" style="border-radius: 50%;">
                                    @endif
                                    @endif
                                    <div>
                                        @if(isset($leaveRequest['approvedLeaveRequest']->first_name))
                                        <p class="mb-0 normalText m-auto text-start">
                                            <span style="display: inline-block; width: 110px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ ucwords(strtolower($leaveRequest['approvedLeaveRequest']->first_name)) }} {{ ucwords(strtolower($leaveRequest['approvedLeaveRequest']->last_name)) }}">
                                                {{ ucwords(strtolower($leaveRequest['approvedLeaveRequest']->first_name)) }}
                                                {{ ucwords(strtolower($leaveRequest['approvedLeaveRequest']->last_name)) }}
                                            </span>

                                            @if(isset($leaveRequest['approvedLeaveRequest']->emp_id))
                                            <span style="color: #778899; font-size: 10px; text-align: start;">
                                                #{{ $leaveRequest['approvedLeaveRequest']->emp_id }}
                                            </span>
                                            @endif
                                        </p>

                                        @else
                                        <p class="normalTetValue text-center mb-0">Name Not
                                            Available</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col accordion-content">
                                <span class="category-type-hide">Category</span>
                                <span class="leave-type-hide" title="{{ $leaveRequest['approvedLeaveRequest']->category_type }}">{{ $leaveRequest['approvedLeaveRequest']->category_type }}</span>
                            </div>

                            <div class="col accordion-content">
                                <span class="category-type-hide">Leave Type</span>
                                <span class="leave-type-hide" title="{{ $leaveRequest['approvedLeaveRequest']->leave_type }}">{{ $leaveRequest['approvedLeaveRequest']->leave_type }}</span>
                            </div>

                            <div class="col accordion-content">
                                <span class="category-type-hide">No. of Days</span>
                                <span style="color: #36454F; font-size:12px; font-weight: 500;">
                                    {{ $this->calculateNumberOfDays($leaveRequest['approvedLeaveRequest']->from_date, $leaveRequest['approvedLeaveRequest']->from_session, $leaveRequest['approvedLeaveRequest']->to_date, $leaveRequest['approvedLeaveRequest']->to_session) }}
                                </span>
                            </div>
                            @if(($leaveRequest['approvedLeaveRequest']->category_type) == 'Leave')
                            <div class="col accordion-content">
                                @if(strtoupper($leaveRequest['approvedLeaveRequest']->status) == 'APPROVED')
                                <span style=" font-size: 12px; font-weight: 500; color:#32CD32;">{{ strtoupper($leaveRequest['approvedLeaveRequest']->status) }}</span>
                                @elseif(strtoupper($leaveRequest['approvedLeaveRequest']->status) == 'REJECTED')
                                <span style=" font-size: 12px; font-weight: 500; color:#FF0000;">{{ strtoupper($leaveRequest['approvedLeaveRequest']->status) }}</span>
                                @else
                                <span class="normalTextValue">{{ strtoupper($leaveRequest['approvedLeaveRequest']->status) }}</span>
                                @endif
                            </div>
                            @else
                            <div class="col accordion-content">
                                @if(strtoupper($leaveRequest['approvedLeaveRequest']->cancel_status) == 'APPROVED')
                                <span style=" font-size: 12px; font-weight: 500; color:#32CD32;">{{ strtoupper($leaveRequest['approvedLeaveRequest']->cancel_status) }}</span>
                                @elseif(strtoupper($leaveRequest['approvedLeaveRequest']->cancel_status) == 'REJECTED')
                                <span style=" font-size: 12px; font-weight: 500; color:#FF0000;">{{ strtoupper($leaveRequest['approvedLeaveRequest']->cancel_status) }}</span>
                                @else
                                <span class="normalTextValue">{{ strtoupper($leaveRequest['approvedLeaveRequest']->cancel_status) }}</span>
                                @endif
                            </div>
                            @endif
                            <div class="arrow-btn px-1">
                                <i class="fa fa-angle-down"></i>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-body m-0 p-0">
                        <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>
                        <div class="review-content px-3">

                            <span class="normalTextValue">Duration:</span>

                            <span class="normalText font-weight-normal">

                                <span class="normalText">{{ $leaveRequest['approvedLeaveRequest']->formatted_from_date }}</span>

                                ({{ $leaveRequest['approvedLeaveRequest']->from_session }} ) to

                                <span class="normalText">{{ $leaveRequest['approvedLeaveRequest']->formatted_to_date }}</span>

                                ( {{ $leaveRequest['approvedLeaveRequest']->to_session }} )

                            </span>

                        </div>

                        <div class="review-content px-3">

                            <span class="normalTextValue">Reason:</span>

                            <span class="normalText font-weight-400">{{ucfirst( $leaveRequest['approvedLeaveRequest']->reason) }}</span>
                        </div>

                        <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>
                        <div class="approvedLeaveDetails d-flex justify-content-between align-items-center">

                            <div class="review-content px-3">

                                <span class="normalTextValue">Applied on:</span>

                                <span class="normalText">{{ $leaveRequest['approvedLeaveRequest']->created_at->format('d M, Y') }}</span>

                            </div>
                            <div class="review-content px-3">
                                <span class="normalTextValue">Leave Balance:</span>
                                @if(!empty($leaveRequest['leaveBalances']))
                                <div class="d-flex align-items-center flex-row justify-content-center">
                                    @if(isset($leaveRequest['leaveBalances']['sickLeaveBalance']))
                                    <!-- Sick Leave -->
                                    <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #e6e6fa; display: flex; align-items: center; justify-content: center; margin-left:15px;">
                                        <span style="font-size: 10px; color: #50327c;font-weight:500;">SL</span>
                                    </div>
                                    <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['sickLeaveBalance'] }}</span>
                                    @else
                                    <span>Key does not exist</span>
                                    @endif
                                    <!-- Casual Leave -->
                                    <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #e7fae7; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                        <span style="font-size: 10px; color: #1d421e;font-weight:500;">CL</span>
                                    </div>
                                    <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['casualLeaveBalance'] }}</span>
                                    <!-- Casual Leave Probation-->
                                    @if($leaveRequest['approvedLeaveRequest']->leave_type === 'Casual Leave Probation')
                                    <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #e7fae7; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                        <span style="font-size: 10px; color: #1d421e;font-weight:500;">CLP</span>
                                    </div>
                                    <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['casualProbationLeaveBalance'] }}</span>
                                    <!-- Loss of Pay -->
                                    @elsif($leaveRequest['approvedLeaveRequest']->leave_type === 'Loss Of Pay' && isset($leaveRequest['leaveBalances']['lossOfPayBalance']))
                                    <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                        <span style="font-size: 10px; color: #890000;font-weight:500;">LOP</span>
                                    </div>
                                    <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">&minus;{{ $leaveRequest['leaveBalances']['lossOfPayBalance'] }}</span>
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

                            <div class="review-content px-3">
                                <a href="{{ route('approved-details', ['leaveRequestId' => $leaveRequest['approvedLeaveRequest']->id]) }}">
                                    <span style="color: #3a9efd; font-size: 11px; font-weight: 500;">View Details</span>
                                </a>

                            </div>

                        </div>

                    </div>

                </div>
                @endforeach
            </div>
            @else
            <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                <img src="/images/pending.png" alt="Pending Image" style="width:50%; margin:0 auto;">
                <p class="normalTextValue text-center">Hey, you have no leave records to view
                </p>
            </div>
            @endif
            <!-- if loginid is a normal employee they can view their leave history -->
            @else
            @if($empLeaveRequests->isNotEmpty())

            @foreach($empLeaveRequests as $leaveRequest)

            <div class="containerWidth mt-4">

                <div class="accordion rounded ">

                    <div class="accordion-heading rounded" onclick="toggleAccordion(this)">

                        <div class="accordion-title">

                            <!-- Display leave details here based on $leaveRequest -->

                            <div class="col accordion-content">

                                <span class="normalTextValue">Category</span>

                                <span class="normalText">{{ $leaveRequest->category_type}}</span>

                            </div>

                            <div class="col accordion-content">

                                <span class="normalTextValue">Leave Type</span>

                                <span class="normalText">{{ $leaveRequest->leave_type}}</span>

                            </div>

                            <div class="col accordion-content">

                                <span class="normalTextValue">No. of Days</span>

                                <span class="normalText">

                                    {{ $this->calculateNumberOfDays($leaveRequest->from_date, $leaveRequest->from_session, $leaveRequest->to_date, $leaveRequest->to_session) }}

                                </span>

                            </div>



                            <!-- Add other details based on your leave request structure -->
                            @if($leaveRequest->category_type == 'Leave Cancel')
                            <div class="col accordion-content">

                                @if(strtoupper($leaveRequest->cancel_status) == 'APPROVED')

                                <span class="accordionContentSpanValue" style="color:#32CD32 !important;">{{ strtoupper($leaveRequest->cancel_status) }}</span>

                                @elseif(strtoupper($leaveRequest->cancel_status) == 'REJECTED')

                                <span class="accordionContentSpanValue" style="color:#FF0000 !important;">{{ strtoupper($leaveRequest->cancel_status) }}</span>

                                @else

                                <span class="accordionContentSpanValue" style="color:#778899 !important;">{{ strtoupper($leaveRequest->cancel_status) }}</span>

                                @endif

                            </div>

                            @else
                            <div class="col accordion-content">

                                @if(strtoupper($leaveRequest->status) == 'APPROVED')

                                <span class="accordionContentSpanValue" style="color:#32CD32 !important;">{{ strtoupper($leaveRequest->status) }}</span>

                                @elseif(strtoupper($leaveRequest->status) == 'REJECTED')

                                <span class="accordionContentSpanValue" style="color:#FF0000 !important;">{{ strtoupper($leaveRequest->status) }}</span>

                                @else

                                <span class="accordionContentSpanValue" style="color:#778899 !important;">{{ strtoupper($leaveRequest->status) }}</span>

                                @endif

                            </div>
                            @endif

                            <div class="arrow-btn">
                                <i class="fa fa-chevron-down"></i>
                            </div>

                        </div>

                    </div>

                    <div class="accordion-body m-0 p-0">

                        <div class="verticalLine"></div>

                        <div class="content pt-1 px-3">

                            <span class="headerText">Duration:</span>

                            <span >

                                <span style="font-size: 11px; font-weight: 500;"> {{ \Carbon\Carbon::parse($leaveRequest->from_date)->format('d-m-Y') }}</span>

                                ({{ $leaveRequest->from_session }} ) to

                                <span style="font-size: 11px; font-weight: 500;"> {{ \Carbon\Carbon::parse($leaveRequest->to_date)->format('d-m-Y') }}</span>

                                ( {{ $leaveRequest->to_session }} )

                            </span>

                        </div>

                        <div class="content  pb-1 px-3">

                            <span class="headerText">Reason:</span>

                            <span style="font-size: 11px;">{{ ucfirst($leaveRequest->reason) }}</span>

                        </div>

                        <div class="verticalLine"></div>

                        <div class="d-flex flex-row justify-content-between px-3 py-2">

                            <div class="content px-1 ">

                                <span class="headerText">Applied on:</span>

                                <span class="paragraphContent">{{ $leaveRequest->created_at->format('d M, Y') }}</span>

                            </div>

                            <div class="content px-1 ">
                            <a href="{{ route('approved-details', ['leaveRequestId' => $leaveRequest->id]) }}">
                                    <span class="anchorTagDetails">View
                                        Details</span>
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>v

            @endforeach

            @else

            <div class="containerWidth">
                <div class="leave-pending rounded">

                    <img src="{{asset('/images/pending.png')}}" alt="Pending Image" class="imgContainer">

                    <p class="restrictedHoliday">There are no  records of any leave
                        transaction</p>

                </div>
            </div>

            @endif

            @endif


            @endif





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