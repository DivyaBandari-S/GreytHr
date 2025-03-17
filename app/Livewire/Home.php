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

use App\Helpers\FlashMessageHelper;
use App\Models\Conversation;
use App\Models\EmployeeDetails;
use App\Models\EmpSalary;
use App\Models\LeaveRequest;
use App\Models\SwipeRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\HolidayCalendar;
use App\Models\RegularisationDates;
use App\Models\EmpSalaryRevision;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Throwable;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use App\Models\EmpBankDetail;
use App\Models\EmpPersonalInfo;
use Barryvdh\DomPDF\Facade\Pdf;

class Home extends Component
{
    public $currentDate;
    public $swipes;
    public $groupedRequests;
    public $pendingCount;
    public $whoisinTitle = '';
    public $currentDay;
    public $absent_employees_count;
    public $showAlertDialog = false;
    public $signIn = true;
    public $swipeDetails;
    public $calendarData;
    public $TaskAssignedToCount;

    public $signInOutStatus = 'IN';

    public $testforswipe = null;
    public $swipeblock;
    public $TasksCompletedCount;
    public $TasksInProgressCount;


    public $totalTasksCount;
    public $taskCount;
    public $employeeNames;
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
    public $formattedAddress = [];

    public $signStatus;
    public $showAllAbsentEmployees = false;
    public $showAllLateEmployees = false;
    public $employee_details;
    public $showAllEarlyEmployees = false;
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
    public $weatherCondition;
    public $temperature;
    public $minTemperature;
    public $maxTemperature;
    public $error;
    public $windspeed;
    public $winddirection;
    public $isDay;
    public $weatherCode;
    public $city;
    public $country;
    public $postal_code;
    public $lon;


    public $lat;
    public $latitude;
    public $loginEmpManagerDetails;
    public $showThisMonthLeaveRequest = false;
    public $showTodayLeaveRequest = false;
    public $modalLeaveTitle = '';
    public $showModal = false;

    public $swipe_location;

    public $showtoggleSignState = false;
    public $shiftStartTime;

    public $signstatusfortest;
    public $swipesforbutton;
    public $swipe_remarks;
    public $shiftEndTime;
    public $shiftType;
    public $showSalary = true;
    public $longitude;
    public $monthOfSal;
    public $totalDaysInMonth;
    public $paidDays;


    public $sal;
    public function mount()
    {
        try {
            // Fetch weather data
            $this->fetchWeather();

            // Get current hour to determine greeting
            $currentHour = date('G');
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $today = Carbon::now()->format('Y-m-d');


            $this->swipes = DB::table('swipe_records')
                ->whereDate('created_at', $today)
                ->where('emp_id', $employeeId)
                ->orderBy('id', 'desc')
                ->first();


            if (!empty($this->swipes)) {
                $this->swipe_location = $this->swipes->swipe_location;
            }
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

            // Get employee details


            $this->shiftType = EmployeeDetails::where('emp_id', $employeeId)->value('shift_type');
            $this->employeeShiftDetails = EmployeeDetails::where('emp_id', $employeeId) // Match employee ID
                ->join('company_shifts', function ($join) {
                    $join->whereRaw('JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(company_shifts.company_id))') // Match JSON company_id
                        ->whereColumn('employee_details.shift_type', '=', 'company_shifts.shift_name'); // Match shift_type with shift_name
                })
                ->select(
                    'employee_details.shift_type',          // Select the shift_type from employee_details
                    'company_shifts.shift_start_time',      // Select shift_start_time from company_shifts
                    'company_shifts.shift_end_time'         // Select shift_end_time from company_shifts
                )
                ->first();
            if ($this->employeeShiftDetails) {
                $this->shiftStartTime = Carbon::parse($this->employeeShiftDetails->shift_start_time)->format('H:i');
                $this->shiftEndTime = Carbon::parse($this->employeeShiftDetails->shift_end_time)->format('H:i');
            } else {
                $this->shiftStartTime = null;
                $this->shiftEndTime = null;
            }



            // Check if employee details exist before attempting to access
            $this->loginEmployee = EmployeeDetails::where('emp_id', $employeeId)
                ->select('emp_id', 'first_name', 'last_name', 'manager_id')
                ->first();

            if ($this->loginEmployee) {
                // Get manager details
                $this->loginEmpManagerDetails = EmployeeDetails::with('empSubDepartment')
                    ->where('emp_id', $this->loginEmployee->manager_id)
                    ->first();

                // Get employees under the manager
                $employees = EmployeeDetails::where('manager_id', $employeeId)
                    ->select('emp_id', 'first_name', 'last_name')
                    ->get();

                // Extract employee IDs
                $empIds = $employees->pluck('emp_id')->toArray();

                // Get regularisation data
                $this->regularisations = RegularisationDates::whereIn('emp_id', $empIds)
                    ->where('is_withdraw', 0) // Assuming you want records with is_withdraw set to 0
                    ->where('status', 5)
                    ->selectRaw('*, JSON_LENGTH(regularisation_entries) AS regularisation_entries_count')
                    ->whereRaw('JSON_LENGTH(regularisation_entries) > 0')
                    ->with('employee')
                    ->get();

                // Count regularisations
                $this->countofregularisations = RegularisationDates::whereIn('emp_id', $empIds)
                    ->where('is_withdraw', 0) // Assuming you want records with is_withdraw set to 0
                    ->where('status', 5)
                    ->selectRaw('*, JSON_LENGTH(regularisation_entries) AS regularisation_entries_count')
                    ->whereRaw('JSON_LENGTH(regularisation_entries) > 0')
                    ->with('employee')
                    ->count();
            } else {
                // Handle case where employee details could not be found
                $this->loginEmployee = null;
                $this->loginEmpManagerDetails = null;
                $this->regularisations = collect();
                $this->countofregularisations = 0;
            }
        } catch (\Exception $e) {
            // Handle any exception that occurs
            Log::error('Error occurred in mount method: ' . $e->getMessage());
            $this->loginEmployee = null;
            $this->loginEmpManagerDetails = null;
            $this->regularisations = collect();
            $this->countofregularisations = 0;
            FlashMessageHelper::flashError('An error occurred while fetching data. Please try again later.');
        } catch (\Illuminate\Database\QueryException $e) {
            FlashMessageHelper::flashError('An error occurred while fetching data. Please try again later.');
        }
    }


    public function OpentoggleSignStatePopup()
    {

        // Do something with $swipeId and $inOrOut
        $this->showtoggleSignState = true;

        $this->testforswipe = $this->testlatestSwipe()['swipesforbutton'];
        $this->signstatusfortest = $this->testlatestSwipe()['signStatus'];
    }
    public function testlatestSwipe()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $today = Carbon::now()->format('Y-m-d');
        $this->swipesforbutton = DB::table('swipe_records')
            ->whereDate('created_at', $today)
            ->where('emp_id', $employeeId)
            ->orderBy('id', 'desc')
            ->first();
        $this->signStatus = $this->swipesforbutton ? ($this->swipesforbutton->in_or_out == "IN" ? "OUT" : "IN") : 'IN';

        return [
            'swipesforbutton' => $this->swipesforbutton,
            'signStatus' => $this->signStatus,

        ];
    }
    public function closeToggleSignState()
    {
        $this->showtoggleSignState = false;
    }
    public function updateSwipeLocation()
    {
        $this->swipe_location = $this->swipe_location;
    }
    public function updateSwipeRemarks()
    {
        $this->swipe_remarks = $this->swipe_remarks;
    }
    public function downloadPdf($month)
    {
        $month = Carbon::parse($month)->format('Y-m');

        $salaryDivisions = [];
        $empBankDetails = [];
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
        $empSalaryDetails = EmpSalary::join('salary_revisions', 'emp_salaries.sal_id', '=', 'salary_revisions.id')
            ->where('salary_revisions.emp_id', $employeeId)
            ->where('month_of_sal', 'like', $month . '%')
            ->first();

        if ($empSalaryDetails) {
            $salaryDivisions = $empSalaryDetails->calculateSalaryComponents($empSalaryDetails->salary);
            $empBankDetails = EmpBankDetail::where('emp_id', $employeeId)
                ->where('id', $empSalaryDetails->bank_id)->first();
            $employeePersonalDetails = EmpPersonalInfo::where('emp_id', $employeeId)->first();
            // dd( $this->employeePersonalDetails);
        } else {
            // Handle the null case (e.g., log an error or set a default value)
            $salaryDivisions = [];
        }

        // Generate PDF using the fetched data
        if ($empSalaryDetails) {
            $pdf = Pdf::loadView('download-pdf', [
                'employees' =>  $this->employeeDetails,
                'salaryRevision' =>  $salaryDivisions,
                'empBankDetails' => $empBankDetails,
                'rupeesInText' => $this->convertNumberToWords($salaryDivisions['net_pay']),
                'salMonth' => Carbon::parse($month)->format('F Y')
            ]);

            $name = Carbon::parse($month)->format('MY');

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, 'payslip-' . $name . '.pdf');
        }
    }

    public function convertNumberToWords($number)
    {
        // Array to represent numbers from 0 to 19 and the tens up to 90
        $words = [
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety'
        ];

        // Handle special cases
        if ($number < 0) {
            return 'minus ' . $this->convertNumberToWords(-$number);
        }

        // Handle numbers less than 100
        if ($number < 100) {
            if ($number < 20) {
                return $words[$number];
            } else {
                $tens = $words[10 * (int) ($number / 10)];
                $ones = $number % 10;
                if ($ones > 0) {
                    return $tens . ' ' . $words[$ones];
                } else {
                    return $tens;
                }
            }
        }

        // Handle numbers greater than or equal to 100
        if ($number < 1000) {
            $hundreds = $words[(int) ($number / 100)] . ' hundred';
            $remainder = $number % 100;
            if ($remainder > 0) {
                return $hundreds . ' ' . $this->convertNumberToWords($remainder);
            } else {
                return $hundreds;
            }
        }

        // Handle larger numbers
        if ($number < 1000000) {
            $thousands = $this->convertNumberToWords((int) ($number / 1000)) . ' thousand';
            $remainder = $number % 1000;
            if ($remainder > 0) {
                return $thousands . ' ' . $this->convertNumberToWords($remainder);
            } else {
                return $thousands;
            }
        }

        // Handle even larger numbers
        if ($number < 1000000000) {
            $millions = $this->convertNumberToWords((int) ($number / 1000000)) . ' million';
            $remainder = $number % 1000000;
            if ($remainder > 0) {
                return $millions . ' ' . $this->convertNumberToWords($remainder);
            } else {
                return $millions;
            }
        }

        // Handle numbers larger than or equal to a billion
        return 'number too large to convert';
    }
    public function getThisMonthLeaves()
    {
        $this->showModal = true;
        $this->modalLeaveTitle = 'This Month';
        $this->showThisMonthLeaveRequest = !$this->showThisMonthLeaveRequest;
    }
    public function closeThisMonthLeaves()
    {
        $this->showModal = false;
        $this->modalLeaveTitle = '';
        $this->showThisMonthLeaveRequest = false;
    }
    public function getTodayLeaves()
    {
        $this->modalLeaveTitle = 'Today';
        $this->showModal = true;
        $this->showTodayLeaveRequest = true;
    }
    public function closeTodayLeaves()
    {
        $this->showModal = false;
        $this->modalLeaveTitle = '';
        $this->showTodayLeaveRequest = false;
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
    public function hideAlert()
    {
        $this->showAlert = false;
    }

    public function openEarlyEmployees()
    {
        $this->whoisinTitle = 'On Time Employees';
        $this->showAllEarlyEmployees = true;
    }
    public function openLateEmployees()
    {
        $this->whoisinTitle = 'Late Arrival Employees';
        $this->showAllLateEmployees = true;
    }
    public function closeAllAbsentEmployees()
    {
        $this->whoisinTitle = '';
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

    private function isEmployeeLeaveOnDate($date, $employeeId)
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            return LeaveRequest::where('emp_id', $employeeId)
                ->where('leave_applications.leave_status', 2)
                ->where('leave_applications.from_session', 'Session 1')
                ->where('leave_applications.to_session', 'Session 2')
                ->where(function ($query) use ($date) {
                    $query->whereDate('from_date', '<=', $date)
                        ->whereDate('to_date', '>=', $date);
                })
                ->join('status_types', 'status_types.status_code', '=', 'leave_applications.leave_status') // Join with status_types
                ->exists();
        } catch (\Exception $e) {
            Log::error('Error in isEmployeeLeaveOnDate method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while checking employee leave. Please try again later.');
            return false; // Return false to handle the error gracefully
        }
    }

    public function toggleSignState()
    {
        try {
            $currentTime = Carbon::now();

            $todayDate = $currentTime->format('Y-m-d');
            $employeeId = auth()->guard('emp')->user()->emp_id;


            if ($this->isEmployeeLeaveOnDate($todayDate, $employeeId)) {

                FlashMessageHelper::flashError('You cannot swipe on this date as you are on leave.');
                return;
            } elseif (HolidayCalendar::where('date', $todayDate)->exists()) {

                FlashMessageHelper::flashError('You cannot swipe on this date as it is a holiday.');
                return;
            }

            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

            $this->signIn = !$this->signIn;

            $userAgent = request()->header('User-Agent');

            // Detect Device Type
            if (stripos($userAgent, 'mobile') !== false) {
                $deviceName = 'Mobile';
            } elseif (stripos($userAgent, 'tablet') !== false) {
                $deviceName = 'Tablet';
            } elseif (stripos($userAgent, 'windows') !== false || stripos($userAgent, 'macintosh') !== false) {
                $deviceName = 'Laptop/Desktop';
            } else {
                $deviceName = 'Unknown Device';
            }

            // Detect Platform (OS)
            if (stripos($userAgent, 'windows') !== false) {
                $platform = 'Windows';
            } elseif (stripos($userAgent, 'macintosh') !== false || stripos($userAgent, 'mac os') !== false) {
                $platform = 'MacOS';
            } elseif (stripos($userAgent, 'linux') !== false) {
                $platform = 'Linux';
            } elseif (stripos($userAgent, 'android') !== false) {
                $platform = 'Android';
            } elseif (stripos($userAgent, 'iphone') !== false || stripos($userAgent, 'ipad') !== false) {
                $platform = 'iOS';
            } else {
                $platform = 'Unknown OS';
            }

            $ipAddress = request()->ip();

            dd($deviceName, $platform, $ipAddress);

            SwipeRecord::create([
                'emp_id' => $this->employeeDetails->emp_id,
                'swipe_time' => now()->format('H:i:s'),
                'in_or_out' => $this->swipes ? ($this->swipes->in_or_out == "IN" ? "OUT" : "IN") : 'IN',
                'sign_in_device' => $deviceName,
                'device_name' => $platform,
                'device_id' => $ipAddress,
                'swipe_location' => $this->swipe_location,
                'swipe_remarks' => $this->swipe_remarks,
            ]);



            $flashMessage = $this->swipes ? ($this->swipes->in_or_out == "IN" ? "OUT" : "IN") : 'IN';
            FlashMessageHelper::flashSuccess($flashMessage == "IN"
                ? "You have successfully signed in."
                : "You have successfully signed out.");

            $this->testforswipe = $this->testlatestSwipe()['swipesforbutton'];
            $this->signstatusfortest = $this->testlatestSwipe()['signStatus'];


            return redirect('/');
        } catch (Throwable $e) {


            FlashMessageHelper::flashError("An error occurred while toggling sign state. Please try again later.");
        }
    }

    public function showEarlyEmployees()
    {
        $this->whoisinTitle = 'On Time';
        $this->showAllEarlyEmployees = true;
    }
    public function closeAllEarlyEmployees()
    {
        $this->whoisinTitle = '';
        $this->showAllEarlyEmployees = false;
    }
    public function openAbsentEmployees()
    {
        $this->whoisinTitle = 'Not Yet In';
        $this->showAllAbsentEmployees = true;
    }
    public function closeAllLateEmployees()
    {
        $this->whoisinTitle = '';
        $this->showAllLateEmployees = false;
    }


    public function getChatUserImages()
    {
        $authUserId = Auth::id();

        // Get all conversations where the auth user is either sender or receiver
        $conversations = Conversation::where('sender_id', $authUserId)
            ->orWhere('receiver_id', $authUserId)
            ->get();

        // Get the employees excluding the auth user
        $employeeIds = $conversations->pluck('sender_id')
            ->merge($conversations->pluck('receiver_id'))
            ->unique()
            ->filter(fn($id) => $id != $authUserId);

        // Fetch employee details
        return EmployeeDetails::whereIn('emp_id', $employeeIds)
            ->take(6) // Limit to 6 for display
            ->get(['emp_id', 'image', 'gender']);
    }

    public function render()
    {
        try {
            $loggedInEmpId = Session::get('emp_id');
            $isManager = EmployeeDetails::where('manager_id', $loggedInEmpId)->exists();
            $employeeId = auth()->guard('emp')->user()->emp_id;




            $this->currentDay = now()->format('l');
            $this->currentDate = now()->format('d M Y');
            $today = Carbon::now()->format('Y-m-d');
            $this->testforswipe = $this->testlatestSwipe()['swipesforbutton'];
            $this->signstatusfortest = $this->testlatestSwipe()['signStatus'];



            $threeWorkingDaysAgo = $this->subtractWorkingDays(3);
            $this->leaveRequests = LeaveRequest::with('employee')
                ->where(function ($query) {
                    $query->where('leave_status', 5)
                        ->orWhere(function ($query) {
                            $query->where('leave_status', 2)
                                ->where('cancel_status', 7);
                        });
                })
                ->where('created_at', '>=', $threeWorkingDaysAgo)
                ->orderBy('created_at', 'desc')
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
            $this->pendingCount = count($this->leaveApplied);
            $groupedRequests = [];
            // Iterate through each leave request
            foreach ($this->leaveApplied as $request) {
                $leaveRequest = $request['leaveRequest'];
                $empId = $leaveRequest->emp_id; // Extract emp_id from LeaveRequest model

                if (!isset($groupedRequests[$empId])) {
                    // Initialize the array for this employee ID
                    $groupedRequests[$empId] = [
                        'count' => 0,
                        'leaveRequests' => []
                    ];
                }

                // Increment the count and store the leave request
                $groupedRequests[$empId]['count']++;
                $groupedRequests[$empId]['leaveRequests'][] = $leaveRequest;
            }
            // Store the grouped requests in the class property
            $this->groupedRequests = $groupedRequests;
            $this->count = count($matchingLeaveApplications);
            //team on leave
            $currentDate = Carbon::today();

            $this->teamOnLeaveRequests = LeaveRequest::with('employee')
                ->where('category_type',  'Leave')
                ->where('leave_status', 2)
                ->where('cancel_status', '!=', 6)
                ->where(function ($query) use ($currentDate) {
                    $query->whereDate('from_date', '<=', $currentDate)
                        ->whereDate('to_date', '>=', $currentDate);
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
                ->join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id') // Join with employee_details table
                ->where('leave_applications.leave_status', 2)
                ->where('category_type', 'Leave')
                ->where(function ($query) use ($currentDate) {
                    $query->whereMonth('leave_applications.from_date', Carbon::now()->month); // Filter for the current month
                })
                ->where('employee_details.manager_id', auth()->user()->emp_id) // Match login_manager_id with the authenticated user's ID (assuming they are the manager)
                ->orderBy('leave_applications.created_at', 'desc')
                ->select('leave_applications.*') // Select all columns from the leave_requests table
                ->get();
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



            $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->get();
            $approvedLeaveRequests = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
                ->where('leave_applications.leave_status', 2)
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

            $this->absent_employees_count = EmployeeDetails::where('employee_details.manager_id', $loggedInEmpId)
                ->leftJoin('emp_personal_infos', 'employee_details.emp_id', '=', 'emp_personal_infos.emp_id') // Join personal info table
                ->leftJoin('company_shifts', function ($join) {
                    $join->on(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(employee_details.company_id, '$[0]'))"), '=', 'company_shifts.company_id')
                        ->whereColumn('employee_details.shift_type', 'company_shifts.shift_name'); // Join on shift_type and shift_name
                })
                ->select(
                    'employee_details.*',
                    // Selecting the mobile number from emp_personal_infos
                    'company_shifts.shift_name', // Selecting shift_name from company_shifts
                    'company_shifts.shift_start_time',
                    'company_shifts.shift_end_time'
                )
                ->whereNotIn('employee_details.emp_id', function ($query) use ($loggedInEmpId, $currentDate) {
                    $query->select('emp_id')
                        ->from('swipe_records')
                        ->where('manager_id', $loggedInEmpId)
                        ->whereDate('created_at', $currentDate);
                })
                ->whereNotIn('employee_details.emp_id', $approvedLeaveRequests->pluck('emp_id'))
                ->where('employee_details.employee_status', 'active')
                ->distinct('employee_details.emp_id')
                ->count();

            $employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->select('emp_id', 'first_name', 'last_name')->where('employee_status', 'active')->get();
            $swipes_early = SwipeRecord::whereIn('swipe_records.id', function ($query) use ($employees, $approvedLeaveRequests, $currentDate) {
                $query->selectRaw('MIN(swipe_records.id)')
                    ->from('swipe_records')
                    ->whereIn('swipe_records.emp_id', $employees->pluck('emp_id'))
                    ->whereNotIn('swipe_records.emp_id', $approvedLeaveRequests->pluck('emp_id'))
                    ->whereDate('swipe_records.created_at', $currentDate)
                    ->groupBy('swipe_records.emp_id');
            })
                ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
                ->leftJoin('emp_personal_infos', 'swipe_records.emp_id', '=', 'emp_personal_infos.emp_id') // Joining emp_personal_infos
                ->leftJoin('company_shifts', function ($join) {
                    $join->on(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(employee_details.company_id, '$[0]'))"), '=', 'company_shifts.company_id') // Join on company_id
                        ->whereColumn('employee_details.shift_type', 'company_shifts.shift_name'); // Join on shift_type
                })
                ->select(
                    'swipe_records.*',
                    'employee_details.first_name',
                    'employee_details.last_name',
                    'employee_details.emergency_contact', // Selecting fields from emp_personal_infos
                    'company_shifts.shift_start_time', // Get shift_start_time from company_shifts
                    'company_shifts.shift_end_time',
                )
                ->where(function ($query) {
                    $query->whereRaw("swipe_records.swipe_time <= company_shifts.shift_start_time"); // Compare against company_shifts.shift_start_time
                })
                ->where('employee_details.employee_status', 'active')
                ->distinct('swipe_records.emp_id')
                ->get();


            $swipes_early1 = $swipes_early->count();

            $swipes_late = SwipeRecord::whereIn('swipe_records.id', function ($query) use ($employees, $approvedLeaveRequests, $currentDate) {
                $query->selectRaw('MIN(swipe_records.id)')
                    ->from('swipe_records')
                    ->whereNotIn('swipe_records.emp_id', $approvedLeaveRequests->pluck('emp_id'))
                    ->whereIn('swipe_records.emp_id', $employees->pluck('emp_id'))
                    ->whereDate('swipe_records.created_at', $currentDate)
                    ->groupBy('swipe_records.emp_id');
            })
                ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
                ->leftJoin('emp_personal_infos', 'swipe_records.emp_id', '=', 'emp_personal_infos.emp_id') // Join with emp_personal_infos table
                ->leftJoin('company_shifts', function ($join) {
                    $join->on(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(employee_details.company_id, '$[0]'))"), '=', 'company_shifts.company_id') // Join on company_id
                        ->whereColumn('employee_details.shift_type', 'company_shifts.shift_name'); // Join on shift_type
                })
                ->select(
                    'swipe_records.emp_id',  // Ensure that you are selecting emp_id for distinct comparison
                    'swipe_records.swipe_time',
                    'employee_details.first_name',
                    'employee_details.last_name',
                    'company_shifts.shift_start_time', // Get shift_start_time from company_shifts
                    'company_shifts.shift_end_time',   // Optionally, include shift_end_time if needed
                    'employee_details.emergency_contact'  // Include fields from emp_personal_infos
                )
                ->whereRaw("swipe_records.swipe_time > company_shifts.shift_start_time") // Compare against company_shifts.shift_start_time
                // Apply distinct on emp_id to avoid duplicates
                ->distinct('swipe_records.emp_id')
                ->get();

            $swipes_late1 = $swipes_late->count();

            $this->swipeDetails = DB::table('swipe_records')
                ->whereDate('created_at', $today)
                ->where('emp_id', $employeeId)
                ->orderBy('created_at', 'desc')
                ->get();



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
            // $this->salaryRevision = EmpSalaryRevision::where('emp_id', $employeeId)->get();
            $loggedInEmpId = Auth::guard('emp')->user()->emp_id;

            $isManager = EmployeeDetails::where('manager_id', $loggedInEmpId)->exists();

            $this->showLeaveApplies = $isManager;


            //##################################### pie chart details #########################
            $empId = auth()->user()->emp_id;

            // Fetch all salary revision IDs for the employee
            $salaryRevisionIds = EmpSalaryRevision::where('emp_id', $empId)
                ->pluck('id'); // Retrieve only IDs
            //    dd($salaryRevisionIds);
            if ($salaryRevisionIds->isNotEmpty()) {
                // Fetch the latest salary by comparing each revision ID with sal_id
                $this->sal = EmpSalary::whereIn('sal_id', $salaryRevisionIds)
                    ->latest('month_of_sal')
                    ->first();

                if ($this->sal) {
                    // Format the month and year from 'month_of_sal'
                    $monthOfSal = date('M Y', strtotime($this->sal->month_of_sal));
                    $totalDaysInMonth = 30; // Fixed to 30 days

                    $effectiveDate = strtotime($this->sal->effective_date);
                    $startOfMonth = strtotime(date('Y-m-01', strtotime($this->sal->month_of_sal)));

                    // Calculate paid days
                    $paidDays = $effectiveDate > $startOfMonth
                        ? $totalDaysInMonth - (date('j', $effectiveDate) - 1)
                        : $totalDaysInMonth;

                    // Pass data to the view
                    $this->monthOfSal = $monthOfSal;
                    $this->totalDaysInMonth = $totalDaysInMonth;
                    $this->paidDays = $paidDays;

                    // Calculate salary components
                    $salComponents = $this->sal->calculateSalaryComponents($this->sal->salary);
                    $this->grossPay = $salComponents['earnings'] ?? 0;
                    $this->deductions = $salComponents['total_deductions'] ?? 0;
                    $this->netPay = $salComponents['net_pay'] ?? 0;
                }
            }



            $this->calculateTaskData();
            $this->getChatUserImages();

            // Pass the data to the view and return the view instance
            return view('livewire.home', [
                'calendarData' => $this->calendarData,
                'pendingCount' => $this->pendingCount,
                'holidayCount' => $this->holidayCount,
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
                'TaskAssignedToCount' => $this->TaskAssignedToCount,
                'TasksCompletedCount' => $this->TasksCompletedCount,
                'TasksInProgressCount' => $this->TasksInProgressCount,
                'totalTasksCount' => $this->totalTasksCount,
                'taskCount' => $this->taskCount,
                'employeeNames' => $this->employeeNames,
                'groupedRequests' => $this->groupedRequests,
                'loginEmpManagerDetails' => $this->loginEmpManagerDetails

            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Error in home component: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while processing your request. Please try again later.');
        } catch (\Exception $e) {
            Log::error('An unexpected error occurred: ' . $e->getMessage());
            FlashMessageHelper::flashError('An unexpected error occurred. Please try again later.');
        }
    }
    private function subtractWorkingDays($days)
    {
        $date = Carbon::now();

        while ($days > 0) {
            $date->subDay();

            // Check if it's a weekday (Monday to Friday)
            if ($date->isWeekday()) {
                $days--;
            }
        }

        return $date;
    }
    public $filterPeriod = 'this_month';
    public function getStartDate()
    {
        switch ($this->filterPeriod) {
            case 'last_month':
                return now()->subMonth()->startOfMonth();
            case 'this_year':
                return now()->startOfYear();
            default:
                return now()->startOfMonth();
        }
    }
    public function getEndDate()
    {
        switch ($this->filterPeriod) {
            case 'last_month':
                return now()->subMonth()->endOfMonth();
            case 'this_year':
                return now()->endOfYear();
            default:
                return now()->endOfMonth();
        }
    }
    public function updatedFilterPeriod($value)
    {

        $this->calculateTaskData();
    }
    public function calculateTaskData()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;

        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $startDate = $this->getStartDate();
            $endDate = $this->getEndDate();

            $totalTasksAssignedBy = Task::with('emp')
                ->where(function ($query) use ($employeeId) {
                    $query->where('assignee', 'LIKE', "%($employeeId)%");
                })
                ->select('emp_id')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            $totalTasksCountAssignedBy = $totalTasksAssignedBy->count();

            $totalTasksAssignedTo = Task::with('emp')
                ->where('emp_id', $employeeId)
                ->where(function ($query) use ($employeeId) {
                    $query->whereRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(assignee, '#(', -1), ')', 1) != ?", [$employeeId])
                        ->orWhere('assignee', 'NOT LIKE', "%#($employeeId)%");
                })
                ->select('emp_id')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            $tasksSummary = Task::with('emp')
                ->selectRaw("
            COUNT(*) AS total_tasks_assigned_to,
            COALESCE(SUM(CASE WHEN status = 11 THEN 1 ELSE 0 END), 0) AS tasks_completed_count,
            COALESCE(SUM(CASE WHEN status = 10 THEN 1 ELSE 0 END), 0) AS tasks_in_progress_count
        ")
                ->whereRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(assignee, '#(', -1), ')', 1) = ?", [$employeeId])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->first();

            $this->TaskAssignedToCount = $tasksSummary->total_tasks_assigned_to;
            $this->TasksCompletedCount = $tasksSummary->tasks_completed_count;
            $this->TasksInProgressCount = $tasksSummary->tasks_in_progress_count;

            $totalTasksCountAssignedTo = $totalTasksAssignedTo->count();
            $this->totalTasksCount = $totalTasksCountAssignedTo + $totalTasksCountAssignedBy;

            $taskRecords = \App\Models\Task::with('emp')
                ->where(function ($query) use ($employeeId) {
                    $query->where('assignee', 'LIKE', "%($employeeId)%");
                })
                ->whereDate('created_at', now()->toDateString())
                ->whereBetween('created_at', [$startDate, $endDate])
                ->select('emp_id')
                ->get();

            $empIds = $taskRecords->pluck('emp_id')->unique()->toArray();

            $employeeDetails = \App\Models\EmployeeDetails::whereIn('emp_id', $empIds)->get();

            $this->employeeNames = $employeeDetails
                ->map(function ($employee) {
                    return $employee->first_name . ' ' . $employee->last_name;
                })
                ->implode(', ');

            $this->taskCount = $taskRecords->count();
        } catch (\Exception $e) {
            Log::error('Error calculating task data: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occured, please try again later.');
        }
    }



    // Livewire component method
    public function fetchWeather()
    {
        try {
            // Get the IP address and determine location
            $ip = request()->ip() === '127.0.0.1' ? Http::get('https://api64.ipify.org')->body() : request()->ip(); // Use Google's IP for testing
            $ipUrl = env('FINDIP_API_URL', 'https://ipapi.co'); // Use the API URL from .env
            $response = Http::get("{$ipUrl}/{$ip}/json/");

            if ($response->successful()) {
                $location = $response->json();

                $this->lat = $location['latitude'] ?? null;
                $this->lon = $location['longitude'] ?? null;
                $this->country = $location['country_name'] ?? null;
                $this->city = $location['city'] ?? null;
                $this->postal_code = $location['postal'] ?? null;
            } else {
                // Handle API error
                Log::error("Failed to fetch IP location data", ['ip' => $ip, 'response' => $response->body()]);
            }

            // Get the base API URL from the .env file
            $weatherUrl = env('WEATHER_API_URL', 'https://api.open-meteo.com/v1/forecast');
            // Prepare the request URL with dynamic latitude and longitude
            $requestUrl = $weatherUrl . '?latitude=' . $this->lat . '&longitude=' . $this->lon . '&current_weather=true';

            $response = Http::get($requestUrl);

            // Log response for debugging
            // Log::info('API Response:', $response->json() ?? []);
            // Log::info('API Response Status Code:', ['status' => $response->status()]);
            // Log::info('API Response Headers:', ['headers' => $response->headers()]);
            // Log::info('API Response Body:', ['body' => $response->body()]);

            // Check if the request was successful
            if ($response->successful()) {
                // Decode the JSON response
                $data = $response->json();

                // Extract weather data from the response
                $currentWeather = $data['current_weather'] ?? [];

                // $this->weatherCondition = $this->mapWeatherCodeToCondition($currentWeather['weathercode'] ?? 'Unknown');
                $this->weatherCode = $currentWeather['weathercode'] ?? 'Unknown';
                $this->temperature = $currentWeather['temperature'] ?? 'Unknown';
                $this->windspeed = $currentWeather['windspeed'] ?? 'Unknown';
                $this->winddirection = $currentWeather['winddirection'] ?? 'Unknown';
                $this->isDay = $currentWeather['is_day'] ? 'Day' : 'Night';
            } else {
                // Log the error response
                // Log::error('API Error:', ['status' => $response->status(), 'body' => $response->body()]);
                $this->weatherCondition = 'Unable to fetch weather data';
                $this->temperature = 'Unknown';
                $this->windspeed = 'Unknown';
                $this->winddirection = 'Unknown';
                $this->isDay = 'Unknown';
            }
        } catch (\Exception $e) {
            // Log::error("Exception: ", ['message' => $e->getMessage()]);
            FlashMessageHelper::flashError('Requested IP Not found.');
            $this->weatherCondition = 'An error occurred';
            $this->temperature = 'Unknown';
            $this->windspeed = 'Unknown';
            $this->winddirection = 'Unknown';
            $this->isDay = 'Unknown';
        }
    }

    private function mapWeatherCodeToCondition($code)
    {
        // Map weather code to weather condition
        $weatherCodes = [
            0  => 'Clear sky',
            1  => 'Mainly clear',
            2  => 'Partly cloudy',
            3  => 'Overcast',
            45 => 'Fog',
            48 => 'Depositing rime fog',
            51 => 'Drizzle: Light intensity',
            53 => 'Drizzle: Moderate intensity',
            55 => 'Drizzle: Dense intensity',
            56 => 'Freezing Drizzle: Light intensity',
            57 => 'Freezing Drizzle: Dense intensity',
            61 => 'Rain: Slight intensity',
            63 => 'Rain: Moderate intensity',
            65 => 'Rain: Heavy intensity',
            66 => 'Freezing Rain: Light intensity',
            67 => 'Freezing Rain: Heavy intensity',
            71 => 'Snowfall: Slight intensity',
            73 => 'Snowfall: Moderate intensity',
            75 => 'Snowfall: Heavy intensity',
            77 => 'Snow grains',
            80 => 'Rain showers: Slight intensity',
            81 => 'Rain showers: Moderate intensity',
            82 => 'Rain showers: Violent intensity',
            85 => 'Snow showers: Slight intensity',
            86 => 'Snow showers: Heavy intensity',
            95 => 'Thunderstorm: Slight or moderate',
            96 => 'Thunderstorm with slight hail',
            99 => 'Thunderstorm with heavy hail',
        ];

        return $weatherCodes[$code] ?? '';
    }


    public function getLocationByIP()
    {

        try {

            $ip = '';

            // $ip = request()->ip();
            $apiUrl = env('FINDIP_API_URL');

            // Construct the full API URL
            $url = "{$apiUrl}/{$ip}/json/";

            // Make the HTTP request
            $response = Http::get($url);
            // dd($response->json());
        } catch (\Exception $e) {
            // Log::error("Exception: ", ['message' => $e->getMessage()]);
            FlashMessageHelper::flashError('An error occured while getting location.');
        }
    }

    // public $latitude;
    // public $longitude;
    // #[Js]
    // public function fetcLocationByJS()
    // {
    //     return <<<'JS'
    //         console.log('Calling after loading...');
    //         if (navigator.geolocation) {
    //             navigator.geolocation.getCurrentPosition(function(position) {
    //                 const latitude = position.coords.latitude;
    //                 const longitude = position.coords.longitude;

    //                 // Send the latitude and longitude back to Livewire using the correct variable names
    //                 $wire.set('latitude', latitude);
    //                 $wire.set('longitude', longitude);

    //                 // Optionally alert the user
    //                 alert('Location fetched: (' + latitude + ', ' + longitude + ')');
    //             }, function(error) {
    //                 alert('Error fetching location: ' + error.message);
    //             });
    //         } else {
    //             alert('Geolocation is not supported by this browser.');
    //         }
    //     JS;
    // }

    #[On('post-created')]
    public function updatePostList()
    {
        // dd('called');
    }

    protected $listeners = ['sendCoordinates'];


    public function sendCoordinates($latitude, $longitude)
    {
        // Log the received coordinates
        // Log::info("Received coordinates: Latitude: {$latitude}, Longitude: {$longitude}");

        // Build the API URL for reverse geocoding
        $apiUrl = "https://nominatim.openstreetmap.org/reverse";

        // Call the Nominatim API to get address details
        try {
            $response = Http::get($apiUrl, [
                'lat' => $latitude,
                'lon' => $longitude,
                'format' => 'json'
            ]);
            if ($response->successful()) {
                $data = $response->json();
                // Extract address details
                $address = $data['address'] ?? [];
                $this->formattedAddress = [
                    'village' => $address['village'] ?? '',
                    'road' => $address['road'] ?? '',
                    'suburb' => $address['suburb'] ?? '',
                    'city_district' => $address['city_district'] ?? '',
                    'city' => $address['city'] ?? '',
                    'county' => $address['county'] ?? '',
                    'state' => $address['state'] ?? '',
                    'postcode' => $address['postcode'] ?? '',
                    'country' => $address['country'] ?? '',
                    'country_code' => $address['country_code'] ?? ''
                ];
            } else {
                // Log::error("Failed to fetch address. Error: " . $response->body());
            }
        } catch (\Exception $e) {
            // Log::error("Error occurred while fetching address: " . $e->getMessage());
            FlashMessageHelper::flashError('Error occurred while fetching address');
        }
    }
}
