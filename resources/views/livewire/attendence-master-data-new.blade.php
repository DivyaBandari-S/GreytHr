
<div>
    <style>
      
.sidebar {
    position: fixed;
    top: 0;
    overflow-y: hidden;
    right: -255px;
    height: 100%;
    width: 245px; /* Adjust width as needed */
    background-color: #fff; /* Adjust background color */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Optional box shadow */
     /* Add vertical scrollbar if needed */
    z-index: 1000; /* Adjust z-index */
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
  border-bottom: 17px solid #e2b7ff ;
  margin-right: 5px;
} 
.down-arrow-ign { 
  width: 0;
  height: 0;
  /* border-left: 20px solid transparent; */
  border-right: 17px solid transparent;
  border-bottom: 17px solid ;
  margin-right: 5px;
} 
.legendsIcon{
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

        .search-bar{
            display:flex;
            padding:0;
            justify-content:start;
            width: 250px; /* Adjust width as needed */
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
            background:#fff;
        }
        .holidayIcon {
              background-color: #f7f7f7;
        }
    
        .custom-button{
          padding: 2px;
            margin-bottom:15px;
            background-color:#3eb0f7;
            color: #fff;
            width:100px;
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
            content: "\f002"; /* Unicode for the search icon (font-awesome) */
            font-family: FontAwesome; /* Use an icon font library like FontAwesome */
            font-size: 16px;
            padding: 5px;
            color: #999; /* Icon color */
            cursor: pointer;
        }
        .presentIcon
        {
            border:1px solid #6c757d;
        }
        .absentIcon
        {
            border:1px solid #6c757d;
        }
        .offIcon
        {
            border:1px solid #6c757d;
        }
        .restIcon
        {
            border:1px solid #6c757d;
        }
        .down-arrow-gra { 
                width: 0;
                height: 0;
  /* border-left: 20px solid transparent; */
                border-right: 17px solid transparent;
                border-bottom: 17px solid #ffe8de;
                margin-left:-5px;
        } 
        /* Styling for the search icon (optional) */
        .search-bar input[type="search"]::placeholder {
            color: #999; /* Placeholder color */
        }

        .search-bar input[type="search"]::-webkit-search-cancel-button {
            display: none; /* Hide cancel button on Chrome */
        }
        .summary{
            border:1px solid #ccc;
            background:#ebf5ff;
            padding:0;
        }
        .Attendance {
            border: 1px solid #ccc;
            background: #ebf5ff;
            padding: 0;
            max-width: 800px;
            overflow-x: auto;
            scrollbar-width: thin; /* For Firefox */
            scrollbar-color: #dce0e5; /* For Firefox */
        }

        /* For Webkit-based browsers (Chrome, Safari, Edge) */
        .Attendance::-webkit-scrollbar {
            width: 2px; /* Width of the scrollbar */
            height:8px;
        }

        /* Track (the area where the scrollbar sits) */
        .Attendance::-webkit-scrollbar-track {
            background: #fff; /* Background color of the track */
        }

        /* Handle (the draggable part of the scrollbar) */
        .Attendance::-webkit-scrollbar-thumb {
            background: #dce0e5; /* Color of the scrollbar handle */
            border-radius: 2px; /* Border radius of the handle */
        }

        /* Handle on hover */
        .Attendance::-webkit-scrollbar-thumb:hover {
            background: #dce0e5; /* Color of the scrollbar handle on hover */
        }

        .Attendance th,
        .Attendance td {
            width: auto;
            white-space: nowrap; /* Prevent content from wrapping */
        }
        .table{
            background:#fff;
            margin:0;
        }
       
        td{
            font-size:0.795rem;
        }
        .table tbody td {
            border-right: 1px solid #d5d5d5; /* Vertical border color and width */
        }

        /* Remove right border for the last cell in each row to avoid extra border */
        .summary .table tbody tr td:last-child {
            border-right: none;
            background:#f2f2f2;
        }
        .Attendance .table tbody tr td:last-child {
            border-right: none;
        }
        .legend-item {
                display: flex;
                align-items: center;
               margin-top: -5px; /* Adjust as needed for spacing */
        }
     
    
    </style>
    @php
        $present=0;
        $count=0;
        $flag=0;
        $isFilter=1;
        $isHoliday=0;
        $leaveTake=0;
        $currentMonth=12;
        $currentYear=2023;
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
    @endphp  
    @for ($i = 1; $i <= $daysInMonth; $i++)
            @php
                $timestamp = mktime(0, 0, 0, $currentMonth, $i, $currentYear);
                $dayName = date('D', $timestamp);
                $fullDate = date('Y-m-d', $timestamp);
               
            @endphp

            
    @endfor
    <button class="custom-button"style="float:right;"wire:click="downloadExcel">
        <i class="fa fa-download" aria-hidden="true"></i>
    </button>

    <div class="container">
        <div class="search-bar">
            <input type="text" wire:model="search"placeholder="Search..."wire:change="searchfilter">
        </div>
        <a href="#" id="toggleSidebar" class="gt-overlay-toggle"
                style="margin-top:69px;color:rgb(2, 17, 79);">Legend</a>
        <div class="sidebar">
                <!-- Sidebar content goes here -->
                <div class="sidebar-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="color: #7f8fa4;margin-left:0;font-size:20px;">Legends</h3>
                    <button style="font-size: 12px; padding: 5px 10px; margin-left: 10px; margin-top: -5px;"
                        id="closeSidebar">&#10006;</button>


                </div>
                <div class="sidebar-content"style="overflow-y:auto">
                    <h3 style="font-size: 16px;">Actionable&nbsp;Status</h3>
                    
                        <div class="legend-item">
                            <p class="me-2 mb-0"style="font-size: 14px; color: #e2b7ff;margin-left:22px;">
                                                <span class="legendsIcon presentIcon"style="font-size:13px;color:#6c757d;">P</span>
                            </p>
                            <p style="display: inline-block; margin-left: 2px;margin-top:15px;">Present</p>
                        </div>
                        <div class="legend-item">
                           <p class="me-2 mb-0"style="font-size: 14px; color: #e2b7ff;margin-left:22px;">
                                                <span class="legendsIcon absentIcon"style="font-size:13px;color:#6c757d;">A</span>
                            </p>
                            <p style="display: inline-block; margin-left: 2px;margin-top:15px">Absent</p>
                        </div>
                   
                    
                        <div class="legend-item">
                        <p class="me-2 mb-0"style="font-size: 14px; color: #e2b7ff;margin-left:22px;">
                                                <span class="legendsIcon offIcon"style="font-size:13px;color:#6c757d;">O</span>
                            </p>
                            <p style="display: inline-block; margin-left: 2px;margin-top:15px">
                                Off&nbsp;Day</p>
                        </div>
                        <div class="legend-item">
                           <p class="me-2 mb-0"style="font-size: 14px; color: #e2b7ff;margin-left:22px;">
                                                <span class="legendsIcon restIcon"style="font-size:13px;color:#6c757d;">R</span>
                            </p>
                            <p style="display: inline-block; margin-left: 2px;margin-top:15px">Rest&nbsp;Day</p>
                        </div>
                    
                   
                    <h3 style="font-size: 16px;">Alerts&nbsp;&&nbsp;Deductions</h3>
                    <div style="display:flex;flex-direction:row;margin-top:-10px;">
                        <div class="legend-item">
                            <p class="me-2 mb-0">
                                   <div class="down-arrow-reg"style="color:#e2b7ff;"></div>
                            </p>
                            <p style="display: inline-block; margin-left: -25px;margin-top:20px">Regularized</p>
                        </div>
                        <div class="legend-item">
                            <p class="me-2 mb-0">
                                   <div class="down-arrow-ove"style="color:#e2b7ff;"></div>
                            </p>
                            <p style="display: inline-block; margin-left: -25px;margin-top:20px">Override</p>
                        </div>


                    </div>
                    <div style="display:flex;flex-direction:row;margin-top:-10px;">
                        <div class="legend-item">
                           <p class="me-2 mb-0">
                                   <div class="down-arrow-ded"style="color:#ff9595;"></div>
                            </p>
                            <p style="display: inline-block; margin-left: -25px;margin-top:20px">
                                Deduction</p>
                        </div>
                        <div class="legend-item">
                            <p class="me-2 mb-0">
                                   <div class="down-arrow-afd"style="color:#7dd4ff;"></div>
                            </p>
                            <p style="display: inline-block;margin-left: -25px;margin-top:20px">Alert&nbsp;for&nbsp;Deduction</p>
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:row;margin-top:-10px;margin-left:5px;">
                        <div class="legend-item">
                           <p class="me-2 mb-0">
                                   <div class="down-arrow-ign"style="color:#c7c7c7;"></div>
                            </p>
                            <p style="display: inline-block; margin-left: -25px;margin-top:20px">Ignored</p>
                        </div>
                        <div class="legend-item">
                           <p class="me-2 mb-0">
                                   <div class="down-arrow-gra"style="color:#ffe8de;"></div>
                            </p>
                            <p style="display: inline-block; margin-left: -25px;margin-top:20px">Grace</p>
                        </div>
                    </div>
                   
                   
                    <h3 style="font-size: 16px;">Display&nbsp;Status</h3>
                    
                    <div class="legend-item"style="margin-top:-15px;">
                        <p  style="font-size: 13px; color: #a3b2c7;margin-left:25px;margin-top:10px">P</p>
                        <p style="display: inline-block; margin-left: 20px;margin-top:10px;">Present</p>
                    </div>
                    <div class="legend-item"style="margin-top:-15px;">
                        <p  style="font-size: 13px; color: #a3b2c7;margin-left:25px;margin-top:10px">L</p>
                        <p style="display: inline-block; margin-left: 20px;margin-top:10px">Leave</p>
                    </div>
               
                
                    <div class="legend-item"style="margin-top:-15px;">
                         <p class="me-2 mb-0"style="margin-left:23px;">
                                   <span class="legendsIcon holidayIcon">H</span>
                         </p>
                        <p style="display: inline-block; margin-left: 12px;margin-top:12px">
                            Holiday</p>
                    </div>
                    <div class="legend-item"style="margin-top:-15px;">
                        <p style="font-size: 13px; color: #f66;margin-left:25px;margin-top:10px">A</p>
                        <p style="display: inline-block; margin-left: 20px;margin-top:12px">Absent</p>
                    </div>
                    <div class="legend-item"style="margin-top:-15px;">
                        <p style="font-size: 13px; color: #a3b2c7;margin-left:25px;margin-top:10px">O</p>
                        <p style="display: inline-block; margin-left: 20px;margin-top:12px">Off&nbsp;Day</p>
                    </div>
               
                </div>

            </div>
     
 

     
  </div>
        <div class="row" style="margin-top: 20px;">
            <div class="summary col-md-3">
                <p style="background:#ebf5ff;padding:5px 15px;font-size:0.755rem;">Summary</p>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:75%;background:#ebf5ff;color:#778899;font-weight:500;line-height:2;font-size:0.825rem;">Employee Name</th>
                            <th  style="width:25%;background:#ebf5ff;color:#778899;font-weight:500;line-height:2;font-size:0.8255rem;">P</th>
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
                             
                                <td style="max-width: 200px;font-weight:400; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ucfirst($emp->first_name)}}&nbsp;{{ucfirst($emp->last_name)}}<span class="text-muted">(#{{ $emp->emp_id }})</span><br/><span class="text-muted"style="font-size:11px;">{{ucfirst($emp->job_title)}},{{ucfirst($emp->city)}}</span></td>
                                @php
                                         $found = false;
                                @endphp
                               @foreach($DistinctDatesMapCount as $empId=>$d1)
                                   @if($empId ==$emp->emp_id)
                                      
                                      <td>{{$d1['date_count']}}</td>
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
                             
                                <td style="max-width: 200px;font-weight:400; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ucfirst($emp->first_name)}}&nbsp;{{ucfirst($emp->last_name)}}<span class="text-muted">(#{{ $emp->emp_id }})</span><br/><span class="text-muted"style="font-size:11px;">{{ucfirst($emp->job_title)}},{{ucfirst($emp->city)}}</span></td>
                                @php
                                         $found = false;
                                         
                                @endphp
                               @foreach($DistinctDatesMapCount as $empId=>$d1)
                               
                                   @if($empId ==$emp->emp_id)
                                      
                                      <td>{{$d1['date_count']}}</td>
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
            <div class="Attendance col-md-9" >
                <p style="background:#ebf5ff; padding:5px 15px;font-size:0.755rem;">Attendance</p>
                <table class="table">
                @php
                    // Get current month and year
                    $currentMonth = 12;
                    $currentYear = 2023;
                    
                    // Total number of days in the current month
                    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
                    
                @endphp

                <thead>
                    <tr>
                        
                        @for ($i = 1; $i <= $daysInMonth; $i++)
                            @php
                                $timestamp = mktime(0, 0, 0, $currentMonth, $i, $currentYear);
                                $dayName = date('D', $timestamp); // Get the abbreviated day name (e.g., Sun, Mon)
                                $fullDate = date('Y-m-d', $timestamp); // Full date in 'YYYY-MM-DD' format
                               
                            @endphp
                            <th style="width:75%; background:#ebf5ff; color:#778899; font-weight:500; text-align:center;">
                                <div style="font-size:0.825rem;line-height:0.8;font-weight:500;"> {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</div>
                                <div style="margin-top:-5px; font-size:0.625rem;margin-top:1px;">{{ $dayName }}</div>
                            </th>

                        @endfor
                    </tr>
                </thead>
              
                    <tbody>
                        <!-- Add table rows and data for Attendance -->
                        @if($isFilter==1)
                
                        
                        
                         
                        @foreach($Employees as $e)
                       
                          
                        <tr style="height:14px;background-color:#fff;">
                          
                           @for ($i = 1; $i <= $daysInMonth; $i++)
                           @php
                                $timestamp = mktime(0, 0, 0, $currentMonth, $i, $currentYear);
                                $dayName = date('D', $timestamp); // Get the abbreviated day name (e.g., Sun, Mon)
                                $fullDate = date('Y-m-d', $timestamp);
                              
                               
                                
                                 // Full date in 'YYYY-MM-DD' format
                           @endphp
                           
                          <td style="height:20px;">
                           
                                 
                               
                          @foreach ($DistinctDatesMap  as $empId => $distinctDates)
                            
                             
                            @if($empId==$e->emp_id)
                            
                            @php 
                              
                               foreach ($distinctDates as $distinctDate) {
                               
                            // Extract date part from created_at and distinctDate
                              
                               $createdAtDate = date('Y-m-d', strtotime($e->created_at));
                           
                               
                            // Your logic for each distinct date
                              if ($distinctDate === $fullDate) {
                                
                                $present=1;
                                
                              }
                            }
                            @endphp
                           
                           @endif  
                          @endforeach
                          
                          @foreach($ApprovedLeaveRequests1  as $empId => $leaveDetails)
                            
                            
                                  @if($empId==$e->emp_id)
                                    <p>
                                        @php
                                           foreach ($leaveDetails['dates'] as $date)
                                           {
                                                      if($date == $fullDate)
                                                       {
                                                           $leaveTake=1;
                                                         
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
                                 
                                  @if ($dayName === 'Sat' || $dayName === 'Sun')
                                    <p style="color:#666;font-weight:500;">O</p> 
                                
                                  @elseif($isHoliday==1)
                                    <p style=" color:#666;font-weight:500;">H</p> 
                                  @elseif($leaveTake==1)
                                    <p style=" color:#666;font-weight:500;">L</p>
                                  @elseif($present==1)
                                    <p style=" color:#666;font-weight:500;">P</p> 
                                  
                                        
                                  @else
                                    
                                     <p style=" color: #f66;font-weight:500;">A</p>    
                                  @endif
                                 
                        </td>
                            
                          @php
                             $present=0;
                             $isHoliday=0;
                             $leaveTake=0;
                            
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
                   
                       @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
    const toggleSidebarButton = document.getElementById("toggleSidebar");
    const sidebar = document.querySelector(".sidebar");

    toggleSidebarButton.addEventListener("click", function () {
        if (sidebar.style.right === "0px" || sidebar.style.right === "") {
            sidebar.style.right = "-250px"; // Hide the sidebar
        } else {
            sidebar.style.right = "0px"; // Show the sidebar
        }
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const toggleSidebarButton = document.getElementById("toggleSidebar");
    const closeSidebarButton = document.getElementById("closeSidebar");
    const sidebar = document.querySelector(".sidebar");

    toggleSidebarButton.addEventListener("click", function () {
        sidebar.style.right = "0px"; // Show the sidebar
    });

    closeSidebarButton.addEventListener("click", function () {
        sidebar.style.right = "-250px"; // Hide the sidebar
    });
});   


</script> 
</div>
