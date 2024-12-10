<div>
<div class="col-md-4 p-0 m-0 mb-2 ">
                <div aria-label="breadcrumb bg-none">
                    <ol class="breadcrumb d-flex align-items-center ">
                        <li class="breadcrumb-item"><a type="button" style="color:#fff !important;" class="submit-btn" href="{{ route('regularisation') }}">Back</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Regularisation - View Details</li>
                    </ol>
                </div>
            </div>
        
        <div class="headers-details">
            <h6>Regularisation Applied on {{ $regularisationrequest->created_at->format('d M, Y') }} </h6>
        </div>
    <div class="detail-container ">
        <div class="approved-leave d-flex gap-3">
            <div class="heading mb-3">
                <div class="heading-2" >
                    <div class="d-flex flex-row justify-content-between rounded">
                    <div class="field">
                            <span style="color: #778899; font-size: 12px; font-weight: 500;">
                                 Pending With
                            </span><br>
                                @if($ManagerName)
                                    <span style="color: #333; font-weight: 500;font-size:12px;">
                                       {{ucwords(strtolower($ManagerName->first_name))}}&nbsp;{{ucwords(strtolower($ManagerName->last_name))}}
                                    </span>
                                @else
                                    <span style="color: #333; font-weight: 500;font-size:12px; ">
                                         Manager Details Not Available
                                    </span>
                                @endif
                        </div>
 
                     <div>
                        <span style="color: #32CD32; font-size: 12px; font-weight: 500; text-transform:uppercase;">
                      
 
                                    <span style="margin-top:0.625rem; font-size: 12px; font-weight: 500; color:#32CD32;text-transform:uppercase;">pending</span>
 
                        </span>
                   </div>
                </div>
            <div class="middle-container">
                <div class="view-container m-0 p-0">
                     <div class="first-col" style="display:flex; gap:40px;">
                            <div class="field p-2">
                                <span style="color: #778899; font-size:11px; font-weight: 500;">Remarks</span><br>
                                @if(empty($regularisationrequest->employee_remarks))
                                  <span style="font-size: 12px; font-weight: 600;text-align:center;">-</span>
                                @else 
                                  <span style="font-size: 12px; font-weight: 600;text-align:center;">{{$regularisationrequest->employee_remarks}}</span>
                                @endif   
                            </div>
                           
                            <div class="vertical-line"></div>
                         </div>
                         <div class="box" style="display:flex;  margin-left:30px;  text-align:center; padding:5px;">
                            <div class="field p-2">
                                <span style="color: #778899; font-size:10px; font-weight: 500;">No. of days</span><br>
                                <span style=" font-size: 12px; font-weight: 600;">{{$totalEntries}}</span>
                            </div>
                        </div>
                     </div>
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
              <div style="margin-top:20px;margin-left:10px;">
                <h5 style="color: #333; font-size: 12px; font-weight: 400; text-align:start;">
                    
                        Pending <br><span style="color: #778899; font-size: 12px; font-weight: 400; text-align:start;">with</span>
                        @if($ManagerName)
                            <span style="color: #778899; font-weight: 500; ">
                            {{ucwords(strtolower($ManagerName->first_name))}}&nbsp;{{ucwords(strtolower($ManagerName->last_name))}}
                            </span>
                        @else
                           <span style="color: #778899; font-weight: 500;">
                             Manager Details Not Available
                            </span>
                        @endif
                    <br>
                    
                </h5>
            </div>
 
           </div>
           <div class="group">
               <div style="margin-top:15px;margin-left:10px;">
                  <h5 style="color: #333; font-size: 12px; font-weight: 400; text-align:start;">Submitted<br>
                <span style="color: #778899; font-size: 11px; font-weight: 400;text-align:start;">
                                      @if(\Carbon\Carbon::parse($regularisationrequest->created_at)->isToday())
                                                Today 
                                      @elseif(\Carbon\Carbon::parse($regularisationrequest->created_at)->isYesterday())
                                                Yesterday
                                      @else
                                         {{ \Carbon\Carbon::parse($regularisationrequest->created_at)->format('Y-m-d') }}
                                      @endif
                                      &nbsp;&nbsp;&nbsp;{{ \Carbon\Carbon::parse($regularisationrequest->created_at)->format('h:i A') }}
                </span>
                    </h5>
               </div>
           </div>
              </div>
           
           </div>
             
        </div>
        </div>
    </div>
  <div class="table-responsive rounded bg-white border mt-4">
  <table class="custom-table">
        <thead>
            <tr>
                <th class="header-style">Date</th>
                <th class="header-style">Approve/Reject</th>
                <th class="header-style">Shift</th>
                <th class="header-style">First In Time</th>
                <th class="header-style">Last Out Time</th>
                <th class="header-style">Reason</th>
            </tr>
        </thead>
        @foreach($regularisationEntries as $entry)
        <tbody >
                <td>{{ \Carbon\Carbon::parse($entry['date'])->format('d M, Y') }}</td>
                <td style="text-transform: uppercase;">pending</td>
                <td >{{ \Carbon\Carbon::parse($empDetails->shift_start_time)->format('H:i a') }} to {{ \Carbon\Carbon::parse($empDetails->shift_end_time)->format('H:i a') }}</td>
                <td>
                       @if(empty($entry['from']))
                            10:00
                       @else
                            {{ $entry['from'] }}
                       @endif
                </td>
                <td>
                       @if(empty($entry['to']))
                            19:00
                       @else
                            {{ $entry['to'] }}
                       @endif
                </td>
                <td style="padding-right:5px;">
                       @if(empty($entry['reason']))
                            -....
                       @else
                            {{ $entry['reason'] }}
                       @endif
                </td>
        </tbody>
        @endforeach
    </table>
  </div>

</div>