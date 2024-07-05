<div>
    <div class="detail-container ">
        <div class="row m-0 p-0">
            <div class="col-md-4 p-0 m-0 mb-2 ">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb d-flex align-items-center " style="font-size: 14px;background:none;font-weight:500;">
                        <li class="breadcrumb-item"><a type="button" class="submit-btn" href="{{ route('leave-page') }}">Go Back</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: #000;">Review - Review Leave</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="header-details" style="font-size: 10px; font-weight: 500; text-align:start; margin-left:150px; ">
            <h6 >Leave Applied on {{ $leaveRequest->created_at->format('d M, Y') }} </h6>
        </div>
        <div class="approved-leave d-flex gap-3">
            <div class="heading mb-3">
                <div class="heading-2" >
                    <div class="d-flex flex-row justify-content-between rounded">
                    <div class="field">
                            <span style="color: #778899; font-size: 12px; font-weight: 500;">
                                @if(strtoupper($leaveRequest->status) == 'WITHDRAWN')
                                    Withdrawn by
                                @elseif(strtoupper($leaveRequest->status) == 'APPROVED')
                                    Approved by
                                @else
                                    Rejected by
                                @endif
                            </span>
                            @if(strtoupper($leaveRequest->status) == 'WITHDRAWN')
                                <span style="color: #333; font-weight: 500; text-transform: uppercase;">
                                    {{ ucwords(strtolower($this->leaveRequest->employee->first_name)) }} {{ ucwords(strtolower($this->leaveRequest->employee->last_name))}}
                                </span>
                                @elseif(!empty($leaveRequest['applying_to']))
                                @foreach($leaveRequest['applying_to'] as $applyingTo)
                                    <span style="color: #333; font-weight: 500;font-size:12px; text-transform:uppercase;">
                                    {{ ucwords(strtolower($applyingTo['report_to'])) }}
                                    </span>
                                @endforeach
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
            <div class="middle-container">
                <div class="view-container m-0 p-0">
                     <div class="first-col" style="display:flex; gap:40px;">
                            <div class="field p-2">
                                <span style="color: #778899; font-size:11px; font-weight: 500;">From date</span>
                                <span style="font-size: 12px; font-weight: 600;"> {{ $leaveRequest->from_date->format('d M, Y') }}<br><span style="color: #494F55;font-size:9px; ">{{ $leaveRequest->from_session }}</span></span>
                            </div>
                            <div class="field p-2">
                                <span style="color: #778899; font-size:11px; font-weight: 500;">To date</span>
                                <span style="font-size: 12px; font-weight: 600;">{{ $leaveRequest->to_date->format('d M, Y') }} <br><span style="color: #494F55;font-size:9px; ">{{ $leaveRequest->to_session }}</span></span>
                            </div>
                            <div class="vertical-line"></div>
                         </div>
                         <div class="box" style="display:flex;  margin-left:30px;  text-align:center; padding:5px;">
                            <div class="field p-2">
                                <span style="color: #778899; font-size:10px; font-weight: 500;">No. of days</span>
                                <span style=" font-size: 12px; font-weight: 600;"> {{ $this->calculateNumberOfDays($leaveRequest->from_date, $leaveRequest->from_session, $leaveRequest->to_date, $leaveRequest->to_session) }}</span>
                            </div>
                        </div>
                     </div>
                 </div>
                    <div class="leave">
                        <div class="pay-bal">
                            <span style=" font-size: 12px; font-weight: 500;">Balance:</span>
                            @if($leaveBalances)
                                @if($leaveRequest->leave_type === 'Sick Leave' && isset($leaveBalances['sickLeaveBalance']))
                                    <span style="font-size: 12px; font-weight: 500;">{{ $leaveBalances['sickLeaveBalance'] }}</span>
                                @elseif($leaveRequest->leave_type === 'Causal Leave Probation' && isset($leaveBalances['casualProbationLeaveBalance']))
                                    <span style="font-size: 12px; font-weight: 500;">{{ $leaveBalances['casualProbationLeaveBalance'] }}</span>
                                @elseif($leaveRequest->leave_type === 'Causal Leave' && isset($leaveBalances['casualLeaveBalance']))
                                    <span style="font-size: 12px; font-weight: 500;">{{ $leaveBalances['casualLeaveBalance'] }}</span>
                                @elseif($leaveRequest->leave_type === 'Loss of Pay' && isset($leaveBalances['lossOfPayBalance']))
                                    <span style="font-size: 12px; font-weight: 500;">{{ $leaveBalances['lossOfPayBalance'] }}</span>
                                @elseif($leaveRequest->leave_type === 'Marriage Leave' && isset($leaveBalances['marriageLeaveBalance']))
                                    <span style="font-size: 12px; font-weight: 500;">{{ $leaveBalances['marriageLeaveBalance'] }}</span>
                                @elseif($leaveRequest->leave_type === 'Maternity Leave' && isset($leaveBalances['maternityLeaveBalance']))
                                    <span style="font-size: 12px; font-weight: 500;">{{ $leaveBalances['maternityLeaveBalance'] }}</span>
                                @elseif($leaveRequest->leave_type === 'Petarnity Leave' && isset($leaveBalances['paternityLeaveBalance']))
                                    <span style="font-size: 12px; font-weight: 500;">{{ $leaveBalances['paternityLeaveBalance'] }}</span>
                                @endif
                            @endif
                        </div>
                        <div class="leave-type">
                            <span style=" color: #605448; font-size: 12px; font-weight: 600;">{{ $leaveRequest->leave_type }}</span>
                        </div>
                  </div>
              </div>

        <div class="history-details">
           <div class="data">
           <p><span style="color: #333; font-weight: 500; font-size:12px;">Details</span></p>
           @if(is_array($leaveRequest['applying_to']) || is_object($leaveRequest['applying_to']))
            @foreach($leaveRequest['applying_to'] as $applyingTo)
            <p style=" font-size: 12px; "><span style="color: #778899; font-size: 12px; font-weight: 400;padding-right: 58px;">Applying to</span>{{ ucwords(strtolower($applyingTo['report_to'])) }}
        </p>
            @endforeach
            @endif
             <div style="display:flex; flex-direction:row;">
             <span style="color: #778899; font-size: 12px; font-weight: 400;padding-right: 84px; ">Reason</span>
             <p style=" font-size: 12px; ">{{ ucfirst($leaveRequest->reason) }}</p>
             </div>
            <p style="font-size: 12px;"><span style="color: #778899; font-size: 12px; font-weight: 400; padding-right: 82px;">Contact</span>{{ $leaveRequest->contact_details }} </p>
            @if(is_array($leaveRequest->cc_to) || is_object($leaveRequest->cc_to))
                @if(!empty($leaveRequest->cc_to))
                    <p style="font-size: 0.975rem; font-weight: 500;">
                        <span style="color: #778899; font-size: 12px; font-weight: 400; padding-right: 90px;">CC to</span>
                        @foreach($leaveRequest->cc_to as $ccToItem)
                           <span style="font-size: 12px;"> {{ ucwords(strtolower($ccToItem['full_name'] ))}} (#{{ $ccToItem['emp_id'] }})</span>
                            @if(!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </p>
                @endif
            @endif
           </div>
        </div>
        </div>
        <div class="side-container mx-2 ">
            <h6 style="color: #778899; font-size: 12px; font-weight: 500; text-align:start;"> Application Timeline </h6>
           <div  style="display:flex; ">
           <div style="margin-top:20px;">
             <div class="cirlce"></div>
             <div class="v-line"></div>
              <div class=cirlce></div>
            </div>
              <div style="display:flex; flex-direction:column; gap:60px;">
              <div class="group">
              <div>
                <h5 style="color: #333; font-size: 12px; font-weight: 400; text-align:start;">
                    @if(strtoupper($leaveRequest->status) == 'WITHDRAWN')
                        Withdrawn <br><span style="color: #778899; font-size: 12px; font-weight: 400; text-align:start;">by</span>
                        <span style="color: #778899; font-weight: 500; text-transform: uppercase;">
                        {{ ucwords(strtolower($this->leaveRequest->employee->first_name)) }} {{ ucwords(strtolower($this->leaveRequest->employee->last_name)) }}
                        </span>
                    @elseif(strtoupper($leaveRequest->status) == 'APPROVED')
                        Approved  <br>by
                        @if(!empty($leaveRequest['applying_to']))
                            @foreach($leaveRequest['applying_to'] as $applyingTo)
                                <span style="color: #778899; font-size: 12px; font-weight: 500;text-align:start;">
                                {{ ucwords(strtolower($applyingTo['report_to'])) }}
                                </span>
                            @endforeach
                            @else
                            <span style="color: #778899; font-size: 12px; font-weight: 500;text-align:start;">
                                    Null
                            </span>
                          @endif
                    @else
                        Rejected by
                        <!-- Add your logic for rejected by -->
                    @endif
                    <br>
                    <span style="color: #778899; font-size: 11px; font-weight: 400;text-align:start;">
                        {{ $leaveRequest->updated_at->format('d M, Y g:i A') }}
                    </span>
                </h5>
            </div>

           </div>
           <div class="group">
               <div >
                  <h5 style="color: #333; font-size: 12px; font-weight: 400; text-align:start;">Submitted<br>
                <span style="color: #778899; font-size: 11px; font-weight: 400;text-align:start;">{{ $leaveRequest->created_at->format('d M, Y g:i A') }}</span>
                    </h5>
               </div>
           </div>
              </div>
           
           </div>
             
        </div>
        </div>
    </div>

</div>