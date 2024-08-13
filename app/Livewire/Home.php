<?php
// <!--
// File Name                       : Home.php
// Description                     : This file is Landing page for employee, we can navigate desired modules as per requirement.....,
// Creator                         : Bandari Divya,Sri Kumar Manikanta Asapu,Pranita Priyadarshi, A Archana
// Email                           : bandaridivya1@gmail.com,
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL, Sql Server
// Models                          : EmployeeDetails,Company,LeaveRequest,SwipeRecord,SwipeData ,SalaryRevision,HolidayCalendar-->

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\LeaveRequest;
use App\Models\SwipeRecord;
use App\Models\SwipeData;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\HolidayCalendar;
use App\Models\RegularisationDates;
use App\Models\SalaryRevision;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use Throwable;

class Home extends Component
{
    public $currentDate;
    public $swipes;
    public $showSalary = false;
    public $currentDay;
    public $absent_employees_count;
    public $showAlertDialog = false;
    public $signIn = true;
    public $swipeDetails;
    public $calendarData;
    public $employeeDetails;
    public $employee;
    public $salaries;
    public $count;
    public $initials;
    public $applying_to = [];
    public $matchingLeaveApplications = [];
    public $upcomingLeaveApplications;
    public $leaveRequest;
    public $salaryRevision;
    public $pieChartData;
    public $absent_employees;

    public $showAllAbsentEmployees = false;

    public $showAllLateEmployees = false;

    public $employee_details;
    public $showAllEarlyEmployees=false;
    public $grossPay;
    public $deductions;
    public $netPay;
    public $leaveRequests;
    public $showLeaveApplies;
    public $greetingImage;

    public $showReviewLeaveAndAttendance = false;

    public $countofregularisations;

    public $employeeShiftDetails;
    public $regularisations;
    public $greetingText;
    public $teamOnLeave;
    public $leaveApplied;
    public  $teamOnLeaveRequests;
    public  $teamCount = 0;
    public  $upcomingLeaveRequests;
    public $holidayCount = 0;
    public $empIdWithoutHyphens;
    public $matchedData = [];
    public $swipedDataRecords, $loginEmployee;
    public $showMessage = true;
    public $showAlert = false;
    public $swipeDataOfEmployee;
    public function mount()
    {
        // Get the current month and year
        // $currentDate = Carbon::today();
        // $today = $currentDate->toDateString(); // Get today's date in 'Y-m-d' format
        // $month = $currentDate->format('n');
        // $year = $currentDate->format('Y');

        // // Construct the table name for SQL Server
        // $tableName = 'DeviceLogs_' . $month . '_' . $year;

        // // Get data from SQL Server
        // $dataSqlServer = DB::connection('sqlsrv')
        //     ->table($tableName)
        //     ->select('UserId', 'logDate', 'Direction')
        //     ->whereDate('logDate', $today) // Filter for today's date
        //     ->orderBy('logDate')
        //     ->get();
        // // dd($dataSqlServer);

        // // Get data from MySQL
        // $dataMySql = DB::connection('mysql')
        //     ->table('employee_details')
        //     ->pluck('emp_id');2
        // $mysqlEmployeeIds = $dataMySql->toArray();

        // // Process and match the data from both databases
        // foreach ($dataSqlServer as $sqlData) {
        //     foreach ($mysqlEmployeeIds as $mysqlData) {
        //         // Remove hyphens from emp_id in MySQL
        //         $empIdWithoutHyphens = str_replace('-', '', $mysqlData);

        //         // Compare emp_id from MySQL with UserId from SQL Server
        //         if ($sqlData->UserId === $empIdWithoutHyphens) {
        //             $matchedData[] = [
        //                 'UserId' => $sqlData->UserId,
        //                 'logDate' => $sqlData->logDate,
        //                 'Direction' => $sqlData->Direction,
        //             ];
        //         }
        //     }
        // }
        // $this->swipedDataRecords = $matchedData;
        // // dd($this->swipedDataRecords);
        // foreach ($this->swipedDataRecords as $data) {
        //     // Check if a record with the same emp_id, direction, and DownloadDate already exists
        //     $existingRecord = SwipeData::where('emp_id', $data['UserId'])
        //         ->where('direction', $data['Direction'])
        //         ->whereDate('DownloadDate', $data['logDate'])
        //         ->exists();

        //     // If the record does not exist, create a new SwipeData record
        //     if (!$existingRecord) {
        //         SwipeData::create([
        //             'emp_id' => $data['UserId'],
        //             'direction' => $data['Direction'],
        //             'DownloadDate' => $data['logDate']
        //         ]);
        //     }
        // }

        // //SwipeData for loginEmployees
        // $currentDate = Carbon::today()->toDateString(); // Get today's date
        // $employeeId = str_replace('-', '', auth()->guard('emp')->user()->emp_id);
        // $this->swipeDataOfEmployee = SwipeData::where('emp_id', $employeeId)
        //     ->whereDate('DownloadDate', $currentDate)
        //     ->get();

        $currentHour = date('G');
     
        if ($currentHour >= 4 && $currentHour < 12) {
            $this->greetingImage = 'morning.jpeg';
            $this->greetingText = 'Good Morning';
        } elseif ($currentHour >= 12 && $currentHour < 16) {
            $this->greetingImage = 'afternoon.jpeg';
            $this->greetingText = 'Good Afternoon';
        } elseif ($currentHour >= 16 && $currentHour < 20) {
            $this->greetingImage = 'evening.jpeg';
            $this->greetingText = 'Good Evening';
        } else {
            $this->greetingImage = 'night.jpeg';
            $this->greetingText = 'Good Night';
        }
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->loginEmployee = EmployeeDetails::where('emp_id', $employeeId)->select('emp_id', 'first_name', 'last_name')->first();
        $employees = EmployeeDetails::where('manager_id', $employeeId)->select('emp_id', 'first_name', 'last_name')->get();
        $empIds = $employees->pluck('emp_id')->toArray();
        $this->regularisations = RegularisationDates::whereIn('emp_id', $empIds)
            ->where('is_withdraw', 0) // Assuming you want records with is_withdraw set to 0
            ->where('status', 'pending')
            ->selectRaw('*, JSON_LENGTH(regularisation_entries) AS regularisation_entries_count')
            ->whereRaw('JSON_LENGTH(regularisation_entries) > 0')
            ->with('employee')
            ->get();

        $this->countofregularisations = RegularisationDates::whereIn('emp_id', $empIds)
            ->where('is_withdraw', 0) // Assuming you want records with is_withdraw set to 0
            ->where('status', 'pending')
            ->selectRaw('*, JSON_LENGTH(regularisation_entries) AS regularisation_entries_count')
            ->whereRaw('JSON_LENGTH(regularisation_entries) > 0')
            ->with('employee')
            ->count();
    }
    public function reviewLeaveAndAttendance()
    {
        $this->showReviewLeaveAndAttendance = true;
    }
    public function closereviewLeaveAndAttendance()
    {
        $this->showReviewLeaveAndAttendance = false;
    }
    public function hideMessage()
    {
        $this->showMessage = false;
    }
    public function hideAlert(){
        $this->showAlert = false;
    }
    public function openLateEmployees()
    {
        $this->showAllLateEmployees = true;
    }
    public function closeAllAbsentEmployees()
    {
        $this->showAllAbsentEmployees = false;
    }
    public function open()
    {
        $this->showAlertDialog = true;
    }

    public function close()
    {
        $this->showAlertDialog = false;
    }
    public function toggleSalary()
    {
        $this->showSalary = !$this->showSalary;
    }
    public function determineSwipeDevice()
    {
        try {
            $agent = new Agent();

            if ($agent->isDesktop()) {
                return 'desktop';
            } else {
                return 'mobile';
            }
        } catch (Throwable $e) {
            return 'unknown'; // Return a default value or handle the error gracefully
        }
    }

    public function toggleSignState()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
            $this->signIn = !$this->signIn;
            $swipeDevice = $this->determineSwipeDevice();
            SwipeRecord::create([
                'emp_id' => $this->employeeDetails->emp_id,
                'swipe_time' => now()->format('H:i:s'),
                'in_or_out' => $this->swipes
                    ? ($this->swipes->in_or_out == "IN" ? "OUT" : "IN")
                    : 'IN',
                'sign_in_device' => $swipeDevice,
            ]);

            $flashMessage = $this->swipes
                ? ($this->swipes->in_or_out == "IN" ? "OUT" : "IN")
                : 'IN';

            $message = $flashMessage == "IN"
                ? "You have successfully signed in."
                : "You have successfully signed out.";

            session()->flash('success', $message);
            $this->showAlert = true;
        } catch (Throwable $e) {
            // Log or handle the exception as needed
            session()->flash('error', 'An error occurred while toggling sign state. Please try again later.');
        }
    }
    public function showEarlyEmployees()
    {
        $this->showAllEarlyEmployees = true;
    }
    public function closeAllEarlyEmployees()
    {
        $this->showAllEarlyEmployees = false;
    }
    public function openAbsentEmployees()
    {
        $this->showAllAbsentEmployees = true;
    }
    public function closeAllLateEmployees()
    {
        $this->showAllLateEmployees = false;
    }
    public function render()
    {
        try {
            $loggedInEmpId = Session::get('emp_id');
            // Check if the logged-in user is a manager by comparing emp_id with manager_id in employeedetails
            $isManager = EmployeeDetails::where('manager_id', $loggedInEmpId)->exists();

            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeShiftDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
            $this->currentDay = now()->format('l');
            $this->currentDate = now()->format('d M Y');
            $today = Carbon::now()->format('Y-m-d');
            $this->leaveRequests = LeaveRequest::with('employee')
                ->where('status', 'pending')
                ->get();
            $matchingLeaveApplications = [];

            foreach ($this->leaveRequests as $leaveRequest) {
                $applyingToJson = trim($leaveRequest->applying_to);
                $applyingArray = is_array($applyingToJson) ? $applyingToJson : json_decode($applyingToJson, true);

                $ccToJson = trim($leaveRequest->cc_to);
                $ccArray = is_array($ccToJson) ? $ccToJson : json_decode($ccToJson, true);

                $isManagerInApplyingTo = isset($applyingArray[0]['manager_id']) && $applyingArray[0]['manager_id'] == $employeeId;
                $isEmpInCcTo = isset($ccArray[0]['emp_id']) && $ccArray[0]['emp_id'] == $employeeId;
                if (!empty($ccArray) && !empty($applyingArray)) {
                    // Process when both cc_to and applying_to are present
                    foreach ($ccArray as $ccItem) {
                        if (isset($ccItem['emp_id']) && $ccItem['emp_id'] === auth()->guard('emp')->user()->emp_id) {
                            $matchingLeaveApplications[] = [
                                'leaveRequest' => $leaveRequest,
                                'empId' => $ccItem['emp_id']
                            ];
                            break; // Stop iterating if emp_id matches
                        }
                    }
                    // Check for applying_to conditions
                    foreach ($applyingArray as $applyingItem) {
                        if (isset($applyingItem['manager_id']) && $applyingItem['manager_id'] === auth()->guard('emp')->user()->emp_id) {
                            $matchingLeaveApplications[] = [
                                'leaveRequest' => $leaveRequest,
                                'managerId' => $applyingItem['manager_id']
                            ];
                            break; // Stop iterating if manager_id matches
                        }
                    }
                } elseif (!empty($applyingArray)) {
                    // Process when only applying_to is present
                    foreach ($applyingArray as $applyingItem) {
                        if (isset($applyingItem['manager_id']) && $applyingItem['manager_id'] === auth()->guard('emp')->user()->emp_id) {
                            $matchingLeaveApplications[] = [
                                'leaveRequest' => $leaveRequest,
                                'managerId' => $applyingItem['manager_id']
                            ];
                            break; // Stop iterating if manager_id matches
                        }
                    }
                } elseif (!empty($ccArray)) {
                    // Process when only cc_to is present
                    foreach ($ccArray as $ccItem) {
                        if (isset($ccItem['emp_id']) && $ccItem['emp_id'] === auth()->guard('emp')->user()->emp_id) {
                            $matchingLeaveApplications[] = [
                                'leaveRequest' => $leaveRequest,
                                'empId' => $ccItem['emp_id']
                            ];
                            break; // Stop iterating if emp_id matches
                        }
                    }
                }
            }

            // Get the count of matching leave applications
            $this->leaveApplied = $matchingLeaveApplications;

            $this->count = count($matchingLeaveApplications);

            //team on leave
            $currentDate = Carbon::today();
            $this->teamOnLeaveRequests = LeaveRequest::with('employee')
                ->where('status', 'approved')
                ->where(function ($query) use ($currentDate) {
                    $query->whereDate('from_date', '=', $currentDate)
                        ->orWhereDate('to_date', '=', $currentDate);
                })
                ->get();
            $teamOnLeaveApplications = [];
            foreach ($this->teamOnLeaveRequests as $teamOnLeaveRequest) {
                $applyingToJson = trim($teamOnLeaveRequest->applying_to);
                $applyingArray = is_array($applyingToJson) ? $applyingToJson : json_decode($applyingToJson, true);

                $ccToJson = trim($teamOnLeaveRequest->cc_to);
                $ccArray = is_array($ccToJson) ? $ccToJson : json_decode($ccToJson, true);

                $isManagerInApplyingTo = isset($applyingArray[0]['manager_id']) && $applyingArray[0]['manager_id'] == $employeeId;
                $isEmpInCcTo = isset($ccArray[0]['emp_id']) && $ccArray[0]['emp_id'] == $employeeId;

                if ($isManagerInApplyingTo || $isEmpInCcTo) {
                    $teamOnLeaveApplications[] = $teamOnLeaveRequest;
                }
            }
            $this->teamOnLeave = $teamOnLeaveApplications;

            // Get the count of  leave applications
            $this->teamCount = count($teamOnLeaveApplications);

            $currentDate = Carbon::today();
            $this->upcomingLeaveRequests = LeaveRequest::with('employee')
                ->where('status', 'approved')
                ->where(function ($query) use ($currentDate) {
                    $query->whereMonth('from_date', Carbon::now()->month); // Filter for the current month
                })
                ->orderBy('created_at', 'desc')
                ->get();
            //Process each leave request to add initials and random color
            // foreach ($this->upcomingLeaveRequests as $request) {
            //     $employee = $request->employee;
            //     if ($employee) {
            //         $initialsForThisMonth = strtoupper(substr($employee->first_name, 0, 1) . substr($employee->last_name, 0, 1));
            //        // $randomLeaveColor = '#' . str_pad(dechex(mt_rand(0xC0C0C0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT); // Generate random color
            //         // $request->initials = $initialsForThisMonth;
            //         //$request->randomColor = $randomLeaveColor;
            //     }
            // }
            $this->upcomingLeaveApplications = count($this->upcomingLeaveRequests);

            //attendance related query
            $this->absent_employees = EmployeeDetails::where('manager_id', $loggedInEmpId)
                ->select('emp_id', 'first_name', 'last_name')
                ->whereNotIn('emp_id', function ($query) {
                    $query->select('emp_id')
                        ->from('swipe_records')
                        ->whereDate('created_at', today());
                })
                ->whereNotIn('emp_id', function ($query) {
                    $query->select('emp_id')
                        ->from('leave_applications')
                        ->whereDate('from_date', '>=', today())
                        ->whereDate('to_date', '<=', today());
                })
                ->get();
            $arrayofabsentemployees = $this->absent_employees->toArray();

            $this->absent_employees_count = EmployeeDetails::where('manager_id', $loggedInEmpId)
                ->select('emp_id', 'first_name', 'last_name')
                ->whereNotIn('emp_id', function ($query) {
                    $query->select('emp_id')
                        ->from('swipe_records')
                        ->whereDate('created_at', today());
                })
                ->whereNotIn('emp_id', function ($query) {
                    $query->select('emp_id')
                        ->from('leave_applications')
                        ->whereDate('from_date', '>=', today())
                        ->whereDate('to_date', '<=', today());
                })
                ->where('employee_status', 'active')
                ->count();

            $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();
            $approvedLeaveRequests = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
                ->where('leave_applications.status', 'approved')
                ->whereIn('leave_applications.emp_id', $employees->pluck('emp_id'))
                ->whereDate('from_date', '<=', $currentDate)
                ->whereDate('to_date', '>=', $currentDate)
                ->get(['leave_applications.*', 'employee_details.first_name', 'employee_details.last_name'])
                ->map(function ($leaveRequest) {
                    // Calculate the number of days between from_date and to_date
                    $fromDate = Carbon::parse($leaveRequest->from_date);
                    $toDate = Carbon::parse($leaveRequest->to_date);

                    $leaveRequest->number_of_days = $fromDate->diffInDays($toDate) + 1; // Add 1 to include both start and end dates

                    return $leaveRequest;
                });
            $this->absent_employees = EmployeeDetails::where('manager_id', $loggedInEmpId)
                ->select('emp_id', 'first_name', 'last_name')
                ->whereNotIn('emp_id', function ($query) use ($loggedInEmpId, $currentDate, $approvedLeaveRequests) {
                    $query->select('emp_id')
                        ->from('swipe_records')
                        ->where('manager_id', $loggedInEmpId)
                        ->whereDate('created_at', $currentDate);
                })
                ->whereNotIn('emp_id', $approvedLeaveRequests->pluck('emp_id'))
                ->where('employee_status', 'active')
                ->get();

            $arrayofabsentemployees = $this->absent_employees->toArray();

            $this->absent_employees_count = EmployeeDetails::where('manager_id', $loggedInEmpId)
                ->select('emp_id', 'first_name', 'last_name')
                ->whereNotIn('emp_id', function ($query) use ($loggedInEmpId, $currentDate, $approvedLeaveRequests) {
                    $query->select('emp_id')
                        ->from('swipe_records')
                        ->where('manager_id', $loggedInEmpId)
                        ->whereDate('created_at', $currentDate);
                })
                ->whereNotIn('emp_id', $approvedLeaveRequests->pluck('emp_id'))
                ->where('employee_status', 'active')
                ->count();
            $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();
            $swipes_early = SwipeRecord::whereIn('id', function ($query) use ($employees, $currentDate, $approvedLeaveRequests) {
                $query->selectRaw('MIN(id)')
                    ->from('swipe_records')
                    ->whereIn('emp_id', $employees->pluck('emp_id'))
                    ->whereNotIn('emp_id', $approvedLeaveRequests->pluck('emp_id'))
                    ->whereDate('created_at', $currentDate)
                    ->whereRaw("swipe_time < employee_details.shift_start_time") // Add this condition to filter swipes before 10:00 AM
                    ->groupBy('emp_id');
            })
                ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
                ->select('swipe_records.*', 'employee_details.first_name', 'employee_details.last_name')
                ->where('employee_details.employee_status', 'active')
                ->get();

            $swipes_early1 = $swipes_early->count();

            $swipes_late = SwipeRecord::whereIn('id', function ($query) use ($employees, $currentDate, $approvedLeaveRequests) {
                $query->selectRaw('MIN(id)')
                    ->from('swipe_records')
                    ->where('in_or_out', 'IN')
                    ->whereIn('emp_id', $employees->pluck('emp_id'))
                    ->whereNotIn('emp_id', $approvedLeaveRequests->pluck('emp_id'))
                    ->whereDate('created_at', $currentDate)
                    ->whereRaw("swipe_time > TIME(employee_details.shift_start_time)") // Add this condition to filter swipes before 10:00 AM
                    ->groupBy('emp_id');
            })
                ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
                ->select('swipe_records.*', 'employee_details.first_name', 'employee_details.last_name')
                ->where('employee_details.employee_status', 'active')
                ->get();

            $swipes_late1 = $swipes_late->count();

            $this->swipeDetails = DB::table('swipe_records')
                ->whereDate('created_at', $today)
                ->where('emp_id', $employeeId)
                ->orderBy('created_at', 'desc')
                ->get();
            $this->swipes = DB::table('swipe_records')
                ->whereDate('created_at', $today)
                ->where('emp_id', $employeeId)
                ->orderBy('created_at', 'desc')
                ->first();


            // Assuming $calendarData should contain the data for upcoming holidays
            // Get the current year and date
            $currentYear = Carbon::now()->year;
            $today = Carbon::today();

            // Initialize an empty collection to hold valid holidays
            $validHolidays = collect();

            // Retrieve holidays starting from today
            $holidays = HolidayCalendar::where('date', '>=', $today)
                ->whereYear('date', $currentYear)
                ->orderBy('date')
                ->get();

            foreach ($holidays as $holiday) {
                // Add the current holiday if it has festivals
                if (!empty($holiday->festivals)) {
                    $validHolidays->push($holiday);
                } else {
                    // Find the next holiday with festivals
                    $nextHoliday = HolidayCalendar::where('date', '>', $holiday->date)
                        ->whereYear('date', $currentYear)
                        ->orderBy('date')
                        ->first();

                    if ($nextHoliday && !empty($nextHoliday->festivals) && !$validHolidays->contains('id', $nextHoliday->id)) {
                        $validHolidays->push($nextHoliday);
                    }
                }

                // Break the loop if we have 3 holidays
                if ($validHolidays->count() >= 4) {
                    break;
                }
            }

            // Limit to the first 3 unique holidays
            $this->calendarData = $validHolidays->unique('id')->take(3);
            $this->holidayCount = $this->calendarData;

            $this->salaryRevision = SalaryRevision::where('emp_id', $employeeId)->get();
            $loggedInEmpId = Auth::guard('emp')->user()->emp_id;

            $isManager = EmployeeDetails::where('manager_id', $loggedInEmpId)->exists();

            $this->showLeaveApplies = $isManager;


            //##################################### pie chart details #########################
            $sal = new SalaryRevision();
            $this->grossPay = $sal->calculateTotalAllowance();
            $this->deductions = $sal->calculateTotalDeductions();
            $this->netPay = $this->grossPay - $this->deductions;


            // Pass the data to the view and return the view instance
            return view('livewire.home', [
                'calendarData' => $this->calendarData,
                'holidayCount' => $this->holidayCount,
                'salaryRevision' => $this->salaryRevision,
                'showLeaveApplies' => $this->showLeaveApplies,
                'count' => $this->count,
                'leaveApplied' => $this->leaveApplied,
                'teamCount' => $this->teamCount,
                'teamOnLeave' => $this->teamOnLeave,
                'matchingLeaveApplications' => $matchingLeaveApplications,
                'upcomingLeaveRequests'  => $this->upcomingLeaveRequests,
                'upcomingLeaveApplications' => $this->upcomingLeaveApplications,
                'ismanager' => $isManager,
                'AbsentEmployees' => $this->absent_employees,
                'CountAbsentEmployees' => $this->absent_employees_count,
                'EarlySwipes' => $swipes_early,
                'CountEarlySwipes' => $swipes_early1,
                'LateSwipes' => $swipes_late,
                'CountLateSwipes' => $swipes_late1,
                'swipeDataOfEmployee' => $this->swipeDataOfEmployee,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database query exceptions
            Log::error('Database Error: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while processing your request. Please try again later.');
        } catch (\Exception $e) {
            // Handle other general exceptions
            Log::error('General Error: ' . $e->getMessage());
            session()->flash('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}
