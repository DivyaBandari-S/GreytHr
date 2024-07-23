<div>
<body>
<div>
    <div style="display:flex;flex-direction:row;">
    <div class="dropdown-container1-employee-swipes">
        <label for="start_date"style="color: #666;font-size:12px;">Start Date<span style="color: red;">*</span>:</label><br/>
        <input type="date"style="font-size: 12px;" id="start_date" wire:model="startDate"wire:change="checkDates">
    </div>
    <div class="dropdown-container1-employee-swipes">
        <label for="end_date"style="color: #666;font-size:12px;">End Date<span style="color: red;">*</span>:</label><br/>
        <input type="date" style="font-size: 12px;"id="end_date" wire:model="endDate"wire:change="checkDates">
          
    </div>
     <div class="dropdown-container1-employee-swipes">
          <label for="dateType"style="color: #666;font-size:12px;">Date Type<span style="color: red;">*</span>:</label><br/>
          <button class="dropdown-btn1"style="font-size: 12px;">Swipe Date</button>
          <div class="dropdown-content1-employee-swipes">

          </div>
     </div>

     <div class="dropdown-container1-employee-swipes">
             <label for="dateType"style="color: #666;font-size:12px;">Employee Search</label><br/>
          
             <div class="search-input-employee-swipes">
             <div class="search-container"style="position: relative;">
                       <i class="fa fa-search search-icon-employee-swipes" aria-hidden="true"style="cursor:pointer;"wire:click="testMethod"></i>
                       <input wire:model="search" type="text" placeholder="Search Employee" class="search-text">

              </div>
                   
             </div>
    </div>
    <div class="dropdown-container1-employee-swipes">

        <button type="button" class="button2" data-toggle="modal" data-target="#exampleModalCenter"style="margin-top:30px;border-radius:2px;">
             <i class="fa-solid fa-download"wire:click="downloadFileforSwipes"></i>
        </button>
           
    </div>
    <div class="dropdown-container1-employee-swipes">

            <button type="button" class="button2" data-toggle="modal" data-target="#exampleModalCenter"style="margin-top:30px;border-radius:2px;">
                 <i class="fa-icon fas fa-filter"style="color:#666"></i>
            </button>
               
        </div>  
      
</div>

    <div class="row m-0 p-0  mt-4" >
        <div class="col-md-9 mb-4" >
           <div class="bg-white border rounded" style="height: 100vh;">
             <div class="table-responsive bg-white rounded p-0 m-0" style="width:100%;">
                <table class="employee-swipes-table  bg-white " >
                    <thead>
                        <tr>
                            <th>Employee&nbsp;Name</th>
                            <th>Swipe&nbsp;Time&nbsp;&&nbsp;Date</th>
                            <th>Shift</th>
                            <th>In/Out</th>
                            <th>Received&nbsp;On</th>
                            <th>Door/Address</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <div>
                    <tbody>
                    @if($notFound)
                         <td colspan="12" class="record-not-found-who-is-in">Record not found</td>
                    @else
    <!-- Display the filtered collection or any other content -->
                        @foreach($SignedInEmployees as $swipe)
        <!-- Display swipe details -->
   
                       <tr class="employee-swipes-table-container">
                              <td  class="employee-swipes-name-and-id">
                              <input type="checkbox" name="employeeCheckbox[]" class="employee-swipes-checkbox" value="{{ $swipe->swipe_time }}"wire:model="selectedSwipeTime"wire:change="updateselectedSwipeTime('{{$swipe->swipe_time}}')">
                                        <span style="width:100px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ ucwords(strtolower($swipe->first_name)) }} {{ ucwords(strtolower($swipe->last_name)) }}">
                                            {{ ucwords(strtolower($swipe->first_name)) }} {{ ucwords(strtolower($swipe->last_name)) }}
                                        </span>

                                            <br />
                                        <span class="text-muted employee-swipes-emp-id">#{{$swipe->emp_id}}</span>
                              </td>
                              <td class="employee-swipes-swipe-details-for-signed-employees">{{$swipe->swipe_time}}<br /> <span class="text-muted employee-swipes-swipe-date">{{ \Carbon\Carbon::parse($swipe->created_at)->format('d M, Y') }}</span></td>
                              @php
                                        $EmployeeStartshiftTime=$swipe->shift_start_time;
                                        $EmployeeEndshiftTime=$swipe->shift_end_time;
                                        // Create DateTime objects
                                        $startShiftTime = new DateTime($EmployeeStartshiftTime);
                                        $endShiftTime = new DateTime($EmployeeEndshiftTime);
                                        // Format the times
                                        $formattedStartShiftTime = $startShiftTime->format('H:i a');
                                        $formattedEndShiftTime = $endShiftTime->format('H:i a');
                                    @endphp
                              <td class="employee-swipes-swipe-details-for-signed-employees">{{$formattedStartShiftTime}} to {{$formattedEndShiftTime}}</td>
                              <td class="employee-swipes-swipe-details-for-signed-employees">{{$swipe->in_or_out}}</td>
                              <td class="employee-swipes-swipe-details-for-signed-employees">{{$swipe->swipe_time}}<br /><span class="text-muted employee-swipes-swipe-date"> {{ \Carbon\Carbon::parse($swipe->created_at)->format('d M, Y') }}</span></td>
                              <td class="empty-text">-</td>
                              <td class="empty-text">-</td>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            @if($searchtest == 1)
            <div class="table-responsive bg-white rounded p-0 m-0" style="width:100%;">
                <table class="employee-swipes-table bg-white ">
                    <thead>
                        <tr>
                            <th>Employee&nbsp;Name</th>
                            <th>Swipe&nbsp;Time&nbsp;&&nbsp;Date</th>
                            <th>Shift</th>
                            <th>In/Out</th>
                            <th>Received&nbsp;On</th>
                            <th>Door/Address</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <div>
                    <tbody>
                    @if($notFound)
                         <td colspan="12" class="record-not-found-who-is-in">Record not found</td>
                    @else
                    <!-- Display the filtered collection or any other content -->
                        @foreach($SWIPES as $swipe)
                     <!-- Display swipe details -->
                       <tr class="employee-swipes-table-container">
                              <td  class="employee-swipes-name-and-id">
                                        <input type="checkbox" name="employeeCheckbox[]" class="employee-swipes-checkbox" value="{{ $swipe->emp_id }}">

                                        <span style="width:100px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ ucwords(strtolower($swipe->first_name)) }} {{ ucwords(strtolower($swipe->last_name)) }}">
                                            {{ ucwords(strtolower($swipe->first_name)) }} {{ ucwords(strtolower($swipe->last_name)) }}
                                        </span>

                                        <br />
                                               <span class="text-muted employee-swipes-emp-id">#{{$swipe->emp_id}}</span>
                              </td>
                              <td class="employee-swipes-swipe-details-for-signed-employees">{{$swipe->swipe_time}}<br /> <span class="text-muted employee-swipes-swipe-date">{{ \Carbon\Carbon::parse($swipe->created_at)->format('d M, Y') }}</span></td>
                              <td class="employee-swipes-swipe-details-for-signed-employees">{{$swipe->shift_start_time}} to {{$swipe->shift_end_time}}</td>
                              <td class="employee-swipes-swipe-details-for-signed-employees">{{$swipe->in_or_out}}</td>
                              <td class="employee-swipes-swipe-details-for-signed-employees">{{$swipe->swipe_time}}<br /><span class="text-muted employee-swipes-swipe-date"> {{ \Carbon\Carbon::parse($swipe->created_at)->format('d M, Y') }}</span></td>
                              <td class="empty-text">-</td>
                              <td class="empty-text">-</td>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            @endif
           </div>
        </div>
        <div class="col-md-3 m-0 p-0 bg-white rounded border " style="height: 100vh;">
                <div class="green-section-employee-swipes p-2">
                 <img src="https://cdn-icons-png.flaticon.com/512/2055/2055568.png"
                            class="container-employee-swipes-right-image">
                     <h6>Swipe-in Time</h6>
                     @if($selectedSwipeTime)
                        <p>{{$selectedSwipeTime}}</p>
                     @elseif($SwipeTime)
                        <p>{{$SwipeTime}}</p>
                     @else
                        <p>Not Swiped Yet</p>
                     @endif
                </div>
                <h2 class="swipe-details-who-is-in p-2">Swipe Details</h2>
                <hr class="swipe-details-who-is-in-horizontal-row">
                <div class="p-2">
                <p class="swipe-deatils-title">Device Name</p>
                <p class="swipe-details-description">{{$this->status}}</p>
                <p class="swipe-deatils-title">Access Card</p>
                <p class="swipe-details-description">-</p>
                <p class="swipe-deatils-title">Door/Address</p>

                  <p class="swipe-details-description">-</p>

                <p class="swipe-deatils-title">Remarks</p>
                <p class="swipe-details-description">-</p>
                <p class="swipe-deatils-title">Device ID</p>
                <p class="swipe-details-description">-</p>
                <p class="swipe-deatils-title">Location Details</p>
                <p class="swipe-details-description">-</p>

                </div>
        </div>
    </div>

    </div>
    <script>
     jQuery(document).ready(function($) {

       $(function() {
           $('input[name="daterange"]').daterangepicker({
                                     opens: 'left'
                              }, function(start, end, label) {

                          console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });

    });
    </script>

</body>
</div>