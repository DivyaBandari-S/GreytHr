<div>
<body>
<div>
    <div style="display:flex;flex-direction:row;">
    <div class="dropdown-container1-employee-swipes">
        <label for="start_date"style="color: #666;font-size:13px;">Start Date<span style="color: red;">*</span>:</label><br/>
        <input type="date"style="font-size: 13px;" id="start_date" wire:model="startDate"wire:change="checkDates">
    </div>
    <div class="dropdown-container1-employee-swipes">
        <label for="end_date"style="color: #666;font-size:13px;">End Date<span style="color: red;">*</span>:</label><br/>
        <input type="date" style="font-size: 13px;"id="end_date" wire:model="endDate"wire:change="checkDates">
          
    </div>
     <div class="dropdown-container1-employee-swipes">
          <label for="dateType"style="color: #666;font-size:13px;">Date Type<span style="color: red;">*</span>:</label><br/>
          <button class="dropdown-btn1"style="font-size: 13px;">Swipe Date</button>
          <div class="dropdown-content1-employee-swipes">

          </div>
     </div>

     <div class="dropdown-container1-employee-swipes">
             <label for="dateType"style="color: #666;font-size:13px;">Employee Search</label><br/>
          
             <div class="search-input-employee-swipes"style="margin-top:-1px;">
             <div class="search-container"style="position: relative;">
                       <i class="fa fa-search search-icon-employee-swipes" aria-hidden="true"style="cursor:pointer;"wire:click="testMethod"></i>
                       <input wire:model="search" type="text" placeholder="Search Employee" class="search-text">
                      
              </div>
                   
             </div>
    </div>
    <div class="dropdown-container1-employee-swipes">

        <button type="button" class="button2" data-toggle="modal" data-target="#exampleModalCenter"style="margin-top:24px;border-radius:2px;">
             <i class="fa-solid fa-download"wire:click="downloadFileforSwipes"></i>
        </button>
           
    </div>
    <div class="dropdown-container1-employee-swipes">

            <button type="button" class="button2" data-toggle="modal" data-target="#exampleModalCenter"style="margin-top:24px;border-radius:2px;">
                 <i class="fa-icon fas fa-filter"style="color:#666"></i>
            </button>
               
        </div>  
      
</div>

    <div class="container-employee-swipes">
        
        <div class="container4-employee-swipes">
            <div>
                <table class="employee-swipes-table">
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
                                        <input type="checkbox" name="employeeCheckbox[]" class="employee-swipes-checkbox" value="{{ $swipe->emp_id }}">

                                        {{ ucwords(strtolower($swipe->first_name)) }} {{ ucwords(strtolower($swipe->last_name)) }}<br />
                                               <span class="text-muted employee-swipes-emp-id">#{{$swipe->emp_id}}</span>
                              </td>
                              <td class="employee-swipes-swipe-details-for-signed-employees">{{$swipe->swipe_time}}<br /> <span class="text-muted employee-swipes-swipe-date">{{ \Carbon\Carbon::parse($swipe->created_at)->format('d M, Y') }}</span></td>
                              <td class="employee-swipes-swipe-details-for-signed-employees">10:00 am to 07:00...</td>
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
        </div>
        <div class="container-employee-swipes-right">
                <div class="green-section-employee-swipes">
                    
                <img src="https://cdn-icons-png.flaticon.com/512/2055/2055568.png"
                            class="container-employee-swipes-right-image">
                     <h6>Swipe-in Time</h6>
                     @if($SwipeTime)
                        <h1>{{$SwipeTime}}</h1>
                     @else
                        <h1>Not Swiped Yet</h1>
                     @endif
                </div>
                <h2 class="swipe-details-who-is-in">Swipe Details</h2>
                <hr class="swipe-details-who-is-in-horizontal-row">
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