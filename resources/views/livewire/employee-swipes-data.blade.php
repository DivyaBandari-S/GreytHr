<div>
    <div class="position-absolute" wire:loading wire:target="updateDate,downloadFileforSwipes">
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

        .custom-radio-class {
            vertical-align: middle;
            margin-bottom: 12px;
        }

        .history-button {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }
        .sidebar {
        position: fixed;
        top: 0;
        right: -350px; /* Initially hidden */
        width: 350px;
        height: 100%;
        background: white;
        box-shadow: -2px 0 5px rgba(0,0,0,0.2);
        transition: right 0.3s ease-in-out;
        padding: 20px;
        z-index: 1050;
        border-radius: 10px 0 0 10px;
    }

    .sidebar.active {
        right: 0;
    }

    .sidebar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: bold;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
    }

    .sidebar-content {
        margin-top: 15px;
    }

    label {
        display: block;
        font-size: 14px;
        margin-bottom: 5px;
        color: #333;
    }

    .custom-dropdown {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    .button-container {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .apply-btn {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    .reset-btn {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1049;
    }
    .button-container {
        display: flex;
        justify-content: center; /* Centers buttons horizontally */
        align-items: center; /* Aligns buttons vertically */
        gap: 5px; /* Reduces the space between buttons */
        margin-top: 20px; /* Adds spacing from elements above */
    }

    .apply-btn, .reset-btn {
        padding: 8px 15px;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        border: none;
    }

    .apply-btn {
        background-color: #007bff;
        color: white;
    }

    .reset-btn {
        background-color: #6c757d;
        color: white;
    }
    .category-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 6px; /* Reduce vertical gap */
        color: #333;
    }

    .custom-dropdown {
        width: 100%;
        padding: 6px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        margin-top: 0;
    }

    .apply-btn, .reset-btn {
        padding: 8px 15px;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        border: none;
    }

    .apply-btn {
        background-color: rgb(2, 17, 79);
        color: white;
    }

    .reset-btn {
        border:1px solid rgb(2, 17, 79);
        color: rgb(2, 17, 79);
        background-color: #fff;

    }
    </style>

    <body>
        <div>
            <div class="employee-swipes-fields d-flex align-items-center">
                <div class="dropdown-container1-employee-swipes">
                    <label for="start_date" style="color: #666;font-size:12px;">Select Date<span
                            style="color: red;">*</span>:</label><br />
                    <input type="date" style="font-size: 12px;" id="start_date" wire:model="startDate"
                        wire:change="updateDate" max="{{ now()->toDateString() }}">

                </div>




                <div class="dropdown-container1-employee-swipes-for-search-employee">
                    <label for="dateType" style="color: #666;font-size:12px;">Employee Search:</label><br />

                    <div class="search-input-employee-swipes">
                        <div class="search-container" style="position: relative;margin-top:-25px;">
                            <i class="fa fa-search search-icon-employee-swipes" aria-hidden="true"
                                style="cursor:pointer;" wire:click="searchEmployee"></i>
                            <input wire:model="search" type="text" placeholder="Search Employee" class="search-text">

                        </div>

                    </div>
                </div>
                <div class="dropdown-container1-employee-swipes-for-download-and-filter d-flex">
                    <div class="dropdown-container1-employee-swipes">

                        <button type="btn" class="button2" data-toggle="modal"
                            data-target="#exampleModalCenter"style="padding:5px;border-radius:5px;">
                            <i class="fa-solid fa-download" wire:click="downloadFileforSwipes"></i>
                        </button>

                    </div>
                    <div class="dropdown-container1-employee-swipes">

                                                    <!-- Filter Button -->
                                <button type="button" class="button2"
                                    style="margin-top:30px; border-radius:5px; padding:5px;">
                                    <i class="fa-icon fas fa-filter"wire:click="toggleSidebar"style="color:#666"></i>
                                </button>

                                <!-- Overlay -->
                                @if ($isOpen)
                                    <div class="overlay" wire:click="closeSidebar"></div>
                                @endif

                                <!-- Sidebar -->
                                <div class="sidebar {{ $isOpen ? 'active' : '' }}">
                                    <div class="sidebar-header">
                                        <h6>Apply Filter</h6>
                                        <button wire:click="closeSidebar" class="filter-close-btn">×</button>
                                    </div>

                                    <!-- Filter Section -->
                                    <div class="sidebar-content">
                                            <label for="designation" class="designation-label">Designation:</label>
                                            <select wire:model="selectedDesignation" wire:change="updateselectedDesignation" class="custom-dropdown">
                                                <option value="">All</option>
                                                <option value="software_engineer">Software Engineer</option>
                                                <option value="senior_software_engineer">Sr. Software Engineer</option>
                                                <option value="team_lead">Team Lead</option>
                                                <option value="sales_head">Sales Head</option>
                                            </select>
                                            <label for="department" class="department-label">Department:</label>
                                            <select wire:model="selectedDepartment" wire:change="updateselectedDepartment" class="custom-dropdown">
                                                <option value="">All</option>
                                                <option value="information_technology">Information Techonology</option>
                                                <option value="business_development">Business Development</option>
                                                <option value="operations">Operations</option>
                                                <option value="innovation">Innovation</option>
                                                <option value="infrastructure">Infrastructure</option>
                                                <option value="human_resources">Human Resource</option>
                                            </select>

                                            <label for="location" class="location-label">Location:</label>
                                            @if($isPending==1&&$defaultApply==0)
                                            <select wire:model="selectedLocation" wire:change="updateselectedLocation" class="custom-dropdown">
                                                <option value="Hyderabad">Hyderabad</option>
                                                <option value="Udaipur">Udaipur</option>
                                                <option value="Mumbai">Mumbai</option>
                                                <option value="Remote">Remote</option>
                                            </select>
                                            @endif
                                            @if($isApply==1&&$defaultApply==1)
                                            @livewire('location-finder')
                                            <select wire:model="selectedLocation" wire:change="updateselectedLocation" class="custom-dropdown">
                                                <option value="{{ $city }}"> {{ $city }}</option>

                                            </select>
                                            @endif
                                            <label for="swipe_status" class="swipe-status-label">Swipe Status:</label>
                                            <select wire:model="selectedSwipeStatus" wire:change="updateselectedSwipeStatus" class="custom-dropdown">
                                               @if($isPending==1&&$defaultApply==0)

                                                <option value="All">All</option>
                                                <option value="mobile_sign_in">Mobile Sign In</option>
                                                <option value="web_sign_in">Web Sign In</option>
                                              @endif
                                                @if($isApply == 1 && $defaultApply == 1)
                                                   <option value="door">Door Sign In</option>
                                                @endif
                                            </select>
                                    </div>
                                    <div class="button-container">
                                            <button wire:click="applyFilter" class="apply-btn">Apply</button>
                                            <button wire:click="resetSidebar" class="reset-btn">Reset</button>
                                    </div>
                                </div>

                    </div>
                    <div class="button-container-for-employee-swipes">
                        <button class="my-button apply-button"
                            style="background-color:{{ $isApply == 1 && $defaultApply == 1 ? 'rgb(2,17,79)' : '#fff' }};color: {{ $isApply == 1 && $defaultApply == 1 ? '#fff' : 'initial' }};"
                            wire:click="viewDoorSwipeButton"><span style="font-size:10px;">View Door Swipe
                                Data</span></button>
                        <button class="my-button history-button"
                            style="background-color:{{ $isPending == 1 && $defaultApply == 0 ? 'rgb(2,17,79)' : '#fff' }};color: {{ $isPending == 1 && $defaultApply == 0 ? '#fff' : 'initial' }};"
                            wire:click="viewWebsignInButton"><span style="font-size:10px;">View Web Sign-In
                                Data</span></button>
                    </div>
                </div>
            </div>

            <div class="row m-0 p-0  mt-4">
                <div class="col-md-9 mb-4">
                    <div class="bg-white border rounded">
                        <div class="table-responsive bg-white rounded p-0 m-0" style="max-height: 500px;">
                            <table class="employee-swipes-table  bg-white" style="width: 100%;padding-right:10px;">
                                <thead style="position: sticky;top: 0px;">
                                    <tr>
                                        <th>Employee&nbsp;Name</th>
                                        <th>Swipe&nbsp;Time&nbsp;&&nbsp;Date</th>
                                        <th>Shift</th>
                                        <th>In/Out</th>
                                        <th>Received&nbsp;On</th>
                                        <th>Door/Address</th>
                                        @if($isPending == 1 && $defaultApply == 0)
                                        <th style="white-space:nowrap;">Swipe Location</th>
                                        <th style="white-space:nowrap;">Swipe Remarks</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>

                                    @if ($isApply == 1 && $defaultApply == 1)

                                        @if (count($SignedInEmployees) > 0)
                                            @foreach ($SignedInEmployees as $swipe)
                                                @foreach ($swipe['swipe_log'] as $index => $log)
                                                    <tr>
                                                        <td class="employee-swipes-name-and-id">
                                                            <input type="radio" name="selectedEmployee"
                                                                value="{{ $swipe['employee']->emp_id }}-{{ $loop->index }}-{{ \Carbon\Carbon::parse($log->logDate)->format('H:i:s') }}"
                                                                class="radio-button custom-radio-class"wire:model="selectedEmployeeId"
                                                                wire:change="handleEmployeeSelection" />
                                                            <span
                                                                style="width:100px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="{{ ucwords(strtolower($swipe['employee']->first_name)) }} {{ ucwords(strtolower($swipe['employee']->last_name)) }}">
                                                                {{ ucwords(strtolower($swipe['employee']->first_name)) }}
                                                                {{ ucwords(strtolower($swipe['employee']->last_name)) }}
                                                            </span>
                                                            <br />
                                                            <span
                                                                class="text-muted employee-swipes-emp-id">#{{ $swipe['employee']->emp_id }}</span>
                                                        </td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($log->logDate)->format('H:i:s') }}<br />
                                                            <span class="text-muted employee-swipes-swipe-date">
                                                                {{ \Carbon\Carbon::parse($log->logDate)->format('jS F Y') }}
                                                            </span>
                                                        </td>
                                                        <td style="white-space:nowrap;">
                                                            {{ \Carbon\Carbon::parse($swipe['employee']->shift_start_time)->format('H:i a') }}
                                                            to
                                                            {{ \Carbon\Carbon::parse($swipe['employee']->shift_end_time)->format('H:i a') }}
                                                        </td>
                                                        <td style="text-transform:uppercase;">{{ $log->Direction }}
                                                        </td>
                                                        <td> {{ \Carbon\Carbon::parse($log->logDate)->format('H:i:s') }}<br />
                                                            <span
                                                                class="text-muted employee-swipes-swipe-date"style="white-space:nowrap;">
                                                                {{ \Carbon\Carbon::parse($log->logDate)->format('jS F Y') }}</span>
                                                        </td>
                                                        <td style="white-space:nowrap;">
                                                            @if ($log->Direction === 'in')
                                                                Door Swipe In
                                                            @else
                                                                Door Swipe Out
                                                            @endif
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="12" class="text-center">Employee Swipe Data Not found
                                                </td>
                                            </tr>
                                        @endif
                                    @elseif($isPending == 1 && $defaultApply == 0)
                                        @if (count($SignedInEmployees))
                                            @foreach ($SignedInEmployees as $swipe)
                                                @foreach ($swipe['swipe_log'] as $index => $log)
                                                    <tr>
                                                        <td class="employee-swipes-name-and-id">
                                                            <input type="radio" name="selectedEmployee"
                                                                value="{{ $swipe['employee']->emp_id }}-{{ $loop->index }}-{{ $log->swipe_time }}-{{ $log->in_or_out }}"
                                                                class="radio-button custom-radio-class"wire:model="selectedWebEmployeeId"
                                                                wire:change="handleEmployeeWebSelection" />
                                                            <span
                                                                style="width:100px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="{{ ucwords(strtolower($swipe['employee']->first_name)) }} {{ ucwords(strtolower($swipe['employee']->last_name)) }}">
                                                                {{ ucwords(strtolower($swipe['employee']->first_name)) }}
                                                                {{ ucwords(strtolower($swipe['employee']->last_name)) }}
                                                            </span>
                                                            <br />
                                                            <span
                                                                class="text-muted employee-swipes-emp-id">#{{ $swipe['employee']->emp_id }}</span>
                                                        </td>

                                                        <!-- Swipe Log Details -->
                                                        <td>
                                                            {{ $log->swipe_time }}<br />
                                                            <span class="text-muted employee-swipes-swipe-date">
                                                                {{ \Carbon\Carbon::parse($log->created_at)->format('jS F, Y') }}
                                                            </span>

                                                        </td>

                                                        <!-- Shift Details -->
                                                        <td style="white-space:nowrap;">
                                                            {{ \Carbon\Carbon::parse($swipe['employee']->shift_start_time)->format('H:i a') }}
                                                            to
                                                            {{ \Carbon\Carbon::parse($swipe['employee']->shift_end_time)->format('H:i a') }}
                                                        </td>

                                                        <!-- Sign In/Out Type -->
                                                        <td>
                                                            @if ($log->in_or_out === 'IN')
                                                                IN
                                                            @else
                                                                OUT
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $log->swipe_time }}<br />
                                                            <span class="text-muted employee-swipes-swipe-date">
                                                                {{ \Carbon\Carbon::parse($log->created_at)->format('jS F, Y') }}
                                                            </span>

                                                        </td>
                                                        <td style="white-space:nowrap;">
                                                                           @if ($log->in_or_out === 'IN' && ($log->sign_in_device==='Laptop/Desktop'||$log->sign_in_device==='Laptop'))
                                                                                Web Sign In
                                                                            @elseif ($log->in_or_out === 'IN' && $log->sign_in_device==='Mobile')
                                                                                Mobile Sign In
                                                                            @elseif ($log->in_or_out === 'OUT' && ($log->sign_in_device==='Laptop/Desktop'||$log->sign_in_device==='Laptop'))
                                                                                Web Sign Out
                                                                            @elseif ($log->in_or_out === 'OUT' && $log->sign_in_device==='Mobile')
                                                                                Mobile Sign Out
                                                                            @elseif ($log->in_or_out === 'IN')
                                                                                Web Sign In
                                                                            @elseif ($log->in_or_out === 'OUT')
                                                                                Web Sign Out
                                                                            @endif
                                                        </td>
                                                        <td class="text-center"style="white-space:nowrap;">
                                                            @if(!empty($log->swipe_location))
                                                               {{ ucwords(strtolower(preg_replace('/[^A-Za-z0-9]/', ' ', $log->swipe_location))) }}
                                                            @else
                                                                 NA
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if(!empty($log->swipe_remarks))
                                                               {{ $log->swipe_remarks }}
                                                            @else
                                                                 NA
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="12"class="text-center">Employee Swipe Record Not found
                                                </td>
                                            </tr>
                                        @endif


                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div
                    class="green-and-white-section-for-employee-swipes col-md-3 p-0 bg-white rounded border"style="margin-left:-8px;">

                    <div class="green-section-employee-swipes p-2">
                        <img src="https://cdn-icons-png.flaticon.com/512/2055/2055568.png"
                            class="container-employee-swipes-right-image">
                        <h6>Swipe-in Time</h6>
                        @if ($swipeTime)
                            <p>{{ $swipeTime }}</p>
                        @elseif($doorSwipeTime)
                            <p>{{ $doorSwipeTime }}</p>
                        @else
                            <p>Not Swiped Yet</p>
                        @endif

                    </div>
                    <h2 class="swipe-details-who-is-in p-2">Swipe Details</h2>
                    <hr class="swipe-details-who-is-in-horizontal-row">
                    <div class="p-2">
                        <p class="swipe-deatils-title">Device Name</p>
                        <p class="swipe-details-description">
                            @if (!empty($webDeviceName))
                                {{ $webDeviceName }}
                            @else
                                -
                            @endif
                        </p>
                        <p class="swipe-deatils-title">Access Card</p>
                        <p class="swipe-details-description">
                            @if (!empty($accessCardDetails))
                                {{ $accessCardDetails }}
                            @else
                                -
                            @endif
                        </p>
                        <p class="swipe-deatils-title">Door/Address</p>

                        <p class="swipe-details-description">-</p>

                        <p class="swipe-deatils-title">Remarks</p>
                        <p class="swipe-details-description">-</p>
                        <p class="swipe-deatils-title">Device ID</p>
                        <p class="swipe-details-description-for-device-id"title="{{ !empty($deviceId) ? $deviceId : (!empty($webDeviceId) ? $webDeviceId : '-') }}">
                            @if (!empty($deviceId))
                                {{ $deviceId }}
                            @elseif(!empty($webDeviceId))
                                {{ $webDeviceId }}
                            @else
                                -
                            @endif
                        </p>
                        <p class="swipe-deatils-title">Location Details</p>
                        <p class="swipe-details-description">-</p>

                    </div>
                </div>
            </div>

        </div>


    </body>
</div>
