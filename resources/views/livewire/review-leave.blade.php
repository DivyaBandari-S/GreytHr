<div>
    
<style>
   /* .container{
    height: 200px;
    width: 906px;
   } */
   .h3{
        font-size:15px;
        margin-left:10px;
    }
    .card{
        height:440px;
    width: 580px;
    }
    .card1 {
            background-color: #ffffe8;
            height: 100px;
            width: 385px;
            margin-top: 27px;
            margin-left: 19px;
        }
        .card2{
            height: 80px;
    width: 583px;
    background-color: white;
    margin-top: 25px;
        }
        .card3 {
            height: 265px;
    width: 290px;
    background-color: white;
    margin-left: 597px;
    margin-top: -602px;
        }
        .svg-line {
    /* Set the width and height of the SVG */
    width: 4px;
    height:105px;
    margin-left:248px;
    margin-top: -122px;
  }
  .connector {
    /* Style the line element within the SVG */
    stroke: blue; /* Change the line color to blue */
    stroke-width: 2px; /* Set the line width */
   
  }
  .avatar-initials {
        width: 33px;
    height: 33px;
    background-color: #ED7D31;
    color: #fff;
    text-align: center;
    line-height: 32px;
    font-size: 14px;
    border-radius: 50%;
    margin-left: 26px;
}
.avatar-initials1{
    width: 33px;
    height: 33px;
    background-color: #48D1CC;
    color: #fff;
    text-align: center;
    line-height: 32px;
    font-size: 14px;
    border-radius: 50%;
    margin-left: 20px;
    margin-top:18px;
}
.item-name, .item-status {
    font-size: 0.875rem;
    line-height: 1.25rem;
    --tw-text-opacity: 1;
    color: rgba(57,70,87,var(--tw-text-opacity));
    margin-left:74px;
    margin-top:-28px;
}
.item-date1 {
    font-size: 0.75rem;
    line-height: 2;
    margin-left: 73px;
    margin-top: -3px;
}
.svg-line1 {
    /* Set the width and height of the SVG */
    width: 4px;
    height: 80px;
    margin-left: 38px;
    margin-top: -53px;
  }
 </style>
 <div class="renuka">
   
<h6>Leave Applied on Aug 10, 2023</h6>
 
<div class="card">
@foreach($leavereviews as $leavereview)
<div  class="info-2 ng-star-inserted" style="margin-top:12px;margin-left:67px;font-size:13px">Applied by</div>
<div  class="info-3 ng-star-inserted" style="margin-top:-1px;margin-left:67px;">{{$leavereview->applied_by}}</div>
<div  class="leave-main-form-status text-regular text-4 text-success ng-star-inserted"style="margin-top:-34px;margin-left:410px;font-size:14px"> APPROVED </div>
<div class="card1">
                <p style="margin-left: 28px; font-size: 11px; margin-top:9px;">From date</p><br>
                <p style="margin-left: 28px; font-size: 13px; margin-top:-37px;">{{$leavereview->from_date}}</p><br>
                <p style="margin-left: 31px; font-size: 11px;     margin-top: -37px;">Session 1</p>
    </div>
    <div>
                <p style="margin-left:177px; font-size: 11px; margin-top:-92px;">To date</p><br>
                <p style="margin-left:153px; font-size: 13px; margin-top:-36px;">{{$leavereview->to_date}}</p><br>
                <p style="margin-left:175px; font-size: 11px;margin-top:-40px;">Session 2</p>
            </div>
            <svg class="svg-line" id="svg_0" width="2" height="108">
  <line class="connector" id="line_0" x1="0" x2="0" y1="25" y2="133"></line>
</svg>
<div>
                <p style="margin-left:265px; font-size: 11px; margin-top:-72px;">No. of days</p><br>
                <p style="margin-left:287px; font-size: 11px;margin-top:-32px;">{{$leavereview->no_of_days}}</p>
            </div>
            <span class="info-3 balance" style="margin-left:32px;margin-top:23px"; >Balance : 3</span>
            <span  class="info-2 leave ng-star-inserted" style="margin-left:151px;margin-top:-25px"> Casual Leave Probation</span>
            <hr class="line" style="border: none; margin: 4px 0; height: 1px; background-color: black;">
            <div>
            <span  class="info-3" style="margin-left:47px; margin-top:1px;">Details</span>
            <p style="margin-top:9px;margin-left:44px; font-size: 14px;">Applying to</p>
            <p style="margin-top:-41px;margin-left:181px; font-size: 14px;">{{$leavereview->applying_to}}</p>
            <p style="margin-top:9px;margin-left:44px; font-size: 14px;">Reason</p>
            <p style="margin-top:-41px;margin-left:181px; font-size: 14px;">
            {{$leavereview->reason}}</p>
             <!-- <p style="margin-top:9px;margin-left:44px; font-size: 14px;">Contact</p> -->
             <p style="margin-top:9px;margin-left:44px; font-size: 14px;">CC to</p>
             <p style="margin-top:-41px;margin-left:181px; font-size: 14px;">{{$leavereview->cc_to}}</p>
            </div>
            </div>
              <div class="card2">
             <div class="dropdown">
        <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="margin-left: 650px; margin-left:100px;
        margin-top:23px;">
            Last week
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/Apr2023Mar2024">This week</a></li>
            <li><a class="dropdown-item" href="/Apr2022Mar2023"> Last week</a></li>
            <li><a class="dropdown-item" href="/Apr2021Mar2022"> Next week</a></li>
            <li><a class="dropdown-item" href="/Apr2022Mar2023"> This Month</a></li>
            <li><a class="dropdown-item" href="/Apr2021Mar2022"> Last Month</a></li>
        </ul>
    </div>
   
</div>
<div class="text-5 text-regular text-muted" style="margin-top:18px; font-size:12px;">No employee has availed leave during this period.</div>
<div class="card3">
           
            <!-- <h2 style="font-size: 0.875rem; margin-left:16px;">Confirmation Timeline</h2> -->
            <h2 style="font-size:16px; margin-left:16px; margin-top :20px;">Application Timeline</h2>
            <div part="initials" class="avatar-initials">A</div>
        <div class="item-name">Approved</div>
        <span class="item-status">{{$leavereview->approved}}</span>
        <div class="item-date1">25 Apr 2023<span class="item-time1" style="margin-top:10px;">05:14 PM</span></div>
        <svg class="svg-line1" id="svg_0" width="2" height="108">
  <line class="connector" id="line_0" x1="0" x2="0" y1="25" y2="133"></line>
</svg>
<div part="initials" class="avatar-initials1">S</div>
        <p class="item-name" style="margin-top:-27px;">Submitted</p>
        <div class="item-date1">{{$leavereview->submitted}}<span class="item-time1" style="margin-top:10px;">05:14 PM</span></div>
@endforeach
    </div>
</div>
 
</div>