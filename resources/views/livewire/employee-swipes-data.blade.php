<div>
<div class="position-absolute" wire:loading
        wire:target="updateDate,downloadFileforSwipes">
        <div class="loader-overlay">
            <div class="loader">
                <div></div>
            </div>
        </div>
    </div>
<style>
    .my-button {
            margin: 0px;
            font-size: 0.8rem;
            background-color: #FFFFFF;
            border: 1px solid #a3b2c7;
            /* font-size: 20px;
        height: 50px; */
            padding: 8px 30px;
        }
 .my-button.active-button {
            background-color: rgb(2, 17, 79);
            color: #FFFFFF;
            border-color: rgb(2, 17, 79);
        }
 .my-button.active-button:hover {
            background-color: rgb(2, 17, 79);
            color: #FFFFFF;
            border-color: rgb(2, 17, 79);
        }
        .apply-button {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
            transition: border-color 0.3s, color 0.3s;
            /* Smooth transition effect */
        }

        .apply-button:hover {
            border-color: rgb(2, 17, 79);
            /* Change the border color to green on hover */
            color: rgb(2, 17, 79);
            /* Change the text color to green on hover */
        }
.apply-button:active {
            background-color: rgb(2, 17, 79);
            /* Change background color to green when clicked */
            color: #FFFFFF;
            border-color: rgb(2, 17, 79);
            /* Change text color to white when clicked */
        }
        .pending-button:hover {
            border-color: rgb(2, 17, 79);
            /* Change the border color to green on hover */
            color: rgb(2, 17, 79);
            /* Change the text color to green on hover */
        }
.pending-button:active {
            background-color: rgb(2, 17, 79);
            /* Change background color to green when clicked */
            color: #FFFFFF;
            border-color: rgb(2, 17, 79);
            /* Change text color to white when clicked */
        }
        
</style>
    <body>
        <div>
            <div class="employee-swipes-fields d-flex align-items-center">
                <div class="dropdown-container1-employee-swipes">
                    <label for="start_date" style="color: #666;font-size:12px;">Select Date<span style="color: red;">*</span>:</label><br />
                    <input type="date" style="font-size: 12px;" id="start_date" wire:model="startDate" wire:change="updateDate"  max="{{ now()->toDateString() }}">
                      
                </div>
                <!-- <div class="dropdown-container1-employee-swipes">
                        <label for="end_date" style="color: #666;font-size:12px;">End Date<span style="color: red;">*</span>:</label><br />
                       <input type="date" style="font-size: 12px;" id="end_date" wire:model="endDate" wire:change="checkDates">
                </div> -->
                <div class="dropdown-container1-employee-swipes-for-date-type">
                    <label for="dateType" style="color: #666;font-size:12px;">Date Type<span style="color: red;">*</span>:</label><br />
                    <button class="dropdown-btn1" style="font-size: 12px;">Swipe Date</button>
                    <div class="dropdown-content1-employee-swipes">

                    </div>
                </div>
                <div class="dropdown-container1-employee-swipes-for-search-employee">
                    <label for="dateType" style="color: #666;font-size:12px;">Employee Search</label><br />

                    <div class="search-input-employee-swipes">
                        <div class="search-container" style="position: relative;">
                            <i class="fa fa-search search-icon-employee-swipes" aria-hidden="true" style="cursor:pointer;" wire:click="searchEmployee"></i>
                            <input wire:model="search" type="text" placeholder="Search Employee" class="search-text">

                        </div>

                    </div>
                </div>
                <div class="dropdown-container1-employee-swipes-for-download-and-filter d-flex">
                    <div class="dropdown-container1-employee-swipes">

                        <button type="btn" class="button2" data-toggle="modal" data-target="#exampleModalCenter">
                            <i class="fa-solid fa-download" wire:click="downloadFileforSwipes"></i>
                        </button>

                    </div>
                    <div class="dropdown-container1-employee-swipes">

                        <button type="button" class="button2" data-toggle="modal" data-target="#exampleModalCenter" style="margin-top:30px;border-radius:2px;">
                            <i class="fa-icon fas fa-filter" style="color:#666"></i>
                        </button>

                    </div>
                    <div class="button-container-for-employee-swipes">
                        <button class="my-button apply-button" style="background-color:{{ ($isApply == 1 && $defaultApply == 1) ? 'rgb(2,17,79)' : '#fff' }};color: {{ ($isApply == 1 && $defaultApply == 1) ? '#fff' : 'initial' }};" wire:click="viewDoorSwipeButton"><span style="font-size:10px;">View Door Swipe Data</span></button>
                        <button class="my-button pending-button" style="background-color:{{ ($isPending==1&&$defaultApply==0) ? 'rgb(2,17,79)' : '#fff' }};color: {{ ($isPending==1&&$defaultApply==0) ? '#fff' : 'initial' }};" wire:click="viewWebsignInButton"><span style="font-size:10px;">View Web Sign-In Data</span></button>
                    </div>
                </div>
            </div>

    <div class="row m-0 p-0  mt-4" >
        <div class="col-md-9 mb-4" >
           <div class="bg-white border rounded">
             <div class="table-responsive bg-white rounded p-0 m-0">
                <table class="employee-swipes-table  bg-white" style="width: 100%;padding-right:10px;">
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
                                     @if($isApply==1&&$defaultApply==1)
                                         @if(count($SignedInEmployees))
                                            @foreach($SignedInEmployees as $swipe)
                                                  @foreach($swipe['swipe_log'] as $log)
                                                <tr class="employee-swipes-table-container">
                                                    <td class="employee-swipes-name-and-id">
                                                        <span style="width:100px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" data-toggle="tooltip"
                                                                data-placement="top" title="{{ ucwords(strtolower($swipe['employee']->first_name)) }} {{ ucwords(strtolower($swipe['employee']->last_name)) }}">
                                                                {{ ucwords(strtolower($swipe['employee']->first_name)) }} {{ ucwords(strtolower($swipe['employee']->last_name)) }}
                                                        </span>
                                                        <br />
                                                        <span class="text-muted employee-swipes-emp-id">#{{$swipe['employee']->emp_id}}</span>
                                                    </td> 
                                                    
                                                    <!-- Loop through each swipe log entry for the employee -->
                                                    
                                                        <td class="employee-swipes-swipe-details-for-signed-employees"> 
                                                            {{ \Carbon\Carbon::parse($log->logDate)->format('H:i:s') }}<br /> 
                                                            <span class="text-muted employee-swipes-swipe-date"> 
                                                                {{ \Carbon\Carbon::parse($log->logDate)->format('jS F Y') }}
                                                            </span>
                                                        </td>
                                                        <td class="employee-swipes-swipe-details-for-signed-employees">{{ \Carbon\Carbon::parse($swipe['employee']->shift_start_time)->format('H:i a') }} to {{ \Carbon\Carbon::parse($swipe['employee']->shift_end_time)->format('H:i a') }}</td>
                                                        <td class="employee-swipes-swipe-details-for-signed-employees" style="text-transform:uppercase;">{{$log->Direction}}</td> 
                                                        <td class="employee-swipes-swipe-details-for-signed-employees"> {{ \Carbon\Carbon::parse($log->logDate)->format('H:i:s') }}<br /> <span class="text-muted employee-swipes-swipe-date"> {{ \Carbon\Carbon::parse($log->logDate)->format('jS F Y') }}</span></td>
                                                        <td class="employee-swipes-swipe-details-for-signed-employees">
                                                            @if ($log->Direction === 'in')
                                                                Door Swipe In
                                                            @else
                                                                Door Swipe Out
                                                            @endif
                                                        </td> 
                                                    @endforeach
                                                  
                                                    
                                                </tr> 
                                            @endforeach
                                        @else
                                            <td colspan="12" class="text-center">Employee Swipe Data Not found</td>
                                        @endif
                                     @elseif($isPending==1&&$defaultApply==0)
                                        @if(count($SignedInEmployees))
                                            @foreach($SignedInEmployees as $swipe)
                                            @foreach($swipe['swipe_log'] as $index => $log)
                                                    <tr class="employee-swipes-table-container">
                                                        <!-- Employee Details -->
                                                        <td class="employee-swipes-name-and-id">
                                                            <span style="width:100px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" data-toggle="tooltip"
                                                                data-placement="top" title="{{ ucwords(strtolower($swipe['employee']->first_name)) }} {{ ucwords(strtolower($swipe['employee']->last_name)) }}">
                                                                {{ ucwords(strtolower($swipe['employee']->first_name)) }} {{ ucwords(strtolower($swipe['employee']->last_name)) }}
                                                            </span>
                                                            <br />
                                                            <span class="text-muted employee-swipes-emp-id">#{{ $swipe['employee']->emp_id }}</span>
                                                        </td>

                                                        <!-- Swipe Log Details -->
                                                        <td class="employee-swipes-swipe-details-for-signed-employees">
                                                             {{ $log->swipe_time }}<br />
                                                             <span class="text-muted employee-swipes-swipe-date">
                                                                {{ \Carbon\Carbon::parse($log->created_at)->format('jS F, Y') }}
                                                             </span>
                                                            
                                                        </td>

                                                        <!-- Shift Details -->
                                                        <td class="employee-swipes-swipe-details-for-signed-employees">
                                                            {{ \Carbon\Carbon::parse($swipe['employee']->shift_start_time)->format('H:i a') }} 
                                                            to 
                                                            {{ \Carbon\Carbon::parse($swipe['employee']->shift_end_time)->format('H:i a') }}
                                                        </td>

                                                        <!-- Sign In/Out Type -->
                                                        <td class="employee-swipes-swipe-details-for-signed-employees">
                                                            @if ($log->in_or_out === 'IN')
                                                                IN
                                                            @else
                                                                OUT
                                                            @endif
                                                        </td>
                                                        <td class="employee-swipes-swipe-details-for-signed-employees">
                                                             {{ $log->swipe_time }}<br />
                                                             <span class="text-muted employee-swipes-swipe-date">
                                                                {{ \Carbon\Carbon::parse($log->created_at)->format('jS F, Y') }}
                                                             </span>
                                                            
                                                        </td>
                                                        <td class="employee-swipes-swipe-details-for-signed-employees">
                                                                @if ($log->in_or_out === 'IN')
                                                                    Web Sign In
                                                                @elseif ($log->in_or_out === 'OUT')
                                                                    Web Sign Out
                                                                @endif
                                                        </td>
                                                    </tr>
                                                @endforeach  
                                            @endforeach 
                                        @else
                                           <td colspan="12"class="text-center">Employee Swipe Record Not found</td>
                                        @endif   
                                     @endif

                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="green-and-white-section-for-employee-swipes col-md-3 p-0 bg-white rounded border">
                    <div class="green-section-employee-swipes p-2">
                        <img src="https://cdn-icons-png.flaticon.com/512/2055/2055568.png"
                            class="container-employee-swipes-right-image">
                        <h6>Swipe-in Time</h6>
                        @if($swipeLogTime)
                        <p>{{$swipeLogTime}}</p>
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


    </body>
</div>
