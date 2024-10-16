<?php
// File Name                       : LeaveCalender.php
// Description                     : This file contains the implementation of a Calendar by this we can know that holidays in a month and the members who are on leave.
// Creator                         : Bandari Divya
// Email                           : bandaridivya1@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : LeaveRequest,EmployeeDetails,HolidayCalendar
namespace App\Livewire;

use App\Models\Company;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\LeaveRequest;
use App\Models\EmployeeDetails;
use App\Models\HolidayCalendar;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\SimpleExcel\SimpleExcelWriter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LeaveCalender extends Component
{
    public $year, $date;
    public $month;
    public $calendar;
    public $leaveData;
    public $restrictedHolidayData;
    public $generalHolidayData;
    public $leaveRequests;
    public $selectedDate;
    public $eventDetails;
    public $companyId;
    public $filterCriteria = null;
    public $leaveTransactions = [];
    public $searchTerm = '';
    public $showDialog = false;
    public $showLocations = false;
    public $showDepartment = false;
    public $selectedLocations = [];
    public $filterType;
    public $selectedDepartments = [];


    public function toggleSelection($location)
    {
        try {
            if ($location === 'All') {
                if (in_array('All', $this->selectedLocations)) {
                    $this->selectedLocations = [];
                } else {
                    $this->selectedLocations = ['All'];
                }
            } else {
                $key = array_search('All', $this->selectedLocations);
                if ($key !== false) {
                    unset($this->selectedLocations[$key]);
                }

                if (in_array($location, $this->selectedLocations)) {
                    $this->selectedLocations = array_diff($this->selectedLocations, [$location]);
                } else {
                    $this->selectedLocations[] = $location;
                }
            }
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database query exceptions
            Log::error('Database Error: ' . $e->getMessage());
            return view('error', ['message' => 'An error occurred while processing your request. Please try again later.']);
        } catch (\Exception $e) {
            // Handle other general exceptions
            Log::error('General Error: ' . $e->getMessage());
            return view('error', ['message' => 'An unexpected error occurred. Please try again later.']);
        }
    }
    public function toggleDeptSelection($dept)
    {
        try {
            if ($dept === 'All') {
                if (in_array('All', $this->selectedDepartments)) {
                    $this->selectedDepartments = [];
                } else {
                    $this->selectedDepartments = ['All'];
                }
            } else {
                $key = array_search('All', $this->selectedDepartments);
                if ($key !== false) {
                    unset($this->selectedDepartments[$key]);
                }

                if (in_array($dept, $this->selectedDepartments)) {
                    $this->selectedDepartments = array_diff($this->selectedDepartments, [$dept]);
                } else {
                    $this->selectedDepartments[] = $dept;
                }
            }
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


    public function isSelectedAll()
    {
        return in_array('All', $this->selectedLocations);
    }

    public function openDept()
    {
        $this->showDepartment = !$this->showDepartment;
    }

    public function open()
    {
        $this->showDialog = true;
    }

    public function close()
    {
        $this->showDialog = false;
    }
    public function openLocations()
    {
        $this->showLocations = !$this->showLocations;
    }

    public function closeLocations()
    {
        $this->showLocations = false;
    }

    public function closeDept()
    {
        $this->showDepartment = false;
    }
    public function isSelecteDeptdAll()
    {
        return in_array('All', $this->selectedDepartments);
    }
    public function filterBy($value)
    {

        $this->filterCriteria = $value;

        $this->generateCalendar();
    }
    public function isSelectedAllDept()
    {
        return count($this->selectedDepartments) === 1 && in_array('All', $this->selectedDepartments);
    }


    public function mount()
    {
        $this->year = now()->year;
        $this->month = now()->month;
        $this->leaveRequests = LeaveRequest::all();
        $this->filterCriteria = 'Me';
        $this->searchTerm = '';
        $this->selectedLocations = ['All'];
        $this->selectedDepartments = ['All'];
        $this->loadLeaveTransactions(now()->toDateString(), $this->filterType);
        $this->generateCalendar();
    }
    public function generateCalendar()
    {
        try {
            $firstDay = Carbon::create($this->year, $this->month, 1);

            $daysInMonth = $firstDay->daysInMonth;

            $today = now();

            $calendar = [];
            $dayCount = 1;
            $publicHolidays = $this->getPublicHolidaysForMonth($this->year, $this->month);

            // Calculate the first day of the week for the current month
            $firstDayOfWeek = $firstDay->dayOfWeek;

            // Calculate the starting date of the previous month
            $startOfPreviousMonth = $firstDay->copy()->subMonth();

            // Fetch holidays for the previous month
            $publicHolidaysPreviousMonth = $this->getPublicHolidaysForMonth(
                $startOfPreviousMonth->year,
                $startOfPreviousMonth->month
            );

            // Calculate the last day of the previous month
            $lastDayOfPreviousMonth = $firstDay->copy()->subDay();

            for ($i = 0; $i < ceil(($firstDayOfWeek + $daysInMonth) / 7); $i++) {
                $week = [];
                for ($j = 0; $j < 7; $j++) {
                    if ($i === 0 && $j < $firstDay->dayOfWeek) {
                        // Add the days of the previous month
                        $previousMonthDays = $lastDayOfPreviousMonth->copy()->subDays($firstDay->dayOfWeek - $j - 1);
                        $week[] = [
                            'day' => $previousMonthDays->day,
                            'isToday' => false,
                            'isPublicHoliday' => in_array($previousMonthDays->toDateString(), $publicHolidaysPreviousMonth->pluck('date')->toArray()),
                            'isCurrentMonth' => false,
                            'isPreviousMonth' => true,
                            'backgroundColor' => '', // Initialize with an empty background color
                            'leaveCountMe' => 0,
                            'leaveCountMyTeam' => 0,
                        ];
                    } elseif ($dayCount <= $daysInMonth) {
                        // Add the days of the current month
                        $isToday = $dayCount === $today->day && $this->month === $today->month && $this->year === $today->year;
                        $isPublicHoliday = in_array(
                            Carbon::create($this->year, $this->month, $dayCount)->toDateString(),
                            $publicHolidays->pluck('date')->toArray()
                        );

                        $backgroundColor = $isPublicHoliday ? 'background-color: IRIS;' : '';

                        $date = Carbon::create($this->year, $this->month, $dayCount)->toDateString();
                        $leaveCountMe = 0;
                        $leaveCountMyTeam = 0;

                        if ($this->filterCriteria === 'Me') {
                            $leaveCountMe = $this->loadLeaveTransactions($date, 'Me');
                        } elseif ($this->filterCriteria === 'MyTeam') {
                            $leaveCountMyTeam = $this->loadLeaveTransactions($date, 'MyTeam');
                        }

                        $week[] = [
                            'day' => $dayCount,
                            'isToday' => $isToday,
                            'isPublicHoliday' => $isPublicHoliday,
                            'isCurrentMonth' => true,
                            'isPreviousMonth' => false,
                            'backgroundColor' => $backgroundColor,
                            'leaveCountMe' => $leaveCountMe,
                            'leaveCountMyTeam' => $leaveCountMyTeam,
                        ];
                        $dayCount++;
                    } else {
                        // Add the days of the next month
                        $week[] = [
                            'day' => $dayCount - $daysInMonth,
                            'isToday' => false,
                            'isPublicHoliday' => in_array($lastDayOfPreviousMonth->copy()->addDays($dayCount - $daysInMonth)->toDateString(), $this->getPublicHolidaysForMonth($startOfPreviousMonth->year, $startOfPreviousMonth->month)->pluck('date')->toArray()),
                            'isCurrentMonth' => false,
                            'isNextMonth' => true,
                            'backgroundColor' => '', // Initialize with an empty background color
                            'leaveCountMe' => 0,
                            'leaveCountMyTeam' => 0,
                        ];
                        $dayCount++;
                    }
                }
                $calendar[] = $week;
            }


            $this->calendar = $calendar;
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

    protected function getPublicHolidaysForMonth($year, $month)
    {
        try {
            return HolidayCalendar::whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get();
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


    public function previousMonth()
    {
        try {
            $date = Carbon::create($this->year, $this->month, 1)->subMonth();
            $this->year = $date->year;
            $this->month = $date->month;
            $this->generateCalendar();
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

    public function nextMonth()
    {
        try {
            $date = Carbon::create($this->year, $this->month, 1)->addMonth();
            $this->year = $date->year;
            $this->month = $date->month;
            $this->generateCalendar();
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
    public function searchData()
    {
        $this->loadLeaveTransactions($this->selectedDate, $this->filterCriteria);
    }


    public function loadLeaveTransactions($date, $filterType)
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $companyId = auth()->guard('emp')->user()->company_id;
            // Check if companyIds is an array; decode if it's a JSON string
            $companyIdsArray = is_array($companyId) ? $companyId : json_decode($companyId, true);
            $dateFormatted = Carbon::parse($date)->format('Y-m-d');
            $searchTerm = '%' . $this->searchTerm . '%';
            $leaveCount = 0;

            if ($filterType === 'Me') {
                $leaveTransactions = LeaveRequest::with('employee')
                    ->whereDate('from_date', '<=', $dateFormatted)
                    ->whereDate('to_date', '>=', $dateFormatted)
                    ->where('emp_id', $employeeId)
                    ->where('status', 'approved')
                    ->where(function ($query) use ($searchTerm) {
                        $query->where('emp_id', 'like', $searchTerm)
                            ->orWhereHas('employee', function ($query) use ($searchTerm) {
                                $query->where('first_name', 'like', $searchTerm)
                                    ->orWhere('last_name', 'like', $searchTerm);
                            });
                    })
                    ->get();
                $leaveCount = $leaveTransactions->count();
                $this->leaveTransactions = $leaveTransactions;
            } elseif ($filterType === 'MyTeam') {
                // Get the employee's manager ID
                $employeeId = auth()->guard('emp')->user()->emp_id;
                $checkLoginIsManager = EmployeeDetails::where('manager_id', $employeeId)->value('manager_id');
                $managerId = EmployeeDetails::where('emp_id', $employeeId)->value('manager_id');
                if ($checkLoginIsManager) {
                    $teamMembersIds = EmployeeDetails::whereJsonContains('company_id', $companyIdsArray)
                        ->where('manager_id', $checkLoginIsManager) // Filter by manager_id
                        ->pluck('emp_id')
                        ->toArray();
                } else {
                    $teamMembersIds = EmployeeDetails::whereJsonContains('company_id', $companyIdsArray)
                        ->where('manager_id', $managerId)
                        // Filter by manager_id
                        ->pluck('emp_id')
                        ->toArray();
                }
                // Fetch leave transactions for the team members
                $leaveTransactionsOfTeam = LeaveRequest::with('employee')
                    ->where('category_type', 'Leave')
                    ->whereIn('emp_id', $teamMembersIds)
                    ->whereDate('from_date', '<=', $dateFormatted)
                    ->whereDate('to_date', '>=', $dateFormatted)
                    ->where(function ($query) {
                        $query->where('status', 'approved')
                            ->whereIn('cancel_status', ['Re-applied', 'Pending', 'rejected', 'Withdrawn']);
                    })
                    ->where(function ($query) use ($searchTerm) {
                        $query->where('emp_id', 'like', $searchTerm)
                            ->orWhereHas('employee', function ($query) use ($searchTerm) {
                                $query->where('first_name', 'like', $searchTerm)
                                    ->orWhere('last_name', 'like', $searchTerm);
                            });
                    })
                    ->get();
                $leaveCount = $leaveTransactionsOfTeam->count();
                $this->leaveTransactions = $leaveTransactionsOfTeam;
            }
            return $leaveCount;
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Database Error: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while processing your request. Please try again later.');
        } catch (\Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
            session()->flash('error', 'An unexpected error occurred. Please try again later.');
        }
    }
    protected function getTeamOnLeaveDataForDay($day)
    {
        // Fetch team leave data from your database

        return LeaveRequest::where('from_date', $day)->get();
    }

    protected function isRestrictedHolidayForDay($day)
    {
        // Check if $day is a restricted holiday
        return LeaveRequest::where('from_date', $day)->get();
    }

    public $showAccordion = true;
    public function dateClicked($date)
    {
        try {
            $this->showAccordion = true;
            $this->selectedDate = Carbon::createFromDate($this->year, $this->month, (int)$date)->format('Y-m-d');
            $this->loadLeaveTransactions($this->selectedDate, $this->filterCriteria);
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while processing your request. Please try again later.');
            Log::error('Error in dateClicked: ' . $e->getMessage());
            return redirect()->back();
        }
    }




    public function render()
    {
        try {
            $holidays = $this->getHolidays();

            return view('livewire.leave-calender', [
                'holidays' => $holidays,
                'leaveTransactions' => $this->leaveTransactions,
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

    public function getHolidays()
    {
        try {
            // Extract only the date part before the space
            $dateParts = explode(' ', $this->selectedDate);
            $dateOnly = $dateParts[0]; // Take only the date part

            // Get only the first two characters for the date part
            $dateFormatted = substr($dateOnly, 0, 10);

            // Parse the cleaned date
            $clickedDate = Carbon::parse($dateFormatted);

            return HolidayCalendar::whereDate('date', $clickedDate->toDateString())->get();
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
    public function calculateNumberOfDays($fromDate, $fromSession, $toDate, $toSession, $leaveType)
    {
        try {
            $startDate = Carbon::parse($fromDate);
            $endDate = Carbon::parse($toDate);

            // Check if the start or end date is a weekend
            if ($startDate->isWeekend() || $endDate->isWeekend()) {
                return 0;
            }

            // Check if the start and end sessions are different on the same day
            if (
                $startDate->isSameDay($endDate) &&
                $this->getSessionNumber($fromSession) === $this->getSessionNumber($toSession)
            ) {
                // Inner condition to check if both start and end dates are weekdays
                if (!$startDate->isWeekend() && !$endDate->isWeekend()) {
                    return 0.5;
                } else {
                    // If either start or end date is a weekend, return 0
                    return 0;
                }
            }

            if (
                $startDate->isSameDay($endDate) &&
                $this->getSessionNumber($fromSession) !== $this->getSessionNumber($toSession)
            ) {
                // Inner condition to check if both start and end dates are weekdays
                if (!$startDate->isWeekend() && !$endDate->isWeekend()) {
                    return 1;
                } else {
                    // If either start or end date is a weekend, return 0
                    return 0;
                }
            }

            $totalDays = 0;

            while ($startDate->lte($endDate)) {
                if ($leaveType == 'Sick Leave') {
                    $totalDays += 1;
                } else {
                    if ($startDate->isWeekday()) {
                        $totalDays += 1;
                    }
                }
                // Move to the next day
                $startDate->addDay();
            }

            // Deduct weekends based on the session numbers
            if ($this->getSessionNumber($fromSession) > 1) {
                $totalDays -= $this->getSessionNumber($fromSession) - 1; // Deduct days for the starting session
            }
            if ($this->getSessionNumber($toSession) < 2) {
                $totalDays -= 2 - $this->getSessionNumber($toSession); // Deduct days for the ending session
            }
            // Adjust for half days
            if ($this->getSessionNumber($fromSession) === $this->getSessionNumber($toSession)) {
                // If start and end sessions are the same, check if the session is not 1
                if ($this->getSessionNumber($fromSession) !== 1) {
                    $totalDays += 0.5; // Add half a day
                } else {
                    $totalDays += 0.5;
                }
            } elseif ($this->getSessionNumber($fromSession) !== $this->getSessionNumber($toSession)) {
                if ($this->getSessionNumber($fromSession) !== 1) {
                    $totalDays += 1; // Add half a day
                }
            } else {
                $totalDays += ($this->getSessionNumber($toSession) - $this->getSessionNumber($fromSession) + 1) * 0.5;
            }

            return $totalDays;
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
    private function getSessionNumber($session)
    {
        // You might need to customize this based on your actual session values
        return (int) str_replace('Session ', '', $session);
    }
    public function downloadexcelforLeave()
    {
        try {
            $userId = Auth::id();
            $user = EmployeeDetails::find($userId);
            $managerId = $user->manager_id;
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $startDate = Carbon::create($this->year, $this->month, 1)->startOfMonth();
            $endDate = Carbon::create($this->year, $this->month, 1)->endOfMonth();
            $formattedStartDate = Carbon::create($this->year, $this->month, 1)->startOfMonth()->toDateString();
            $formattedEndDate = Carbon::create($this->year, $this->month, 1)->endOfMonth()->toDateString();

            // Fetch company name and address based on user's company ID
            $companyIds = EmployeeDetails::where('emp_id', $userId)->value('company_id');
            $companyIdsArray = is_array($companyIds) ? $companyIds : json_decode($companyIds, true);

            if (count($companyIdsArray) === 1) {
                $companyName = Company::whereIn('company_id', $companyIdsArray)->value('company_name');
                $companyDetails = Company::whereIn('company_id', $companyIdsArray)
                    ->select('company_present_address', 'company_perminent_address')
                    ->first();
            } else {
                $companyName = Company::whereIn('company_id', $companyIdsArray)
                    ->where('is_parent', 'yes')
                    ->value('company_name');
                $companyDetails = Company::whereIn('company_id', $companyIdsArray)
                    ->where('is_parent', 'yes')
                    ->select('company_present_address', 'company_perminent_address')
                    ->first();
            }

            // Default values if no company info is found
            if (!$companyName || !$companyDetails) {
                $companyName = 'N/A';
                $companyDetails = (object)[
                    'company_present_address' => 'N/A',
                    'company_perminent_address' => 'N/A'
                ];
            }

            $companyAddress1 = $companyDetails->company_present_address;
            $companyAddress2 = $companyDetails->company_perminent_address;
            $concatenatedAddress = $companyAddress1 . ' ' . $companyAddress2;

            // Fetch employees on leave
            if ($this->filterCriteria === 'MyTeam') {
                // Fetch employee IDs of all team members under the same manager with active or on-probation status
                $checkLoginIsManager = EmployeeDetails::where('manager_id', $employeeId)->value('manager_id');
                $managerId = EmployeeDetails::where('emp_id', $employeeId)->value('manager_id');
                if ($checkLoginIsManager) {
                    $teamMembers = EmployeeDetails::whereJsonContains('company_id', $companyIdsArray)
                        ->where('manager_id', $checkLoginIsManager) // Filter by manager_id
                        ->whereIn('employee_status', ['active', 'on-probation']) // Add this condition
                        ->pluck('emp_id')
                        ->toArray();
                } else {
                    $teamMembers = EmployeeDetails::whereJsonContains('company_id', $companyIdsArray)
                        ->where('manager_id', $managerId)
                        // Filter by manager_id
                        ->pluck('emp_id')
                        ->toArray();
                }
                // Fetch leave requests for the team members
                $employeesOnLeave = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
                    ->where('leave_applications.category_type', 'Leave')
                    ->where(function ($query) use ($formattedStartDate, $formattedEndDate) {
                        $query->whereBetween('from_date', [$formattedStartDate, $formattedEndDate])
                            ->orWhereBetween('to_date', [$formattedStartDate, $formattedEndDate])
                            ->orWhere(function ($subQuery) use ($formattedStartDate, $formattedEndDate) {
                                $subQuery->where('from_date', '<=', $formattedStartDate)
                                    ->where('to_date', '>=', $formattedEndDate);
                            });
                    })
                    ->where(function ($query) {
                        $query->where('leave_applications.status', 'approved')
                            ->where('leave_applications.cancel_status', '!=', 'approved');
                    })
                    ->whereIn('leave_applications.emp_id', $teamMembers) // Use the team member IDs here
                    ->select('employee_details.first_name', 'employee_details.last_name', 'leave_applications.from_date', 'leave_applications.to_date', 'leave_applications.leave_type', 'employee_details.emp_id')
                    ->get();
            } elseif ($this->filterCriteria === 'Me') {
                $employeesOnLeave = LeaveRequest::join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
                    ->where(function ($query) use ($formattedStartDate, $formattedEndDate) {
                        $query->whereBetween('from_date', [$formattedStartDate, $formattedEndDate])
                            ->orWhereBetween('to_date', [$formattedStartDate, $formattedEndDate])
                            ->orWhere(function ($subQuery) use ($formattedStartDate, $formattedEndDate) {
                                $subQuery->where('from_date', '<=', $formattedStartDate)
                                    ->where('to_date', '>=', $formattedEndDate);
                            });
                    })
                    ->where('leave_applications.status', 'approved')
                    ->where('employee_details.emp_id', $userId)
                    ->select('employee_details.first_name', 'employee_details.last_name', 'leave_applications.from_date', 'leave_applications.to_date', 'leave_applications.leave_type', 'employee_details.emp_id')
                    ->get();
            }


            // Create a new spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set header data and apply styles (with company info)
            $sheet->setCellValue('A1', $companyName);
            $sheet->setCellValue('A2', $concatenatedAddress);
            $sheet->setCellValue('A3', $this->filterCriteria == 'Me' ? 'My Leave' : 'My Team Leave');

            // Header row
            $sheet->setCellValue('A4', 'Employee No');
            $sheet->setCellValue('B4', 'Name of the Employee');
            $sheet->setCellValue('C4', 'Type');
            $sheet->setCellValue('D4', 'Days');
            $sheet->setCellValue('E4', 'From Date');
            $sheet->setCellValue('F4', 'To Date');
            $sheet->setCellValue('G4', 'Remarks');

            // Apply styles to header row
            $headerStyleArray = [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                ],
            ];
            $sheet->getStyle('A4:G4')->applyFromArray($headerStyleArray);

            // Set column widths to be the same
            foreach (range('A', 'G') as $columnID) {
                $sheet->getColumnDimension($columnID)->setWidth(20);
            }

            // Insert data
            $row = 5; // Start from row 5
            foreach ($employeesOnLeave as $eol) {
                $fromDate = Carbon::parse($eol->from_date);
                $toDate = Carbon::parse($eol->to_date);
                $numberOfDays = $fromDate->diffInDays($toDate) + 1;

                $sheet->setCellValue('A' . $row, $eol->emp_id);
                $sheet->setCellValue('B' . $row, $eol->first_name . ' ' . $eol->last_name);
                $sheet->setCellValue('C' . $row, $eol->leave_type);
                $sheet->setCellValue('D' . $row, $numberOfDays);
                $sheet->setCellValue('E' . $row, $fromDate->format('d M,Y'));
                $sheet->setCellValue('F' . $row, $toDate->format('d M,Y'));
                $sheet->setCellValue('G' . $row, '');

                // Apply borders to all data rows
                $sheet->getStyle('A' . $row . ':G' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $row++;
            }

            // Save the file
            $writer = new Xlsx($spreadsheet);
            $filePath = storage_path('app/leave calendar.xlsx');
            $writer->save($filePath);

            // Return file for download
            return response()->download($filePath, 'leave calendar.xlsx');
        } catch (\Exception $e) {
            Log::error('Error generating Excel: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while processing your request. Please try again later.');
        }
    }
}
