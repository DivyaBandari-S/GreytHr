<div>
    @if(session()->has('emp_error'))
    <div class="alert alert-danger">
        {{ session('emp_error') }}
    </div>
    @endif
    <div class="detail-container ">
        <div class="row m-0 p-0">
            <div class="col-md-4 p-0 m-0 mb-2 ">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb d-flex align-items-center" style="font-size: 14px;background:none;font-weight:500;">
                        <li class="breadcrumb-item"><a type="button" class="submit-btn" href="{{ route('review') }}">Go Back</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: #000;">Review - Review Leave</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="header-details" style="font-size: 14px; font-weight: 500; text-align:start; margin-left:150px; ">
            @if ($leaveRequest)
            <p>Leave Applied on {{ optional($leaveRequest->created_at)->format('d M, Y') }}</p>
            @else
            <p>Leave request details not found.</p>
            @endif

        </div>
        <div class="view-details-container ">
            <div class="heading mb-2
            ">
                <div class="heading-2">
                    <div style="display:flex; flex-direction:row; justify-content:space-between;">
                        <div class="field">
                            <span style="color: #778899; font-size: 12px; font-weight: 500;">
                                Applied by
                            </span>
                            @if(strtoupper($leaveRequest->status) == 'APPROVED')
                            <span style="color: #333;  font-size: 12px;font-weight: 500; text-transform: uppercase;">
                                {{ $this->leaveRequest->employee->first_name }} {{ $this->leaveRequest->employee->last_name }}
                            </span>
                            @elseif(strtoupper($leaveRequest->status) == 'REJECTED')
                            <span style="color: #333; font-weight: 500; text-transform: uppercase;">
                                {{ $this->leaveRequest->employee->first_name }} {{ $this->leaveRequest->employee->last_name }}
                            </span>
                            @endif
                        </div>

                        <div>
                            <span style="color: #32CD32; font-size: 12px; font-weight: 500; text-transform:uppercase;">
                                @if(strtoupper($leaveRequest->status) == 'APPROVED')

                                <span style="margin-top:0.625rem; font-size: 12px; font-weight: 500; color:#32CD32;">{{ strtoupper($leaveRequest->status) }}</span>

                                @elseif(strtoupper($leaveRequest->status) == 'REJECTED')

                                <span style="margin-top:0.625rem; font-size: 12px; font-weight: 500; color:#FF0000;">{{ strtoupper($leaveRequest->status) }}</span>

                                @else

                                <span style="margin-top:0.625rem; font-size: 12px; font-weight: 500; color:#778899;">{{ strtoupper($leaveRequest->status) }}</span>

                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="middle-container ">
                        <div class="view-container m-0 p-0">
                            <div class="first-col" style="display:flex; gap:40px; ">
                                <div class="field p-2">
                                    <span style="color: #778899; font-size: 11px; font-weight: 500;">From date</span>
                                    <span style="font-size: 12px; font-weight: 600;"> {{ $leaveRequest->from_date->format('d M, Y') }}<br><span style="color: #494F55;font-size: 10px; font-weight: 600;">{{ $leaveRequest->from_session }}</span></span>
                                </div>
                                <div class="field p-2">
                                    <span style="color: #778899; font-size: 11px; font-weight: 500;">To date</span>
                                    <span style="font-size: 12px; font-weight: 600;">{{ $leaveRequest->to_date->format('d M, Y') }} <br><span style="color: #494F55;font-size: 10px; font-weight: 600;">{{ $leaveRequest->to_session }}</span></span>
                                </div>
                                <div class="vertical-line"></div>
                            </div>
                            <div class="box" style="display:flex;  margin-left:30px;  text-align:center; ">
                                <div class="field p-2">
                                    <span style="color: #778899; font-size: 11px; font-weight: 500;">No. of days</span>
                                    <span style=" font-size: 12px; font-weight: 600;"> {{ $this->calculateNumberOfDays($leaveRequest->from_date, $leaveRequest->from_session, $leaveRequest->to_date, $leaveRequest->to_session) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="leave">
                        <div class="pay-bal">
                            <span style=" font-size: 12px; font-weight: 500;">Balance:</span>
                            @if(!empty($this->leaveBalances))
                            <div style=" flex-direction:row; display: flex; align-items: center;justify-content:center;">
                                <!-- Sick Leave -->
                                <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #e6e6fa; display: flex; align-items: center; justify-content: center; margin-left:15px;">
                                    <span style="font-size: 10px; color: #50327c;font-weight:500;">SL</span>
                                </div>
                                <span style="font-size: 11px; font-weight: 500; color: #50327c; margin-left: 5px;">{{ $this->leaveBalances['sickLeaveBalance'] }}</span>
                                <!-- Casual Leave  -->
                                <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #e7fae7; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                    <span style="font-size: 10px; color: #1d421e;font-weight:500;">CL</span>
                                </div>
                                <span style="font-size: 11px; font-weight: 500; color: #1d421e; margin-left: 5px;">{{ $this->leaveBalances['casualLeaveBalance'] }}</span>
                                <!-- Casual Leave  Probation-->
                                <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #e7fae7; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                    <span style="font-size: 10px; color: #50327c;font-weight:500;">CLP</span>
                                </div>
                                <span style="font-size: 11px; font-weight: 500; color: #1d421e; margin-left: 5px;">{{ $this->leaveBalances['casualProbationLeaveBalance'] }}</span>
                                <!-- Loss of Pay -->
                                @if($leaveRequest->leave_type === 'Loss of Pay' && isset($leaveBalances['lossOfPayBalance']))
                                <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                    <span style="font-size: 10px; color: #890000;font-weight:500;">LOP</span>
                                </div>
                                <span style="font-size: 11px; font-weight: 500; color: #890000; margin-left: 5px;">{{ $this->leaveBalances['lossOfPayBalance'] }}</span>
                                @elseif($leaveRequest->leave_type === 'Marriage Leave' && isset($leaveBalances['marriageLeaveBalance']))
                                <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                    <span style="font-size: 10px; color: #890000;font-weight:500;">MRL</span>
                                </div>
                                <span style="font-size: 11px; font-weight: 500; color: #890000; margin-left: 5px;">{{ $this->leaveBalances['marriageLeaveBalance'] }}</span>
                                @elseif($leaveRequest->leave_type === 'Petarnity Leave' && isset($leaveBalances['paternityLeaveBalance']))
                                <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                    <span style="font-size: 10px; color: #890000;font-weight:500;">PL</span>
                                </div>
                                <span style="font-size: 11px; font-weight: 500; color: #890000; margin-left: 5px;">{{ $this->leaveBalances['paternityLeaveBalance'] }}</span>
                                @elseif($leaveRequest->leave_type === 'Maternity Leave' && isset($leaveBalances['maternityLeaveBalance']))
                                <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                    <span style="font-size: 10px; color: #890000;font-weight:500;">ML</span>
                                </div>
                                <span style="font-size: 11px; font-weight: 500; color: #890000; margin-left: 5px;">{{ $this->leaveBalances['maternityLeaveBalance'] }}</span>

                                @endif
                            </div>
                            @endif
                        </div>
                        <div class="leave-types">
                            <span style=" color: #605448; font-size: 12px; font-weight: 600;">{{ $leaveRequest->leave_type }}</span>
                        </div>
                    </div>
                </div>

                <div class="approved-leave-details">
                    <div class="data">
                        <p><span style="color: #333; font-weight: 500; font-size:12px;">Details</span></p>
                        @if(!empty($leaveRequest['applying_to']))
                        @foreach($leaveRequest['applying_to'] as $applyingTo)
                        <p style=" font-size: 12px; "><span style="color: #778899; font-size: 12px; font-weight: 400;padding-right: 58px;">Applying to</span>{{ ucwords(strtolower($applyingTo['report_to'])) }}</p>
                        @endforeach
                        @endif
                        <div style="display:flex; flex-direction:row;">
                            <span style="color: #778899; font-size: 12px; font-weight: 400; padding-right: 84px;">Reason</span>
                            <p style="font-size: 12px;">{{ ucfirst($leaveRequest->reason) }}</p>
                        </div>

                        <p style="font-size: 12px;"><span style="color: #778899; font-size: 12px; font-weight: 400; padding-right: 82px;">Contact</span>{{ $leaveRequest->contact_details }} </p>
                        @if (!empty($leaveRequest->cc_to))
                        <p style="font-size: 0.975rem; font-weight: 500;">
                            <span style="color: #778899; font-size: 12px; font-weight: 500; padding-right: 94px;">CC to</span>
                            @if (is_string($leaveRequest->cc_to))
                            @foreach(json_decode($leaveRequest->cc_to, true) as $ccToItem)
                            <span style="font-size: 12px;">
                                {{ ucwords(strtolower($ccToItem['full_name'])) }} (#{{ $ccToItem['emp_id']['emp_id'] }})
                            </span>
                            @if (!$loop->last)
                            ,
                            @endif
                            @endforeach
                            @else
                            @foreach($leaveRequest->cc_to as $ccToItem)
                            <span style="font-size: 12px;">
                                {{ ucwords(strtolower($ccToItem['full_name'])) }} (#{{ $ccToItem['emp_id']['emp_id'] }})
                            </span>
                            @if (!$loop->last)
                            ,
                            @endif
                            @endforeach
                            @endif
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="side-container ">
                <h6 style="color: #778899; font-size: 12px; font-weight: 500; text-align:start;"> Application Timeline </h6>
                <div style="display:flex; ">
                    <div style="margin-top:20px;">
                        <div class="cirlce"></div>
                        <div class="v-line"></div>
                        <div class=cirlce></div>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:50px;">
                        <div class="group">
                            <div>
                                <h5 style="color: #333; font-size: 12px; font-weight: 400; text-align:start;">
                                    @if(strtoupper($leaveRequest->status) == 'WITHDRAWN')
                                    Withdrawn <br><span style="color: #778899; font-size: 12px; font-weight: 400; text-align:start;">by</span>
                                    <span style="color: #778899; font-weight: 500; text-transform: uppercase;">
                                        {{ ucwords(strtolower($leaveRequest->first_name)) }} {{ ucwords(strtolower($leaveRequest->last_name)) }}

                                    </span>
                                    @elseif(strtoupper($leaveRequest->status) == 'APPROVED')
                                    Approved <br> by
                                    @if(!empty($leaveRequest['applying_to']))
                                    @foreach($leaveRequest['applying_to'] as $applyingTo)
                                    <span style="color: #778899; font-size: 12px; font-weight: 500;text-align:start;">
                                        {{ ucwords(strtolower($applyingTo['report_to'])) }}
                                    </span>
                                    @endforeach
                                    @endif
                                    @else
                                    Rejected by <br>
                                    <span style="color: #778899; font-size: 12px; font-weight: 500;text-align:start;">
                                        {{ ucwords(strtolower($applyingTo['report_to'])) }}
                                    </span>
                                    @endif
                                    <br>
                                    <span style="color: #778899; font-size: 10px; font-weight: 400;text-align:start;">
                                        {{ $leaveRequest->updated_at->format('d M, Y g:i A') }}
                                    </span>
                                </h5>
                            </div>

                        </div>
                        <div class="group">
                            <div>
                                <h5 style="color: #333; font-size: 12px; font-weight: 400; text-align:start;">Submitted<br>
                                    <span style="color: #778899; font-size: 10px; font-weight: 400;text-align:start;">{{ $leaveRequest->created_at->format('d M, Y g:i A') }}</span>
                                </h5>
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
                    <select wire:model="selectedWeek" wire:click="setWeekDates" class="dropdown p-2 outline-none rounded placeholder-small" id="weekSelect" style="font-size: 12px;">
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
                    <h6 style="font-weight: 600;color:#333;font-size:14px;">{{$employeeName}}'s Leave Transctions</h6>
                    <div class="col-md-4 rounded mt-3 pt-1 pb-1" style="background-color: #ffffe8;">
                        <span style="margin-bottom: 0;color:#605448;font-size:12px;font-weight:500;">Total leaves taken
                        </span> <br>
                        @php
                        $totalDays = 0;
                        @endphp

                        @foreach($leaveApplications as $leaveCountOfEmp)
                        @php
                        $totalDays += $this->calculateNumberOfDays($leaveCountOfEmp->from_date, $leaveCountOfEmp->from_session, $leaveCountOfEmp->to_date, $leaveCountOfEmp->to_session);
                        @endphp
                        @endforeach

                        <span style="margin-bottom: 0;font-weight:500;"> {{ $totalDays }}
                        </span>
                    </div>
                    <div class="rounded bg-white border mt-4">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th class="header-style" style="width: 25%;">Leave Type</th>
                                    <th class="header-style" style="width: 30%;">Date (From - To)</th>
                                    <th class="header-style" style="width: 20%;">Days</th>
                                    <th class="header-style" style="width: 25%;">Status</th>
                                </tr>
                            </thead>
                            <tbody style="max-height: 200px; overflow-y: auto;">
                                @foreach ($leaveApplications as $leaveApplication)
                                <tr>
                                    <td style="width: 25%;">
                                        <span style="color: #000;">{{ $leaveApplication->leave_type }}</span> <br>
                                        <span style="font-size:12px;color:#778899;">Applied : {{ $leaveApplication->created_at->format('d M') }}</span>
                                    </td>
                                    <td style="width: 30%;">
                                        <div class="d-flex gap-3">
                                            <span style="font-size: 12px;"> {{ $leaveApplication->from_date->format('d M, Y') }}<br><span style="color: #778899;font-size: 10px;">{{ $leaveApplication->from_session }}</span></span>
                                            <span>-</span>
                                            <span style="font-size: 12px;"> {{ $leaveApplication->to_date->format('d M, Y') }}<br><span style="color: #778899;font-size: 10px; ">{{ $leaveApplication->to_session }}</span></span>
                                        </div>
                                    </td>
                                    <td style="width: 20%;"> {{ $this->calculateNumberOfDays($leaveApplication->from_date, $leaveApplication->from_session, $leaveApplication->to_date, $leaveApplication->to_session) }}</td>
                                    <td style="width: 25%;">
                                        {{ ucfirst($leaveApplication->status === 'approved' ? 'Availed' : $leaveApplication->status) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <span class="p-3" style="color:#778899;font-size:12px;">Your leave transaction list is empty.</span>
                @endif
            </div>
        </div>

        @endif
    </div>
</div>