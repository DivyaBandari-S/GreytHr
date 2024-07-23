<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @guest
    <link rel="icon" type="image/x-icon" href="{{ asset('public/images/hr_expert.png') }}">
    <title>
        HR Strategies Pro
    </title>
    @endguest

    @auth('emp')
    @php
    $employeeId = auth()->guard('emp')->user()->emp_id;
    $employee = DB::table('employee_details')
    ->join('companies', 'employee_details.company_id', '=', 'companies.company_id')
    ->where('employee_details.emp_id', $employeeId)
    ->select('companies.company_logo', 'companies.company_name')
    ->first();
    $mangerid = DB::table('employee_details')
    ->join('companies', 'employee_details.company_id', '=', 'companies.company_id')
    ->where('employee_details.manager_id', $employeeId)
    ->select('companies.company_logo', 'companies.company_name')
    ->first();
    @endphp
    <link rel="icon" type="image/x-icon" href="{{ asset($employee->company_logo) }}">
    <title>
        {{ $employee->company_name }}
    </title>
    @endauth
    <style>
        .dropdown-menu.show {
            display: block;
            background-color: none !important;
            margin-left: 20px;
            border: none;
        }
    </style>
    <livewire:styles />

    @vite(['public/css/app.css', 'public/js/app.js'])

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/alpine.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Font Family -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">


    <!-- DateRangePicker CSS and JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.min.js">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.11.0/sweetalert2.min.js" integrity="sha512-Wi5Ms24b10EBwWI9JxF03xaAXdwg9nF51qFUDND/Vhibyqbelri3QqLL+cXCgNYGEgokr+GA2zaoYaypaSDHLg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- npm Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/app.js') }}" defer data-turbolinks-track="reload"></script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>

    <script src="{{ asset('vendor/livewire/livewire.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Add these links to your HTML -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Hierarchy Select Js -->
    <!-- <script src="js/hierarchy-select.min.js"></script> -->

    <!-- Hierarchy Select CSS -->
    <!-- <link rel="stylesheet" href="css/hierarchy-swelect.min.css"> -->
    <!-- Emoji links -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.css" />
    <script src="https://twemoji.maxcdn.com/v/latest/twemoji.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"></script>

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('livewire/livewire.js') }}" defer></script>

    <style>
        @import url('/public/app.css');
    </style>

    @livewireScripts

    @stack('styles')
</head>

@guest
<livewire:emplogin />
@else

<body>

    <div>
        <div class="row m-0 p-0 " style="height: 100vh;background:#f5f5f5;">

            <div class="menucard displayNone hideMinBar" id="menu-popup" style="border-radius:0px; width: auto; background:#fff;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);padding:0;margin:0; backdrop-filter: blur( 3px ); -webkit-backdrop-filter: blur( 3px );">

                <div class="left-card-body" style="padding: 0 5px;margin: 0;">

                    <ul class="flex-column nav">

                        <div style="margin-bottom: 20px;margin-top:5px;cursor:pointer;">
                            <a href="/"> @livewire('company-logo')</a>
                        </div>

                        @livewire('profile-card')


                        @auth('emp')
                        <div class="scrollable-container mt-2">
                            <ul class="nav flex-column">
                                <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item  ">

                                    <a class="nav-link" href="/" onclick="setActiveLink(this)">

                                        <i class="fas mr-1 fa-home" style="color:#6c7e90;"></i>
                                        Home

                                    </a>

                                </li>
                                <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                    <a class="nav-link" href="/time-sheet" onclick="setActiveLink(this)">
                                        <i class="fas mr-1 fa-clock" style="color:#6c7e90;"></i> <!-- Clock icon -->
                                        Time Sheet
                                    </a>
                                </li>

                                <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item ">

                                    <a class="nav-link" href="/Feeds" onclick="setActiveLink(this)">

                                        <i class="fas mr-1 fa-rss" style="color:#6c7e90"></i>
                                        Feeds

                                    </a>

                                </li>
                                <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item  ">

                                    <a class="nav-link" href="/PeoplesList" onclick="setActiveLink(this)">

                                        <i class="fas mr-1    fa-users" style="color:#6c7e90"></i>
                                        People

                                    </a>

                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" onclick="toggleToDoDropdown()">
                                        <i class="fas mr-1    fa-file-alt" id="todo-icon" style="color:#6c7e90"></i>
                                        To Do
                                        <i class="fas mr-1    fa-caret-down" id="todo-caret" style="color:#6c7e90"></i>
                                    </a>
                                    <div id="todo-options" style="display: none;">
                                        <ul style="list-style: none;  margin-left:10px; cursor:pointer;">
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/tasks" onclick=" setActiveLink(this)">
                                                    Tasks
                                                </a>
                                            </li>
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/employees-review" onclick=" setActiveLink(this)">
                                                    Review
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" onclick="toggleSalaryDropdown()">
                                        <i class="fas mr-1    fa-solid fa-money-bill-transfer" id="salary-icon" style="color:#6c7e90"></i>
                                        Salary
                                        <i class="fas mr-1    fa-caret-down" id="salary-caret" style="color:#6c7e90"></i>
                                    </a>
                                  
                                    <div id="salary-options" style="display: none;">
                                        <ul style="list-style: none;  margin-left:10px; cursor:pointer;">
                                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/slip" id="slip" onclick="selectOption(this, 'Pay Slip');setActiveLink(this)">
                                                    Payslips
                                                </a>
                                            </li> 
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/ytd" id="itstatement" onclick="selectOption(this, 'IT Statement');setActiveLink(this)">
                                                    YTD Reports
                                                </a>
                                            </li>
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/itstatement" id="itstatement" onclick="selectOption(this, 'IT Statement');setActiveLink(this)">
                                                    IT Statement
                                                </a>
                                            </li>
                                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/formdeclaration" id="itdeclaration" onclick="selectOption(this, 'IT Declaration');setActiveLink(this)">
                                                    IT Declaration
                                                </a>
                                            </li>
                                 


                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/reimbursement" id="reimbursement" onclick="selectOption(this, 'Reimbursement'); setActiveLink(this)">
                                                    Reimbursement
                                                </a>
                                            </li>
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/investment" id="investment" onclick="selectOption(this, 'Proof of Investment'); setActiveLink(this) ">
                                                    Proof of Investment
                                                </a>
                                            </li>
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/salary-revision" id="salary-revision" onclick="selectOption(this, 'Salary Revision'); setActiveLink(this)">
                                                    Salary Revision
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" onclick="toggleLeaveDropdown(event)">
                                        <i class="fas mr-1    fa-file-alt" id="leave-icon" style="color:#6c7e90"></i>
                                        Leave
                                        <i class="fas mr-1    fa-caret-down" id="leave-caret" style="color:#6c7e90"></i>
                                    </a>
                                    <div id="leave-options" style="display: none;">
                                        <ul style="list-style: none;  margin-left:10px; cursor:pointer;">
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/leave-page" onclick="setActiveLink(this)">
                                                    Leave Apply
                                                </a>
                                            </li>
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/leave-balances" onclick="setActiveLink(this)">
                                                    Leave Balances
                                                </a>
                                            </li>
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/leave-calender" onclick="setActiveLink(this)">
                                                    Leave Calendar
                                                </a>
                                            </li>
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/holiday-calender" onclick="setActiveLink(this)">
                                                    Holiday Calendar
                                                </a>
                                            </li>
                                            @if ($mangerid)
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/team-on-leave-chart" onclick="setActiveLink(this)">
                                                    @livewire('team-on-leave')
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" onclick="toggleAttendanceDropdown()">
                                        <i class="fas mr-1    fa-clock" style="color:#6c7e90"></i>
                                        Attendance
                                        <i class="fas mr-1    fa-caret-down" id="attendance-caret" style="color:#6c7e90"></i>
                                    </a>
                                    <div id="attendance-options" style="display: none;">
                                        <ul style="list-style: none;  margin-left:10px; cursor:pointer;">
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/Attendance" onclick="setActiveLink(this)">
                                                    Attendance Info
                                                </a>
                                            </li>
                                            @if ($mangerid)
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/whoisinchart" onclick="setActiveLink(this)">
                                                    @livewire('whoisin')
                                                </a>
                                            </li>
                                            @endif
                                            @if ($mangerid)
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/employee-swipes-data" onclick="setActiveLink(this)">
                                                    @livewire('employee-swipes')
                                                </a>
                                            </li>
                                            @endif
                                            @if ($mangerid)
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/attendance-muster-data" onclick="setActiveLink(this)">
                                                    @livewire('attendance-muster')
                                                </a>
                                            </li>
                                            @endif
                                            @if ($mangerid)
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/shift-roaster-data" onclick="setActiveLink(this)">
                                                    @livewire('shift-roaster-submodule')
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>

                                <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">

                                    <a class="nav-link" href="/document" onclick="setActiveLink(this)">

                                        <i class="fas mr-1    fa-folder" style="color:#6c7e90"></i> Document Center

                                    </a>

                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" onclick="toggleHelpDeskDropdown()">
                                        <i class="fas mr-1    fa-file-alt" id="help-icon" style="color:#6c7e90"></i>
                                        Helpdesk
                                        <i class="fas mr-1    fa-caret-down" id="help-caret" style="color:#6c7e90"></i>
                                    </a>
                                    <div id="help-options" style="display: none;">
                                        <ul style="list-style: none;  margin-left:10px; cursor:pointer;">
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/HelpDesk" onclick=" setActiveLink(this)">
                                                    New Requests
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </li>


                                <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">

                                    <a class="nav-link" href="/delegates" onclick="setActiveLink(this)">

                                        <i class="fas mr-1    fa-user-friends" style="color:#6c7e90"></i> Workflow
                                        Delegates

                                    </a>
                                </li>
                                @if ($mangerid)
                                <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">

                                    <a class="nav-link" href="/reports" onclick="setActiveLink(this)">

                                        <i class="fas mr-1    fa-user-friends" style="color:#6c7e90"></i> Reports
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                        @endauth

                        @auth('hr')
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                            <a class="nav-link" href="/home-dashboard" onclick="setActiveLink(this)">
                                <i class="fas mr-1    fa-home" style="color:#6c7e90"></i> Home
                            </a>
                        </li>

                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                            <a class="nav-link" href="/hrPage" onclick="setActiveLink(this)">
                                <i class="fas mr-1    fa-laptop" style="color:#6c7e90"></i> HR Requests
                            </a>
                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item ">

                            <a class="nav-link" href="/hrFeeds" onclick="setActiveLink(this)">

                                <i class="fas mr-1 fa-rss" style="color:#6c7e90"></i>
                                Feeds

                            </a>

                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">

                            <a class="nav-link" href="/addLeaves" onclick="setActiveLink(this)">

                                <i class="fas mr-1    fa-envelope" style="color:#6c7e90"></i>
                                Grant Leaves

                            </a>

                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">

                            <a class="nav-link" href="/letter-requests" onclick="setActiveLink(this)">

                                <i class="fas mr-1    fa-envelope" style="color:#6c7e90"></i>
                                Letter Requests

                            </a>

                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">

                            <a class="nav-link" href="/add-holiday-list" onclick="setActiveLink(this)">

                                <i class="fas mr-1    fa-envelope" style="color:#6c7e90"></i>
                                Add Holidays
                            </a>

                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">

                            <a class="nav-link" href="/hremployeedirectory" onclick="setActiveLink(this)">

                                <i class="fas mr-1    fa-envelope" style="color:#6c7e90"></i>
                                Employee Directory
                            </a>

                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">

                            <a class="nav-link" href="/hrorganisationchart" onclick="setActiveLink(this)">

                                <i class="fas mr-1    fa-envelope" style="color:#6c7e90"></i>
                                Organization Chart
                            </a>

                        </li>
                        @endauth

                        @auth('it')
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                            <a class="nav-link" href="/itPage" onclick="setActiveLink(this)">
                                <i class="fas mr-1    fa-laptop" style="color:#6c7e90"></i> IT Requests
                            </a>
                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                            <a class="nav-link" href="/emp-assets-details   " onclick="setActiveLink(this)">
                                <i class="fas mr-1 fa-laptop" style="color:#6c7e90"></i> Employee Assets
                            </a>
                        </li>
                        @endauth

                        @auth('finance')
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                            <a class="nav-link" href="#" onclick="setActiveLink(this)">
                                <i class="fas mr-1    fa-dollar-sign" style="color:#6c7e90"></i> Finance Requests
                            </a>
                        </li>
                        @endauth

                    </ul>
                </div>

            </div>

            <div onmouseleave="myMenuSmallHover()" class="menucard displayNone hideMinBar" id="menu-popup-hover" style="position: absolute; z-index: 1; border-radius:0px; width: auto; background:#fff;;box-shadow: 0 4px 6px
            a(0, 0, 0, 0.1);padding:0;margin:0;  backdrop-filter: blur( 3px ); -webkit-backdrop-filter: blur( 3px )">

                <div class="left-card-body" style="margin-top: 0px;padding: 0 5px;margin: 0;height: 100vh;background:#fff;">

                    <ul class="nav flex-column">

                        <div style="margin-bottom: 20px;margin-top:5px;cursor:pointer;">
                            <a href="/"> @livewire('company-logo')</a>
                        </div>

                        @livewire('profile-card')


                        @auth('emp')
                        <div class="scrollable-container mt-2">
                            <ul class="nav flex-column">
                                <li data-bs-target="#navigateLoader" class="nav-item">

                                    <a class="nav-link" href="/" onclick="setActiveLink(this, '/')">

                                        <i class="fas mr-1 fa-home" style="color:#6c7e90;"></i>
                                        Home

                                    </a>

                                </li>

                                <li data-bs-target="#navigateLoader" class="nav-item">

                                    <a class="nav-link" href="/Feeds" onclick="setActiveLink(this, '/Feeds')">

                                        <i class="fas mr-1    fa-rss" style="color:#6c7e90"></i>
                                        Feeds
                                    </a>

                                </li>
                                <li data-bs-target="#navigateLoader" class="nav-item">

                                    <a class="nav-link" href="/PeoplesList" onclick="setActiveLink(this, '/PeoplesList')">


                                        <i class="fas mr-1    fa-users" style="color:#6c7e90"></i>

                                        People


                                    </a>

                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" onclick="toggleToDoDropdown2()">
                                        <i class="fas mr-1    fa-file-alt" id="todo-icon" style="color:#6c7e90"></i>
                                        To Do
                                        <i class="fas mr-1    fa-caret-down" id="todo-caret-2" style="color:#6c7e90"></i>
                                    </a>
                                    <div id="todo-options-2" style="display: none;">
                                        <ul style="list-style: none;  margin-left:10px; cursor:pointer;">
                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/tasks" onclick=" setActiveLink(this, '/tasks')">
                                                    Tasks
                                                </a>
                                            </li>
                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/employees-review" onclick=" setActiveLink(this, '/employees-review')">
                                                    Review
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </li>




                                <li class="nav-item">
                                    <a class="nav-link" onclick="toggleSalaryDropdown2()">
                                        <i class="fas mr-1    fa-solid fa-money-bill-transfer" id="salary-icon" style="color:#6c7e90"></i>
                                        Salary
                                        <i class="fas mr-1    fa-caret-down" id="salary-caret-2" style="color:#6c7e90"></i>
                                    </a>
                                    <div id="salary-options-2" style="display: none;">
                                        <ul style="list-style: none;  margin-left:10px; cursor:pointer;">
                                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/slip" id="slip" onclick="selectOption(this, 'Pay Slip');setActiveLink(this)">
                                                    Payslips
                                                </a>
                                            </li>
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/ytd" id="itstatement" onclick="selectOption(this, 'IT Statement');setActiveLink(this)">
                                                    YTD Reports
                                                </a>
                                            </li>
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/itstatement" id="itstatement" onclick="selectOption(this, 'IT Statement');setActiveLink(this)">
                                                    IT Statement
                                                </a>
                                            </li>
                                        
                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/formdeclaration" id="itdeclaration" onclick="selectOption(this, 'IT Declaration');setActiveLink(this, '/formdeclaration')">
                                                    IT Declaration
                                                </a>
                                            </li>
                                     
                                     

                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/reimbursement" id="reimbursement" onclick="selectOption(this, 'Reimbursement'); setActiveLink(this)">
                                                    Reimbursement
                                                </a>
                                            </li>
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/investment" id="investment" onclick="selectOption(this, 'Proof of Investment'); setActiveLink(this) ">
                                                    Proof of Investment
                                                </a>
                                            </li>
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/salary-revision" id="salary-revision" onclick="selectOption(this, 'Salary Revision'); setActiveLink(this)">
                                                    Salary Revision
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" onclick="toggleLeaveDropdown2(event)">
                                        <i class="fas mr-1    fa-file-alt" id="leave-icon" style="color:#6c7e90"></i>
                                        Leave
                                        <i class="fas mr-1    fa-caret-down" id="leave-caret-2" style="color:#6c7e90"></i>
                                    </a>
                                    <div id="leave-options-2" style="display: none;">
                                        <ul style="list-style: none;  margin-left:10px; cursor:pointer;">
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/leave-page" onclick="setActiveLink(this)">
                                                    Leave Apply
                                                </a>
                                            </li>
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/leave-balances" onclick="setActiveLink(this)">
                                                    Leave Balances
                                                </a>
                                            </li>
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/leave-calender" onclick="setActiveLink(this)">
                                                    Leave Calendar
                                                </a>
                                            </li>
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/holiday-calender" onclick="setActiveLink(this)">
                                                    Holiday Calendar
                                                </a>
                                            </li>
                                            @if ($mangerid)
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/team-on-leave-chart" onclick="setActiveLink(this)">
                                                    @livewire('team-on-leave')
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" onclick="toggleAttendanceDropdown2()">
                                        <i class="fas mr-1    fa-clock" style="color:#6c7e90"></i>
                                        Attendance
                                        <i class="fas mr-1    fa-caret-down" id="attendance-caret" style="color:#6c7e90"></i>
                                    </a>
                                    <div id="attendance-options-2" style="display: none;">
                                        <ul style="list-style: none;  margin-left:10px; cursor:pointer;">
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/Attendance" onclick="setActiveLink(this)">
                                                    Attendance Info
                                                </a>
                                            </li>
                                            @if ($mangerid)
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/whoisinchart" onclick="setActiveLink(this)">
                                                    @livewire('whoisin')
                                                </a>
                                            </li>
                                            @endif
                                            @if ($mangerid)
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/employee-swipes-data" onclick="setActiveLink(this)">
                                                    @livewire('employee-swipes')
                                                </a>
                                            </li>
                                            @endif
                                            @if ($mangerid)
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/attendance-muster-data" onclick="setActiveLink(this)">
                                                    @livewire('attendance-muster')
                                                </a>
                                            </li>
                                            @endif
                                            @if ($mangerid)
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/shift-roaster-data" onclick="setActiveLink(this)">
                                                    @livewire('shift-roaster-submodule')
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>

                                <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">

                                    <a class="nav-link" href="/document" onclick="setActiveLink(this)">

                                        <i class="fas mr-1    fa-folder" style="color:#6c7e90"></i> Document Center

                                    </a>

                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" onclick="toggleHelpDeskDropdown2()">
                                        <i class="fas mr-1    fa-file-alt" id="help-icon" style="color:#6c7e90"></i>
                                        Helpdesk
                                        <i class="fas mr-1    fa-caret-down" id="help-caret" style="color:#6c7e90"></i>
                                    </a>
                                    <div id="help-options" style="display: none;">
                                        <ul style="list-style: none;  margin-left:10px; cursor:pointer;">
                                            <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/HelpDesk" onclick=" setActiveLink(this)">
                                                    New Requests
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </li>

                                <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">

                                    <a class="nav-link" href="/delegates" onclick="setActiveLink(this)">

                                        <i class="fas mr-1    fa-user-friends" style="color:#6c7e90"></i> Workflow
                                        Delegates

                                    </a>
                                </li>
                                @if ($mangerid)
                                <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">

                                    <a class="nav-link" href="/reports" onclick="setActiveLink(this)">

                                        <i class="fas mr-1    fa-user-friends" style="color:#6c7e90"></i> Reports
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                        @endauth

                        @auth('hr')
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                            <a class="nav-link" href="/home-dashboard" onclick="setActiveLink(this)">
                                <i class="fas mr-1    fa-home" style="color:#6c7e90"></i> Home
                            </a>
                        </li>

                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                            <a class="nav-link" href="/hrPage" onclick="setActiveLink(this)">
                                <i class="fas mr-1    fa-laptop" style="color:#6c7e90"></i> HR Requests
                            </a>
                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item ">

                            <a class="nav-link" href="/hrFeeds" onclick="setActiveLink(this)">

                                <i class="fas mr-1 fa-rss" style="color:#6c7e90"></i>
                                Feeds

                            </a>

                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">

                            <a class="nav-link" href="/letter-requests" onclick="setActiveLink(this)">

                                <i class="fas mr-1    fa-envelope" style="color:#6c7e90"></i>
                                Letter Requests

                            </a>

                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">

                            <a class="nav-link" href="/addLeaves" onclick="setActiveLink(this)">

                                <i class="fas mr-1    fa-envelope" style="color:#6c7e90"></i>
                                Grant Leaves

                            </a>

                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">

                            <a class="nav-link" href="/add-holiday-list" onclick="setActiveLink(this)">

                                <i class="fas mr-1    fa-envelope" style="color:#6c7e90"></i>
                                Add Holidays
                            </a>

                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">

                            <a class="nav-link" href="/hremployeedirectory" onclick="setActiveLink(this)">

                                <i class="fas mr-1    fa-envelope" style="color:#6c7e90"></i>
                                Employee Directory
                            </a>

                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">

                            <a class="nav-link" href="/hrorganisationchart" onclick="setActiveLink(this)">

                                <i class="fas mr-1    fa-envelope" style="color:#6c7e90"></i>
                                Organization Chart
                            </a>

                        </li>
                        @endauth

                        @auth('it')
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                            <a class="nav-link" href="#" onclick="setActiveLink(this)">
                                <i class="fas mr-1    fa-laptop" style="color:#6c7e90"></i> IT Requests
                            </a>
                        </li>
                        @endauth

                        @auth('finance')
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">
                            <a class="nav-link" href="#" onclick="setActiveLink(this)">
                                <i class="fas mr-1    fa-dollar-sign" style="color:#6c7e90"></i> Finance Requests
                            </a>
                        </li>
                        @endauth

                    </ul>
                </div>

            </div>

            <div class="menucard displayNone" onclick="myMenuSmallHover()" id="menu-small" style="border-radius:0px; width: 5%; background:#55535333;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);padding:0;margin:0;  backdrop-filter: blur( 3px ); -webkit-backdrop-filter: blur( 3px )">

                <div class="left-card-body" style="margin-top: 0px;padding: 0 5px;margin: 0;height: 100%;">
                    <ul class="nav flex-column">

                        <div class="miniBarLogo" style="margin-bottom: 20px;margin-top:5px;cursor:pointer;">
                            <a href="/"> @livewire('company-logo')</a>
                        </div>



                        @auth('emp')
                        <div>
                            <ul class="nav flex-column">
                                <li data-bs-target="#navigateLoader" title="Home" class="nav-item">
                                    <a class="nav-link" href="/" onclick="setActiveLink(this, '/')">
                                        <img width="25" height="25" src="https://img.icons8.com/3d-fluency/94/home.png" alt="home" />
                                        <!-- <i class="fas mr-1 fa-home" style="color:#6c7e90"></i> -->
                                    </a>
                                </li>
                                <li data-bs-target="#navigateLoader" title="Time Sheet" class="nav-item">
                                    <a class="nav-link" href="/time-sheet" onclick="setActiveLink(this, '/time-sheet')">
                                        <img width="25" height="25" src="https://img.icons8.com/3d-fluency/94/clock.png" alt="time sheet" />
                                        <!-- Alternative text for accessibility -->
                                    </a>
                                </li>


                                <li data-bs-target="#navigateLoader" title="Feeds" class="nav-item">

                                    <a class="nav-link" href="/Feeds" onclick="setActiveLink(this, '/Feeds')">

                                        <img width="25" height="25" src="https://img.icons8.com/3d-fluency/94/rss.png" alt="rss" />

                                        <!-- <i class="fas mr-1    fa-rss" style="color:#6c7e90"></i> -->

                                    </a>

                                </li>
                                <li data-bs-target="#navigateLoader" title="People" class="nav-item">

                                    <a class="nav-link" href="/PeoplesList" onclick="setActiveLink(this, '/PeoplesList')">
                                        <img width="25" height="25" src="https://img.icons8.com/3d-fluency/94/group--v1.png" alt="group--v1" />

                                        <!-- <i class="fas mr-1    fa-users" style="color:#6c7e90"></i> -->

                                    </a>

                                </li>

                                <li class="nav-item" data-bs-placement="right" title="To do">
                                    <a class="nav-link" onclick="toggleToDoDropdown()">
                                        <img width="25" height="25" src="https://img.icons8.com/3d-fluency/94/document.png" alt="document" />
                                        <!-- <i class="fas mr-1    fa-file-alt" id="todo-icon" style="color:#6c7e90"></i> -->
                                    </a>
                                    <div id="todo-options" style="display: none;">
                                        <ul style="list-style: none;  margin-left:10px; cursor:pointer;">
                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/tasks" onclick=" setActiveLink(this, '/tasks')">

                                                </a>
                                            </li>
                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/employees-review" onclick=" setActiveLink(this, '/employees-review')">

                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item" data-bs-placement="right" title="Salary">
                                    <a class="nav-link" onclick="toggleSalaryDropdown()">
                                        <img width="25" height="25" src="https://img.icons8.com/3d-fluency/94/money-transfer.png" alt="money-transfer" />
                                        <!-- <i class="fas mr-1    fa-solid fa-money-bill-transfer" id="salary-icon" style="color:#6c7e90"></i> -->
                                    </a>
                                    <div id="salary-options" style="display: none;">
                                        <ul style="list-style: none;  margin-left:10px; cursor:pointer;">
                                        <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/slip" id="slip" onclick="selectOption(this, 'Pay Slip');setActiveLink(this, '/slip')">
                                                    Payslips
                                                </a>
                                            </li>
                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/ytd" id="itstatement" onclick="selectOption(this, 'IT Statement');setActiveLink(this, '/itstatement')">
                                                    YTD Reports
                                                </a>
                                            </li>
                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/itstatement" id="itstatement" onclick="selectOption(this, 'IT Statement');setActiveLink(this, '/itstatement')">
                                                    IT Statement
                                                </a>
                                            </li>
                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/formdeclaration" id="itdeclaration" onclick="selectOption(this, 'IT Declaration');setActiveLink(this, '/formdeclaration')">
                                                    IT Declaration
                                                </a>
                                            </li>
                                        
                                       
                                       


                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/reimbursement" id="reimbursement" onclick="selectOption(this, 'Reimbursement'); setActiveLink(this, '/reimbursement')">
                                                    Reimbursement
                                                </a>
                                            </li>
                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/investment" id="investment" onclick="selectOption(this, 'Proof of Investment'); setActiveLink(this, '/investment') ">
                                                    Proof of Investment
                                                </a>
                                            </li>
                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/salary-revision" id="salary-revision" onclick="selectOption(this, 'Salary Revision'); setActiveLink(this, '/salary-revision')">
                                                    Salary Revision
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item" data-bs-placement="right" title="Leave">
                                    <a class="nav-link" onclick="toggleLeaveDropdown(event)">
                                        <img width="25" height="25" src="https://img.icons8.com/3d-fluency/94/leave.png" alt="leave" />
                                        <!-- <i class="fas mr-1 fa-file-alt" id="leave-icon" style="color:#6c7e90"> </i> -->
                                    </a>
                                    <div id="leave-options" style="display: none;">
                                        <ul style="list-style: none;  margin-left:10px; cursor:pointer;">
                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/leave-page" onclick="setActiveLink(this, '/leave-page')">
                                                    Leave Apply
                                                </a>
                                            </li>
                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/leave-balances" onclick="setActiveLink(this, '/leave-balances')">
                                                    Leave Balances
                                                </a>
                                            </li>
                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/leave-calender" onclick="setActiveLink(this, '/leave-calende')">
                                                    Leave Calendar
                                                </a>
                                            </li>
                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/holiday-calender" onclick="setActiveLink(this, '/holiday-calender')">
                                                    Holiday Calendar
                                                </a>
                                            </li>
                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/team-on-leave-chart" onclick="setActiveLink(this, '/team-on-leave-chart')">
                                                    @livewire('team-on-leave')
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item" data-bs-placement="right" title="Attendance">
                                    <a class="nav-link" onclick="toggleAttendanceDropdown()">
                                        <img width="25" height="25" src="https://img.icons8.com/3d-fluency/94/timetable.png" alt="timetable" />
                                        <!-- <i class="fas mr-1    fa-clock" style="color:#6c7e90"></i> -->
                                    </a>
                                    <div id="attendance-options" style="display: none;">
                                        <ul style="list-style: none;  margin-left:10px; cursor:pointer;">
                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/Attendance" onclick="setActiveLink(this. '/Attendance')">
                                                    Attendance Info
                                                </a>
                                            </li>

                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/whoisinchart" onclick="setActiveLink(this, '/whoisinchart')">
                                                    @livewire('whoisin')
                                                </a>
                                            </li>

                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/employee-swipes-data" onclick="setActiveLink(this, '/employee-swipes-dat')">
                                                    @livewire('employee-swipes')
                                                </a>
                                            </li>
                                            <li data-bs-target="#navigateLoader" class="nav-item">
                                                <a class="nav-link" href="/attendance-muster-data" onclick="setActiveLink(this, '/attendance-muster-data')">
                                                    @livewire('attendance-muster')
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li data-bs-target="#navigateLoader" title="Document Center" class="nav-item">

                                    <a class="nav-link" href="/document" onclick="setActiveLink(this, '/document')">

                                        <img width="25" height="25" src="https://img.icons8.com/3d-fluency/94/folder-invoices--v1.png" alt="folder-invoices--v1" />

                                        <!-- <i class="fas mr-1    fa-folder" style="color:#6c7e90"></i> -->

                                    </a>

                                </li>


                                <li data-bs-target="#navigateLoader" title="Help Desk" class="nav-item">

                                    <a class="nav-link" href="/HelpDesk" onclick="setActiveLink(this, '/HelpDesk')">

                                        <img width="25" height="25" src="https://img.icons8.com/3d-fluency/94/headset.png" alt="headset" />

                                        <!-- <i class="fas mr-1    fa-headset" style="color:#6c7e90"></i> -->

                                    </a>

                                </li>

                                <li data-bs-target="#navigateLoader" title="Workflow Delegates" class="nav-item">
                                    <a class="nav-link" href="/delegates" onclick="setActiveLink(this, '/delegates')">
                                        <img width="25" height="25" src="https://img.icons8.com/3d-fluency/94/collaboration-female-male--v1.png" alt="collaboration-female-male--v1" />
                                        <!-- <i class="fas mr-1    fa-user-friends" style="color:#6c7e90"></i> -->
                                    </a>
                                </li>
                            </ul>
                        </div>
                        @endauth

                        @auth('hr')
                        <li data-bs-target="#navigateLoader" class="nav-item">
                            <a class="nav-link" href="/home-dashboard" onclick="setActiveLink(this, '/home-dashboar')">
                                <i class="fas mr-1    fa-home" style="color:#6c7e90"></i>
                            </a>
                        </li>

                        <li data-bs-target="#navigateLoader" class="nav-item">
                            <a class="nav-link" href="/hrPage" onclick="setActiveLink(this, '/hrPage')">
                                <i class="fas mr-1    fa-laptop" style="color:#6c7e90"></i>
                            </a>
                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item ">

                            <a class="nav-link" href="/hrFeeds" onclick="setActiveLink(this)">

                                <i class="fas mr-1 fa-rss" style="color:#6c7e90"></i>


                            </a>

                        </li>
                        <li data-bs-toggle="modal" data-bs-target="#navigateLoader" class="nav-item">

                            <a class="nav-link" href="/addLeaves" onclick="setActiveLink(this)">

                                <i class="fas mr-1    fa-envelope" style="color:#6c7e90"></i>


                            </a>

                        </li>
                        <li data-bs-target="#navigateLoader" class="nav-item">

                            <a class="nav-link" href="/letter-requests" onclick="setActiveLink(this, '/letter-requests')">

                                <i class="fas mr-1    fa-envelope" style="color:#6c7e90"></i>


                            </a>

                        </li>

                        <li data-bs-target="#navigateLoader" class="nav-item">

                            <a class="nav-link" href="/add-holiday-list" onclick="setActiveLink(this, '/add-holiday-list')">

                                <i class="fas mr-1    fa-envelope" style="color:#6c7e90"></i>

                            </a>

                        </li>
                        <li data-bs-target="#navigateLoader" class="nav-item">

                            <a class="nav-link" href="/add-holiday-list" onclick="setActiveLink(this, '/add-holiday-list')">

                                <i class="fas mr-1    fa-envelope" style="color:#6c7e90"></i>

                            </a>

                        </li>
                        <li data-bs-target="#navigateLoader" class="nav-item">

                            <a class="nav-link" href="/add-holiday-list" onclick="setActiveLink(this, '/add-holiday-list')">

                                <i class="fas mr-1    fa-envelope" style="color:#6c7e90"></i>

                            </a>

                        </li>
                        @endauth

                        @auth('it')
                        <li data-bs-target="#navigateLoader" class="nav-item">
                            <a class="nav-link" href="#" onclick="setActiveLink(this, '#')">
                                <i class="fas mr-1    fa-laptop" style="color:#6c7e90"></i>
                            </a>
                        </li>
                        @endauth

                        @auth('finance')
                        <li data-bs-target="#navigateLoader" class="nav-item">
                            <a class="nav-link" href="#" onclick="setActiveLink(this, '#')">
                                <i class="fas mr-1    fa-dollar-sign" style="color:#6c7e90"></i>
                            </a>
                        </li>
                        @endauth

                    </ul>
                </div>
            </div>

            <div class="col m-0 px-2 " style="height: 60px; width: auto; background: url('images/imageedit_1_3636168378.png') no-repeat center #02114f; background-size: cover;">

                <div class="col d-flex align-items-center mt-2">
                    <!-- <i class="fas fa-bars hideHamburger btn btn-primary" style="padding: 6px;color: #fff; font-size: 12px; margin: 0px 10px; cursor: pointer;" onclick="myMenu()"></i>
                        <i class="fas fa-bars showHamburger btn btn-primary" style="padding: 6px;color: #fff; font-size: 12px;  cursor: pointer;" onclick="myMenuSmall()"></i> -->
                    <img src="/images/app-drawer.png" class="app-drawer-img hideHamburger" onclick="myMenu()">
                    <img src="/images/app-drawer.png" class="app-drawer-img showHamburger" onclick="myMenuSmall()">
                    <h6 class="mx-2 my-0" style="color: white; width: -webkit-fill-available; margin-bottom: 10px;"> @livewire('page-title')
                    </h6>

                    @auth('emp')


                    @livewire('notification')
                    <div class="col dropdown mx-2 p-0">
                        <button class="dropdown-btn" style="font-size: 13px;  white-space: nowrap; margin-bottom: 5px; ">Quick
                            Links</button>
                        <div class="dropdown-content" style="font-size: 12px;font-weight:500;">
                            <a href="/tasks">Tasks</a>
                            <a href="/HelpDesk">Helpdesk</a>
                        </div>
                    </div>



                    @endauth

                    <div style="text-align:end;cursor:pointer; margin-right:10px;">
                        @livewire('log-out')
                    </div>

                </div>

                <div class="slot mt-4 ">
                    {{ $slot }}
                </div>

            </div>

        </div>

        <!-- Modal -->
        <div class="modal fade backdropModal" id="navigateLoader" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="navigateLoaderLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background-color : transparent; border : none">
                    <!-- <div class="modal-header">
            <h1 class="modal-title fs-5" id="navigateLoaderLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> -->

                    <div class="modal-body">
                        <div class="logo text-center mb-1" style="padding-top: 20px;">
                            <a href="/">@livewire('company-logo')</a>
                        </div>

                        <div class="d-flex justify-content-center m-4">
                            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Understood</button>
        </div> -->
                </div>
            </div>
        </div>

    </div>



    @livewireScripts
    <script>
        function myMenu() {
            document.getElementById("menu-popup").classList.toggle("displayBlock");
        }

        // function myMenuSmall() {
        //     document.getElementById("menu-small").classList.toggle("hideMinBar");
        //     document.getElementById("menu-popup").classList.toggle("showMinBar");
        // }

        function myMenuSmall() {
            var menuSmall = document.getElementById("menu-small");
            var menuPopup = document.getElementById("menu-popup");

            // Toggle the "hideMinBar" class
            menuSmall.classList.toggle("hideMinBar");
            menuPopup.classList.toggle("showMinBar");

            // Store the state in localStorage
            if (menuSmall.classList.contains("hideMinBar")) {
                localStorage.setItem("sidebarState", "hidden");
            } else {
                localStorage.setItem("sidebarState", "visible");
            }
        }

        // Retrieve the sidebar state on page load
        window.onload = function() {
            var sidebarState = localStorage.getItem("sidebarState");
            var menuSmall = document.getElementById("menu-small");
            var menuPopup = document.getElementById("menu-popup");

            // Set the sidebar state based on the stored value
            if (sidebarState === "hidden") {
                menuSmall.classList.add("hideMinBar");
                menuPopup.classList.add("showMinBar");
            }
        };


        function myMenuSmallHover() {
            document.getElementById("menu-small").classList.toggle("showMinBar");
            document.getElementById("menu-popup-hover").classList.toggle("hideMinBar");
        }

        if (localStorage.getItem("pageIcon") && localStorage.getItem("pageTitle")) {

            var storedIcon = localStorage.getItem("pageIcon");

            var storedTitle = localStorage.getItem("pageTitle");

            document.getElementById("pageIcon").innerHTML = storedIcon;

            document.getElementById("pageTitle").textContent = storedTitle;

        }

        function toggleLeaveDropdown(event) {
            event.stopPropagation();
            const leaveOptions = document.getElementById("leave-options");
            const leaveCaret = document.getElementById("leave-caret");

            if (leaveOptions.style.display === "block") {
                leaveOptions.style.display = "none";
                leaveCaret.classList.remove("fa-caret-up");
                leaveCaret.classList.add("fa-caret-down");
            } else {
                leaveOptions.style.display = "block";
                leaveCaret.classList.remove("fa-caret-down");
                leaveCaret.classList.add("fa-caret-up");
            }
        }

        function toggleLeaveDropdown2(event) {
            event.stopPropagation();
            const leaveOptions = document.getElementById("leave-options-2");
            const leaveCaret = document.getElementById("leave-caret-2");

            if (leaveOptions.style.display === "block") {
                leaveOptions.style.display = "none";
                leaveCaret.classList.remove("fa-caret-up");
                leaveCaret.classList.add("fa-caret-down");
            } else {
                leaveOptions.style.display = "block";
                leaveCaret.classList.remove("fa-caret-down");
                leaveCaret.classList.add("fa-caret-up");
            }
        }

        function toggleAttendanceDropdown() {
            const AttendanceOptions = document.getElementById("attendance-options");
            const AttendanceCaret = document.getElementById("attendance-caret");

            if (AttendanceOptions.style.display === "block") {
                AttendanceOptions.style.display = "none";
                AttendanceCaret.classList.remove("fa-caret-up");
                AttendanceCaret.classList.add("fa-caret-down");
            } else {
                AttendanceOptions.style.display = "block";
                AttendanceCaret.classList.remove("fa-caret-down");
                AttendanceCaret.classList.add("fa-caret-up");
            }
        }

        function toggleAttendanceDropdown2() {
            const AttendanceOptions = document.getElementById("attendance-options-2");
            const AttendanceCaret = document.getElementById("attendance-caret-2");

            if (AttendanceOptions.style.display === "block") {
                AttendanceOptions.style.display = "none";
                AttendanceCaret.classList.remove("fa-caret-up");
                AttendanceCaret.classList.add("fa-caret-down");
            } else {
                AttendanceOptions.style.display = "block";
                AttendanceCaret.classList.remove("fa-caret-down");
                AttendanceCaret.classList.add("fa-caret-up");
            }
        }

        function toggleSalaryDropdown() {
            const salaryOptions = document.getElementById("salary-options");
            const salaryCaret = document.getElementById("salary-caret");
            const leaveOptions = document.getElementById("leave-options");
            const leaveCaret = document.getElementById("leave-caret");

            if (salaryOptions.style.display === "block") {
                salaryOptions.style.display = "none";
                leaveOptions.style.display = "none";
                salaryCaret.classList.remove("fa-caret-up");
                salaryCaret.classList.add("fa-caret-down");
            } else {
                salaryOptions.style.display = "block";
                salaryCaret.classList.remove("fa-caret-down");
                salaryCaret.classList.add("fa-caret-up");
            }
        }

        function toggleSalaryDropdown2() {
            const salaryOptions = document.getElementById("salary-options-2");
            const salaryCaret = document.getElementById("salary-caret-2");
            const leaveOptions = document.getElementById("leave-options-2");
            const leaveCaret = document.getElementById("leave-caret-2");

            if (salaryOptions.style.display === "block") {
                salaryOptions.style.display = "none";
                leaveOptions.style.display = "none";
                salaryCaret.classList.remove("fa-caret-up");
                salaryCaret.classList.add("fa-caret-down");
            } else {
                salaryOptions.style.display = "block";
                salaryCaret.classList.remove("fa-caret-down");
                salaryCaret.classList.add("fa-caret-up");
            }
        }

        var todoDropdownClicked = false;

        function toggleToDoDropdown() {
            const todoOptions = document.getElementById("todo-options");
            const todoCaret = document.getElementById("todo-caret");
            const salaryOptions = document.getElementById("salary-options");
            const salaryCaret = document.getElementById("salary-caret");
            const leaveOptions = document.getElementById("leave-options");
            const leaveCaret = document.getElementById("leave-caret");

            // Check the status of other dropdowns and close them if open
            if (salaryOptions.style.display === "block") {
                salaryOptions.style.display = "none";
                salaryCaret.classList.remove("fa-caret-up");
                salaryCaret.classList.add("fa-caret-down");
            }

            if (leaveOptions.style.display === "block") {
                leaveOptions.style.display = "none";
                leaveCaret.classList.remove("fa-caret-up");
                leaveCaret.classList.add("fa-caret-down");
            }

            // Toggle the state of the current dropdown
            if (todoOptions.style.display === "block" && !todoDropdownClicked) {
                todoOptions.style.display = "none";
                todoCaret.classList.remove("fa-caret-up");
                todoCaret.classList.add("fa-caret-down");
            } else {
                todoOptions.style.display = "block";
                todoCaret.classList.remove("fa-caret-down");
                todoCaret.classList.add("fa-caret-up");
                todoDropdownClicked = false; // Reset the flag after toggling
            }
        }

        function toggleToDoDropdown2() {
            const todoOptions = document.getElementById("todo-options-2");
            const todoCaret = document.getElementById("todo-caret-2");
            const salaryOptions = document.getElementById("salary-options-2");
            const salaryCaret = document.getElementById("salary-caret-2");
            const leaveOptions = document.getElementById("leave-options-2");
            const leaveCaret = document.getElementById("leave-caret-2");

            // Check the status of other dropdowns and close them if open
            if (salaryOptions.style.display === "block") {
                salaryOptions.style.display = "none";
                salaryCaret.classList.remove("fa-caret-up");
                salaryCaret.classList.add("fa-caret-down");
            }

            if (leaveOptions.style.display === "block") {
                leaveOptions.style.display = "none";
                leaveCaret.classList.remove("fa-caret-up");
                leaveCaret.classList.add("fa-caret-down");
            }

            // Toggle the state of the current dropdown
            if (todoOptions.style.display === "block" && !todoDropdownClicked) {
                todoOptions.style.display = "none";
                todoCaret.classList.remove("fa-caret-up");
                todoCaret.classList.add("fa-caret-down");
            } else {
                todoOptions.style.display = "block";
                todoCaret.classList.remove("fa-caret-down");
                todoCaret.classList.add("fa-caret-up");
                todoDropdownClicked = false; // Reset the flag after toggling
            }
        }


        function selectOption(option, pageTitle) {
            const accordionItems = document.querySelectorAll('.nav-link');
            // Update the pageTitle
            updatePageTitle(pageTitle);
            // Close the dropdown if open
            toggleAttendanceDropdown();
            toggleLeaveDropdown();
            toggleSalaryDropdown();
        }

        function updatePageTitle(newTitle) {
            document.getElementById("pageTitle").textContent = newTitle;
            localStorage.setItem("pageTitle", newTitle);
        }

        // function setActiveLink(link) {
        //     // Remove active-link class from all links
        //     var links = document.querySelectorAll('.nav-link');
        //     links.forEach(function(el) {
        //         el.classList.remove('active-link');
        //     });

        //     // Add active-link class to the parent of the clicked link (li element)
        //     link.parentNode.classList.add('active-link');
        // }

        function setActiveLink(link, targetUrl) {
            var currentUrl = window.location.pathname;

            // Check if the target URL is the same as the current URL
            if (currentUrl !== targetUrl) {
                openModal();
                // Remove active class from all links
                var links = document.querySelectorAll('.nav-link');
                links.forEach(function(element) {
                    element.classList.remove('active');
                });

                // Add active class to the clicked link
                link.classList.add('active');

            } else {
                // If target URL is same as current URL, prevent modal opening
                event.preventDefault();
                console.log("Already on the same page.");
            }
        }

        function openModal() {
            var modal = new bootstrap.Modal(document.getElementById('navigateLoader'));
            modal.show();
        }



        // Check and set active link on page load
        document.addEventListener("DOMContentLoaded", function() {
            var currentPath = window.location.pathname;
            var links = document.querySelectorAll('.nav-link');

            links.forEach(function(link) {
                if (link.getAttribute("href") === currentPath) {
                    link.parentNode.classList.add('active-link');
                }
            });
        });


        var helpdeskDropdownClicked = false;

        function toggleHelpDeskDropdown() {
            const helpOptions = document.getElementById("help-options");
            const helpCaret = document.getElementById("help-caret");
            const salaryOptions = document.getElementById("salary-options");
            const salaryCaret = document.getElementById("salary-caret");
            const leaveOptions = document.getElementById("leave-options");
            const leaveCaret = document.getElementById("leave-caret");

            // Check the status of other dropdowns and close them if open
            if (salaryOptions.style.display === "block") {
                salaryOptions.style.display = "none";
                salaryCaret.classList.remove("fa-caret-up");
                salaryCaret.classList.add("fa-caret-down");
            }

            if (leaveOptions.style.display === "block") {
                leaveOptions.style.display = "none";
                leaveCaret.classList.remove("fa-caret-up");
                leaveCaret.classList.add("fa-caret-down");
            }

            // Toggle the state of the current dropdown
            if (helpOptions.style.display === "block" && !helpdeskDropdownClicked) {
                helpOptions.style.display = "none";
                helpCaret.classList.remove("fa-caret-up");
                helpCaret.classList.add("fa-caret-down");
            } else {
                helpOptions.style.display = "block";
                helpCaret.classList.remove("fa-caret-down");
                helpCaret.classList.add("fa-caret-up");
                helpdeskDropdownClicked = false; // Reset the flag after toggling
            }
        }

        function toggleHelpDeskDropdown2() {
            const helpOptions = document.getElementById("help-options");
            const helpCaret = document.getElementById("help-caret");
            const salaryOptions = document.getElementById("salary-options");
            const salaryCaret = document.getElementById("salary-caret");
            const leaveOptions = document.getElementById("leave-options");
            const leaveCaret = document.getElementById("leave-caret");

            // Check the status of other dropdowns and close them if open
            if (salaryOptions.style.display === "block") {
                salaryOptions.style.display = "none";
                salaryCaret.classList.remove("fa-caret-up");
                salaryCaret.classList.add("fa-caret-down");
            }

            if (leaveOptions.style.display === "block") {
                leaveOptions.style.display = "none";
                leaveCaret.classList.remove("fa-caret-up");
                leaveCaret.classList.add("fa-caret-down");
            }

            // Toggle the state of the current dropdown
            if (helpOptions.style.display === "block" && !helpdeskDropdownClicked) {
                helpOptions.style.display = "none";
                helpCaret.classList.remove("fa-caret-up");
                helpCaret.classList.add("fa-caret-down");
            } else {
                helpOptions.style.display = "block";
                helpCaret.classList.remove("fa-caret-down");
                helpCaret.classList.add("fa-caret-up");
                helpdeskDropdownClicked = false; // Reset the flag after toggling
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

@endguest

</html>