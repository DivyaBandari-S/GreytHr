<div>
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            overflow-y: hidden;
            right: -255px;
            height: 100%;
            width: 245px;
            /* Adjust width as needed */
            background-color: #fff;
            /* Adjust background color */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Optional box shadow */
            /* Add vertical scrollbar if needed */
            z-index: 1000;
            /* Adjust z-index */
            /* Add any other styles you need */
        }

        /* Adjust the close button position if needed */
        #closeSidebar {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .sidebar .sidebar-header {
            background-color: #e9edf1;
            padding: 10px;
            text-align: center;
        }

        .down-arrow-reg {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #5473e3;
            margin-right: 5px;
        }

        .down-arrow-ove {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #e2b7ff;
            margin-right: 5px;
        }

        .down-arrow-ign {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid;
            margin-right: 5px;
        }

        .legendsIcon {
            padding: 1px 6px;
            font-weight: 500;
        }

        .down-arrow-afd {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #7dd4ff;
            margin-right: 5px;
        }

        .down-arrow-ded {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #ff9595;
            margin-right: 5px;
        }

        .sidebar .sidebar-header h2 {
            color: #7f8fa4;
            font-size: 24px;
            margin: 0;
        }

        .sidebar-content h3 {
            color: #7f8fa4;
            margin-left: 30px;
        }

        .sidebar-content p {
            color: #7f8fa4;
            font-size: 12px;
            margin-left: 30px;
        }

        .search-bar {
            display: flex;
            padding: 0;
            justify-content: start;
            width: 250px;
            /* Adjust width as needed */
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
            background: #fff;
        }

        .holidayIcon {
            background-color: #f7f7f7;
        }

        .custom-button {
            padding: 2px;
            margin-bottom: 15px;
            background-color: #3eb0f7;
            color: #fff;
            width: 100px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Styling for the input */
        .search-bar input[type="search"] {
            flex: 1;
            padding: 5px;
            border: none;
            outline: none;
            font-size: 14px;
            background: transparent;
        }

        /* Styling for the search icon */
        .search-bar::after {
            content: "\f002";
            /* Unicode for the search icon (font-awesome) */
            font-family: FontAwesome;
            /* Use an icon font library like FontAwesome */
            font-size: 16px;
            padding: 5px;
            color: #999;
            /* Icon color */
            cursor: pointer;
        }

        .presentIcon {
            border: 1px solid #6c757d;
        }

        .absentIcon {
            border: 1px solid #6c757d;
        }

        .offIcon {
            border: 1px solid #6c757d;
        }

        .restIcon {
            border: 1px solid #6c757d;
        }

        .down-arrow-gra-attendance-muster {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #ffe8de;
            margin-left: -5px;
        }

        /* Styling for the search icon (optional) */
        .search-bar input[type="search"]::placeholder {
            color: #999;
            /* Placeholder color */
        }

        .search-bar input[type="search"]::-webkit-search-cancel-button {
            display: none;
            /* Hide cancel button on Chrome */
        }

        .summary {
            border: 1px solid #ccc;
            background: #ebf5ff;
            padding: 0;
        }

        .Attendance {
            border: 1px solid #ccc;
            background: #ebf5ff;
            padding: 0;
            max-width: 800px;
            overflow-x: auto;
            scrollbar-width: thin;
            /* For Firefox */
            scrollbar-color: #dce0e5;
            /* For Firefox */
        }

        /* For Webkit-based browsers (Chrome, Safari, Edge) */
        .Attendance::-webkit-scrollbar {
            width: 2px;
            /* Width of the scrollbar */
            height: 8px;
        }

        /* Track (the area where the scrollbar sits) */
        .Attendance::-webkit-scrollbar-track {
            background: #fff;
            /* Background color of the track */
        }

        /* Handle (the draggable part of the scrollbar) */
        .Attendance::-webkit-scrollbar-thumb {
            background: #dce0e5;
            /* Color of the scrollbar handle */
            border-radius: 2px;
            /* Border radius of the handle */
        }

        /* Handle on hover */
        .Attendance::-webkit-scrollbar-thumb:hover {
            background: #dce0e5;
            /* Color of the scrollbar handle on hover */
        }

        .Attendance th,
        .Attendance td {
            width: auto;
            white-space: nowrap;
            /* Prevent content from wrapping */
        }

        .table {
            background: #fff;
            margin: 0;
        }

        td {
            font-size: 0.75rem;
        }

        .table tbody td {
            border-right: 1px solid #d5d5d5;
            /* Vertical border color and width */
        }

        .table tbody tr {
            height: 60px;
            /* Adjust as needed */
            align-items: center;
            /* Center align items vertically */
        }

        p {
            margin-bottom: 0;
        }

        /* Remove right border for the last cell in each row to avoid extra border */
        .summary .table tbody tr td:last-child {
            border-right: none;
            background: #f2f2f2;
        }

        .Attendance .table tbody tr td:last-child {
            border-right: none;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-top: -5px;
            /* Adjust as needed for spacing */
        }

        .accordion {
            background-color: #dae0f7;
            color: #444;
            cursor: pointer;
            padding: 21px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
            margin-top: 10px;
            border: 1px solid #cecece;
        }

        .panel {
            background-color: white;
            overflow: hidden;
            border: 1px solid #cecece;
            font-size: 14px;
        }

        .accordion:after {
            
            font-size: 13px;
            color: #fff;
            float: right;
            margin-left: 5px;
        }

        .legendsIcon {
            padding: 1px 6px;
            font-weight: 500;
            color: #778899;
            font-size: 12px;
        }

        .presentIcon {
            background-color: #edfaed;
        }

        .absentIcon {
            background-color: #fcf0f0;
            color: #ff6666;
        }

        .offDayIcon {
            background-color: #f7f7f7;
        }

        .leaveIcon {
            background-color: #fcf2ff;
        }

        .onDutyIcon {
            background-color: #fff7eb;
        }

        .holidayIcon {
            background-color: #f2feff;
        }

        .alertForDeIcon {
            background-color: #edf3ff;
        }

        .deductionIcon {
            background-color: #fcd2ca;
        }
        .accordion-icon {
            font-size: 13px;
            color: #fff;
            float: right;
            margin-left: 5px;
}

        .down-arrow-reg {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #f09541;
            margin-right: 5px;
        }

        .down-arrow-gra {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #5473e3;
            margin-right: 5px;
        }


        .emptyday {
            color: #aeadad;
            pointer-events: none;
        }
        .search-bar input[type="text"] {
    font-size: 12px; /* Adjust the font size as needed */
    color: #555; /* Change to your desired text color */
  /* Optional: Add border radius for rounded corners */
}
     
    </style>
    @php
    $present=0;
    $count=0;
    $flag=0;
    $isFilter=1;
    $isHoliday=0;
    $leaveTake=0;
    $leaveTakeforSession1=0;
    $leaveTakeforSession2=0;
    $leaveTakeforSession22=0;
    $leaveTypeForSession22=null;
    $currentMonth=date('n');
    if(isset($attendanceYear) && $attendanceYear !== null) {
    $currentYear = intval($attendanceYear);
    } else {
    // Set a default value if $attendanceYear is not set
    $currentYear = 2024;
    }
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
    @endphp
    @for ($i = 1; $i <= $daysInMonth; $i++) 
              @php 
                   $timestamp=mktime(0, 0, 0, $currentMonth, $i, $currentYear); 
                   $dayName=date('D', $timestamp); 
                   $fullDate=date('Y-m-d', $timestamp); 
              @endphp 
    @endfor 
    <div class="row">
        <div class="search-bar" style="margin-left:30px;">
            <input type="text" wire:model="search" placeholder="Search..." wire:change="searchfilter">
        </div>
        <div class="shift-roster-download-and-dropdown-for-attendance-muster col-md-4 d-flex justify-content-end">
            <button class="submit-btn"wire:click="downloadExcel"style="margin:13px;">
                <i class="fa fa-download" aria-hidden="true"></i>
            </button>
            <select class="dropdown-for-shift-roster-download-and-dropdown bg-white rounded border"name="year" wire:model="selectedYear" wire:change="updateselectedYear">
                <option value="{{$todayyear-1}}"style="font-size:12px;">{{$todaymonthinformat}} {{$todayyear-1}}</option>
                <option value="{{$todayyear}}"style="font-size:12px;">{{$todaymonthinformat}} {{$todayyear}}</option>
                <option value="{{$todayyear+1}}"style="font-size:12px;">{{$todaymonthinformat}} {{$todayyear+1}}</option>
            </select>
            @php
            $attendanceYearAsNumber = intval($attendanceYear);
            @endphp
        </div>
</div>

<div class="row m-0">

    <div class="col-md-12">


        <button class="accordion"wire:click="openlegend">Legend
        <span class="accordion-icon">
                            @if($legend)
                                &#x2796; <!-- Unicode for minus sign -->
                            @else
                                &#x2795; <!-- Unicode for plus sign -->
                            @endif
                    </span>
        </button>
        <div class="panel"style="display: {{ $legend ? 'block' : 'none' }};">
            <div class="row m-0 mt-3 mb-3">
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon presentIcon">P</span>
                    </p>
                    <p class="m-0 legend-text">Present</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon absentIcon">A</span>
                    </p>
                    <p class="m-0 legend-text">Absent</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon offDayIcon">O</span>
                    </p>
                    <p class="m-0 legend-text">Off Day</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon offDayIcon">R</span>
                    </p>
                    <p class="m-0 legend-text">Rest Day</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon leaveIcon">L</span>
                    </p>
                    <p class="m-0 legend-text">Leave</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon onDutyIcon">OD</span>
                    </p>
                    <p class="m-0 legend-text">On Duty</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon holidayIcon">H</span>
                    </p>
                    <p class="m-0 legend-text">Holiday</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon deductionIcon">&nbsp;&nbsp;</span>
                    </p>
                    <p class="m-0 legend-text" style="word-break: break-all;"> Deduction</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon alertForDeIcon">&nbsp;&nbsp;</span>
                    </p>
                    <p class="m-0 legend-text">Allert for Deduction</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <span class="legendsIcon absentIcon">?</span>
                    </p>
                    <p class="m-0 legend-text">Status Unknown</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <i class="far fa-clock"></i>
                    </p>
                    <p class="m-0 legend-text">Overtime</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                        <i class="far fa-edit"></i>
                    </p>
                    <p class="m-0 legend-text">Override</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                    <div class="down-arrow-ign-attendance-info-attendance-muster"></div>
                    </p>
                    <p class="m-0 legend-text">Ignored</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                    <div class="down-arrow-gra"></div>
                    </p>
                    <p class="m-0 legend-text">Grace</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="me-2 mb-0">
                    <div class="down-arrow-reg"></div>
                    </p>
                    <p class="m-0 legend-text">Regularized</p>
                </div>
            </div>
            <div class="row m-0 mb-3">
                <h6 class="m-0 p-2 mb-2" style="background-color: #f1f4f7;font-size:12px;">Day Type</h6>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="mb-0">
                        <i class="fas fa-mug-hot" style="color: #778899;"></i>
                    </p>
                    <p class="m-1 legend-text">Rest Day</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="mb-0">
                        <i class="fas fa-tv" style="color: #778899;"></i>
                    </p>
                    <p class="m-1 legend-text">Off Day</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="mb-0">
                        <i class="fas fa-umbrella" style="color: #778899;"></i>
                    </p>
                    <p class="m-1 legend-text">Holiday</p>
                </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex;margin-left:-10px">
                    <p class="mb-0">
                        <img src="{{ asset('images/half-day-session1-present.png') }}"  height="20" width="20">
                    </p>
                    <p class="m-1  pb-2 legend-text">Half Day(Session 1)</p>
                </div>
            <div class="d-flex" style="gap: 10px;">   
            <div class="col-md-3 mb-2" style="display: flex;margin-left:-2px">
                                <p class="mb-0">
                                <img src="{{ asset('images/half-day-session2-present.png') }}"  height="20" width="20">
                                </p>
                                <p class="m-1  pb-2 legend-text">Half Day(Session 2)</p>
                            </div>
                <div class="col-md-3 mb-2 pe-0" style="display: flex">
                    <p class="mb-0">
                        <i class="fas fa-battery-empty" style="color: #778899;"></i>
                    </p>
                    <p class="m-1  legend-text">IT Maintanance</p>
                </div>
            </div>    
            </div>
        </div>
    </div>



</div>
<div class="m-3 mt-4 row" style="margin-top:20px;">
    <div class="summary col-md-3">
        <p style="background:#ebf5ff;padding:5px 15px;font-size:0.755rem;">Summary</p>
        <table class="table">
            <thead>
                <tr>
                    <th style="width:75%;background:#ebf5ff;color:#778899;font-weight:500;line-height:2;font-size:0.825rem;">
                        Employee Name</th>
                    <th style="width:25%;background:#ebf5ff;color:#778899;font-weight:500;line-height:2;font-size:0.8255rem;">
                        P</th>
                    <!-- Add more headers as needed -->
                </tr>
            </thead>

            <tbody>
                <!-- Add table rows and data for Summary -->
                @if($notFound)
                @foreach($Employees as $emp)
                @php
                $isFilter=1;
                @endphp
                <tr>

                    <td  style="max-width: 200px;font-weight:400; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ ucwords(strtolower($emp->first_name)) }}&nbsp;{{ ucwords(strtolower($emp->last_name)) }}<span class="text-muted">(#{{ $emp->emp_id }})</span><br /><span class="text-muted" style="font-size:11px;">{{ucfirst($emp->job_title)}}{{ucfirst($emp->city)}}</span>
                    </td>
                    @php
                    $found = false;
                    @endphp
                    @foreach($DistinctDatesMapCount as $empId=>$d1)
                    

                    @foreach ($DistinctDatesMap as $empId => $distinctDates)


                        @if($empId==$e->emp_id)

                            @php
                            $decreaseincount=0;
                            foreach ($distinctDates as $distinctDate) {

                            // Extract date part from created_at and distinctDate

                            $createdAtDate = date('Y-m-d', strtotime($e->created_at));


                            // Your logic for each distinct date
                            if ($distinctDate === $fullDate) {

                            
                            $inRecord=App\Models\SwipeRecord::whereDate('created_at',$fullDate)->where('in_or_out','IN')->where('emp_id',$e->emp_id)->first();
                            $outRecord=App\Models\SwipeRecord::whereDate('created_at',$fullDate)->where('in_or_out','OUT')->where('emp_id',$e->emp_id)->orderByDesc('created_at')->first();
                            $formattedInTime = Carbon::parse($inRecord->swipe_time)->format('H:i');
                            $formattedOutTime = Carbon::parse($outRecord->swipe_time)->format('H:i');
                            $inTime = Carbon::parse($inRecord->swipe_time);
                            $outTime = Carbon::parse($outRecord->swipe_time);
                            $differenceInMinutes = $inTime->diffInMinutes($outTime);
                                if($outRecord==null)
                                {
                                   $decreaseincount+=1;
                                }
                                elseif($differenceInMinutes <= 270)
                                {
                                    $decreaseincount+=0.5;
                                }
                            }
                            }
                            @endphp

                        @endif
                    @endforeach
                    @if($empId ==$emp->emp_id)

                    <td>{{$d1['date_count']}}and{{$decreaseincount}}</td>
                    @php
                    $found = true;
                    @endphp

                    @endif

                    @endforeach
                    @if(!$found)
                    <td>0</td>
                    @endif


                </tr>
                @endforeach
                @else
                @foreach($Employees as $emp)
                <tr>

                    <td style="max-width: 200px;font-weight:400; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"data-toggle="tooltip" data-placement="top"
                    title="{{ ucwords(strtolower($emp->first_name)) }} {{ ucwords(strtolower($emp->last_name)) }}({{ $emp->emp_id }})">
                        {{ ucwords(strtolower($emp->first_name)) }}&nbsp;{{ ucwords(strtolower($emp->last_name)) }}<span class="text-muted">(#{{ $emp->emp_id }})</span><br /><span class="text-muted" style="font-size:11px;">{{ucfirst($emp->job_role)}}
                            @if(!empty($emp->job_location))
                              <span>, {{ucwords(strtolower($emp->job_location))}}</span>
                            @endif
                        </span>
                    </td>
                    @php
                    $found = false;

                    @endphp
                    @foreach($DistinctDatesMapCount as $empId=>$d1)
                       
                    

                    @if($empId ==$emp->emp_id)

                    @foreach ($DistinctDatesMap as $empId => $distinctDates)
 
 
                        @if($empId==$emp->emp_id)
 
                        @php
                        
                         $decreaseincount=0;
                        foreach ($distinctDates as $distinctDate) {
                            Illuminate\Support\Facades\Log::info("Processing distinct date: {$distinctDate} for employee ID: {$emp->emp_id}");
                        // Extract date part from created_at and distinctDate
 
                        
 
 
                        // Your logic for each distinct date
                        
 
                       
                        $inRecord=App\Models\SwipeRecord::whereDate('created_at',$distinctDate)->where('in_or_out','IN')->where('emp_id',$emp->emp_id)->first();
                        $outRecord=App\Models\SwipeRecord::whereDate('created_at',$distinctDate)->where('in_or_out','OUT')->where('emp_id',$emp->emp_id)->orderByDesc('created_at')->first();
                        Illuminate\Support\Facades\Log::info("IN Record:", ['inRecord' => $inRecord]);
                        Illuminate\Support\Facades\Log::info("OUT Record:", ['outRecord' => $outRecord]);
                        if($outRecord==null)
                                    {
                                        Illuminate\Support\Facades\Log::warning("OUT record is null for date: {$distinctDate}, increasing decreaseincount by 1");
                                        $decreaseincount+=1;
                                    }
                                    else
                                    {
                                        $formattedInTime = \Carbon\Carbon::parse($inRecord->swipe_time)->format('H:i');
                                        $formattedOutTime = \Carbon\Carbon::parse($outRecord->swipe_time)->format('H:i');
                                        $inTime = \Carbon\Carbon::parse($inRecord->swipe_time);
                                        $outTime = \Carbon\Carbon::parse($outRecord->swipe_time);
                                        $differenceInMinutes = $inTime->diffInMinutes($outTime);
                                        Illuminate\Support\Facades\Log::info("Formatted IN Time: {$formattedInTime}, OUT Time: {$formattedOutTime}");
                                        Illuminate\Support\Facades\Log::info("Time Difference in Minutes: {$differenceInMinutes}");
                                        if($differenceInMinutes <= 270)
                                        {
                                            Illuminate\Support\Facades\Log::info("Time difference is less than or equal to 270 minutes. Increasing decreaseincount by 0.5");
                                            $decreaseincount+=0.5;
                                        }
                                       
                                    }
                         
                        }
                        Illuminate\Support\Facades\Log::info("Final decreaseincount for employee ID {$emp->emp_id}: {$decreaseincount}");
                        @endphp
 
                        @endif
                        @endforeach
 
 
                    <td>{{ $d1['date_count'] - $decreaseincount }} </td>
                    @php
                    $found = true;
                    @endphp

                    @endif

                    @endforeach
                    @if(!$found)
                    <td>0</td>
                    @endif


                </tr>
                @endforeach
                @endif
                <!-- Add more rows as needed -->
            </tbody>

        </table>
    </div>
    <div class="Attendance col-md-9">
        @if($attendanceYear==0)
        <p style="background:#ebf5ff; padding:5px 15px;font-size:0.755rem;">Attendance for {{date("M", mktime(0, 0, 0, $currentMonth, 1))}},{{$todayyear}}</p>
        @else
        <p style="background:#ebf5ff; padding:5px 15px;font-size:0.755rem;">Attendance for {{date("M", mktime(0, 0, 0, $currentMonth, 1))}},{{$currentYear}}</p>
        @endif
        <table class="table">
            @php
            // Get current month and year
            $currentMonth = date('n');
            // Total number of days in the current month
            if(isset($attendanceYear) && $attendanceYear !== null) {
            $currentYear = intval($attendanceYear);
            } else {
            // Set a default value if $attendanceYear is not set
            $currentYear = date('Y');
            }

            // Total number of days in the current month
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

            @endphp

            <thead>
                <tr>

                    @for ($i = 1; $i <= $daysInMonth; $i++)
                        @php
                        $timestamp=mktime(0, 0, 0, $currentMonth, $i, $currentYear);
                        $dayName=date('D', $timestamp); // Get the abbreviated day name (e.g., Sun, Mon)
                        $fullDate=date('Y-m-d', $timestamp); // Full date in 'YYYY-MM-DD' format
                        @endphp
                        <th style="width:75%; background:#ebf5ff; color:#778899; font-weight:500; text-align:center;">
                        <div style="font-size:0.825rem;line-height:0.8;font-weight:500;">
                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        <div style="margin-top:-5px; font-size:0.625rem;margin-top:1px;">{{ $dayName }}</div>
                        </th>

                        @endfor
                </tr>
            </thead>

            <tbody>
                <!-- Add table rows and data for Attendance -->
                @if($isFilter==1)




                @foreach($Employees as $e)

                @php
                $currentYear = date('Y');
                @endphp

                
                <tr style="height:60px;background-color:#fff;">
                    @php
                    // Get the current day of the month
                    $currentYear = date('Y');
                    $currentDay = $daysInMonth;
                    $currentDate=now()->format('Y-m-d');
                   
                    // Check if $attendanceYear is greater than the current year
                    //if ($attendanceYear == $currentYear) {
                    //$currentDay = date('j');
                    //}
                    //elseif($attendanceYear == 0) {
                    //$currentDay = date('j');
                    //}
                    @endphp

                    @for ($i = 1; $i <= $currentDay; $i++)
                        @php
                        $timestamp=mktime(0, 0, 0, $currentMonth, $i, $SelectedYear);
                        $dayName=date('D', $timestamp); // Get the abbreviated day name (e.g., Sun, Mon)
                        $fullDate=date('Y-m-d', $timestamp); // Full date in 'YYYY-MM-DD' format
                        @endphp
                        <td >




                        @foreach ($DistinctDatesMap as $empId => $distinctDates)


                        @if($empId==$e->emp_id)

                        @php

                        foreach ($distinctDates as $distinctDate) {

                        // Extract date part from created_at and distinctDate

                        $createdAtDate = date('Y-m-d', strtotime($e->created_at));


                        // Your logic for each distinct date
                        if ($distinctDate === $fullDate) {

                        $present=1;
                        $employeeShiftDetails = \DB::table('employee_details')
                                        ->join('company_shifts', function ($join) {
                                            $join->on('employee_details.shift_type', '=', 'company_shifts.shift_name')
                                                ->whereJsonContains('employee_details.company_id', \DB::raw('JSON_QUOTE(company_shifts.company_id)'));
                                        })
                                        ->select(
                                            'employee_details.*',
                                            'company_shifts.shift_start_time',
                                            'company_shifts.shift_end_time'
                                        )
                                        ->where('employee_details.emp_id', $e->emp_id) // Replace with the desired employee ID
                                        ->first();
                        $inRecord=App\Models\SwipeRecord::whereDate('created_at',$fullDate)->where('in_or_out','IN')->where('emp_id',$e->emp_id)->first();
                        $outRecord=App\Models\SwipeRecord::whereDate('created_at',$fullDate)->where('in_or_out','OUT')->where('emp_id',$e->emp_id)->orderByDesc('created_at')->first();
                         
                        }
                        }
                        @endphp

                        @endif
                        @endforeach

                        @foreach($ApprovedLeaveRequests1 as $empId => $leaveDetails)


                        @if($empId==$e->emp_id)
                        <p>
                            @php
                            foreach ($leaveDetails['dates'] as $date)
                            {
                            if($date == $fullDate)
                            {
                            $leaveTake=1;
                            $leaveType=App\Models\LeaveRequest::where('emp_id',$e->emp_id)->whereDate('from_date', '<=', $date)
                                        ->whereDate('to_date', '>=', $date)
                                        ->where('leave_status',2)
                                        ->where('from_session','Session 1')
                                        ->where('to_session','Session 2')
                                        ->value('leave_type');

                            }
                            }
                            @endphp
                        </p>

                        @endif

                        @endforeach
                        @foreach($ApprovedLeaveRequestsForSession1 as $empId => $leaveDetails)
                        @if($empId==$e->emp_id)
                        <p>
                            @php
                            foreach ($leaveDetails['dates'] as $key=>$date)
                            {
                                    if($date == $fullDate)
                                    {
                                        if (count($leaveDetails['dates']) > 1 && $key != array_key_last($leaveDetails['dates'])) {
                                                $leaveTake = 1; // For last iteration when count > 1
                                                $leaveType=App\Models\LeaveRequest::where('emp_id',$e->emp_id)->whereDate('from_date', '<=', $date)
                                                    ->whereDate('to_date', '>=', $date)
                                                    ->where('leave_status',2)
                                                    ->where('leave_applications.from_session','Session 1')
                                                    ->where('leave_applications.to_session','Session 1')
                                                    ->value('leave_type');

                                         
                                        } else {
                                               $leaveTakeforSession1 = 1; // For other iterations
                                               $leaveTypeforSession1=App\Models\LeaveRequest::where('emp_id',$e->emp_id)->whereDate('from_date', '<=', $date)
                                                    ->whereDate('to_date', '>=', $date)
                                                    ->where('leave_status',2)
                                                    ->where('leave_applications.from_session','Session 1')
                                                    ->where('leave_applications.to_session','Session 1')
                                                    ->value('leave_type');
                                        }
                                    

                                    }
                            }
                            @endphp
                        </p>

                        @endif
                        @endforeach
                        @foreach($ApprovedLeaveRequestsForSession2 as $empId => $leaveDetails)
                        @if($empId==$e->emp_id)
                        <p>
                            @php
                            foreach ($leaveDetails['dates'] as $key=>$date)
                            {
                                if($date == $fullDate)
                                    {
                                        if ((count($leaveDetails['dates']) > 1 && $key === array_key_first($leaveDetails['dates']))||(count($leaveDetails['dates']) == 1)) {
                                               $leaveTakeforSession2 = 1; // For other iterations
                                               $leaveTypeforSession2=App\Models\LeaveRequest::where('emp_id',$e->emp_id)->whereDate('from_date', '<=', $date)
                                                    ->whereDate('to_date', '>=', $date)
                                                    ->where('leave_status',2)
                                                    ->where('leave_applications.from_session','Session 2')
                                                    ->where('leave_applications.to_session','Session 2')
                                                    ->value('leave_type');
                                              
                                         
                                        } else {

                                                 $leaveTake= 1; // For last iteration when count > 1
                                                $leaveType=App\Models\LeaveRequest::where('emp_id',$e->emp_id)->whereDate('from_date', '<=', $date)
                                                    ->whereDate('to_date', '>=', $date)
                                                    ->where('leave_status',2)
                                                    ->where('leave_applications.from_session','Session 2')
                                                    ->where('leave_applications.to_session','Session 2')
                                                    ->value('leave_type');

                                               
                                        }
                                    

                                    }
                                    
                            }
                            @endphp
                        </p>

                        @endif
                        @endforeach

                        @foreach($Holiday as $h)

                        @if($h==$fullDate)

                        @php
                        $isHoliday=1;
                        break;
                        @endphp
                        @endif

                        @endforeach

                        @if (($dayName === 'Sat' || $dayName === 'Sun')&&($fullDate<=$currentDate))
                        <p style="color:#666;font-weight:500;"title="Off Day">O</p>

                        @elseif(($isHoliday==1)&&($fullDate<=$currentDate))
                        <p style=" color:#666;font-weight:500;"title="Holiday">H</p>
                        @elseif(($leaveTake==1)&&($fullDate<=$currentDate))
            
                        @php
                                            $leaveAbbreviations = [
                                                'Loss Of Pay' => 'LOP',
                                                'Casual Leave' => 'CL',
                                                'Sick Leave' => 'SL',
                                                'Casual Leave Probation'=>'CLP',
                                                'Marriage Leave'=>'ML',
                                                'Paternity Leave'=>'PL',
                                                'Maternity Leave'=>'ML',
                                            ];

                                            $abbreviationforLeaveType = $leaveAbbreviations[$leaveType] ?? strtoupper(substr($leaveType, 0, 2));
                                 @endphp
 
                        <p style=" color:#666;font-weight:500;"title="{{$leaveType}}">{{$abbreviationforLeaveType}}</p>
                        
                        @elseif($leaveTakeforSession1==1&&$present==1&&($fullDate<=$currentDate))
                        @php
                                            $leaveAbbreviations = [
                                                'Loss Of Pay' => 'LOP',
                                                'Casual Leave' => 'CL',
                                                'Sick Leave' => 'SL',
                                                'Casual Leave Probation'=>'CLP',
                                                'Marriage Leave'=>'ML',
                                                'Paternity Leave'=>'PL',
                                                'Maternity Leave'=>'ML',
                                            ];

                                            $abbreviationforLeaveTypeforSession1 = $leaveAbbreviations[$leaveTypeforSession1] ?? strtoupper(substr($leaveType, 0, 2));
                                 @endphp
 
                        <p style=" color:#666;font-weight:500;"title="{{$leaveTypeforSession1}} and Present">{{$abbreviationforLeaveTypeforSession1}}:P</p>
                        @elseif($leaveTakeforSession2==1&&$present==1&&($fullDate<=$currentDate))
                        @php
                                            $leaveAbbreviations = [
                                                'Loss Of Pay' => 'LOP',
                                                'Casual Leave' => 'CL',
                                                'Sick Leave' => 'SL',
                                                'Casual Leave Probation'=>'CLP',
                                                'Marriage Leave'=>'ML',
                                                'Paternity Leave'=>'PL',
                                                'Maternity Leave'=>'ML',
                                            ];

                                            $abbreviationforLeaveTypeforSession2 = $leaveAbbreviations[$leaveTypeforSession2] ?? strtoupper(substr($leaveType, 0, 2));
                                 @endphp
                        <p style=" color:#666;font-weight:500;"title="Present and {{$leaveTypeforSession2}}">P:{{$abbreviationforLeaveTypeforSession2}}</p>
                        @elseif($leaveTakeforSession2==1&&$leaveTakeforSession1==1&&$fullDate<=$currentDate)
                        @php
                                            $leaveAbbreviations = [
                                                'Loss Of Pay' => 'LOP',
                                                'Casual Leave' => 'CL',
                                                'Sick Leave' => 'SL',
                                                'Casual Leave Probation'=>'CLP',
                                                'Marriage Leave'=>'ML',
                                                'Paternity Leave'=>'PL',
                                                'Maternity Leave'=>'ML',
                                            ];

                                            $abbreviationforLeaveTypeforSession1 = $leaveAbbreviations[$leaveTypeforSession1] ?? strtoupper(substr($leaveType, 0, 2));
                                            $abbreviationforLeaveTypeforSession2 = $leaveAbbreviations[$leaveTypeforSession2] ?? strtoupper(substr($leaveType, 0, 2));
                                 @endphp
                        <p style=" color:#666;font-weight:500;"title="{{$leaveTypeforSession1}} and {{$leaveTypeforSession2}}">{{$abbreviationforLeaveTypeforSession1}}:{{$abbreviationforLeaveTypeforSession2}}</p>
                       
                        @elseif(($leaveTakeforSession1==1)&&($fullDate<=$currentDate))
                        @php
                                            $leaveAbbreviations = [
                                                'Loss Of Pay' => 'LOP',
                                                'Casual Leave' => 'CL',
                                                'Sick Leave' => 'SL',
                                                'Casual Leave Probation'=>'CLP',
                                                'Marriage Leave'=>'ML',
                                                'Paternity Leave'=>'PL',
                                                'Maternity Leave'=>'ML',
                                            ];

                                            $abbreviationforLeaveTypeforSession2 = $leaveAbbreviations[$leaveTypeforSession1] ?? strtoupper(substr($leaveType, 0, 2));
                                 @endphp
                        <p style=" color:#666;font-weight:500;"title="{{$leaveTypeforSession1}} and absent">{{$abbreviationforLeaveTypeforSession2}}:A</p>
                        @elseif(($leaveTakeforSession2==1)&&($fullDate<=$currentDate))
                        @php
                                            $leaveAbbreviations = [
                                                'Loss Of Pay' => 'LOP',
                                                'Casual Leave' => 'CL',
                                                'Sick Leave' => 'SL',
                                                'Casual Leave Probation'=>'CLP',
                                                'Marriage Leave'=>'ML',
                                                'Paternity Leave'=>'PL',
                                                'Maternity Leave'=>'ML',
                                            ];

                                            $abbreviationforLeaveTypeforSession2 = $leaveAbbreviations[$leaveTypeforSession2] ?? strtoupper(substr($leaveType, 0, 2));
                                 @endphp
                        <p style=" color:#666;font-weight:500;"title="Absent and {{$leaveTypeforSession2}}">A:{{$abbreviationforLeaveTypeforSession2}}</p>
                        @elseif($present==1&&!empty($outRecord)&&($fullDate<=$currentDate))
                           @php
                                $shiftStartTime = \Carbon\Carbon::parse($employeeShiftDetails->shift_start_time);
                                $shiftEndTime = \Carbon\Carbon::parse($employeeShiftDetails->shift_end_time);


                                // Format swipe times to "H:i"
                                $formattedInTime = \Carbon\Carbon::parse($inRecord->swipe_time)->format('H:i');
                                $formattedOutTime = \Carbon\Carbon::parse($outRecord->swipe_time)->format('H:i');

                                // Calculate time difference
                                $inTime = \Carbon\Carbon::parse($inRecord->swipe_time);
                                $outTime = \Carbon\Carbon::parse($outRecord->swipe_time);
                                $startTimeForSession1 = \Carbon\Carbon::createFromTime(
                                                        $shiftStartTime->hour,
                                                        $shiftStartTime->minute,
                                                        $shiftStartTime->second
                                                    );
                                                    // 10:00 AM
                                $shiftEndTimeForSession1 = $shiftStartTime->copy()->addHours(4)->addMinutes(30);                    
                                $endTimeForSession1 = \Carbon\Carbon::createFromTime(
                                                        $shiftEndTimeForSession1->hour,
                                                        $shiftEndTimeForSession1->minute,
                                                        $shiftEndTimeForSession1->second
                                                    );
                                $shiftStartTimeForSession2 = $shiftStartTime->copy()->addHours(4)->addMinutes(31);                      
                                $startTimeForSession2 = \Carbon\Carbon::createFromTime($shiftStartTimeForSession2->hour, $shiftStartTimeForSession2->minute, $shiftStartTimeForSession2->second); // 10:00 AM
                                $endTimeForSession2 = \Carbon\Carbon::createFromTime(
                                        $shiftEndTime->hour,
                                        $shiftEndTime->minute,
                                        $shiftEndTime->second
                                    );
                                $differenceInMinutes = $inTime->diffInMinutes($outTime);
                                

                                // Format the difference as "HH:MM"
                                //$hours = str_pad($difference->h, 2, '0', STR_PAD_LEFT);
                                //$minutes = str_pad($difference->i, 2, '0', STR_PAD_LEFT);
                            @endphp
                             @if($differenceInMinutes <= 270)
                              @if($inTime->gte($startTimeForSession1) && $outTime->lte($endTimeForSession1))

                                <img src="{{ asset('images/half-day-session1-present.png') }}" title="Half Day For Session-1" height="20" width="20">
                              @elseif($inTime->gte($startTimeForSession2) && $outTime->lte($endTimeForSession2))
                                <img src="{{ asset('images/half-day-session2-present.png') }}" title="Half Day For Session-2" height="20" width="20">
                              @endif
                             @elseif($differenceInMinutes > 270)
                               <p style=" color:#666;font-weight:500;"title="Present">P </p>
                             @endif
                         
                        @elseif($fullDate<=$currentDate)

                        <p style=" color: #f66;font-weight:500;"title="Absent">A</p>
                        @endif

                        </td>

                        @php
                        $present=0;
                        $isHoliday=0;
                        $leaveTake=0;
                        $leaveTakeforSession1=0;
                        $leaveTakeforSession2=0;
                        $leaveTakeforSession22=0;

                        @endphp

                        @endfor

                        @php
                        $EmployeesCount--;

                        @endphp



                        </tr>
                       
                        @endforeach
                        @if($notFound)
                        <td colspan="20" style="text-align: center;font-size:12px">Record not found</td>
                        @endif
                        @php
                        $currentYear=date('Y');
                        @endphp
                        @if($attendanceYear>$currentYear)
                        <div style="text-align: center; font-size: 12px;">

                        </div>
                        @endif
                        @endif

            </tbody>
        </table>
    </div>
</div>

</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleSidebarButton = document.getElementById("toggleSidebar");
        const sidebar = document.querySelector(".sidebar");

        toggleSidebarButton.addEventListener("click", function() {
            if (sidebar.style.right === "0px" || sidebar.style.right === "") {
                sidebar.style.right = "-250px"; // Hide the sidebar
            } else {
                sidebar.style.right = "0px"; // Show the sidebar
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        const toggleSidebarButton = document.getElementById("toggleSidebar");
        const closeSidebarButton = document.getElementById("closeSidebar");
        const sidebar = document.querySelector(".sidebar");

        toggleSidebarButton.addEventListener("click", function() {
            sidebar.style.right = "0px"; // Show the sidebar
        });

        closeSidebarButton.addEventListener("click", function() {
            sidebar.style.right = "-250px"; // Hide the sidebar
        });
    });
</script>

</div>