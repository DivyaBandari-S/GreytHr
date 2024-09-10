<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @guest
        @livewireStyles
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
        @endphp
        <link rel="icon" type="image/x-icon" href="{{ asset($employee->company_logo) }}">
        <title>
            {{ $employee->company_name }}
        </title>
    @endauth
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
         crossorigin="anonymous">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous"> -->
    <!-- Date range picker links -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/employee.css?v=' . filemtime(public_path('css/employee.css'))) }}">
    <link rel="stylesheet" href="{{ asset('css/app.css?v=' . filemtime(public_path('css/app.css'))) }}">
</head>

<body>
    @guest
        <livewire:emplogin />
    @else
    <section>
        @livewire('main-layout')
        <main id="maincontent" style="overflow-x: hidden; height: calc(100vh - 65px);">
            {{ $slot }}
        </main>
    </section>
    @endguest
    @livewireScripts
    <script src="{{ asset('js/admin-dash.js?v=' . filemtime(public_path('js/admin-dash.js'))) }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script> -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</body>

</html>
