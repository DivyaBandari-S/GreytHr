<div>
    <div class="detail-container">
        <div class="row m-0 p-0">
            <div class="col-md-4 p-0 m-0 mb-2 ">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb d-flex align-items-center ">
                        <li class="breadcrumb-item"><a type="button" style="color:#fff !important;" class="submit-btn" href="{{ route('leave-form-page') }}">Back</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Leave - View Details</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="headers-details">
            <h6>Leave Applied on {{ $leaveRequest->created_at->format('d M, Y') }} </h6>
        </div>
        <div class="approved-leave d-flex gap-3">
            <div class="heading rounded mb-3">
                <div class="heading-2 rounded">
                    <div class="d-flex flex-row justify-content-between rounded">
                        <div class="field">
                            <span class="normalTextValue">
                                @if(strtoupper($leaveRequest->status) == 'WITHDRAWN')
                                Withdrawn by
                                @elseif(strtoupper($leaveRequest->status) == 'APPROVED')
                                Approved by
                                @else
                                Pending with
                                @endif
                            </span>
                            <br>
                            @if(strtoupper($leaveRequest->status) == 'WITHDRAWN')
                            <span class="normalText">
                                {{ ucwords(strtoupper($this->leaveRequest->employee->first_name)) }} {{ ucwords(strtoupper($this->leaveRequest->employee->last_name)) }}
                            </span>
                            @elseif(!empty($leaveRequest['applying_to']))
                            @foreach($leaveRequest['applying_to'] as $applyingTo)
                            <span class="normalText">
                                {{ ucwords(strtoupper($applyingTo['report_to'] ))}}
                            </span>
                            @endforeach
                            @endif
                        </div>

                        <div>
                            <span>
                                @if(strtoupper($leaveRequest->status) == 'APPROVED')

                                <span class="approvedColor mt-2">{{ strtoupper($leaveRequest->status) }}</span>

                                @elseif(strtoupper($leaveRequest->status) == 'REJECTED')

                                <span class="rejectColor mt-2">{{ strtoupper($leaveRequest->status) }}</span>

                                @else

                                <span class="otherStatus mt-2">{{ strtoupper($leaveRequest->status) }}</span>

                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="middle-container">
                        <div class="view-container m-0 p-0">
                            <div class="first-col m-0 p-0 d-flex gap-4">
                                <div class="field p-2">
                                    <span class="normalTextValue">From Date</span> <br>
                                    <span class="normalText" style="font-weight:600;"> {{ $leaveRequest->from_date->format('d M, Y') }}<br><span style="color: #494F55;font-size: 9px; ">{{ $leaveRequest->from_session }}</span></span>
                                </div>
                                <div class="field p-2">
                                    <span class="normalTextValue">To Date</span> <br>
                                    <span class="normalText" style="font-weight:600;">{{ $leaveRequest->to_date->format('d M, Y') }} <br><span style="color: #494F55;font-size: 9px; ">{{ $leaveRequest->to_session }}</span></span>
                                </div>
                                <div class="vertical-line"></div>
                            </div>
                            <div class="box" style="display:flex; text-align:center; padding:5px;">
                                <div class="field p-2">
                                    <span class="normalTextValue">No. of days</span> <br>
                                    <span class="normalText" style=" font-weight: 600;"> {{ $this->calculateNumberOfDays($leaveRequest->from_date, $leaveRequest->from_session, $leaveRequest->to_date, $leaveRequest->to_session) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row m-0 p-0 d-flex align-items-center">
                        <div class="col-md-4 m-0 p-0">
                            <div class="pay-bal ">
                                <span class="normalTextValue">Balance:</span>
                                @if($leaveBalances)
                                @if($leaveRequest->leave_type === 'Sick Leave' && isset($leaveBalances['sickLeaveBalance']))
                                <span class="normalText">{{ $leaveBalances['sickLeaveBalance'] }}</span>
                                @elseif($leaveRequest->leave_type === 'Casual Leave Probation' && isset($leaveBalances['casualProbationLeaveBalance']))
                                <span class="normalText">{{ $leaveBalances['casualProbationLeaveBalance'] }}</span>
                                @elseif($leaveRequest->leave_type === 'Casual Leave' && isset($leaveBalances['casualLeaveBalance']))
                                <span class="normalText">{{ $leaveBalances['casualLeaveBalance'] }}</span>
                                @elseif($leaveRequest->leave_type === 'Loss Of Pay' && isset($leaveBalances['lossOfPayBalance']))
                                <span class="normalText">&minus;{{ $leaveBalances['lossOfPayBalance'] }}</span>
                                @elseif($leaveRequest->leave_type === 'Marriage Leave' && isset($leaveBalances['marriageLeaveBalance']))
                                <span class="normalText">{{ $leaveBalances['marriageLeaveBalance'] }}</span>
                                @elseif($leaveRequest->leave_type === 'Maternity Leave' && isset($leaveBalances['maternityLeaveBalance']))
                                <span class="normalText">{{ $leaveBalances['maternityLeaveBalance'] }}</span>
                                @elseif($leaveRequest->leave_type === 'Petarnity Leave' && isset($leaveBalances['paternityLeaveBalance']))
                                <span class="normalText">{{ $leaveBalances['paternityLeaveBalance'] }}</span>
                                @endif
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 m-0 p-0">
                            <span class="leave-type">{{ $leaveRequest->leave_type }}</span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="pending-details">
                    <div class="data">
                        <span class="normalText" style="font-size:0.8rem;">Details</span>
                        <div class="row m-0 p-0">
                            <div class="col-md-8 m-0 p-0">
                                <div class="custom-grid-container text-start">
                                    <div class="custom-grid-item">
                                        <span class="custom-label">Applied to</span>
                                        <span class="custom-label">Reason</span>
                                        <span class="custom-label">Contact</span>
                                        @if (!empty($leaveRequest->cc_to))
                                        <span class="custom-label">CC to</span>
                                        @endif
                                    </div>
                                    <div class="custom-grid-item">
                                        @if (!empty($leaveRequest['applying_to']) && is_array($applyingTo) && isset($applyingTo['report_to']))
                                        <span class="custom-value">{{ ucwords(strtolower($applyingTo['report_to'])) }}</span>
                                        @else
                                        <span class="custom-value">-</span>
                                        @endif
                                        <span class="custom-value">{{ ucfirst($leaveRequest->reason) }}</span>
                                        <span class="custom-value">{{ ucfirst($leaveRequest->contact_details) }}</span>

                                        @if (!empty($leaveRequest->cc_to))
                                        <span class="custom-value">
                                            @if (is_string($leaveRequest->cc_to))
                                            @foreach(json_decode($leaveRequest->cc_to, true) as $ccToItem)
                                            <span class="custom-cc-item">
                                                {{ ucwords(strtolower($ccToItem['full_name'])) }} (#{{ $ccToItem['emp_id']['emp_id'] }})
                                            </span>
                                            @if (!$loop->last)
                                            ,
                                            @endif
                                            @endforeach
                                            @else
                                            @foreach($leaveRequest->cc_to as $ccToItem)
                                            <span class="custom-cc-item">
                                                {{ ucwords(strtolower($ccToItem['full_name'])) }} (#{{ $ccToItem['emp_id']['emp_id'] }})
                                            </span>
                                            @if (!$loop->last)
                                            ,
                                            @endif
                                            @endforeach
                                            @endif
                                        </span>
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
                    <div class="mt-4 d-flex flex-column" style="gap: 60px;">
                        <div class="group">
                            <div>
                                <h5 class="normalText text-start">
                                    @if(strtoupper($leaveRequest->status) == 'WITHDRAWN')
                                    Withdrawn

                                    <span class="normalText text-start">by</span> <br>
                                    <span class="normalTextValue text-start">
                                        {{ ucwords(strtolower($this->leaveRequest->employee->first_name)) }} {{ ucwords(strtolower($this->leaveRequest->employee->last_name)) }} <br>
                                        {{ $leaveRequest->updated_at->format('d M, Y g:i a') }}
                                    </span>
                                    @elseif(strtoupper($leaveRequest->status) == 'APPROVED')
                                    <span class="normalTextValue text-start"> Approved <br> by</span>
                                    @if(!empty($leaveRequest['applying_to']))
                                    @foreach($leaveRequest['applying_to'] as $applyingTo)
                                    <span class="normalText text-start">
                                        {{ ucwords(strtolower($applyingTo['report_to'] ))}}
                                    </span>
                                    @endforeach
                                    @endif
                                    @else
                                    Rejected by
                                    <span class="normalText"> {{ ucwords(strtolower($applyingTo['report_to'] ))}}</span>
                                    @endif
                                    <br>
                                </h5>
                            </div>

                        </div>
                        <div>
                            <div class="d-flex flex-column">
                                <h5 class="mb-0 normalText text-start">Submitted
                                </h5>
                                <span class="normalTextValue text-start" style="font-size:0.625rem;">{{ $leaveRequest->created_at->format('d M, Y g:i a') }}</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>