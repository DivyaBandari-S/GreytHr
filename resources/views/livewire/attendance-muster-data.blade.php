<div>
    <style>
 
   
    </style>
    @php
        $present=0;
        $count=0;
        $flag=0;
    @endphp  
   
    <div class="container">
        <div class="search-bar-attendance-muster">
            <input type="search" placeholder="Search...">
        </div>
 
        <div class="row" style="margin-top: 20px;">
            <div class="summary-attendance-muster col-md-3">
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
                        @foreach($Employees as $emp)
                          <tr>
                             
                                <td>{{ucfirst($emp->first_name)}}&nbsp;{{ucfirst($emp->last_name)}}<br/>#{{ $emp->emp_id }}</td>
                               @foreach($DistinctDatesMapCount as $empId=>$d1)
                                   @if($empId ==$emp->emp_id)
                                     
                                      <td>{{$d1['date_count']}}</td>
                                     
                                   @endif
 
                                 
                               @endforeach
                               
                          </tr>
                         @endforeach
                        <!-- Add more rows as needed -->
                     </tbody>
                   
                </table>
            </div>
            <div class="Attendance-attendance-muster col-md-9" >
                <p style="background:#ebf5ff; padding:5px 15px;font-size:0.755rem;">Attendance</p>
                <table class="table">
                @php
                    // Get current month and year
                    $currentMonth =12;
                   
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
                                <div style="font-size:0.825rem;line-height:0.8;font-weight:500;">{{ $i }}</div>
                                <div style="margin-top:-5px; font-size:0.625rem;margin-top:1px;">{{ $dayName }}</div>
                            </th>
 
                        @endfor
                    </tr>
                </thead>
             
                    <tbody>
                        <!-- Add table rows and data for Attendance -->
                       
                        @while ($EmployeesCount > 0)
                        @foreach($Employees as $e)
                           
                         
                        <tr style="height:64px;background-color:pink;">
                         
                           @for ($i = 1; $i <= $daysInMonth; $i++)
                           @php
                                $timestamp = mktime(0, 0, 0, $currentMonth, $i, $currentYear);
                                $dayName = date('D', $timestamp); // Get the abbreviated day name (e.g., Sun, Mon)
                                $fullDate = date('Y-m-d', $timestamp);
                                 // Full date in 'YYYY-MM-DD' format
                           @endphp
                       
                          <td >
                         
                          @foreach ($DistinctDatesMap  as $empId => $distinctDates)
                            @if($empId==$e->emp_id)
                            @php
                             
                               foreach ($distinctDates as $distinctDate) {
                            // Extract date part from created_at and distinctDate
                             print($distinctDate);
                               $createdAtDate = date('Y-m-d', strtotime($e->created_at));
                               
               
                            // Your logic for each distinct date
                              if ($distinctDate === $fullDate) {
                                $present=1;
                               
                              }
                            }
                            @endphp
                           @endif  
                          @endforeach
                                  @if ($dayName === 'Sat' || $dayName === 'Sun')
                                    <p style="color:#666;font-weight:500;">O</p>
                                  @elseif ($Holiday->contains('date',$createdAtDate))
                                    <p style="color: #666; font-weight: 500;">H</p>
                                       
                                  @elseif($present==1)
                                    <p style=" color:#666;font-weight:500;">P</p>
                               
                                 
                                  @else
                                    <p style=" color: #f66;font-weight:500;">A</p>    
                                  @endif
                        </td>
                           
                          @php
                             $present=0;
                          @endphp  
                         @endfor
                         @php
                             $EmployeesCount--;
                           
                         @endphp
                       
                       
                       
                       </tr>
                       @endforeach
                       @endwhile
                       
                    </tbody>
                </table>
            </div>
        </div>
 
    </div>
</div>