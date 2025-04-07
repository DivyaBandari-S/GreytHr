<?php

/*
 * File Name                       : EmployeeSwipesData.php
 * Description                     : This file contains the implementation of all the employees who swiped in today and we can get the swipe record of the employees before today's date.
 * Creator                         : Pranita Priyadarshi
 * Email                           : priyadarshipranita72@gmail.com
 * Organization                    : PayG.
 * Date                            : 2023-12-07
 * Framework                       : Laravel (10.10 Version)
 * Programming Language            : PHP (8.1 Version)
 * Database                        : MySQL
 * Models                          : SwipeRecord, EmployeeDetails
 */

namespace App\Livewire;

use App\Exports\SwipeDataExport;
use App\Helpers\FlashMessageHelper;
use App\Models\EmpDepartment;
use Illuminate\Support\Facades\Auth;
use App\Models\SwipeRecord;
use App\Models\EmployeeDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;
use Maatwebsite\Excel\Facades\Excel;
use PDO;
use Spatie\SimpleExcel\SimpleExcelWriter;

class EmployeeSwipesData extends Component
{
    public $employees;
    public $startDate;

    public $doorSwipeTime;
    public $accessCardDetails;
    public $endDate;




    public $isOpen = false;





    public $selectedWebEmployeeId;
    public $deviceId;
    public $selectedEmployeeId;

    public $selectedLocation;


    public $selectedDesignation;
    public $webSwipeDirection;
    public $swipeTime;
    public $employeeId;
    public $isPending = 0;

    public $selectedDepartment;
    public $isupdateFilter = 0;
    public $selectedCategory;

    public $todaySwipeRecords;
    public $selectedSwipeStatus;
    public $departmentId;
    public $webDeviceId;
    public $webDeviceName;
    public $isApply = 1;
    public $selectedShift;
    public $employeeShiftDetails;
    public $selectedSwipeTime;

    public $isManager;
    public $defaultApply = 1;
    public $search = '';
    public $searching = 0;
    public $selectedSwipeLogTime = [];
    public $swipeLogTime = null;
    public $status;

    public $city;
    public function mount()
    {
        try {
            $response = Http::get('http://ip-api.com/json');

            // Check if the response is successful
            if ($response->successful()) {
                $location = $response->json();

                // Update the Livewire component properties

                $this->city = $location['city'];
            } else {
                // Handle error (optional)
                FlashMessageHelper::flashError('Unable to get location.');
            }
            $today = now()->startOfDay();
            $authUser = Auth::user();
            $userId = $authUser->emp_id;

            $this->startDate = now()->toDateString();
            $managedEmployees = EmployeeDetails::where('manager_id', $userId)
                ->where('employee_status', 'active')
                ->join('company_shifts', function ($join) {
                    $join->on('employee_details.shift_type', '=', 'company_shifts.shift_name')
                        ->whereRaw('JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(company_shifts.company_id))');
                })
                ->select(
                    'employee_details.*',
                    'company_shifts.shift_start_time',
                    'company_shifts.shift_end_time'
                )
                ->get();

            // Check if the user swiped today
            $userSwipesToday = SwipeRecord::where('emp_id', $authUser->emp_id)
                ->where('created_at', '>=', $today)
                ->where('created_at', '<', $today->copy()->endOfDay())
                ->exists();

            $userAgent = request()->header('User-Agent');
            $this->status = $userSwipesToday
                ? (str_contains($userAgent, 'Mobile')
                    ? 'Mobile'
                    : (str_contains($userAgent, 'Windows') || str_contains($userAgent, 'Macintosh')
                        ? 'Desktop'
                        : '-'))
                : '-';
        } catch (\Exception $e) {
            Log::error('Error in mount method: ' . $e->getMessage());
            $this->status = 'Error';
        }
    }




    public function updateselectedDesignation()
    {
        $this->selectedDesignation = $this->selectedDesignation;
    }



    public function updateselectedSwipeStatus()
    {
        $this->selectedSwipeStatus = $this->selectedSwipeStatus;
    }
    public function resetSidebar()
    {
        if ($this->isApply == 1 && $this->defaultApply == 1) {

            $this->selectedDepartment = 'All';
            $this->selectedDesignation = 'All';
            $this->selectedLocation = 'Hyderabad';
        } elseif ($this->isPending == 1 && $this->defaultApply == 0) {

            $this->selectedDepartment = 'All';
            $this->selectedDesignation = 'All';
            $this->selectedLocation = 'Hyderabad';
            $this->selectedSwipeStatus='All';
        }
    }

    public function updateselectedDepartment()
    {
        $this->selectedDepartment = $this->selectedDepartment;
    }
    public function updateselectedLocation()
    {
        $this->selectedLocation = $this->selectedLocation;
    }
    public function viewDoorSwipeButton()
    {

        $this->isApply = 1;
        $this->isPending = 0;
        $this->defaultApply = 1;
        $this->swipeTime = null;
        $this->webSwipeDirection = null;
        $this->webDeviceName = null;
        $this->webDeviceId = null;

        $today = now()->toDateString();
        $authUser = Auth::user();
        $userId = $authUser->emp_id;

        // Log::info("Authenticated User: {$authUser->name} (ID: $userId)");

        $this->isManager = EmployeeDetails::where('manager_id', $userId)->exists();

        if ($this->isManager) {

            // Log::debug('Starting query for managed employees');

            $managedEmployees =  EmployeeDetails::where(function ($query) use ($userId) {
                $query->where('manager_id', $userId)
                    ->orWhere('emp_id', $userId);
            })
                ->where('employee_status', 'active');

            // Log the state of the query after initial conditions
            // Log::debug('Query after initial conditions:', ['query' => $managedEmployees->toSql()]);

            $managedEmployees = $managedEmployees->join('company_shifts', function ($join) {
                $join->on('employee_details.shift_type', '=', 'company_shifts.shift_name')
                    ->whereRaw('JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(company_shifts.company_id))');
            });

            // Log the state of the query after join
            // Log::debug('Query after join:', ['query' => $managedEmployees->toSql()]);

            if ($this->selectedDesignation && $this->isupdateFilter == 1) {

                $managedEmployees = $managedEmployees->when($this->selectedDesignation, function ($query) {
                    if ($this->selectedDesignation == 'software_engineer') {

                        return $query->whereIn('employee_details.job_role', ['Software Engineer I', 'Software Engineer II']);
                    } elseif ($this->selectedDesignation == 'senior_software_engineer') {

                        return $query->whereIn('employee_details.job_role', ['Software Engineer III', 'Senior Software Engineer']);
                    } elseif ($this->selectedDesignation == 'team_lead') {

                        return $query->where('employee_details.job_role',  'LIKE', '%Team Lead%');
                    } elseif ($this->selectedDesignation == 'sales_head') {

                        return $query->where('employee_details.job_role', 'LIKE', '%Sales Head%');
                    }
                });
            }
            if ($this->selectedLocation && $this->isupdateFilter == 1) {

                $managedEmployees = $managedEmployees->when($this->selectedLocation, function ($query) {
                    if ($this->selectedLocation == 'Remote') {

                        return $query->where('employee_details.job_mode', $this->selectedLocation);
                    } else {

                        $query->where('employee_details.job_location', $this->selectedLocation)
                            ->where('employee_details.job_mode', '!=', 'Remote');
                    }
                });
            }
            if (!empty($this->selectedDepartment) && $this->isupdateFilter == 1) {

                $this->departmentId = null;
                if ($this->selectedDepartment === 'information_technology') {
                    $this->departmentId = EmpDepartment::where('department', 'Information Technology')->value('dept_id');
                } elseif ($this->selectedDepartment === 'business_development') {
                    $this->departmentId = EmpDepartment::where('department', 'Business Development')->value('dept_id');
                } elseif ($this->selectedDepartment === 'operations') {
                    $this->departmentId = EmpDepartment::where('department', 'Operations')->value('dept_id');
                } elseif ($this->selectedDepartment === 'innovation') {
                    $this->departmentId = EmpDepartment::where('department', 'Innovation')->value('dept_id');
                } elseif ($this->selectedDepartment === 'infrastructure') {
                    $this->departmentId = EmpDepartment::where('department', 'Infrastructure')->value('dept_id');
                } elseif ($this->selectedDepartment === 'human_resources') {
                    $this->departmentId = EmpDepartment::where('department', 'Human Resource')->value('dept_id');
                }

                $managedEmployees = $managedEmployees->when($this->departmentId, function ($query) {


                    return $query->where('employee_details.dept_id', $this->departmentId);
                });
            }
            // Log the state of the query after applying designation filter
            // Log::debug('Query after designation filter:', ['query' => $managedEmployees->toSql()]);

            $managedEmployees = $managedEmployees->select(
                'employee_details.first_name',
                'employee_details.emp_id',
                'employee_details.last_name',
                'company_shifts.shift_start_time',
                'company_shifts.shift_end_time'
            );

            // Log the final query before execution
            // Log::debug('Final query before execution:', ['query' => $managedEmployees->toSql()]);

            $managedEmployees = $managedEmployees->get();

            // Log the final result
            // Log::debug('Final result:', ['managedEmployees' => $managedEmployees->toArray()]);
        } else {
            // Log::info('User is not a manager, retrieving self details');

            $managedEmployees = EmployeeDetails::where('emp_id', $userId)
                ->join('company_shifts', function ($join) {
                    $join->on('employee_details.shift_type', '=', 'company_shifts.shift_name')
                        ->whereRaw('JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(company_shifts.company_id))');
                })
                ->select(
                    'employee_details.first_name',
                    'employee_details.emp_id',
                    'employee_details.last_name',
                    'company_shifts.shift_start_time',
                    'company_shifts.shift_end_time'
                )
                ->get();

            // Log::info('Retrieved Self Employee Data:', ['data' => $managedEmployees->toArray()]);
        }

        $this->employees = $this->processSwipeLogs($managedEmployees, $this->startDate);
    }


    public function applyFilter()
    {
        $this->isupdateFilter = 1;
        $this->closeSidebar();
        
    }
    public function processWebSignInLogs()
    {

        $today = $this->startDate;
        $authUser = Auth::user();
        $userId = $authUser->emp_id;
        $webSignInData = [];
        // Check if the user is a manager
        $this->isManager = EmployeeDetails::where('manager_id', $userId)->exists();

        if ($this->isManager) {
            // Log::debug('Starting query for managed employees');

            $managedEmployees =  EmployeeDetails::where(function ($query) use ($userId) {
                $query->where('manager_id', $userId)
                    ->orWhere('emp_id', $userId);
            })
                ->where('employee_status', 'active');

            // Log the state of the query after initial conditions
            // Log::debug('Query after initial conditions:', ['query' => $managedEmployees->toSql()]);

            $managedEmployees = $managedEmployees->join('company_shifts', function ($join) {
                $join->on('employee_details.shift_type', '=', 'company_shifts.shift_name')
                    ->whereRaw('JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(company_shifts.company_id))');
            });

            // Log the state of the query after join

            if ($this->selectedDesignation && $this->isupdateFilter == 1) {

                $managedEmployees = $managedEmployees->when($this->selectedDesignation, function ($query) {
                    if ($this->selectedDesignation == 'software_engineer') {

                        return $query->whereIn('employee_details.job_role', ['Software Engineer I', 'Software Engineer II']);
                    } elseif ($this->selectedDesignation == 'senior_software_engineer') {

                        return $query->whereIn('employee_details.job_role', ['Software Engineer III', 'Senior Software Engineer']);
                    } elseif ($this->selectedDesignation == 'team_lead') {

                        return $query->where('employee_details.job_role',  'LIKE', '%Team Lead%');
                    } elseif ($this->selectedDesignation == 'sales_head') {

                        return $query->where('employee_details.job_role', 'LIKE', '%Sales Head%');
                    }
                });
                
            }
            if ($this->selectedLocation && $this->isupdateFilter == 1) {

                $managedEmployees = $managedEmployees->when($this->selectedLocation, function ($query) {
                    if ($this->selectedLocation == 'Remote') {

                        return $query->where('employee_details.job_mode', $this->selectedLocation);
                    } else {

                        $query->where('employee_details.job_location', $this->selectedLocation)
                            ->where('employee_details.job_mode', '!=', 'Remote');
                    }
                });
                
            }
            if (!empty($this->selectedDepartment) && $this->isupdateFilter == 1) {

                $this->departmentId = null;
                if ($this->selectedDepartment === 'information_technology') {
                    $this->departmentId = EmpDepartment::where('department', 'Information Technology')->value('dept_id');
                } elseif ($this->selectedDepartment === 'business_development') {
                    $this->departmentId = EmpDepartment::where('department', 'Business Development')->value('dept_id');
                } elseif ($this->selectedDepartment === 'operations') {
                    $this->departmentId = EmpDepartment::where('department', 'Operations')->value('dept_id');
                } elseif ($this->selectedDepartment === 'innovation') {
                    $this->departmentId = EmpDepartment::where('department', 'Innovation')->value('dept_id');
                } elseif ($this->selectedDepartment === 'infrastructure') {
                    $this->departmentId = EmpDepartment::where('department', 'Infrastructure')->value('dept_id');
                } elseif ($this->selectedDepartment === 'human_resources') {
                    $this->departmentId = EmpDepartment::where('department', 'Human Resource')->value('dept_id');
                }

                $managedEmployees = $managedEmployees->when($this->departmentId, function ($query) {


                    return $query->where('employee_details.dept_id', $this->departmentId);
                });
               
            }
            // Log the state of the query after applying designation filter
            // Log::debug('Query after designation filter:', ['query' => $managedEmployees->toSql()]);

            $managedEmployees = $managedEmployees->select(
                'employee_details.first_name',
                'employee_details.emp_id',
                'employee_details.last_name',
                'company_shifts.shift_start_time',
                'company_shifts.shift_end_time'
            );

            // Log the final query before execution
            // Log::debug('Final query before execution:', ['query' => $managedEmployees->toSql()]);

            $managedEmployees = $managedEmployees->get();

            // Log the final result
            // Log::debug('Final result:', ['managedEmployees' => $managedEmployees->toArray()]);
        } else {
            $managedEmployees = EmployeeDetails::where('emp_id', $userId)
                ->join('company_shifts', function ($join) {
                    $join->on('employee_details.shift_type', '=', 'company_shifts.shift_name')
                        ->whereRaw('JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(company_shifts.company_id))');
                })
                ->select(
                    'employee_details.*',
                    'company_shifts.shift_start_time',
                    'company_shifts.shift_end_time'
                )
                ->get();
        }

        if ($this->selectedSwipeStatus == 'mobile_sign_in') {

            $this->todaySwipeRecords = SwipeRecord::whereDate('created_at', $today)
                ->whereIn('emp_id', $managedEmployees->pluck('emp_id'))
                ->where('sign_in_device', 'Mobile')
                ->get();
        } elseif ($this->selectedSwipeStatus == 'web_sign_in') {

            $this->todaySwipeRecords = SwipeRecord::whereDate('created_at', $today)
                ->whereIn('emp_id', $managedEmployees->pluck('emp_id'))
                ->where('sign_in_device', 'Laptop/Desktop')
                ->get();
        } elseif ($this->selectedSwipeStatus == 'All') {

            $this->todaySwipeRecords = SwipeRecord::whereDate('created_at', $today)
                ->whereIn('emp_id', $managedEmployees->pluck('emp_id'))
                ->get();
        } else {
            $this->todaySwipeRecords = SwipeRecord::whereDate('created_at', $today)
                ->whereIn('emp_id', $managedEmployees->pluck('emp_id'))
                ->get();
        }
        // Fetch today's swipe records


        // Prepare Web Sign-in Data
        foreach ($managedEmployees as $employee) {
            $normalizedEmployeeId = $employee->emp_id;
            $employeeSwipeLog = $this->todaySwipeRecords->where('emp_id', $normalizedEmployeeId);

            if ($employeeSwipeLog->isNotEmpty()) {
                $webSignInData[] = [
                    'employee' => $employee,
                    'swipe_log' => $employeeSwipeLog,
                ];
            }
        }

        // **Apply Search Filter**
        if (!empty(trim($this->search))) {
            $webSignInData = array_filter($webSignInData, function ($data) {
                return stripos($data['employee']->first_name, $this->search) !== false ||
                    stripos($data['employee']->last_name, $this->search) !== false ||
                    stripos($data['employee']->emp_id, $this->search) !== false;
            });
        }
         
        return array_values($webSignInData);
    }

    public function viewWebsignInButton()
    {

        $this->isApply = 0;
        $this->isPending = 1;
        $this->defaultApply = 0;
        $this->accessCardDetails = null;
        $this->deviceId = null;
        $this->employees = $this->processWebSignInLogs();


        // Debugging: Log the output of processWebSignInLogs

    }

    public function handleEmployeeSelection()
    {
        $parts = explode('-', $this->selectedEmployeeId);
        $this->doorSwipeTime = $parts[3];
        $this->selectedEmployeeId = $parts[0] . '-' . $parts[1];

        $currentDate = Carbon::today();
        $month = $currentDate->format('n');
        $year = $currentDate->format('Y');
        $normalizedId = str_replace('-', '', $this->selectedEmployeeId);

        // Construct the table name for SQL Server
        $tableName = "DeviceLogs_{$month}_{$year}";


        // ✅ Local: Use Laravel's sqlsrv connection
        $this->accessCardDetails = DB::connection('sqlsrv')
            ->table($tableName)
            ->where('UserId', $normalizedId)
            ->value('UserId');

        $this->deviceId = DB::connection('sqlsrv')
            ->table($tableName)
            ->where('UserId', $normalizedId)
            ->value('DeviceId');
    }

    public function updateDate()
    {

        $this->startDate = $this->startDate;
    }

    public function handleEmployeeWebSelection()
    {

        // $this->selectedWebEmployeeId=$this->selectedWebEmployeeId;
        $parts = explode('-', $this->selectedWebEmployeeId);

        $this->selectedWebEmployeeId = $parts[0] . '-' . $parts[1];
        $this->swipeTime = $parts[3];
        $this->webSwipeDirection = $parts[4];
        $this->webDeviceName = SwipeRecord::where('emp_id', $this->selectedWebEmployeeId)->where('in_or_out', $this->webSwipeDirection)->where('swipe_time', $this->swipeTime)->whereDate('created_at', $this->startDate)->value('device_name');
        $this->webDeviceId = SwipeRecord::where('emp_id', $this->selectedWebEmployeeId)->where('in_or_out', $this->webSwipeDirection)->where('swipe_time', $this->swipeTime)->whereDate('created_at', $this->startDate)->value('device_id');

        // Construct the table name for SQL Server


        // $this->webDeviceId=  SwipeRecord::where('')

    }
    public function downloadFileforSwipes()
    {
        try {
            $today = now()->toDateString();
            $authUser = Auth::user();
            $userId = $authUser->emp_id;

            $managedEmployees = EmployeeDetails::where('manager_id', $userId)
                ->orWhere('emp_id', $userId)
                ->where('employee_status', 'active')
                ->get();

            $swipeData = [];

            if ($this->isApply == 1 && $this->isPending == 0 && $this->defaultApply == 1) {
                $title = 'First Door Swipe Data';
                $headerColumns = ['Employee ID', 'Employee Name', 'Swipe Date', 'Swipe Time', 'Direction'];
                $employeesInExcel = $this->processSwipeLogs($managedEmployees, $this->startDate);

                foreach ($employeesInExcel as $employee) {
                    foreach ($employee['swipe_log'] as $log) {
                        $swipeData[] = [
                            $employee['employee']->emp_id,
                            ucwords(strtolower($employee['employee']->first_name)) . ' ' . ucwords(strtolower($employee['employee']->last_name)),
                            Carbon::parse($log->logDate)->format('jS F Y'),
                            Carbon::parse($log->logDate)->format('H:i:s'),
                            $log->Direction,
                        ];
                    }
                }
            } elseif ($this->isApply == 0 && $this->isPending == 1 && $this->defaultApply == 0) {
                $title = 'Web Sign In Data';
                $headerColumns = ['Employee ID', 'Employee Name', 'Swipe Date', 'Swipe Time', 'Web Sign In Data'];
                $employeesInExcel = $this->processWebSignInLogs();

                foreach ($employeesInExcel as $employee) {
                    foreach ($employee['swipe_log'] as $log) {
                        $swipeData[] = [
                            $employee['employee']->emp_id,
                            ucwords(strtolower($employee['employee']->first_name)) . ' ' . ucwords(strtolower($employee['employee']->last_name)),
                            Carbon::parse($log->created_at)->format('jS F Y'),
                            Carbon::parse($log->swipe_time)->format('H:i:s'),
                            $log->in_or_out,
                        ];
                    }
                }
            }

            return Excel::download(new SwipeDataExport($swipeData, $title, $this->startDate), 'todays_present_employees.xlsx');
        } catch (\Exception $e) {
            Log::error('Error downloading file for swipes: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while downloading the file for swipes. Please try again.');
            return redirect()->back();
        }
    }

    public function updatedSelectedShift($value)
    {
        // This method will be called whenever the selected radio button changes
        // $value will contain the value of the selected shift ('GS', 'AS', or 'ES')

        // You can handle the selected value here

        $this->selectedShift = $value;
        // $this->formattedSelectedShift='General Shift';


    }
    public function toggleSidebar()
    {
        $this->isOpen = !$this->isOpen; // Toggle sidebar visibility
        $this->isupdateFilter=0;
        
    }

    public function closeSidebar()
    {
        $this->isOpen = false; // Ensure sidebar closes when called
       
       

    }
    public function searchEmployee()
    {
        $this->searching = 1;
    }

    public function updateselectedCategory()
    {
        $this->selectedCategory = $this->selectedCategory;
    }

    public function processSwipeLogs($managedEmployees, $today)
    {
        $filteredData  = [];
        $today = $this->startDate;
        $normalizedIds = $managedEmployees->pluck('emp_id')->map(fn($id) => str_replace('-', '', $id));
        $currentDate = Carbon::today();
        $month = $currentDate->format('n');
        $year = $currentDate->format('Y');
        $tableName = 'DeviceLogs_' . $month . '_' . $year;
        try {
            if (App::environment('production')) {
                // ✅ In Production: Use ODBC via FreeTDS directly
                $dsn = env('DB_ODBC_DSN') ?: 'odbc:Driver={FreeTDS};Server=59.144.92.154,1433;Database=eSSL;';
                $username = env('DB_ODBC_USERNAME') ?: 'essl';
                $password = env('DB_ODBC_PASSWORD') ?: 'essl';

                $pdo = new \PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);

                $sql = "SELECT UserId, logDate, CONVERT(VARCHAR(8), logDate, 108) AS logTime, Direction
                        FROM {$tableName}
                        WHERE CONVERT(DATE, logDate) = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$today]);
                $rows = array_map(fn($r) => (object) $r, $stmt->fetchAll(\PDO::FETCH_ASSOC));
                // Convert to Laravel collection and filter
                $externalSwipeLogs = collect($rows)->whereIn('UserId', $normalizedIds);
            } else {
                // ✅ In Local/Dev: Use Laravel SQLSRV connection
                if (DB::connection('sqlsrv')->getSchemaBuilder()->hasTable($tableName)) {
                    $externalSwipeLogs = DB::connection('sqlsrv')
                        ->table($tableName)
                        ->select('UserId', 'logDate', DB::raw("CONVERT(VARCHAR(8), logDate, 108) AS logTime"), 'Direction')
                        ->whereIn('UserId', $normalizedIds)
                        ->whereRaw("CONVERT(DATE, logDate) = ?", [$today])
                        ->orderBy('logTime')
                        ->get();
                } else {
                    $externalSwipeLogs = collect();
                }
            }
        } catch (\Exception $e) {
            Log::error("Swipe Logs Error: " . $e->getMessage());
            $externalSwipeLogs = collect();
        }

        // Match logs to employees
        foreach ($managedEmployees as $employee) {
            $normalizedEmployeeId = str_replace('-', '', $employee->emp_id);
            $employeeSwipeLog = $externalSwipeLogs->where('UserId', $normalizedEmployeeId);

            if ($employeeSwipeLog->isNotEmpty()) {
                $filteredData[] = [
                    'employee' => $employee,
                    'swipe_log' => $employeeSwipeLog,
                ];
            }
        }

        // Apply search filter if present
        if (!empty(trim($this->search))) {
            $filteredData = array_filter($filteredData, function ($data) {
                return stripos($data['employee']->first_name, $this->search) !== false ||
                    stripos($data['employee']->last_name, $this->search) !== false ||
                    stripos($data['employee']->emp_id, $this->search) !== false;
            });
        }

        return array_values($filteredData);
    }







    public function render()
    {
        if ($this->isApply == 1 && $this->isPending == 0 && $this->defaultApply == 1) {
            $this->viewDoorSwipeButton();
        } elseif ($this->isApply == 0 && $this->isPending == 1 && $this->defaultApply == 0) {
            $this->viewWebsignInButton();
        }

        // Determine the SignedInEmployees based on conditions




        return view('livewire.employee-swipes-data', [
            'SignedInEmployees' => $this->employees,

        ]);
    }
}
