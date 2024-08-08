<div>
<style>
          body{
            font-family: 'Montserrat', sans-serif;
        }
        .detail-container {
        display: flex;
        flex-direction: column;
        width: 100%;
        gap: 10px;
        padding: 5px;
        background-color: none;
    }
    .detail1-container
    {
        display: flex;
        flex-direction: column;
        width: 100%;
        gap: 10px;
        padding: 5px;
        background-color: none;
    }
          .approved-leave{
            display: flex;
        flex-direction: row;
        width: 100%;
        gap: 10px;
        padding: 5px;
        background-color: none;
          }
 
    .heading {
    flex: 8; /* Adjust the flex value to control the size of the heading container */
    padding: 20px;
    width: 100%;
    background: #fff;
    border: 1px solid #ccc;
    border-radius:5px;
}
 
.side-container {
    flex: 4; /* Adjust the flex value to control the size of the side container */
    background-color: #fff;
    text-align: center;
    padding: 20px;
    height: 230px;
    border-radius:5px;
    border:1px solid #dcdcdc;
}
   
        .view-container{
            border:1px solid #ccc;
            background:#ffffe8;
            display:flex;
            width:80%;
            padding:5px 10px;
            border-radius:5px;
            height:auto;
        }
        .middle-container{
            background:#fff;
            display:flex;
            flex-direction:row;
            justify-content:space-between;
            margin:0.975rem auto;
        }
 
        .field {
            display: flex;
            justify-content: start;
            flex-direction: column;
        }
 
        .pay-bal  {
         display:flex;
         gap:10px;
        }
 
        .details {
       
            line-height:2;
        }
 
        .details p {
            margin: 0;
        }
        .vertical-line {
            width: 1px; /* Width of the vertical line */
            height: 70px; /* Height of the vertical line */
            background-color: #ccc;
            margin-left:-10px; /* Color of the vertical line */
        }
 
 
        .group h6{
            font-weight:600;
            font-size:0.875rem;
        }
        .table-container
        {
            width: auto;
            height:200px;
            background-color: #fff;
            margin-left:10px;
            border-radius: 5px;
            border:1px solid #ccc;

        }
        .group h5{
            font-weight: 400;
            font-size: 1rem;
            white-space: nowrap; /* Prevent text from wrapping */
            overflow: hidden; /* Hide overflowing text */
            text-overflow: ellipsis;
            margin-top:0.975rem;
        }
        .group {
            margin-left:10px;
        }
     
        .data{
            display:flex;
            flex-direction:column;
   
        }
        .cirlce{
            height:0.75rem; width:0.75rem; background: #778899; border-radius:50%;
        }
        .v-line{
            height:100px; width:0.5px; background: #778899; border-right:1px solid #778899; margin-left:5px;
        }
        table {
        width: 75%;
        border-collapse: collapse;
    }
    th, td {
        border-bottom: 1px solid #000; /* Change the color and style as needed */
        padding: 4px;  /* Adjust padding as needed */
        text-align:  left;/* Adjust text alignment as needed */
        font-weight: 200;
    }
    td{
        text-align: left;
    }
    th {
        background-color: #f3faff;
        font-size: 12px;
        text-align: left; /* Center align column headers */
    }
    .overflow-cell {
        max-width: 70px; /* Adjust the maximum width of the cell */
        white-space: nowrap; /* Prevent text wrapping */
        overflow: hidden; /* Hide overflow text */
        text-overflow: ellipsis; /* Display an ellipsis (...) when text overflows */
    }
    td{
        font-size: 14px;
    }
        .leave{
            display:flex; flex-direction:row; gap:50px; background:#fff;
            border-bottom:1px solid #ccc;padding-bottom:10px;
        }
        @media screen and (max-width: 1060px) {
           .detail-container{
            width:100%;
            display:flex;
            flex-direction:column;
           }
           .heading {
        flex: 1; /* Change the flex value for the heading container */
        padding: 10px; /* Modify padding as needed */
        width: 100%;
    }
 
    .side-container {
        flex: 1; /* Change the flex value for the side container */
        padding: 10px; /* Modify padding as needed */
        height: auto;
        width: 100%;/* Allow the height to adjust based on content */
    }
}
    </style>
    
    <div class="detail-container ">
        
        <div class="approved-leave d-flex gap-3">
            <div class="heading mb-3">
                <div class="heading-2" >
                    <div class="d-flex flex-row justify-content-between rounded">
                    <div class="field">
                            @if($regularisationrequest->status=='pending')
                                <span style="color: #778899; font-size: 12px; font-weight: 500;">
                                    Withdrawn by
                                </span>
                            @elseif($regularisationrequest->status=='rejected') 
                               <span style="color: #778899; font-size: 12px; font-weight: 500;">
                                    Rejected by
                                </span>
                            @elseif($regularisationrequest->status=='approved') 
                               <span style="color: #778899; font-size: 12px; font-weight: 500;">
                                    Regularization by
                                </span>    
                            @endif
                                
                               
                                 @if($regularisationrequest->status=='pending')
                                    <span style="color: #333; font-weight: 500;font-size:12px;">
                                       Me
                                    </span>

                                 @elseif($regularisationrequest->status=='approved'||$regularisationrequest->status=='rejected')  
                                    <span style="color: #333; font-weight: 500;font-size:12px;">
                                       {{ucwords(strtolower($ManagerName->first_name))}}&nbsp;{{ucwords(strtolower($ManagerName->last_name))}}
                                    </span>
                                 @endif
                        </div>
 
                     <div>
                        <span style="color: #32CD32; font-size: 12px; font-weight: 500; text-transform:uppercase;">
                      
                                @if($regularisationrequest->status=='rejected')
                                    <span style="margin-top:0.625rem; font-size: 12px; font-weight: 500; color:#f66;text-transform:uppercase;">{{$regularisationrequest->status}}</span>
                                @elseif($regularisationrequest->status=='approved')
                                    <span style="margin-top:0.625rem; font-size: 12px; font-weight: 500; color:#32CD32;text-transform:uppercase;">closed</span>
                                @elseif($regularisationrequest->status=='pending'&&$regularisationrequest->is_withdraw==1)  
                                   <span style="margin-top:0.625rem; font-size: 12px; font-weight: 500; color:#cf9b17;text-transform:uppercase;">Withdrawn</span> 
                                @endif   
                        </span>
                   </div>
                </div>
            <div class="middle-container">
                <div class="view-container m-0 p-0">
                     <div class="first-col" style="display:flex; gap:40px;">
                            <div class="field p-2">
                                <span style="color: #778899; font-size:11px; font-weight: 500;">Remarks</span>
                                <span style="font-size: 12px; font-weight: 600;text-align:center;">-<br></span>
                            </div>
                           
                            <div class="vertical-line"></div>
                         </div>
                         <div class="box" style="display:flex;  margin-left:30px;  text-align:center; padding:5px;">
                            <div class="field p-2">
                                <span style="color: #778899; font-size:10px; font-weight: 500;">No. of days</span>
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
              <div>
                <h5 style="color: #333; font-size: 12px; font-weight: 400; text-align:start;">
                    @if($regularisationrequest->status=='pending')
                        Withdrawn <br><span style="color: #778899; font-size: 12px; font-weight: 400; text-align:start;">by</span>
                        <span style="color: #778899; font-weight: 500;">
                           {{ucwords(strtolower($empName->first_name))}}&nbsp;{{ucwords(strtolower($empName->last_name))}}
                        </span><br>
                                    <span style="color: #778899; font-weight: 400;font-size:11px;">
                                          @if(\Carbon\Carbon::parse($regularisationrequest->withdraw_date)->isToday())
                                                       Today 
                                          @elseif(\Carbon\Carbon::parse($regularisationrequest->withdraw_date)->isYesterday())
                                                      Yesterday
                                          @else
                                                 {{ \Carbon\Carbon::parse($regularisationrequest->withdraw_date)->format('Y-m-d') }}
                                          @endif
                                          &nbsp;&nbsp;&nbsp;{{ \Carbon\Carbon::parse($regularisationrequest->created_at)->format('h:i A') }}
                                    </span>
                    @elseif($regularisationrequest->status=='approved')
                        Accept<br><span style="color: #778899; font-size: 12px; font-weight: 400; text-align:start;">by</span>
                        <span style="color: #778899; font-weight: 500;">
                           {{ucwords(strtolower($ManagerName->first_name))}}&nbsp;{{ucwords(strtolower($ManagerName->last_name))}}
                        </span> 
                        <br>
                                    <span style="color: #778899; font-weight: 400;font-size:11px;">
                                          @if(\Carbon\Carbon::parse($regularisationrequest->approved_date)->isToday())
                                                       Today 
                                          @elseif(\Carbon\Carbon::parse($regularisationrequest->approved_date)->isYesterday())
                                                      Yesterday
                                          @else
                                                 {{ \Carbon\Carbon::parse($regularisationrequest->approved_date)->format('Y-m-d') }}
                                          @endif
                                          &nbsp;&nbsp;&nbsp;{{ \Carbon\Carbon::parse($regularisationrequest->approved_date)->format('h:i A') }}
                                    </span>
                    @elseif($regularisationrequest->status=='rejected')
                       rccept<br><span style="color: #778899; font-size: 12px; font-weight: 400; text-align:start;">by</span>
                        <span style="color: #778899; font-weight: 500;">
                           {{ucwords(strtolower($ManagerName->first_name))}}&nbsp;{{ucwords(strtolower($ManagerName->last_name))}}
                        </span>  
                        <br>
                                    <span style="color: #778899; font-weight: 400;font-size:11px;">
                                          @if(\Carbon\Carbon::parse($regularisationrequest->rejected_date)->isToday())
                                                       Today 
                                          @elseif(\Carbon\Carbon::parse($regularisationrequest->rejected_date)->isYesterday())
                                                      Yesterday
                                          @else
                                                 {{ \Carbon\Carbon::parse($regularisationrequest->rejected_date)->format('Y-m-d') }}
                                          @endif
                                          &nbsp;&nbsp;&nbsp;{{ \Carbon\Carbon::parse($regularisationrequest->rejected_date)->format('h:i A') }}
                                    </span>      
                    @endif
                    <br>
                    
                </h5>
            </div>
 
           </div>
           <div class="group">
               <div >
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
    <div class="rounded bg-white border mt-4">
  <table class="custom-table">
        <thead>
            <tr>
                <th class="header-style">Date</th>
                <th class="header-style">Approve/Reject</th>
                <th class="header-style">Approver&nbsp;Remarks</th>
                <th class="header-style">Shift</th>
                <th class="header-style">First In Time</th>
                <th class="header-style">Last Out Time</th>
                <th class="header-style">Reason</th>
            </tr>
        </thead>
        @foreach($regularisationEntries as $entry)
        <tbody>
                <td>{{ \Carbon\Carbon::parse($entry['date'])->format('d M, Y') }}</td>
                @if($regularisationrequest->status=='pending')
                  <td style="text-transform: uppercase;color: #7f8fa4;">withdrawn</td>
                @elseif($regularisationrequest->status=='approved') 
                  <td style="text-transform: uppercase;color: #5bc67e;">{{$regularisationrequest->status}}</td> 
                @elseif($regularisationrequest->status=='rejected')  
                  <td style="text-transform: uppercase;color:#f66;">{{$regularisationrequest->status}}</td>
                @endif  
                <td>-</td>
                <td class="overflow-cell">10:00 am to 07:00 pm</td>
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
                <td style="padding-right:5px; overflow: hidden; text-overflow: ellipsis;max-width:5px;">
                       {{$entry['reason']}}
                </td>
        </tbody>
        @endforeach

    </table>
  </div>

</div>