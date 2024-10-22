<div>
    <div class="detail-container ">
        <div class="row m-0 p-0">
            <div class="col-md-4 p-0 m-0 mb-2 ">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb d-flex align-items-center ">
                        <li class="breadcrumb-item"><a type="button" style="color:#fff !important;" class="submit-btn" href="{{ route('review') }}">Back</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Review - View Details</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="header-details">
            @if ($leaveRequest->category_type === 'Leave')
            <p class="mb-0 ">Leave Applied on {{ optional($leaveRequest->created_at)->format('d M, Y') }}</p>
            @else
            <p class="mb-0 ">Leave Cancel Applied on {{ optional($leaveRequest->created_at)->format('d M, Y') }}</p>
            @endif
        </div>
        <div class="view-details-container ">
            <div class="heading mb-2
            ">
                <div class="heading-2">
                    <div class="d-flex justify-content-between flex-row">
                        <div class="field">
                            <span class="normalTextValue">
                                Applied by
                            </span>
                            <br>
                            <span class="normalText uppercase-text">
                                {{ strtoupper($this->leaveRequest->employee->first_name) }} {{ strtoupper($this->leaveRequest->employee->last_name) }}
                            </span>
                        </div>
                        <div>
                            @if($leaveRequest->category_type === 'Leave')
                            <span>
                                @if($leaveRequest->leave_status === 2)

                                <span class="approvedStatus">APPROVED</span>

                                @elseif($leaveRequest->leave_status === 3)

                                <span class="rejectedStatus">REJECTED</span>

                                @else

                                <span class="withDrawnStatus">-</span>

                                @endif
                            </span>
                            @else
                            <span>
                                @if($leaveRequest->cancel_status === 2)

                                <span class="approvedStatus">APPROVED</span>

                                @elseif($leaveRequest->cancel_status === 3)

                                <span class="rejectedStatus">REJECTED</span>

                                @else

                                <span class="withDrawnStatus">-</span>

                                @endif
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="middle-container">
                        <div class="view-container m-0 p-0">
                            <div class="first-col m-0 p-0 d-flex gap-4">
                                <div class="field p-2">
                                    <span class="normalTextValue">From Date</span> <br>
                                    <span class="normalText fw-bold"> {{ $leaveRequest->from_date->format('d M, Y') }}<br><span class="sessionFont">{{ $leaveRequest->from_session }}</span></span>
                                </div>
                                <div class="field p-2">
                                    <span class="normalTextValue ">To Date</span> <br>
                                    <span class="normalText fw-bold">{{ $leaveRequest->to_date->format('d M, Y') }} <br><span class="sessionFont">{{ $leaveRequest->to_session }}</span></span>
                                </div>
                                <div class="vertical-line"></div>
                            </div>
                            <div class="box d-flex text-center p-2">
                                <div class="field p-2">
                                    <span class="normalTextValue">No. of days</span> <br>
                                    <span class="normalText fw-bold"> {{ $this->calculateNumberOfDays($leaveRequest->from_date, $leaveRequest->from_session, $leaveRequest->to_date, $leaveRequest->to_session,$leaveRequest->leave_type) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row m-0 p-0 d-flex align-items-center">
                        <div class="col-md-7 m-0 p-0">
                            <div class="pay-bal">
                                <span class="normalTextValue">Balance:</span>
                                @if(!empty($this->leaveBalances))

                                <div class="d-flex align-items-center justify-content-center">

                                    <!-- Sick Leave -->

                                    <div class="sickLeaveCircle">

                                        <span class="sickLeaveBal">SL</span>

                                    </div>

                                    <span class="sickLeaveValue">{{ $leaveBalances['sickLeaveBalance'] }}</span>

                                    <!-- Casual Leave  -->

                                    <div class="casLeaveCircle">

                                        <span class="casLeaveBal">CL</span>

                                    </div>

                                    <span class="casLeaveValue">{{ $leaveBalances['casualLeaveBalance'] }}</span>

                                    <!-- Casual Leave  Probation-->
                                    @if($leaveRequest->leave_type === 'Casual Leave Probation' && isset($leaveBalances['casualProbationLeaveBalance']))
                                    <div class="probLeave">

                                        <span class="probLeaveBal">CLP</span>

                                    </div>

                                    <span class="probLeaveValue">{{ $leaveBalances['casualProbationLeaveBalance'] }}</span>

                                    <!-- Loss of Pay -->

                                    @elseif($leaveRequest->leave_type === 'Loss Of Pay' && isset($leaveBalances['lossOfPayBalance']))

                                    <div class="lossLeave">

                                        <span class="lossLeaveBal">LOP</span>

                                    </div>
                                    @if(($leaveBalances['lossOfPayBalance'])>0)
                                    <span class="lossLeaveValue">&minus;{{ $leaveBalances['lossOfPayBalance'] }}</span>
                                    @else
                                    <span class="lossLeaveValue">{{ $leaveBalances['lossOfPayBalance'] }}</span>
                                    @endif

                                    @elseif($leaveRequest->leave_type === 'Marriage Leave' && isset($leaveBalances['marriageLeaveBalance']))

                                    <div class="marriageLeave">

                                        <span class="marriageLeaveBal">MRL</span>

                                    </div>

                                    <span class="marriageLeaveValue">{{ $leaveBalances['marriageLeaveBalance'] }}</span>

                                    @elseif($leaveRequest->leave_type === 'Petarnity Leave' && isset($leaveBalances['paternityLeaveBalance']))

                                    <div class="petarnityLeave">

                                        <span class="petarnityLeaveBal">PL</span>

                                    </div>

                                    <span class="petarnityLeaveValue">{{ $leaveBalances['paternityLeaveBalance'] }}</span>

                                    @elseif($leaveRequest->leave_type === 'Maternity Leave' && isset($leaveBalances['maternityLeaveBalance']))

                                    <div class="maternityLeave">

                                        <span class="maternityLeaveBal">ML</span>

                                    </div>

                                    <span class="maternityLeaveValue">{{ $leaveBalances['maternityLeaveBalance'] }}</span>

                                    @endif

                                </div>

                                @endif
                            </div>
                        </div>
                        <div class="col-md-3 m-0 p-0">
                            <span class="leave-type">{{ $leaveRequest->leave_type }}</span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="approved-leave-details">
                    <div class="data">
                        <span class="normalTextSubheading">Details</span>
                        <div class="row m-0 p-0">
                            <div class="col-md-8 m-0 p-0">
                                <div class="custom-grid-container text-start">
                                    <div class="custom-grid-item">
                                        <span class="custom-label">Applied to</span>
                                        <span class="custom-label">Reason</span>
                                        @if($leaveRequest->category_type === 'Leave')
                                        <span class="custom-label">Contact</span>
                                        @endif
                                        @if(!empty($leaveRequest->cc_to))
                                        <span class="custom-label">CC to</span>
                                        @endif
                                        @if (!empty($leaveRequest->file_paths))
                                        <span class="custom-label">Attachments</span>
                                        @endif
                                    </div>

                                    <div class="custom-grid-item">
                                        @if(!empty($leaveRequest['applying_to']))
                                        @foreach($leaveRequest['applying_to'] as $applyingTo)
                                        <span class="custom-value">{{ ucwords(strtolower($applyingTo['report_to'])) }}</span>
                                        @endforeach
                                        @else
                                        <span class="custom-value">-</span>
                                        @endif
                                        @if($leaveRequest->category_type === 'Leave')
                                        <span class="custom-value">{{ ucfirst($leaveRequest->reason) }}</span>
                                        @else
                                        <span class="custom-value">{{ ucfirst($leaveRequest->leave_cancel_reason) }}</span>
                                        @endif
                                        @if($leaveRequest->category_type === 'Leave')
                                        <span class="custom-value">{{ ucfirst($leaveRequest->contact_details) }}</span>
                                        @endif
                                        @if (!empty($leaveRequest->cc_to))
                                        <span class="custom-value">
                                            @if (is_string($leaveRequest->cc_to))
                                            @foreach(json_decode($leaveRequest->cc_to, true) as $ccToItem)
                                            <span class="custom-cc-item">
                                                {{ ucwords(strtolower($ccToItem['full_name'])) }} (#{{ $ccToItem['emp_id'] }})
                                            </span>
                                            @if (!$loop->last)
                                            ,
                                            @endif
                                            @endforeach
                                            @else
                                            @foreach($leaveRequest->cc_to as $ccToItem)
                                            <span class="custom-cc-item">
                                                {{ ucwords(strtolower($ccToItem['full_name'])) }} (#{{ $ccToItem['emp_id']}})
                                            </span>
                                            @if (!$loop->last)
                                            ,
                                            @endif
                                            @endforeach
                                            @endif
                                        </span>
                                        @endif
                                        @if (!empty($leaveRequest->file_paths))
                                        @php

                                        // Check if $leaveRequest->file_paths is a string or an array
                                        $fileDataArray = is_string($leaveRequest->file_paths)
                                        ? json_decode($leaveRequest->file_paths, true)
                                        : $leaveRequest->file_paths;

                                        // Separate images and files
                                        $images = array_filter(
                                        $fileDataArray,
                                        fn($fileData) => strpos($fileData['mime_type'], 'image') !== false,
                                        );
                                        $files = array_filter(
                                        $fileDataArray,
                                        fn($fileData) => strpos($fileData['mime_type'], 'image') === false,
                                        );

                                        @endphp


                                        {{-- view file popup --}}
                                        @if ($showViewImageDialog)
                                        <div class="modal custom-modal" tabindex="-1" role="dialog" style="display: block;">
                                            <div class="modal-dialog custom-modal-dialog custom-modal-dialog-centered custom-modal-lg" role="document">
                                                <div class="modal-content custom-modal-content">
                                                    <div class="modal-header custom-modal-header">
                                                        <h5 class="modal-title view-file">View Image</h5>
                                                    </div>
                                                    <div class="modal-body custom-modal-body">
                                                        <div class="swiper-container">
                                                            <div class="swiper-wrapper">
                                                                @foreach ($images as $image)
                                                                @php
                                                                $base64File = $image['data'];
                                                                $mimeType = $image['mime_type'];
                                                                @endphp
                                                                <div class="swiper-slide">
                                                                    <img src="data:{{ $mimeType }};base64,{{ $base64File }}" class="img-fluid" alt="Image">
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer custom-modal-footer">
                                                        <button type="button" class="submit-btn" wire:click.prevent="downloadImage">Download</button>
                                                        <button type="button" class="cancel-btn1" wire:click="closeViewImage">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-backdrop fade show blurred-backdrop"></div>
                                        @endif
                                        @if ($showViewFileDialog)
                                        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title view-file">View Files</h5>
                                                    </div>
                                                    <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                                                        <ul class="list-group list-group-flush">
                                                            @foreach ($files as $file)a

                                                            @php

                                                            $base64File = $file['data'];

                                                            $mimeType = $file['mime_type'];

                                                            $originalName = $file['original_name'];

                                                            @endphp

                                                            <li>

                                                                <a href="data:{{ $mimeType }};base64,{{ $base64File }}"

                                                                    download="{{ $originalName }}"

                                                                    class="anchorTagDetails">

                                                                    {{ $originalName }}

                                                                </a>

                                                            </li>

                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="cancel-btn1" wire:click="closeViewFile">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-backdrop fade show blurred-backdrop"></div>
                                        @endif
                                        <!-- Trigger Links -->
                                        @if (!empty($images) && count($images) > 1)
                                        <a href="#" wire:click.prevent="showViewImage"
                                            class="anchorTagDetails">
                                            View Images
                                        </a>
                                        @elseif(!empty($images) && count($images) == 1)
                                        <a href="#" wire:click.prevent="showViewImage"
                                            class="anchorTagDetails">
                                            View Image
                                        </a>

                                        @endif

                                        @if (!empty($files) && count($files) > 1)
                                        <a href="#" wire:click.prevent="showViewFile"
                                            class="anchorTagDetails">
                                            Download Files
                                        </a>
                                        @elseif(!empty($files) && count($files) == 1)
                                        @foreach($files as $file)
                                        @php
                                            $base64File = trim($file['data'] ?? '');
                                            $mimeType = $file['mime_type'] ?? 'application/octet-stream'; // Default MIME type
                                            $originalName = $file['original_name'] ?? 'download.pdf'; // Default file name
                                        @endphp
                                
                                        <a href="data:{{ $mimeType }};base64,{{ $base64File }}"
                                           download="{{ $originalName }}" class="anchorTagDetails">
                                            Download File
                                        </a>
                                    @endforeach
                                        @endif
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="side-container">
                <h6 class="normalTextValue text-start mb-2"> Application Timeline </h6>
                <div class="d-flex gap-2">
                    <div class="mt-4">
                        <div class="cirlce"></div>
                        <div class="v-line"></div>
                        <div class=cirlce></div>
                    </div>
                    <div class="mt-4 d-flex flex-column" style="gap: 50px;">
                        <div class="group">
                            <div>
                                @if($leaveRequest->category_type == 'Leave')
                                <h5 class="normalText text-start">
                                    @if($leaveRequest->leave_status === 4)
                                    Withdrawn
                                    <span class="normalText text-start">by</span> <br>
                                    <span class="normalTextValue text-start">
                                        {{ ucwords(strtolower($this->leaveRequest->employee->first_name)) }} {{ ucwords(strtolower($this->leaveRequest->employee->last_name)) }} <br>
                                        <span class="normalTextSmall"> {{ $leaveRequest->updated_at->format('d M, Y g:i a')  }}</span>
                                    </span>
                                    @elseif($leaveRequest->leave_status === 2)
                                    <span class="normalTextValue text-start"> Approved <br> by</span>
                                    @if(!empty($actionTakenBy))
                                    <span class="normalText text-start">
                                        {{ ucwords(strtolower($actionTakenBy->first_name))}} {{ ucwords(strtolower($actionTakenBy->last_name))}} <br>
                                        <span class="normalTextSmall"> {{ $leaveRequest->updated_at->format('d M, Y g:i a')  }}</span>
                                    </span>
                                    @else
                                    <span>N/A</span>
                                    @endif
                                    @else
                                    Rejected by <br>
                                    <span class="normalText">
                                    @if(!empty($actionTakenBy))
                                    {{ ucwords(strtolower($actionTakenBy->first_name))}} {{ ucwords(strtolower($actionTakenBy->last_name))}}
                                    @else
                                    <span>N/A</span>
                                    @endif
                                     <br>
                                        <span class="normalTextSmall"> {{ $leaveRequest->updated_at->format('d M, Y g:i a')  }}</span>

                                    </span>
                                    @endif
                                    <br>
                                </h5>
                                @else
                                <h5 class="normalText text-start">
                                    @if($leaveRequest->cancel_status === 4)
                                    Withdrawn
                                    <span class="normalText text-start">by</span> <br>
                                    <span class="normalTextValue text-start">
                                        {{ ucwords(strtolower($this->leaveRequest->employee->first_name)) }} {{ ucwords(strtolower($this->leaveRequest->employee->last_name)) }} <br>
                                        <span class="normalTextSmall"> {{ $leaveRequest->updated_at->format('d M, Y g:i a')  }}</span>
                                    </span>
                                    @elseif($leaveRequest->cancel_status === 2)
                                    <span class="normalTextValue text-start"> Approved <br> by</span>
                                    @if(!empty($leaveRequest['applying_to']))
                                    @foreach($leaveRequest['applying_to'] as $applyingTo)
                                    <span class="normalText text-start">
                                        {{ ucwords(strtolower($applyingTo['report_to'] ))}} <br>
                                        <span class="normalTextSmall"> {{ $leaveRequest->updated_at->format('d M, Y g:i a')  }}</span>
                                    </span>

                                    @endforeach
                                    @endif
                                    @else
                                    Rejected by <br>
                                    <span class="normalText"> {{ ucwords(strtolower($applyingTo['report_to'] ))}} <br>
                                        <span class="normalTextSmall"> {{ $leaveRequest->updated_at->format('d M, Y g:i a')  }}</span>
                                    </span>
                                    @endif
                                    <br>
                                </h5>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="d-flex flex-column">
                                <h5 class="mb-0 normalText text-start">Submitted
                                </h5>
                                <span class="normalTextSmall text-start">{{ $leaveRequest->created_at->format('d M, Y g:i a') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $isManager = DB::table('employee_details')->where('manager_id', $employeeId)->exists();
        @endphp
        @if(!$isManager)
        <!-- resources/views/livewire/week-selector.blade.php -->
        <div class="detail-container">
            <div class="col-md-7 bg-white border rounded p-3 my-2 ">
                <div class="form-group col-5">
                    <select wire:model="selectedWeek" wire:click="setWeekDates" class="dropdown p-2 w-50 outline-none rounded placeholder-small" id="weekSelect">
                        <option value="this_week">This Week</option>
                        <option value="next_week">Next Week</option>
                        <option value="last_week">Last Week</option>
                        <option value="this_month">This Month</option>
                        <option value="next_month">Next Month</option>
                        <option value="last_month">Last Month</option>

                    </select>
                </div>
                @if ($this->leaveApplications !== null && !$this->leaveApplications->isEmpty())
                <div class="p-3">
                    <h6 class="normalText">{{$employeeName}}'s Leave Transctions</h6>
                    <div class="col-md-4 rounded mt-3 p-1" style="background-color: #ffffe8;">
                        <span class="normalTextValue">Total leaves taken
                        </span> <br>
                        @php
                        $totalDays = 0;
                        @endphp

                        @foreach($leaveApplications as $leaveCountOfEmp)
                        @php
                        $totalDays += $this->calculateNumberOfDays($leaveCountOfEmp->from_date, $leaveCountOfEmp->from_session, $leaveCountOfEmp->to_date, $leaveCountOfEmp->to_session,$leaveCountOfEmp->leave_type);
                        @endphp
                        @endforeach

                        <span class="normalText"> {{ $totalDays }}
                        </span>
                    </div>
                    <div class="table-responsive rounded bg-white border mt-4">
                        <table class="reviewTable">
                            <thead>
                                <tr>
                                    <th class="header-style">Leave Type</th>
                                    <th class="header-style">Date (From - To)</th>
                                    <th class="header-style">Days</th>
                                    <th class="header-style">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leaveApplications as $leaveApplication)
                                <tr>
                                    <td>
                                        <span class="normalText">{{ $leaveApplication->leave_type }}</span> <br>
                                        <span class="normalTextValue">Applied : {{ $leaveApplication->created_at->format('d M') }}</span>
                                    </td>
                                    <td>
                                        <div class="dateContainer">
                                            <span class="normalText"> {{ $leaveApplication->from_date->format('d M, Y') }}<br>
                                                <span class="session-info">{{ $leaveApplication->from_session }}</span>
                                            </span>
                                            <span>-</span>
                                            <span class="normalText"> {{ $leaveApplication->to_date->format('d M, Y') }}<br>
                                                <span class="session-info">{{ $leaveApplication->to_session }}</span>
                                            </span>
                                        </div>
                                    </td>
                                    <td> {{ $this->calculateNumberOfDays($leaveApplication->from_date, $leaveApplication->from_session, $leaveApplication->to_date, $leaveApplication->to_session, $leaveApplication->leave_type) }}</td>
                                    <td>
                                        @if($leaveApplication->category_type === 'Leave')
                                        {{ ucfirst($leaveApplication->leave_status === 2 ? 'Availed' : $leaveApplication->leave_status) }}
                                        @else
                                        {{ ucfirst($leaveApplication->cancel_status === 2 ? 'Applied-Approved' : $leaveApplication->leave_status) }}
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <span class="normalTextValue p-3 d-flex align-items-center justify-content-center">Your leave transaction list is empty.</span>
                @endif
            </div>
        </div>

        @endif
    </div>
</div>