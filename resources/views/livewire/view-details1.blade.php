<div>
<!DOCTYPE html>
<html>
<head>
<style>
    .card {
        width: 640px;
        height: 200px;
    }
    .card1 {
        height: 415px;
        width: 250px;
        background-color: white;
        margin-left: 653px;
        margin-top: -198px;
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
    .item-name, .item-status {
        font-size: 0.875rem;
        line-height: 1.25rem;
        --tw-text-opacity: 1;
        color: rgba(57, 70, 87, var(--tw-text-opacity));
        margin-left: 74px;
        margin-top: -28px;
    }
    .item-date {
        font-size: 0.75rem;
        line-height: 2;
        margin-left: 62px;
    }
    .avatar-initials1 {
        width: 33px;
        height: 33px;
        background-color: #48D1CC;
        color: #fff;
        text-align: center;
        line-height: 32px;
        font-size: 14px;
        border-radius: 50%;
        margin-left: 20px;
        margin-top: 18px;
    }
    .item-name1 {
        font-size: 0.875rem;
        line-height: 1.25rem;
        --tw-text-opacity: 1;
        color: rgba(57, 70, 87, var(--tw-text-opacity));
        margin-left: 65px;
        margin-top: -28px;
    }
    .item-date1 {
        font-size: 0.75rem;
        line-height: 2;
        margin-left: 73px;
        margin-top: -15px;
    }
    .avatar-initials2 {
        width: 33px;
        height: 33px;
        background-color: #007bff;
        color: #fff;
        text-align: center;
        line-height: 32px;
        font-size: 14px;
        border-radius: 50%;
        margin-left: 24px;
        margin-top: 8px;
    }
    .svg-line {
        width: 2px;
        height: 40px;
        margin-left: 36px;
    }
    .connector {
        stroke: blue;
        stroke-width: 2px;
    }
    .svg-line1 {
        width: 2px;
        height: 40px;
        margin-left: -99px;
    }
    .svg-line2 {
        width: 2px;
        height: 40px;
        margin-left: -80px;
    }
</style>
</head>
<body>
<div class="container">
    @foreach($views2 as $view)
    <div class="card">
           <p for="text" style="margin-left: 29px; font-size: 13px; margin-top: 20px;">Location</p>
            <p style="margin-top: -16px; margin-left: 25px">{{$view->location}}</p>
             <p for="text" style="margin-left: 155px; font-size: 13px; margin-top: -59px;">Department</p>
            <p style="margin-top: -15px; margin-left: 152px">{{$view->department}}</p>
           <p for="text" style="margin-left: 288px; font-size: 13px; margin-top: -58px;">Reporting Manager</p>
            <p style="margin-top: -12px; margin-left: 268px; font-size: 13px;">{{$view->reporting_manager}}</p>
            <p for="text" style="margin-left: 444px; font-size: 13px; margin-top: -58px;">Total Experience</p>
            <p style="margin-top: -15px; margin-left: 458px; font-size: 15px;">{{$view->total_experience}}</p>
            <p for="text" style="margin-left: 29px; font-size: 13px; margin-top: 20px;">Join Date</p>
            <p style="margin-top: -17px; margin-left: 25px; font-size: 14px">{{$view->join_date}}</p>
            <p for="text" style="margin-left: 155px; font-size: 13px; margin-top: -59px;">Confirmation Initiated<br> On</p>
            <p style="margin-top: -15px; margin-left: 152px; font-size: 13px;">{{$view->confirmation_initiated}}</p>
            <p for="text" style="margin-left: 304px; font-size: 13px; margin-top: -73px;">Confirmation due date</p>
            <p style="margin-top: -12px; margin-left: 323px; font-size: 13px;">{{$view->confirmation_due_date}}</p>
    </div>
 
   
    <div class="card1">
          <h2 style="font-size: 0.875rem; margin-left: 16px;">Confirmation Timeline</h2>
          <div part="initials" class="avatar-initials">A</div>
           <div class="item-name">admin</div>
            <span class="item-date">{{ $view_date }}<span class="item-time">{{ $view_time }}</span></span>
        <span class="item-status" style="margin-left:10px;">confirmed</span>
        <svg class="svg-line1" id="svg_0" width="2" height="108">
            <line class="connector" id="line_0" x1="0" x2="0" y1="25" y2="133"></line>
        </svg>
        <div part="initials" class="avatar-initials1">C</div>
        <p class="item-name" style="margin-top: -27px; ">Confirmation Initiated</p>
        <div class="item-date1">{{$view->confirmation_initiated_date}}<span class="item-time1" style="margin-top: 10px;">{{$view->confirmation_initiated_time}}</span></div>
        <span class="item-status" style="margin-top: 1px">initiate</span>
        <svg class="svg-line2" id="svg_0" width="2" height="108">
            <line class="connector" id="line_0" x1="0" x2="0" y1="25" y2="133"></line>
        </svg>
        <div part="initials" class="avatar-initials1">C</div>
        <p class="item-name" style="margin-top: -27px;">Confirmation Due Date</p>
        <div class="item-date1">{{$view->confirmation_due_date1}}</div>
        <svg class="svg-line" id="svg_0" width="2" height="108">
            <line class="connector" id="line_0" x1="0" x2="0" y1="25" y2="133"></line>
        </svg>
        <div part="initials" class="avatar-initials2">J</div>
        <p class="item-name" style="margin-top: -27px;">Join Date</p>
        <div class="item-date1">{{$view->join_date}}</div>
    </div>
    @endforeach
</div>
</body>
</html>
 
</div>