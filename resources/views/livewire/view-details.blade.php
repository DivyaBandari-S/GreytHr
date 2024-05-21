<div>
    <div class="detail-container">
    <div class="row m-0 p-0">
        <div class="col-md-4 p-0 m-0 mb-2 ">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb " style="font-size: 14px;background:none;font-weight:500;">
                    <li class="breadcrumb-item"><a href="{{ route('review') }}">Review</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: #000;">Leave - View Details</li>
                </ol>
            </nav>
        </div>
        </div>
        <div class="headerss" style="font-size: 12px; font-weight: 500; text-align:start; margin-left:150px; ">
            <h6 >Leave Applied on {{ $leaveRequest->created_at->format('d M, Y') }} </h6>
        </div>
        <div class="d-flex view-details-container gap-2" >
            <div class="heading mb-2">
                <div class="heading-2 " >
                  <div style="display:flex; flex-direction:row; justify-content:space-between;">
                       <div class="field">
                            <span style="color: #778899; font-size: 12px; font-weight: 500;">
                              Applied by
                            </span>
                                <span style="color: #333;font-size: 12px; font-weight: 500; text-transform:uppercase;">
                                  {{ ucwords(strtolower($firstName) )}}
                            </span>
                        </div>
                     <div>
                        <span style="color: #32CD32; font-size: 12px; font-weight: 500; text-transform:uppercase;">
                        @if(strtoupper($leaveRequest->status) == 'APPROVED')

                                    <span style="margin-top:0.625rem; font-size: 12px; font-weight: 500; color:#32CD32;">{{ strtoupper($leaveRequest->status) }}</span>

                                @elseif(strtoupper($leaveRequest->status) == 'REJECTED')

                                    <span style="margin-top:0.625rem; font-size: 12px; font-weight: 500; color:#FF0000;">{{ strtoupper($leaveRequest->status) }}</span>

                                @else

                                    <span style="margin-top:0.625rem; font-size: 12px; font-weight: 500; color:#cf9b17;">{{ strtoupper($leaveRequest->status) }}</span>

                                @endif
                        </span>
                   </div>
                </div>
            <div class="middle-container">
                <div class="view-container p-0 m-0">
                     <div class="first-col" style="display:flex; gap:40px; ">
                            <div class="field p-2">
                                <span style="color: #778899; font-size: 11px; font-weight: 500;">From date</span>
                                <span style="font-size: 12px; font-weight: 600;"> {{ $leaveRequest->from_date->format('d M, Y') }}<br><span style="color: #494F55;font-size: 10px; ">{{ $leaveRequest->from_session }}</span></span>
                            </div>
                            <div class="field p-2">
                                <span style="color: #778899; font-size: 11px; font-weight: 500;">To date</span>
                                <span style="font-size: 12px; font-weight: 600;">{{ $leaveRequest->to_date->format('d M, Y') }} <br><span style="color: #494F55;font-size: 10px; ">{{ $leaveRequest->to_session }}</span></span>
                            </div>
                            <div class="vertical-line"></div>
                        </div>
                         <div class="box" style="display:flex;  margin-left:30px;  text-align:center; ">
                            <div class="field p-2">
                                <span style="color: #778899; font-size: 12px; font-weight: 500;">No. of days</span>
                                <span style=" font-size: 12px; font-weight: 600;"> {{ $this->calculateNumberOfDays($leaveRequest->from_date, $leaveRequest->from_session, $leaveRequest->to_date, $leaveRequest->to_session) }}</span>
                            </div>
                        </div>
                     </div>
                 </div>
                    <div class="leave">
                        <div class="pay-bal">
                            <span style=" font-size: 12px; font-weight: 500;">Balance:</span>
                            @if(!empty($leaveRequest['leaveBalances']))
                                        <div style=" flex-direction:row; display: flex; align-items: center;justify-content:center;">
                                        <!-- Sick Leave -->
                                            <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #e6e6fa; display: flex; align-items: center; justify-content: center; margin-left:15px;">
                                                <span style="font-size:10px; color: #50327c;font-weight:500;">SL</span>
                                        </div>
                                            <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['sickLeaveBalance'] }}</span>

                                        <!-- Casual Leave -->
                                        <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #e7fae7; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                                <span style="font-size:10px; color: #1d421e;font-weight:500;">CL</span>
                                        </div>
                                        <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['casualLeaveBalance'] }}</span>
                                        <!-- Casual Leave Probation-->
                                        <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #FDEBD0  ; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                                <span style="font-size:10px; color: #F39C12  ;font-weight:500;">CLP</span>
                                        </div>
                                            <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['casualProbationLeaveBalance'] }}</span>
                                        <!-- Loss of Pay -->
                                        @if($leaveRequest->leave_type === 'Loss of Pay')
                                        <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                                <span style="font-size:10px; color: #890000;font-weight:500;">LP</span>
                                        </div>
                                            <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['lossOfPayBalance'] }}</span>
                                          <!-- marriage leave -->
                                        @elseif($leaveRequest->leave_type === 'Marriage Leave')
                                        <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                                <span style="font-size:10px; color: #890000;font-weight:500;">MRL</span>
                                        </div>
                                            <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['marriageLeaveBalance'] }}</span>
                                        @elseif($leaveRequest->leave_type === 'Maternity Leave')
                                        <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                                <span style="font-size:10px; color: #890000;font-weight:500;">ML</span>
                                        </div>
                                            <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['maternityLeaveBalance'] }}</span>
                                        @elseif($leaveRequest->leave_type === 'Petarnity Leave')
                                        <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                                <span style="font-size:10px; color: #890000;font-weight:500;">PL</span>
                                        </div>
                                            <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['paternityLeaveBalance'] }}</span>

                                        @endif
                                    </div>
                                @endif
                        </div>
                        <div class="leave-type">
                            <span style=" color: #605448; font-size: 12px; font-weight: 500;">{{ $leaveRequest->leave_type }}</span>
                        </div>
                  </div>
              </div>


        <div class="to-approve-details">

           <div class="data">
           <p><span style="color: #333; font-weight: 500; font-size:13px;">Details</span></p>
            @if(!empty($leaveRequest['applying_to']))
                @foreach($leaveRequest['applying_to'] as $applyingTo)
                <p style=" font-size: 12px; "><span style="color: #778899; font-size: 12px; font-weight: 400;padding-right: 58px;">Applying to</span  >{{ ucwords(strtolower($applyingTo['report_to'])) }}</p>
                @endforeach
                @endif
                <div style="display:flex; flex-direction:row; justify-conetnt-space-between;">
                   <span style="color: #778899; font-size: 12px; font-weight: 400; padding-right: 84px;">Reason</span>
                   <p style=" font-size: 12px; ">{{ ucfirst($leaveRequest->reason) }}</p>

                </div>
                <p style=" font-size: 12px;"><span style="color: #778899; font-size: 12px; font-weight: 400; padding-right: 82px;">Contact</span>{{ $leaveRequest->contact_details }} </p>
                @if(!empty($leaveRequest->cc_to))
                    <p style="font-size: 12px; font-weight: 500;">
                        <span style="color: #778899; font-size: 12px; font-weight: 400; padding-right: 90px;">CC to</span>
                        @foreach($leaveRequest->cc_to as $ccToItem)
                        <p style=" font-size: 12px; ">{{ $ccToItem['full_name'] }} (#{{ $ccToItem['emp_id'] }})</p>
                        @if(!$loop->last)
                            ,
                        @endif
                        @endforeach
                    </p>
                @endif
           </div>
        </div>
        </div>

        <div class="side-container ">
            <h6 style="color: #778899; font-size: 12px; font-weight: 500; text-align:start;"> Application Timeline </h6>
           <div  style="display:flex; ">
           <div style="margin-top:20px;">
             <div class="cirlce"></div>
             <div class="v-line"></div>
            <div class=cirlce></div>
             </div>


              <div style="display:flex; flex-direction:column; gap:45px;">


              <div class="group">
              <div>
                <h5 style="color: #333; font-size: 12px; font-weight: 400; text-align:start;">
                    @if(strtoupper($leaveRequest->status) == 'WITHDRAWN')
                        Withdrawn <br><span style="color: #778899; font-size: 12px; font-weight: 400; text-align:start;">by</span>
                        <span style="color: #778899; font-weight: 500; text-transform: uppercase;">
                            {{ ucwords(strtolower($this->leaveRequest->employee->first_name)) }}  {{ ucwords(strtolower($this->leaveRequest->employee->last_name)) }}
                        </span>
                    @elseif(strtoupper($leaveRequest->status) == 'PENDING')
                    <span style="color: #778899; font-size: 12px; font-weight: 500;text-align:start;"> Pending <br> with</span>
                        @if(!empty($leaveRequest['applying_to']))
                            @foreach($leaveRequest['applying_to'] as $applyingTo)
                                <span style="color: #333; font-size: 12px; font-weight: 500;text-align:start;">
                                    {{ ucwords(strtolower($applyingTo['report_to'])) }}
                                </span>
                            @endforeach
                        @endif
                    @else
                        Rejected by
                        <!-- Add your logic for rejected by -->
                    @endif
                    <br>
                    <span style="color: #778899; font-size: 10px; font-weight: 400; text-align: start;">
                        <input type="text" placeholder="Write comment" style="outline: none; border: 1px solid #778899; padding: 0.3rem; border-radius: 5px; width: 100%; margin-top: 10px; color: #5e6b7c;">
                    </span>

                </h5>
            </div>

           </div>
           <div class="group">
               <div >
                  <h5 style="color: #333; font-size: 12px; font-weight: 400; text-align:start;">Submitted<br>
                <span style="color: #778899; font-size: 10px; font-weight: 400;text-align:start;">{{ $leaveRequest->created_at->format('d M, Y g:i A') }}</span>
                    </h5>
               </div>
           </div>
              </div>
           
           </div>
        </div>
        </div>
    </div>
        </div>

</div>