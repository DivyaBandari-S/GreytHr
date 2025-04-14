<?php

namespace App\Livewire;

use App\Exports\DoorSwipeExport;
use App\Exports\WebSignInExport;
use App\Models\EmployeeDetails;
use App\Models\SwipeRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PDO;

class SwipeDataReport extends Component
{
    public $filteredEmployees;

    public $selectAll=[];
    public $selectDate;
    public $todaySwipeRecords;
    public $startDate;
    public $employees;

    public $notFound;
    public $search;
    public $searching = 0;

    public $isApply = 1;

    public $isPending = 0;

    public $swipeData = [];
    public $defaultApply = 1;

    public function mount()
    {
        $this->selectDate=Carbon::now()->format('Y-m-d');
    }
    public function viewDoorSwipeButton()
    {
        $this->selectAll=[];
        $this->isApply = 1;
        $this->isPending = 0;
        $this->defaultApply = 1;
        $this->employees=$this->processSwipeLogs();
        $this->swipeData=[];
       
    }

    public function updateSelectAll()
    {
       $this->swipeData = EmployeeDetails::pluck('emp_id')->toArray();
    //    dd($this->swipeData);
    }
    public function searchEmployee()
    {
        $this->searching = 1;
        $this->swipeData=[];
    }

    public function updateselectDate()
    {
        

        $this->selectDate=$this->selectDate;
    }
    public function resetFields()
    {
        $this->swipeData=[];
        $this->selectAll=[];
        $this->selectDate=Carbon::now()->format('Ý-m-d');
    }
    

    public function processSwipeLogs()
    {
        $filteredData  = [];
       
        $today = $this->selectDate;
        $managedEmployees =  EmployeeDetails:: 
                whereIn('emp_id', $this->swipeData);
           
            
            // Log the state of the query after initial conditions
            // Log::debug('Query after initial conditions:', ['query' => $managedEmployees->toSql()]);

            $managedEmployees = $managedEmployees->join('company_shifts', function ($join) {
                $join->on('employee_details.shift_type', '=', 'company_shifts.shift_name')
                    ->whereRaw('JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(company_shifts.company_id))');
            });
        
         
            
          
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
    public function processWebSignInLogs()
    {

        $today = $this->selectDate;
        $authUser = Auth::user();
        $userId = $authUser->emp_id;
        $webSignInData = [];
        // Check if the user is a manager
        // $isManager = EmployeeDetails::where('manager_id', $userId)->exists();

        
            // Log::debug('Starting query for managed employees');

            $managedEmployees =  EmployeeDetails:: 
                whereIn('emp_id', $this->swipeData);
           
            
            // Log the state of the query after initial conditions
            // Log::debug('Query after initial conditions:', ['query' => $managedEmployees->toSql()]);

            $managedEmployees = $managedEmployees->join('company_shifts', function ($join) {
                $join->on('employee_details.shift_type', '=', 'company_shifts.shift_name')
                    ->whereRaw('JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(company_shifts.company_id))');
            });
        
         
            
          
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
            
            $this->todaySwipeRecords = SwipeRecord::whereDate('created_at', $today)
                ->whereIn('emp_id', $managedEmployees->pluck('emp_id'))
                ->get();
                
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

    public function exportWebSignInData()
{
   
    

    if($this->isApply == 1 && $this->defaultApply == 1)
    {   
       
        $doorSignInData = $this->processSwipeLogs(); 
    }
    elseif($this->isPending == 1 && $this->defaultApply == 0)
    {
     
        $webSignInData = $this->processWebSignInLogs(); 
    }
    
    if($this->isApply == 1 && $this->defaultApply == 1)
    {
        $fileName = 'DoorSignInData_' . Carbon::now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new  DoorSwipeExport($doorSignInData), $fileName);
     
    }
    elseif($this->isPending == 1 && $this->defaultApply == 0)
    {
        $fileName = 'WebSignInData_' . Carbon::now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new  WebSignInExport($webSignInData), $fileName);
      
    }
    
}
    public function viewWebsignInButton()
    {
        $this->selectAll=[];
        $this->isApply = 0;
        $this->isPending = 1;
        $this->defaultApply = 0;
        $this->employees = $this->processWebSignInLogs();
        $this->swipeData=[];
    }
    
    public function render()
    {
        try
        {
            $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $this->employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name','employee_status')->orderBy('first_name')->get();
        if ($this->searching == 1) {
            $nameFilter = $this->search; // Assuming $this->search contains the name filter
            $this->filteredEmployees = $this->employees->filter(function ($employee) use ($nameFilter) {
                return stripos($employee->first_name, $nameFilter) !== false ||
                    stripos($employee->last_name, $nameFilter) !== false ||
                    stripos($employee->emp_id, $nameFilter) !== false ||
                    stripos($employee->job_title, $nameFilter) !== false ||
                    stripos($employee->city, $nameFilter) !== false ||
                    stripos($employee->state, $nameFilter) !== false;
            });

            if ($this->filteredEmployees->isEmpty()) {
                $this->notFound = true; // Set a flag indicating that the name was not found
            } else {
                $this->notFound = false;
            }
        } else {
            $this->filteredEmployees = $this->employees;
        }
 
        }catch (\Exception $e) {
            // Handle the exception (e.g., log the error, set an error message, etc.)
            $this->notFound = true; // or set another flag indicating an error occurred
            // Log the exception message or handle it as per your application requirements
            Log::error('Error fetching employee details: ' . $e->getMessage());
        }
        return view('livewire.swipe-data-report');
    }
}
