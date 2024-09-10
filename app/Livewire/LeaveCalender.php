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
        $this->loadLeaveTransactions(now()->toDateString(),$this->filterType);
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
        $this->loadLeaveTransactions($this->date,$this->filterType);
    }

    public function loadLeaveTransactions($date,$filterType)
    {
        try {
            // Retrieve the authenticated employee's ID and company ID
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $companyId = auth()->guard('emp')->user()->company_id;
            $dateFormatted = Carbon::parse($date)->format('Y-m-d');
            $leaveCount = 0; // Initialize leave count variable

            // Apply search term condition
            $searchTerm = '%' . $this->searchTerm . '%';

            if ($this->filterCriteria === 'Me') {
                // Query for leave transactions of the logged-in employee
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
            } elseif ($this->filterCriteria === 'MyTeam') {
                // Retrieve the manager_id and team members
                $teamMembersIds = EmployeeDetails::where('manager_id', $employeeId)
                    ->where('company_id', $companyId)
                    ->pluck('emp_id')
                    ->toArray();

                // Query for leave transactions of team members
                $leaveTransactionsOfTeam = LeaveRequest::with('employee')
                    ->whereIn('emp_id', $teamMembersIds)
                    ->whereDate('from_date', '<=', $dateFormatted)
                    ->whereDate('to_date', '>=', $dateFormatted)
                    ->where('status', 'approved')
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
            // Handle database query exceptions
            Log::error('Database Error: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while processing your request. Please try again later.');
        } catch (\Exception $e) {
            // Handle other general exceptions
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
            $date = (int) $date;
            $this->selectedDate = Carbon::createFromDate($this->year, $this->month, $date)->format('Y-m-d');
            $this->loadLeaveTransactions($this->selectedDate, $this->filterType);
        } catch (\Exception $e) {
            // Store the error message in the session
            session()->flash('error', 'An error occurred while processing your request. Please try again later.');

            // Log the error
            Log::error('An error occurred while processing dateClicked: ' . $e->getMessage());

            // Redirect back to the previous page
            return redirect()->back();
        }
    }



    public function render()
    {
        try {
            $this->leaveData = LeaveRequest::where('emp_id', auth()->guard('emp')->user()->emp_id)
                ->where('status', 'approved')
                ->get();
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
    public  function calculateNumberOfDays($fromDate, $fromSession, $toDate, $toSession)
    {
        try {

            $startDate = Carbon::parse($fromDate);
            $endDate = Carbon::parse($toDate);
            // Check if the start and end sessions are different on the same day
            if ($startDate->isSameDay($endDate) && $this->getSessionNumber($fromSession) === $this->getSessionNumber($toSession)) {
                // Inner condition to check if both start and end dates are weekdays
                if (!$startDate->isWeekend() && !$endDate->isWeekend()) {
                    return 0.5;
                } else {
                    // If either start or end date is a weekend, return 0
                    return 0;
                }
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
                // Check if it's a weekday (Monday to Friday)
                if ($startDate->isWeekday()) {
                    $totalDays += 1;
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
            $startDate = Carbon::create($this->year, $this->month, 1)->startOfMonth();

            // Ending date of the current month and year
            $endDate = Carbon::create($this->year, $this->month, 1)->endOfMonth();

            // Format the dates as per your requirement
            $formattedStartDate = $startDate->toDateString();

            $formattedEndDate = $endDate->toDateString();

            if ($this->filterCriteria == 'MyTeam') {
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
                    ->where(function ($query) use ($managerId) {
                        $query->whereJsonContains('leave_applications.applying_to', [['manager_id' => $managerId]])
                            ->orWhereJsonContains('leave_applications.applying_to', ['manager_id' => $managerId]);
                    })
                    ->select('employee_details.first_name', 'employee_details.last_name', 'leave_applications.from_date', 'leave_applications.to_date', 'leave_applications.leave_type', 'employee_details.emp_id')
                    ->get();
            } elseif ($this->filterCriteria == 'Me') {
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
                    ->where(function ($query) use ($managerId) {
                        $query->whereJsonContains('leave_applications.applying_to', [['manager_id' => $managerId]])
                            ->orWhereJsonContains('leave_applications.applying_to', ['manager_id' => $managerId]);
                    })
                    ->where('employee_details.emp_id', $userId)
                    ->select('employee_details.first_name', 'employee_details.last_name', 'leave_applications.from_date', 'leave_applications.to_date', 'leave_applications.leave_type', 'employee_details.emp_id')
                    ->get();
            }
            // Now $employeesOnLeave contains employee first_name and last_name for the specified conditions
            $companyName = EmployeeDetails::join('companies', 'employee_details.company_id', '=', 'companies.company_id')
                ->where('employee_details.emp_id', $userId)
                ->value('companies.company_name');

            $companyDetails = EmployeeDetails::join('companies', 'employee_details.company_id', '=', 'companies.company_id')
                ->where('employee_details.emp_id', $userId)
                ->select('companies.company_present_address', 'companies.company_perminent_address')
                ->first();

            if ($companyDetails) {
                $companyAddress1 = $companyDetails->company_address1;
                $companyAddress2 = $companyDetails->company_address2;
                $concatenatedAddress = $companyAddress1 . ' ' . $companyAddress2;
            } else {
                // Handle the case where no result is found
                $concatenatedAddress = null; // Or any other default value or action
            }
            $data[] = [$companyName];
            $data[] = [$concatenatedAddress];
            if ($this->filterCriteria == 'Me') {
                $data[] = ['My Leave ' . Carbon::createFromFormat('Y-m-d', $formattedStartDate)->format('d M Y') . 'to ' . Carbon::createFromFormat('Y-m-d', $formattedEndDate)->format('d M Y')];
            } else if ($this->filterCriteria == 'MyTeam') {
                $data[] = ['My Team Leave ' . Carbon::createFromFormat('Y-m-d', $formattedStartDate)->format('d M Y') . 'to ' . Carbon::createFromFormat('Y-m-d', $formattedEndDate)->format('d M Y')];
            }

            //   $data[] = ['Early Employees on ' .  $formattedDate, '', '', ''];
            $data[] = ['Employee No', 'Name of the Employee', 'Type', 'Days', 'From Date', 'To Date', 'Remarks'];

            foreach ($employeesOnLeave as $eol) {
                $fromDate = Carbon::parse($eol->from_date);
                $toDate = Carbon::parse($eol->to_date);
                $numberOfDays = $fromDate->diffInDays($toDate, false);
                $numberOfDays = $numberOfDays + 1;
                $numberOfDaysFloat = (float) $numberOfDays;
                $data[] = [$eol->emp_id, $eol->first_name . '  ' . $eol->last_name, $eol->leave_type, $numberOfDaysFloat, $fromDate->format('d M,Y'), $toDate->format('d M,Y'), ' '];
            }

            $filePath = storage_path('app/leaveApplications.xlsx');

            SimpleExcelWriter::create($filePath)->addRows($data);

            return response()->download($filePath, 'leaveApplications.xlsx');
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
