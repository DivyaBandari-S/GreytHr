<div>

    <style>
        /* Add your custom styles here */
        body {
            font-family: 'Montserrat', sans-serif;
            overflow-y:hidden;
        }
        .container-leave {
            padding: 0;
            margin: 0;
        }
        .table thead{
            border:none;
        }
 
        .table th {
            text-align: center; /* Center days of the week */
            height: 15px;
            border: none;       
            /* Adjust the height of days of the week cells */
        }
 
        .table td:hover {
            background-color: #ecf7fe; /* Hover background color */
            cursor: pointer;
        }
 
        /* Add styles for the navigation buttons */
        .nav-btn {
            background: none;
            border: none;
            color:#778899;
            font-size:0.795rem;
            margin-top: -6px;
            cursor: pointer;
        }
 
        .nav-btn:hover {
            color: blue;
        }
 
        /* Increase the size of tbody cells and align text to top-left */
        .table tbody td {
            width: 75px;
            height: 80px;
            border-color:#c5cdd4;
            font-weight:500;
            font-size: 13px; /* Adjust font size as needed */
            vertical-align: top;
            position: relative;
            text-align: left;
        }
 
        /* Add style for the current date cell */
        .current-date {
            background-color: #ff0000; /* Highlight color for the current date */
            color: #fff; /* Text color for the current date */
            font-weight: bold;
        }
 
        .calendar-heading-container {
            background:#fff;
            padding:10px 10px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            /* Add spacing between heading and icons */
        }
        .calendar-heading-container h5{
           font-size:0.975rem;
           color:black;
           font-weight:500;
        }
 
        .table {
            overflow-x: hidden; /* Add horizontal scrolling if the table overflows the container */
        }
 
        .tol-calendar-legend {
            display: flex;
            font-size: 0.875rem;
            width: 100%;
            justify-content:space-between;
            font-weight: 500;
            color: #778899;
        }
 
        /* CSS for legend circles */
        .legend-circle {
            display: inline-block;
            width: 15px; /* Adjust the width as needed */
            height: 15px; /* Adjust the height as needed */
            border-radius: 50%;
            text-align: center;
            line-height: 15px; /* Vertically center the text */
            margin-right: 2px; /* Add some spacing between the circle and text */
            font-weight: bold; /* Make the text bold */
            color: white; /* Text color */
        }
 
        .circle-pale-yellow {
            background-color: #ffeb3b; /* Define the yellow color */
        }
 
        /* CSS for the pink circle */
        .circle-pale-pink {
            background-color: #d29be1; /* Define the pink color */
        }
        .accordion {
        border: 1px solid #ccc;
        border-radius:5px;
        width: 100%; /* Adjust the width as needed */
        top: 100px;
     overflow-x: auto;
        left:0;/* Adjust the top position as needed */
      /* Adjust the right position as needed */
      }
 
      .accordion-heading {
        background-color: #fff;
        cursor: pointer;
      }
 
      .accordion-body {
        background-color: #fff;
        padding:0;
        display: block;
        width: 100%; overflow: auto;
      }
 
      .accordion-content {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
      }
 
      .accordion-title {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
      }
 
      .active .leave-container {
        border-color: #3a9efd; /* Blue border when active */
      }
 
      .accordion-button {
        color: #DCDCDC;
        border: 1px solid #DCDCDC;
      }
 
      .active .accordion-button {
        color: #3a9efd;
        border: 1px solid #3a9efd;
      }
 
      @media (max-width: 760px) {
 
 
        .accordion {
          width: 65%;
          top: auto;
          right: auto;
          margin-top: 20px;
        }
      }
             /* Styles for the container */
  
 
        /* Styles for the button */
        .filter-button {
            padding: 3px;
            margin-bottom:15px;
            background-color: #fff;
            color: #778899;
            font-size:0.825rem;
            width:150px;
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
        }
        .filter-button:hover{
          border:1px solid #007bff;
        }
 

  
 
        /* Styles for dropdown items */
    
        .button-container{
          display:flex;
          padding:10px 15px;
          justify-content:space-between;
 
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

  
        .search-input-leave input[type="text"] {
            padding: 3px;
            outline:none;
            border: 1px solid #ccc;
            border-radius: 4px;
            color:#778899;
            width: 220px; /* Adjust width as needed */
        }
 
        /* Styles for the search icon */
        .search-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            color:#778899;
            transform: translateY(-50%);
            cursor: pointer;
        }
 
        .search-icon::before {
             /* Unicode character for a magnifying glass */
            font-size: 16px;
        }
        .filter-container1{
            display: flex;
            background:#fff;
            align-items:center;
            height:31px;
            width:30px;
            border-radius:5px;
            padding:5px;
            border:1px solid #ccc;
        }
 
        /* Styles for the filter group */
        .filter-group {
            display: flex;
            align-items: center;
        }
 
        /* Styles for the Font Awesome icon */
        .fa-icon {
            font-size: 14px;
            color:#778899;
             /* Add spacing between icon and text */
        }
 
        .calendar-date {
            color:black;
            cursor: pointer;
        }
 
        .event-details {
            display:flex;
            width:100%;
            background:pink;
            justify-content:end;
            flex-direction:row;
            padding: 0px;
        }
        .date-day{
            width:40%;
            display:flex;
            text-align:center;
            color:#778899;
            padding:10px 15px;
            justify-content:center;
            border:1px solid #ccc;
            background: #fff;
        }
        .holiday-con{
            display:flex;
            text-align:start;
            justify-content:start;
            align-items:center;
            width:100%;
            list-style:none;
            padding:10px 15px;
            border:1px solid #ccc;
            background: #fff;
        }
     
        .table  .text{
            font-size:0.875rem;
            color:#778899;
            font-weight:600;
        }
        .circle {
            width: 12px; /* Adjust the width and height for your preferred circle size */
        height: 12px;
        border-radius: 50%; /* Make the element circular */
        position: absolute; /* Position the circle absolutely */
        top: 12px; /* Adjust top and right values for positioning */
        right: 10px;
        text-align: center;
        line-height: 20px;
        }

        /* Define a class for circular cells with a pink background */
        .circle.IRIS {
            background-color: #d29be1;
        }
        .circle-grey {
        width: 20px; /* Adjust the width and height for your preferred circle size */
        height: 20px;
        color: black;
        border-radius: 50%; /* Make the element circular */
        position: absolute; /* Position the circle absolutely */
        text-align: center;
        background-color: #b7b7b7;
        line-height: 15px; /* Match the height for center alignment */
        top: 60%; /* Position the circle at 50% from the top */
        left: 50%; /* Position the circle at 50% from the left */
        transform: translate(-50%, -50%); /* Move the circle to the center */
    }
    .active-date {
        background-color: #ecf7fe; /* Active and hover background color */
        cursor: pointer;
        border-color:1px solid  blue;
    }

    .sidebar {
  height: 100%;
  width: 0;
  position: fixed;
  border-radius:5px;
  z-index: 1;
  top: 0;
  right: 0; /* Position the sidebar to the right */
  background-color: #fff;
  overflow-x: hidden;
  transition: width 0.5s;
}

.sidebar a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidebar a:hover {
  color: #f1f1f1;
}

.sidebar .closebtn {
  position: absolute;
  left: 25px; /* Adjust the close button position */
  font-size: 36px;
  margin-left: 150px;
  
}

.openbtn {
  cursor: pointer;
  display:flex;
  justify-content:center;
  background-color: #fff;
  border: none;
  width:20px;
  z-index: 2;
  right: 10px;
  top: 10px;
}

.filter-container1:hover {
  background-color: #f6faff;
}
.openbtn:hover {
  background-color: #f6faff;
}

#main {
  transition: margin-left .5s;
  margin-right: 0;
  padding-left: 0;
}
.header {
    display: flex; align-items: center; background-color: #dce0e5; padding: 10px;
}
.header h6{
  color:#778899;
  font-weight:500;
}
.locations{
    background:#fff;
    font-size:0.825rem;
    width:195px;
    height:200px;
    border-radius:5px;
    border:1px solid #ccc;
    box-shadow:1px 2px 1px 0 rgba(0,0,0,0.2);
    position: absolute; top: 145px; left:35px;  padding: 10px; border: 1px solid #ccc;
}
.departments{
    background:#fff;
    font-size:0.825rem;
    width:195px;
    height:200px;
    border-radius:5px;
    border:1px solid #ccc;
    box-shadow:1px 2px 1px 0 rgba(0,0,0,0.2);
    position: absolute; top: 225px; left:35px;  padding: 10px; border: 1px solid #ccc;
}
.main-content{
    background:#fff;
    padding:15px 20px;
    flex-grow: 1;
}
.loc-dropdown{
    width:100%;
    border:1px solid #ccc;
    cursor:pointer;
    text-align:center;
    background:#fff;
    padding:5px;
    border-radius:5px;
}
.loc-dropdown p{
   font-size:0.825rem;font-weight:500;color:#778899;margin-bottom:0;
}
.btn-2{
    background:rgb(2, 17, 79);
    color:#fff;
    font-size:0.825rem;
    padding:3px 10px;
    border-radius:5px;
    border:none;
}
.btn-3{
    color:#778899;
    padding:3px 10px;
    background:#fff;
    border:1px solid #ccc;
    border-radius:5px;
}
.btn-3:hover{
  background:#ebf5ff;
}
.btn-1{
    color:rgb(2, 17, 79);
    padding:3px 10px;
    background:#fff;
    font-size:0.825rem;
    border:1px solid rgb(2, 17, 79);
    border-radius:5px;
}
::placeholder {
        font-size: 10px; /* Adjust the font size as needed */
        color:#778899;
    }
/* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
@media screen and (max-height: 450px) {
  .sidebar {padding-top: 15px;}
  .sidebar a {font-size: 18px;}
}
       
    </style>

    <div class="container-leave" >
        <div class="sidebar" style="width: {{ $showDialog ? '250px' : '0' }};display: flex; flex-direction: column; height: 100vh;">
            <div class="header">
                <a href="javascript:void(0)" class="closebtn" wire:click="close" style="margin-right: 10px;">×</a>
                <h6>Apply Filter</h6>
            </div>
             <div class="main-content">
                  <label for="locations" style="font-size: 0.825rem; color: #778899; font-weight: 500; margin-top: 20px; margin-right: 10px;">Location</label>
                    <div wire:click="openLocations" class="loc-dropdown">
                       <div style="position: relative;">
                           <div style="display: flex;justify-content:space-between; align-items: center;">
                                <p>
                                    @if($this->isSelectedAll())
                                        All
                                    @else
                                        {{ implode(', ', $selectedLocations) }}
                                    @endif
                                    </p>
                                <!-- Solid down arrow -->
                                <svg width="15" height="15" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 13L6 9H14L10 13Z" fill="#778899"/>
                                </svg>
                          </div>
                        </div>
                    </div>
                    @if($showLocations)
                        <div class="locations">
                            <div style="display: flex;justify-content:space-between; text-align:center;align-items: center;padding:0;height:40px;position:relative;">
                               <p style="font-size:0.725rem; padding:0;color:#148aff;font-weight:500;">Select Location</p>
                               <a href="#" wire:click="closeLocations" style="top:-5px; right:5px;position:absolute;" >×</a>
                            </div>
                             <div style="display:flex;flex-direction:column;gap:10px;">
                                <label>
                                    <input type="checkbox" wire:click="toggleSelection('All')" wire:model="selectedLocations" value="All"> All
                                </label>
                                <label>
                                    <input type="checkbox" wire:click="toggleSelection('Hyderabad')" wire:model="selectedLocations" value="Hyderabad"> Hyderabad
                                </label>
                                <label>
                                    <input type="checkbox" wire:click="toggleSelection('Udaipur')" wire:model="selectedLocations" value="Udaipur"> Udaipur
                                </label>
                                <label>
                                    <input type="checkbox" wire:click="toggleSelection('Rajasthan')" wire:model="selectedLocations" value="Rajasthan"> Rajasthan
                                </label>
                            </div>
                           
                        </div>
                    @endif
                    <!-- department -->
                    <label for="locations" style="font-size: 0.825rem; color: #778899; font-weight: 500; margin-top: 20px; margin-right: 10px;">Department</label>
                    <div wire:click="openDept" class="loc-dropdown">
                       <div style="position: relative;">
                           <div style="display: flex;justify-content:space-between; align-items: center;">
                                <p>
                                    @if($this->isSelecteDeptdAll())
                                        All
                                    @else
                                        {{ implode(', ', $selectedDepartments) }}
                                    @endif
                                    </p>
                                <!-- Solid down arrow -->
                                <svg width="15" height="15" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 13L6 9H14L10 13Z" fill="#778899"/>
                                </svg>
                          </div>
                        </div>
                    </div>
                    @if($showDepartment)
                        <div class="departments">
                            <div style="display: flex;justify-content:space-between; text-align:center;align-items: center;padding:0;height:40px;position:relative">
                               <p style="font-size:0.725rem;padding:0;color:#148aff;font-weight:500;">Select Department</p>
                               <a href="#" wire:click="closeDept" style="top:-5px; right:5px;position:absolute;" >×</a>
                            </div>
                             <div style="display:flex;flex-direction:column;gap:10px;">
                                <label>
                                    <input type="checkbox" wire:click="toggleDeptSelection('All')" wire:model="selectedDepartments" value="All"> All
                                </label>
                                <label>
                                    <input type="checkbox" wire:click="toggleDeptSelection('Developement')" wire:model="selectedDepartments" value="Developement"> Developement
                                </label>
                                <label>
                                    <input type="checkbox" wire:click="toggleDeptSelection('Sales')" wire:model="selectedDepartments" value="Sales"> Sales
                                </label>
                                <label>
                                    <input type="checkbox" wire:click="toggleDeptSelection('IT')" wire:model="selectedDepartments" value="IT"> IT
                                </label>
                            </div>
                           
                        </div>
                        @endif
                    <!-- end -->
                    <div style="margin-top: 30px;">
                        <button class="btn-1" wire:click="applyFilter">Apply</button>
                        <button class="btn-2" wire:click="resetFilter">Reset</button>
                    </div>
            </div>
    </div>

    <div class="button-container" >
        <!-- Dropdown for filter selection -->
        <div class="filter-container">
            <label for="filterType" style="color: #778899; font-size: 0.825rem;font-weight:500;">Filter Type:</label>
            <select style="font-size:0.855rem;padding:2px 10px;cursor:pointer;outline:none;" wire:model.lazy="filterCriteria" id="filterType" class="filter-dropdown" wire:change="filterBy($event.target.value)">
                <option style="font-size:0.825rem;padding:10px 15px;" value="Me" @if($filterCriteria === 'Me') selected @endif>Me</option>
                <option style="font-size:0.825rem;padding:10px 15px;" value="MyTeam" @if($filterCriteria === 'MyTeam') selected @endif>My Team</option>
                <!-- Add more options as needed -->
            </select>
        </div>


        <button class="custom-button" >
        <i class="fa fa-download" aria-hidden="true" wire:click="downloadexcelforLeave"></i>
        </button>
    </div>
        <div class="row" style="margin:0;padding:0;">
            <div class="col-md-7">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="calendar-heading-container">
                        <button wire:click="previousMonth" class="nav-btn">&lt; Prev</button>
                        <h5>{{ date('F Y', strtotime("$year-$month-1")) }}</h5>
                        <button wire:click="nextMonth" class="nav-btn">Next &gt;</button>
                    </div>
                </div>
                <!-- Calendar -->
                <div class="table-responsive">
                <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text">Sun</th>
                                <th class="text">Mon</th>
                                <th class="text">Tue</th>
                                <th class="text">Wed</th>
                                <th class="text">Thu</th>
                                <th class="text">Fri</th>
                                <th class="text">Sat</th>
                            </tr>
                        </thead>
                        <tbody id="calendar-body">
                            @foreach ($calendar as $week)
                                <tr>
                                    @foreach ($week as $day)
                                    @php
                                                    $carbonDate = \Carbon\Carbon::createFromDate($year, $month, $day['day']);
                                                    $isCurrentMonth = $day['isCurrentMonth'];
                                                    $isWeekend = in_array($carbonDate->dayOfWeek, [0, 6]); // 0 for Sunday, 6 for Saturday
                                                    $isActiveDate = ($selectedDate === $carbonDate->toDateString());
                                                @endphp
                                        <td wire:click="dateClicked($event.target.textContent)" class="calendar-date{{ $selectedDate === $day['day'] ? ' active-date' : '' }}" data-date="{{ $day['day'] }}"
                                                    style="color: {{ $isCurrentMonth ? ($isWeekend ? '#c5cdd4' : 'black') : '#c5cdd4' }};">
                                                
                                            @if ($day)
                                                <div >
                                                    @if ($day['isToday'])
                                                        <div style="background-color: #007bff; color: white; border-radius: 50%; width: 24px; height: 24px; text-align: center; line-height: 24px; ">
                                                            {{ str_pad($day['day'], 2, '0', STR_PAD_LEFT) }}
                                                        </div>
                                                    @else
                                                        {{ str_pad($day['day'], 2, '0', STR_PAD_LEFT) }}
                                                    @endif
                                                    <div class="circle{{ $day['isPublicHoliday'] ? ' IRIS' : '' }}">
                                                        <!-- Render your content -->
                                                    </div>
                                                    @php
                                                        $leaveCount = $filterCriteria === 'Me' ? $day['leaveCountMe'] : $day['leaveCountMyTeam'];
                                                    @endphp
                                                    @if ($leaveCount > 0)
                                                        <div class="circle-grey">
                                                            <!-- Render your grey circle -->
                                                            <span style="display: flex; justify-content: center; align-items: center;width:20px;height:20px;border-radius:50%;">
                                                                {{ $leaveCount }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                    </div>

                 <div class="tol-calendar-legend mt-1 mb-3">
                        <div>
                            Team on Leave
                            <span class="legend-circle" style="background: #ccc; font-size: 0.75rem;">
                                0
                            </span>
                        </div>
                        <div>
                            Restricted Holiday
                            <span class="legend-circle circle-pale-yellow" style="vertical-align: middle; display: inline-block; width: 12px; height: 12px; border-radius: 50%;"></span>
                        </div>
                        <div>
                            General Holiday
                            <span class="legend-circle circle-pale-pink" style="vertical-align: middle; display: inline-block; width: 12px; height: 12px; border-radius: 50%;"></span>
                        </div>
                    </div>
                </div>
                  <div class="col-md-5">
                       <!-- Inside the event-container div -->
                       <div class="event-details" >
                       @if($holidays->count() > 0)
                             <div class="date-day">
                                <span style="font-weight:500;">{{ \Carbon\Carbon::parse($selectedDate)->format('D') }} <br>
                                  <span style="font-weight:normal;font-size:0.825rem;margin-top:-5px;">{{ \Carbon\Carbon::parse($selectedDate)->format('d') }}</span>
                                </span>
                               
                             </div>
                                   <div class="holiday-con">
                                            @foreach($holidays as $holiday)
                                                <span style="font-weight:normal;font-size:0.825rem; color:#778899;">General Holiday <br>
                                                    <span style="font-weight:500;font-size:0.895rem;color:#333;">{{ $holiday->festivals }}</span>
                                                </span>
                                               
                                            @endforeach
                                    </div>
                                 @endif
                            </div>
                            <!-- end -->
                        <div class="cont d-flex justify-content-end  mt-4 ">
                           <div class="search-container d-flex" >
                                <div class="form-group"  >
                                    <div class="search-input-leave"  >
                                        <div class="search-cont ">
                                                <input wire:model.debounce.500ms="searchTerm" type="text" placeholder="Search Employee">
                                               <!-- Search button -->
                                                <button class="btn-3" wire:click="searchData"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="filter-container1" >
                                <div id="main" style="margin-left: {{ $showDialog ? '250px' : '0' }}">
                                    <button class="openbtn" wire:click="open">
                                            <i class="fa-icon fas fa-filter"></i> 
                                    </button>  
                                </div>
                                
                            </div>
                        </div>
                
                    <div class="accordion" >
                         <div class="accordion-heading active" onclick="toggleAccordion(this)">
                            <div class="accordion-title">
                                <div class="accordion-content">
                                   <span style="font-size: 16px; font-weight: 500;color:#778899;padding:10px 15px;">Leave transactions({{ count($this->leaveTransactions) }})</span>
                                </div>
                                <div class="accordion-button" style="border-radius: 50%; height: 0.5rem; width: 0.5rem; display: flex; justify-content: center; align-items: center;">
                                        <!-- <i class="fas fa-chevron-down"></i> -->
                                </div>
                        </div>
                    </div>
                     <div class="accordion-body">
                       <div class="col-md-12 scroll-tabel" style="overflow-y:auto;max-height:320px; min-height:280px;padding:0;">
                        <table class="leave-table" style="width: 100%; border-collapse: collapse; ;overflow: auto;">
                            <thead style="background-color: #ecf7fc; text-align:start;  width:100%;">
                                <tr>
                                    <th style="padding:7px 5px; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc;color:#778899;font-size:0.725rem;font-weight:normal;width: 40%;">Employee ID</th>
                                    <th style="padding:7px 5px; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc;color:#778899;font-size:0.725rem;font-weight:normal;width: 20%;">No of days</th>
                                    <th style="padding:7px 5px; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc;color:#778899;font-size:0.725rem;font-weight:normal;width: 40%;">From-To </th>
                                </tr>
                            </thead>
                            <tbody >
                            @if (empty($this->leaveTransactions))
                            <tr>
                                <td colspan="3">
                                    <p>No data found</p>
                                </td>
                            </tr>`
                            @else
                            @if (!empty($selectedDate))
                                @forelse($this->leaveTransactions as $transaction)
                                    <tr style="border-bottom: 1px solid #ccc; font-size:0.725rem;text-align:start;">
                                        <td style="padding: 20px 5px; border-top: 1px solid #ccc; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">
                                            <span style="color: black; font-size: 0.725rem; font-weight: 500;">
                                                {{ $transaction->employee->first_name }} {{ $transaction->employee->last_name }}
                                            </span>
                                            <span style="font-size: 0.695rem; color: #778899;">
                                                (#{{ $transaction->emp_id }}<br>{{ $transaction->employee->job_location }}, {{ $transaction->employee->job_title }})
                                            </span>
                                        </td>

                                        <td style=" padding:20px 5px;border-top: 1px solid #ccc;font-weight:500;">{{ $this->calculateNumberOfDays($transaction->from_date, $transaction->from_session, $transaction->to_date, $transaction->to_session) }}</td>
                                        <td style=" padding:20px 5px;border-top: 1px solid #ccc;">
                                        @php
                                            $fromDate = \Carbon\Carbon::createFromFormat('Y-m-d', $transaction->from_date)->format('d M');
                                            $toDate = \Carbon\Carbon::createFromFormat('Y-m-d', $transaction->to_date)->format('d M');
                                        @endphp
                                            @if($fromDate === $toDate)
                                              <span style="color:black;font-size:0.725rem;font-weight:500;"> {{ $fromDate }}</span>
                                            @else
                                                <span style="color:black;font-size:0.725rem;font-weight:500;">{{ $fromDate }} - {{ $toDate }} </span><br><span style="font-size:0.60rem;color:#778899;">{{$transaction->from_session}}&nbsp;&nbsp;&nbsp;&nbsp;{{$transaction->to_session}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                  
                                @empty
                                    <tr>
                                        <td colspan="3">
                                            <div class="leave-trans" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                                <img src="/images/pending.png" alt="Pending Image" style="width: 100%; margin: 0 auto;">
                                                <span style="font-size: 0.75rem; font-weight: 500; color:#778899;">No Employees are on leave</span>
                                            </div>
                                        </td>
                                    </tr>
                                  
                                @endforelse
                              
                                @else
                                    <tr>
                                        <td colspan="3">
                                            <div class="leave-trans" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                                <img src="/images/pending.png" alt="Pending Image" style="width: 100%; margin: 0 auto;">
                                                <span style="font-size: 0.75rem; font-weight: 500; color:#778899;">No Employees are on leave</span>
                                            </div>
                                        </td>
                                    </tr>
                                 @endif
                                 @endif
                               </tbody>
                          </table>
                       </div>
                    </div>
                </div>
            </div>
    </div>
 
    
    <script>
        function toggleAccordion(element) {
        const accordionBody = element.nextElementSibling;
        if (accordionBody.style.display === 'block') {
            // If accordion is already open, keep it open
            element.classList.add('active'); // Add active class
            element.closest('.wrapper').classList.add('fixed'); // Add fixed class
        } else {
            // If accordion is closed, open it
            accordionBody.style.display = 'block';
            element.classList.add('active'); // Add active class
            element.closest('.wrapper').classList.add('fixed'); // Add fixed class
        }
    }

    </script> 

 
</div>