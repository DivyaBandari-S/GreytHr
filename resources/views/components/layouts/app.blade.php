<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    @guest
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/fav.jpeg') }}">
    <title>
        hr xpert
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

    $needsFlattening = false;
    foreach ($companyIds as $item) {
    if (is_array($item)) {
    $needsFlattening = true;
    break;
    }
    }

    if ($needsFlattening) {
    // If there's nesting, flatten the array
    $flattenedArray = array_merge(...$companyIds);
    } else {
    // Otherwise, use the array as-is
    $flattenedArray = $companyIds;
    }
    if ($companyIds) {
    // Now perform the join with companies table
    if (count($flattenedArray) <= 1) {
        $employee=DB::table('companies')
        ->whereIn('company_id', $companyIds)
        ->select('companies.company_logo', 'companies.company_name')
        ->first();
        } else {
        $employee = DB::table('companies')
        ->whereIn('company_id', $companyIds)
        ->where('is_parent', 'yes')
        ->select('companies.company_logo', 'companies.company_name')
        ->first();
        }
        }

        @endphp
        <link rel="icon" type="image/x-icon" href="{{ asset('/images/fav.jpeg') }}">
        <title>
            hr xpert
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Toastr CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        @livewireStyles
</head>

<body>
    @guest
    {{ $slot }}
    @else
    <section>
        @livewire('main-layout')
        <main id="maincontent" style="overflow: auto; height: calc(100vh - 65px);">
            <div style="flex-grow: 1;">
                {{ $slot }}
            </div>
            <footer class="d-flexjustify-content-center ">
                <div class="text-center mt-2 pb-2">

                    <small>

                        <a href="/Privacy&Policy" class="privacyPolicy" target="_blank" style="color: rgb(2, 17, 79);">

                            Privacy Policy

                        </a> |

                        <a href="/Terms&Services" class="privacyPolicy" target="_blank" style="color: rgb(2, 17, 79);">

                            Terms of Service

                        </a>

                    </small>

                </div>
            </footer>
        </main>
    </section>
    @endguest

    <script src="https://cdn.tiny.cloud/1/u1aepzhsc1d6jlmrcth6txww7x7eru2qmcgmsdgj4pr2rhkm/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
    <script src="https://cdn.ckeditor.com/4.25.0-lts/standard/ckeditor.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="{{ asset('js/admin-dash.js?v=' . filemtime(public_path('js/admin-dash.js'))) }}"></script>
    <!-- Include TinyMCE from CDN -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @livewireScripts
</body>

</html>
