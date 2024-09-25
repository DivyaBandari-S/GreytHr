<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @guest
    <link rel="icon" type="image/x-icon" href="{{ asset('public/images/hr_expert.png') }}">
    <title>
        HR Strategies Pro
    </title>
    @endguest
    @auth('emp')
    @php
    // Get the logged-in employee ID
    $employeeId = auth()->guard('emp')->user()->emp_id;

    // Retrieve the employee details including the company_id
    $employeeDetails = DB::table('employee_details')
    ->where('emp_id', $employeeId)
    ->select('company_id') // Select only the company_id
    ->first();
    // Decode the company_id from employee_details
    $companyIds = json_decode($employeeDetails->company_id);
    if ($companyIds) {
    // Now perform the join with companies table
    $employee = DB::table('companies')
    ->whereIn('company_id', $companyIds)
    ->where('is_parent', 'yes')
    ->select('companies.company_logo', 'companies.company_name')
    ->first();
    }


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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/employee.css?v=' . filemtime(public_path('css/employee.css'))) }}">
    <link rel="stylesheet" href="{{ asset('css/app.css?v=' . filemtime(public_path('css/app.css'))) }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @livewireStyles
</head>

<body>
    @guest
    {{$slot}}
    @else
    <section>
        @livewire('main-layout')
        <main id="maincontent" style="overflow: auto; height: calc(100vh - 100px);">
            {{ $slot }}
        </main>
    </section>
    @endguest
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('js/admin-dash.js?v=' . filemtime(public_path('js/admin-dash.js'))) }}"></script>
    <!-- Custom Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script> -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('js/get-location.js') }}?v={{ time() }}"></script>
    @livewireScripts
</body>

</html>