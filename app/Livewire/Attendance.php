<?php
/*Created by:Pranita Priyadarshi*/
/*This submodule will be showing users swipe time and also ur attendance status*/
// File Name                       : Attendance.php
// Description                     : This file contains the implementation of a EmployeesAttendance by this we can know attendance of particular employees in a month.
// Creator                         : Pranita Priyadarshi
// Email                           : priyadarshipranita72@gmail.com
// Organization                    : PayG.
// Date                            : 2023-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : LeaveRequest,EmployeeDetails,HolidayCalendar,SwipeRecord
namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\SwipeRecord;
use App\Models\HolidayCalendar;
use App\Models\LeaveRequest;
use Livewire\Component;
use Carbon\Carbon;

class Attendance extends Component
{
    public $currentDate2;
    public $hours;
    public $minutesFormatted;
    public $last_out_time;
    public $currentDate;
    public $date1;
    public $clickedDate;
    public $currentWeekday;
    public $calendar;
    public $selectedDate;
    public $shortFallHrs;
    public $work_hrs_in_shift_time;
    public $swipe_record;
    public $holiday;
    public $leaveApplies;
    public $first_in_time;
    public $year;
    public $currentDate2record;
    public $month;
    public $actualHours = [];
    public $firstSwipeTime;
    public $secondSwipeTime;
    public $swiperecords;
    public $currentDate1;
    public $swiperecord;
    public $showCalendar = true;
    public $date2;
    public $modalTitle = '';
    public $view_student_swipe_time;
    public $view_student_in_or_out;
    public $swipeRecordId;
    public $from_date;
    public $to_date;
    public $status;
    public $dynamicDate;
    public $view_student_emp_id;
    public $view_employee_swipe_time;
    public $currentDate2recordexists;
    public $dateclicked;
    public $view_table_in;
    public $view_table_out;
    public $employeeDetails;
    public $changeDate = 0;
    public $student;
    public $selectedRecordId = null;
    public $distinctDates;
    public $isPresent;
    public $table;
     public $previousMonth;
    public $session1 = 0;
    public $session2 = 0;
    public $session1ArrowDirection = 'right';
    public $session2ArrowDirection = 'right';
    public $avgSwipeInTime=null;
    public $avgSwipeOutTime=null;
    public $totalDays;
    public $avgWorkHours = 0;
    public $avgLateIn = 0;
    public $avgEarlyOut = 0;
    public function toggleSession1Fields()
    {

        $this->session1 = !$this->session1;
        $this->session1ArrowDirection = ($this->session1) ? 'left' : 'right';
    }
    public function toggleSession2Fields()
    {
        $this->session2 = !$this->session2;
        $this->session2ArrowDirection = ($this->session2) ? 'left' : 'right';
        // dd($this->session1);
    }
    public function mount()
    {
        //insights
        $this->from_date = now()->startOfMonth()->toDateString();
        $this->to_date = now()->toDateString();
        $this->updateModalTitle();
        $this->calculateTotalDays();

        $this->previousMonth = Carbon::now()->subMonth()->format('F');

        $swipeRecords = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->get();

        // Group the swipe records by the date part only
        $groupedDates = $swipeRecords->groupBy(function ($record) {
            return Carbon::parse($record->created_at)->format('Y-m-d');
        });
        $this->distinctDates = $groupedDates->mapWithKeys(function ($records, $key) {
            $inRecord = $records->where('in_or_out', 'IN')->first();
            $outRecord = $records->where('in_or_out', 'OUT')->last();

            return [$key => [
                'in' => "IN",
                'first_in_time' => optional($inRecord)->swipe_time,
                'last_out_time' => optional($outRecord)->swipe_time,
                'out' => "OUT",
            ]];
        });

        // Get the current date and store it in the $currentDate property
        $this->currentDate = date('d');
        $this->currentWeekday = date('D');
        $this->currentDate1 = date('d M Y');
        $this->swiperecords = SwipeRecord::all();
        $this->year = now()->year;
        $this->month = now()->month;
        $this->generateCalendar();
    }

    public $k, $k1;
    public $showMessage = false;

    public function showBars()
    {
        $this->showMessage = false;
    }

    protected function getPublicHolidaysForMonth($year, $month)
    {
        return HolidayCalendar::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();
    }
    public function showlargebox($k)
    {
        $this->k1 = $k;
        $this->dispatchBrowserEvent('refreshModal', ['k1' => $this->k1]);
    }
    private function isEmployeePresentOnDate($date)
    {

        return SwipeRecord::whereDate('created_at', $date)->exists();
    }
    private function isEmployeeLeaveOnDate($date, $employeeId)
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        return LeaveRequest::where('emp_id', $employeeId)
            ->where('status', 'approved')
            ->where(function ($query) use ($date) {
                $query->whereDate('from_date', '<=', $date)
                    ->whereDate('to_date', '>=', $date);
            })
            ->exists();
    }
    private function getLeaveType($date, $employeeId)
    {
        $leaveType = LeaveRequest::where('emp_id', $employeeId)
            ->whereDate('from_date', '<=', $date)
            ->whereDate('to_date', '>=', $date)
            ->value('leave_type');

        return $leaveType;
    }
    public function generateCalendar()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
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
                        'backgroundColor' => '',
                        'status' => '',
                        'onleave' => ''
                    ];
                } elseif ($dayCount <= $daysInMonth) {
                    $isToday = $dayCount === $today->day && $this->month === $today->month && $this->year === $today->year;
                    $isPublicHoliday = in_array(
                        Carbon::create($this->year, $this->month, $dayCount)->toDateString(),
                        $publicHolidays->pluck('date')->toArray()
                    );

                    $backgroundColor = $isPublicHoliday ? 'background-color: IRIS;' : '';

                    $date = Carbon::create($this->year, $this->month, $dayCount)->toDateString();

                    // Check if the employee is absent
                    $isAbsent = !$this->isEmployeePresentOnDate($date);
                    $isonLeave = $this->isEmployeeLeaveOnDate($date, $employeeId);
                    $leaveType = $this->getLeaveType($date, $employeeId);
                    if ($isonLeave) {
                        $leaveType = $this->getLeaveType($date, $employeeId);

                        switch ($leaveType) {
                            case 'Causal Leave Probation':
                                $status = 'CLP'; // Casual Leave Probation
                                break;
                            case 'Sick Leave':
                                $status = 'SL'; // Sick Leave
                                break;
                            case 'Loss Of Pay':
                                $status = 'LOP'; // Loss of Pay
                                break;
                            default:
                                $status = 'L'; // Default to 'L' if the leave type is not recognized
                                break;
                        }
                    } else {
                        // Employee is not on leave, check for absence or presence
                        $isAbsent = !$this->isEmployeePresentOnDate($date);

                        // Set the status based on presence
                        $status = $isAbsent ? 'A' : 'P';
                    }
                    // Set the status based on presence
                    $week[] = [
                        'day' => $dayCount,
                        'isToday' => $isToday,
                        'isPublicHoliday' => $isPublicHoliday,
                        'isCurrentMonth' => true,
                        'isPreviousMonth' => false,
                        'backgroundColor' => $backgroundColor,
                        'status' => $status,
                    ];

                    $dayCount++;
                } else {
                    $week[] = [
                        'day' => $dayCount - $daysInMonth,
                        'isToday' => false,
                        'isPublicHoliday' => in_array($lastDayOfPreviousMonth->copy()->addDays($dayCount - $daysInMonth)->toDateString(), $this->getPublicHolidaysForMonth($startOfPreviousMonth->year, $startOfPreviousMonth->month)->pluck('date')->toArray()),
                        'isCurrentMonth' => false,
                        'isNextMonth' => true,
                        'backgroundColor' => '', 
                        'status' => '',
                    ];
                    $dayCount++;
                }
            }
            $calendar[] = $week;
        }

        $this->calendar = $calendar;
    }
    public function updateDate($date1)
    {
        $parsedDate = Carbon::parse($date1);

        if ($parsedDate->format('Y-m-d') < Carbon::now()->format('Y-m-d')) {
            $this->changeDate = 1;
        }

    }
    public function dateClicked($date1)
    {
        $date1 = trim($date1);
        $this->selectedDate = $this->year . '-' . $this->month . '-' . str_pad($date1, 2, '0', STR_PAD_LEFT);
        $isSwipedIn = SwipeRecord::whereDate('created_at', $date1)->where('in_or_out', 'In')->exists();
        $isSwipedOut = SwipeRecord::whereDate('created_at', $date1)->where('in_or_out', 'Out')->exists();


        if (!$isSwipedIn) {
            // Employee did not swipe in
            $this->selectedDate = $date1;
            $this->status = 'A';
        } elseif (!$isSwipedOut) {
            // Employee swiped in but not out
            $this->selectedDate = $date1;
            $this->status = 'P';
        }
        $this->updateDate($date1);
        $this->dateclicked = $date1;
    }

    public function updatedFromDate($value)
    {
        // Additional logic if needed when from_date is updated
        $this->from_date = $value;
        $this->updateModalTitle();
    }

    public function updatedToDate($value)
    {
        // Additional logic if needed when to_date is updated
        $this->to_date = $value;
        $this->updateModalTitle();
    }

    private function updateModalTitle()
    {
        // Format the dates and update the modal title
        $formattedFromDate = Carbon::parse($this->from_date)->format('d M');
        $formattedToDate = Carbon::parse($this->to_date)->format('d M');
        $this->modalTitle = "Insights for Attendance Period $formattedFromDate - $formattedToDate";
    }
    public function calculateTotalDays()
    {
      $employeeId= auth()->guard('emp')->user()->emp_id;
      $startDate = Carbon::parse($this->from_date);
      $endDate = Carbon::parse($this->to_date);
      $originalEndDate = $endDate->copy();
       if ($endDate->isToday()) {
            // Exclude today's date
            $endDate->subDay();
        }
        $totalDays = $this->calculateWorkingDays($startDate, $endDate, $employeeId);
   
       $swipeRecords = SwipeRecord::where('emp_id', $employeeId)
          ->whereBetween('created_at', [$startDate, $originalEndDate])
       ->get();
     
      // Group the swipe records by the date part only
      $groupedDates = $swipeRecords->groupBy(function ($record) {
          return Carbon::parse($record->created_at)->format('Y-m-d');
       });
     $totalLateIn = 0;
     $totalEarlyOut = 0;
     $totalValidDays = 0;
     $signInTotalTime = 0;
     $signOutTotalTime = 0;
     $averageSwipeInTime = [];
     $averageSwipeOutTime = [];

      foreach ($swipeRecords as  $records)
       {
          $inRecord = null;
          $outRecord = null;
           if ($records->in_or_out === 'IN') {
             // Calculate sign-in time
             $signInTime = Carbon::parse($records->swipe_time);
             $averageSwipeInTime[]=$signInTime;
              // Calculate total late-In
              $inTime = Carbon::parse($records->swipe_time);
              $expectedInTime = Carbon::parse('10:00:00');
              if ($inTime->gt($expectedInTime)) {
              $totalLateIn++;
              }
            }
           elseif ($records->in_or_out === 'OUT') {
             // Calculate sign-out time
             $signOutTime = Carbon::parse($records->swipe_time);
             $averageSwipeOutTime[]=$signOutTime;
             $outTime = Carbon::parse($records->swipe_time);
             $expectedOutTime = Carbon::parse('19:00:00');
               if ($outTime->lt($expectedOutTime)) {
                 $totalEarlyOut++;
                }
            }
         $totalValidDays++;
        }
        // Calculate the total time for swipe-in
        foreach ($averageSwipeInTime as $time) {
            $signInTotalTime += $time->timestamp;
        }
        // Calculate the total time for swipe-out
        foreach ($averageSwipeOutTime as $time) {
            $signOutTotalTime += $time->timestamp;
        }
       
        // Calculate average swipe-in time if there are valid days
       if (count($averageSwipeInTime) > 0) {
          $avgSwipeInTimestamp = $signInTotalTime / count($averageSwipeInTime);
         // Create Carbon instance representing the average swipe-in time
         $averageSwipeInTime = Carbon::createFromTimestamp($avgSwipeInTimestamp);
         // Format the resulting time
         $this->avgSwipeInTime = $averageSwipeInTime->format('H:i');  
        }
 
        // Calculate average swipe-out time if there are valid days
        if (count($averageSwipeOutTime) > 0) {
         $avgSwipeOutTimestamp = $signOutTotalTime / count($averageSwipeOutTime);
         // Create Carbon instance representing the average swipe-out time
         $averageSwipeOutTime = Carbon::createFromTimestamp($avgSwipeOutTimestamp);
         // Format the resulting time
         $this->avgSwipeOutTime = $averageSwipeOutTime->format('H:i');
        }
       
      //// Calculate total(LateIn,EarlyOut)
      $this->avgLateIn=$totalLateIn;
      $this->avgEarlyOut=$totalEarlyOut;

      $this->totalDays = $totalDays;
    }
 
    private function calculateWorkingDays($startDate, $endDate, $employeeId)
    {
      $workingDays = 0;
      $currentDate = $startDate->copy();
 
      while ($currentDate->lte($endDate))
      {
        if ($currentDate->isWeekday() && !$this->isEmployeeLeaveOnDate($currentDate, $employeeId) && $this->isEmployeePresentOnDate($currentDate)) {
            $workingDays++;
        }
        $currentDate->addDay();
      }
 
     return $workingDays;
    }
    private function calculateActualHours($swipe_records)
    {
        $this->actualHours = [];

        for ($i = 0; $i < count($swipe_records) - 1; $i += 2) {
            $firstSwipeTime = strtotime($swipe_records[$i]->swipe_time);
            $secondSwipeTime = strtotime($swipe_records[$i + 1]->swipe_time);

            $timeDifference = $secondSwipeTime - $firstSwipeTime;

            $hours = floor($timeDifference / 3600);
            $minutes = floor(($timeDifference % 3600) / 60);

            $this->actualHours[] = sprintf("%02dhrs %02dmins", $hours, $minutes);
        }
    }
    public function viewDetails($id)
    {
        $student = SwipeRecord::find($id);
        $this->view_student_emp_id = $student->emp_id;
        $this->view_student_swipe_time = $student->swipe_time;
        $this->view_student_in_or_out = $student->in_or_out;
        $this->showSR = true;
    }

    public function closeViewStudentModal()
    {
        $this->view_student_emp_id = '';
        $this->view_student_swipe_time = '';
        $this->view_student_in_or_out = '';
    }

    public $show = false;
    public $show1 = false;
    public function showViewStudentModal()
    {
        $this->show = true;
    }

    public function showViewTableModal()
    {
        $this->show1 = true;
    }

    public $showSR = false;
    public function openSwipes()
    {

        $this->showSR = true;
    }
    public function closeSWIPESR()
    {
        $this->showSR = false;
        $this->showSR = false;
    }
    public function close1()
    {
        $this->show1 = false;
    }
    public function beforeMonth()
    {

        $date = Carbon::create($this->year, $this->month, 1)->subMonth();
        $this->year = $date->year;
        $this->month = $date->month;
        $this->generateCalendar();
    }
    public function nextMonth()
    {
        $date = Carbon::create($this->year, $this->month, 1)->addMonth();
        $this->year = $date->year;
        $this->month = $date->month;
        $this->generateCalendar();
    }

    public function render()
    {
        $this->dynamicDate = now()->format('Y-m-d');
        $currentDate = Carbon::now()->format('Y-m-d');
        $holiday = HolidayCalendar::all();

        $today = Carbon::today();
        $data = SwipeRecord::join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
            ->where('swipe_records.emp_id', auth()->guard('emp')->user()->emp_id)
            ->whereDate('swipe_records.created_at', $today)
            ->select('swipe_records.*', 'employee_details.first_name', 'employee_details.last_name')
            ->get();
        $this->holiday = HolidayCalendar::all();
        $this->leaveApplies = LeaveRequest::where('emp_id', auth()->guard('emp')->user()->emp_id)->get();

        if ($this->changeDate == 1) {

            $currentDate2 = $this->dateclicked;

            $this->currentDate2record = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->whereDate('created_at', $currentDate2)->get();

            if (!empty($this->currentDate2record) && isset($this->currentDate2record[0]) && isset($this->currentDate2record[1])) {
                $this->first_in_time = substr($this->currentDate2record[0]['swipe_time'], 0, 5);

                $this->last_out_time = substr($this->currentDate2record[1]['swipe_time'], 0, 5);
                $firstInTime = Carbon::createFromFormat('H:i', $this->first_in_time);
                $lastOutTime = Carbon::createFromFormat('H:i', $this->last_out_time);

                // Check if the last out time is less than the first in time (crosses midnight)
                if ($lastOutTime < $firstInTime) {
                    $lastOutTime->addDay(); // Add a day to the last out time
                }

                if ($lastOutTime < $firstInTime) {
                    $lastOutTime->addDay(); // Add a day to the last out time
                }

                // Calculate the difference
                $timeDifferenceInMinutes = $lastOutTime->diffInMinutes($firstInTime);

                // Calculate hours and minutes
                $this->hours = floor($timeDifferenceInMinutes / 60);

                $minutes = $timeDifferenceInMinutes % 60;
                $this->minutesFormatted = str_pad($minutes, 2, '0', STR_PAD_LEFT);
            } elseif (!isset($this->currentDate2record[1]) && isset($this->currentDate2record[0])) {

                $this->first_in_time = substr($this->currentDate2record[0]['swipe_time'], 0, 5);
                $this->last_out_time = substr($this->currentDate2record[0]['swipe_time'], 0, 5);
            } else {
                $this->first_in_time = '-';
                $this->last_out_time = '-';
            }
            if ($this->first_in_time == $this->last_out_time) {
                $this->shortFallHrs = '08:59';
                $this->work_hrs_in_shift_time = '-';
            } else {
                $this->shortFallHrs = '-';
                $this->work_hrs_in_shift_time = '09:00';
            }
            $this->currentDate2recordexists = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->whereDate('created_at', $currentDate2)->exists();
        } else {
            $currentDate2 = Carbon::now()->format('Y-m-d');
        }

        $swipe_records = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->whereDate('created_at', $currentDate)->get();
        $swipe_records1 = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->orderBy('created_at', 'desc')->get();

        $this->calculateActualHours($swipe_records);
        return view('livewire.attendance', ['Holiday' => $this->holiday, 'Swiperecords' => $swipe_records, 'Swiperecords1' => $swipe_records1, 'data' => $data, 'CurrentDate' => $currentDate2, 'CurrentDateTwoRecord' => $this->currentDate2record, 'ChangeDate' => $this->changeDate, 'CurrentDate2recordexists' => $this->currentDate2recordexists,
        'avgLateIn' => $this->avgLateIn,'avgEarlyOut' => $this->avgEarlyOut,
        'avgSignInTime'=>$this->avgSwipeInTime,'avgSignOutTime'=>$this->avgSwipeOutTime,
        'modalTitle'=>$this->modalTitle,'totalDays'=>$this->totalDays
        ]);
    }
}
