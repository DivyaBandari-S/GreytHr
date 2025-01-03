<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\EmpPersonalInfo;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Notification as ModelsNotification;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Notification extends Component
{
    public $matchingLeaveRequestsCount;
    public $chatNotificationCount;
    public $matchingLeaveRequests;
    public $senderDetails;
    public $messagenotifications;
    public $leaveApproveNotification;
    public $leaveRejectNotification;
    public $leavenotifications, $leavecancelnotifications;
    public $tasknotifications;
    public $successfulYears;
    public $totalnotifications;
    public $totalnotificationscount;
    public $birthdayRecord;
    public $manager_id;
    public $totalBirthdays;
    public $isYourBirthday = false;
    public $isYourJoining = false;
    public $getRemainingBirthday;
    public $birthdayTime;
    public $newJoinRecord;
    public $getRemainingJoinees;
    public $totalJoinees;
    public $joiningTime;

    public $expEmpRecord;
    public $getRemainingExpEmp;
    public $totalExpEmp;

    public function mount()
    {
        try {

            $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
            $CompanyId = Auth::user()->company_id[0];
            $this->getExpEmpList();
            $this->getNewlyJoinedEmpList();
            $today = now();
            $currentDate = $today->toDateString();
            $currentMonth = $today->month;
            $currentDay = $today->day;
            $this->birthdayTime = Carbon::parse($today->startOfDay())->diffForHumans();

            $employees = EmployeeDetails::whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                ->get(['emp_id']); // Only fetch the emp_id field

            // Initialize an empty array to store emp_ids with value 0
            $empIds = [];

            // Loop through the results and populate the array with emp_id => 0
            foreach ($employees as $employee) {
                $empIds[$employee->emp_id] = 0;
            }
            // dd(  $empIds);

            // Fetch employees whose birth_date matches today's month and day
            $birthdayEmployees = EmpPersonalInfo::whereMonth('date_of_birth', $currentMonth)
                ->whereDay('date_of_birth', $currentDay)
                ->join('employee_details', 'employee_details.emp_id', '=', 'emp_personal_infos.emp_id')
                ->whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                ->select('employee_details.*')
                ->get();

            $count = count($birthdayEmployees);

            if ($count > 0) {

                $isBirthdayAvailable = ModelsNotification::where('assignee', $CompanyId)
                    ->where('body', $currentDate)
                    ->where('notification_type', 'birthday')->get();

                // dd($isBirthdayAvailable);
                if (count($isBirthdayAvailable) > 0) {

                    if ($count != $isBirthdayAvailable[0]->chatting_id) {
                        ModelsNotification::where('id', $isBirthdayAvailable[0]->id)  // Ensure to specify the correct `id` to update
                            ->update([
                                'emp_id' => $loggedInEmpId,
                                'chatting_id' => $count,
                                'notification_type' => 'birthday',
                                'assignee' => $CompanyId,
                                'body' => $currentDate,  // Assuming `$today` contains the current date
                                'is_birthday_read' => json_encode($empIds)
                            ]);
                    }
                } else {
                    ModelsNotification::create([
                        'emp_id' => $loggedInEmpId,
                        'chatting_id' => $count,
                        'notification_type' => 'birthday',
                        'assignee' => $CompanyId,
                        'body' => $currentDate,  // Assuming `$today` contains the current date
                        'is_birthday_read' => json_encode($empIds)
                    ]);
                }
            } else {
                DB::table('notifications')
                    ->Where('body', $currentDate)
                    ->where('notification_type', 'birthday')
                    ->where('assignee', $CompanyId)
                    ->delete();
            }

            $this->fetchNotifications();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getExpEmpList()
    {
        try {
            $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
            $CompanyId = Auth::user()->company_id[0];
            $today = now();
            $currentDate = $today->toDateString();
            $currentMonth = $today->month;
            $currentDay = $today->day;
            $this->joiningTime = Carbon::parse($today->startOfDay())->diffForHumans();
            $employees = EmployeeDetails::whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                ->get(['emp_id']); // Only fetch the emp_id field

            // Initialize an empty array to store emp_ids with value 0
            $empIds = [];

            // Loop through the results and populate the array with emp_id => 0
            foreach ($employees as $employee) {
                $empIds[$employee->emp_id] = 0;
            }

            $expEmployees = EmployeeDetails::whereMonth('hire_date', $currentMonth)
                ->whereDay('hire_date', $currentDay)
                ->whereYear('hire_date', '!=', date('Y'))
                ->whereNotIn('employee_status', ['resigned', 'terminated'])
                ->whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                ->select('employee_details.*')
                ->get();
            $expCount = count($expEmployees);

            if ($expCount > 0) {
                $isExpEmpAvailable = ModelsNotification::where('assignee', $CompanyId)
                    ->where('body', $currentDate)
                    ->where('notification_type', 'Experience')->get();
                if (count($isExpEmpAvailable) > 0) {
                    if ($expCount != $isExpEmpAvailable[0]->chatting_id) {
                        // You can choose to update the existing notification here or you can add new individual notifications
                        // Update for now (you can choose to leave it if not needed)
                        ModelsNotification::where('id', $isExpEmpAvailable[0]->id)
                            ->update([
                                'emp_id' => $loggedInEmpId,
                                'chatting_id' => $expCount,
                                'notification_type' => 'Experience',
                                'assignee' => $CompanyId,
                                'body' => $currentDate,
                                'is_birthday_read' => json_encode($empIds)
                            ]);
                    }
                } else {
                    // Create a notification for each new employee
                    foreach ($expEmployees as $newEmployee) {
                        ModelsNotification::create([
                            'emp_id' => $newEmployee->emp_id,
                            'chatting_id' => $expCount, // You might want to give a different chatting_id for each employee
                            'notification_type' => 'Experience',
                            'assignee' => $CompanyId,
                            'body' => $currentDate,
                            'is_birthday_read' => json_encode($empIds),
                            'new_employee_id' => $newEmployee->emp_id, // You can add an additional field to store which employee this is
                        ]);
                    }
                }
            } else {
                // If no new employees, delete the old notification for the current date
                DB::table('notifications')
                    ->Where('body', $currentDate)
                    ->where('notification_type', 'Experience')
                    ->where('assignee', $CompanyId)
                    ->delete();
            }

            // Fetch notifications after updates
            $this->fetchNotifications();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getNewlyJoinedEmpList()
    {
        try {
            $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
            $CompanyId = Auth::user()->company_id[0];
            $today = now();
            $currentDate = $today->toDateString();
            $currentMonth = $today->month;
            $currentDay = $today->day;
            $this->joiningTime = Carbon::parse($today->startOfDay())->diffForHumans();
            $employees = EmployeeDetails::whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                ->get(['emp_id']); // Only fetch the emp_id field

            // Initialize an empty array to store emp_ids with value 0
            $empIds = [];

            // Loop through the results and populate the array with emp_id => 0
            foreach ($employees as $employee) {
                $empIds[$employee->emp_id] = 0;
            }

            $newlyJoinedEmployees = EmployeeDetails::whereMonth('hire_date', $currentMonth)
                ->whereDay('hire_date', $currentDay)
                ->whereYear('hire_date', '=', date('Y'))
                ->whereNotIn('employee_status', ['resigned', 'terminated'])
                ->whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                ->select('employee_details.*')
                ->get();
            $Newcount = count($newlyJoinedEmployees);
            if ($Newcount > 0) {
                $isJoinedEmpAvailable = ModelsNotification::where('assignee', $CompanyId)
                    ->where('body', $currentDate)
                    ->where('notification_type', 'new join')->get();
                if (count($isJoinedEmpAvailable) > 0) {
                    if ($Newcount != $isJoinedEmpAvailable[0]->chatting_id) {
                        // You can choose to update the existing notification here or you can add new individual notifications
                        // Update for now (you can choose to leave it if not needed)
                        ModelsNotification::where('id', $isJoinedEmpAvailable[0]->id)
                            ->update([
                                'emp_id' => $loggedInEmpId,
                                'chatting_id' => $Newcount,
                                'notification_type' => 'new join',
                                'assignee' => $CompanyId,
                                'body' => $currentDate,
                                'is_birthday_read' => json_encode($empIds)
                            ]);
                    }
                } else {
                    // Create a notification for each new employee
                    foreach ($newlyJoinedEmployees as $newEmployee) {
                        ModelsNotification::create([
                            'emp_id' => $newEmployee->emp_id,
                            'chatting_id' => $Newcount, // You might want to give a different chatting_id for each employee
                            'notification_type' => 'new join',
                            'assignee' => $CompanyId,
                            'body' => $currentDate,
                            'is_birthday_read' => json_encode($empIds),
                            'new_employee_id' => $newEmployee->emp_id, // You can add an additional field to store which employee this is
                        ]);
                    }
                }
            } else {
                // If no new employees, delete the old notification for the current date
                DB::table('notifications')
                    ->Where('body', $currentDate)
                    ->where('notification_type', 'new join')
                    ->where('assignee', $CompanyId)
                    ->delete();
            }

            // Fetch notifications after updates
            $this->fetchNotifications();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function fetchNotifications()
    {
        try {
            $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
            $CompanyId = Auth::user()->company_id[0];
            $today = now();
            $currentDate = $today->toDateString();
            $currentMonth = $today->month;
            $currentDay = $today->day;

            $this->birthdayRecord = ModelsNotification::where('body', $currentDate)
                ->where('assignee', $CompanyId)
                ->where('notification_type', 'birthday')
                ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(is_birthday_read, '$.\"$loggedInEmpId\"')) = '0'")
                ->first();
            if ($this->birthdayRecord) {

                $YourBirthday = EmpPersonalInfo::whereMonth('date_of_birth', $currentMonth)
                    ->whereDay('date_of_birth', $currentDay)
                    ->join('employee_details', 'employee_details.emp_id', '=', 'emp_personal_infos.emp_id')
                    ->whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                    ->where('employee_details.emp_id', $loggedInEmpId)
                    ->first();

                $this->totalBirthdays = $this->birthdayRecord->chatting_id;
                // dd( $this->totalBirthdays);
                if ($YourBirthday) {
                    $this->isYourBirthday = true;
                    $this->totalBirthdays = $this->birthdayRecord->chatting_id - 1;

                    if ($this->totalBirthdays == 1) {
                        $this->getRemainingBirthday = EmpPersonalInfo::whereMonth('date_of_birth', $currentMonth)
                            ->whereDay('date_of_birth', $currentDay)
                            ->join('employee_details', 'employee_details.emp_id', '=', 'emp_personal_infos.emp_id')
                            ->whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                            ->select('employee_details.*')
                            ->where('employee_details.emp_id', '!=', $loggedInEmpId)
                            ->first();
                        //   dd( $this->getRemainingBirthday->first_name);

                    }
                } elseif ($this->totalBirthdays == 1) {
                    $this->getRemainingBirthday = EmpPersonalInfo::whereMonth('date_of_birth', $currentMonth)
                        ->whereDay('date_of_birth', $currentDay)
                        ->join('employee_details', 'employee_details.emp_id', '=', 'emp_personal_infos.emp_id')
                        ->whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                        ->select('employee_details.*')
                        ->first();
                } else {
                    $this->getRemainingBirthday = null;
                }
            }


            //fetching the data for experince employeess
            $this->expEmpRecord = ModelsNotification::where('body', $currentDate)
                ->where('assignee', $CompanyId)
                ->where('notification_type', 'Experience')
                ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(is_birthday_read, '$.\"$loggedInEmpId\"')) = '0'")
                ->first();
            if ($this->expEmpRecord) {

                $YourExp = EmployeeDetails::whereMonth('hire_date', $currentMonth)
                    ->whereDay('hire_date', $currentDay)
                    ->whereYear('hire_date', '!=', date('Y'))
                    ->whereNotIn('employee_status', ['resigned', 'terminated'])
                    ->whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                    ->where('employee_details.emp_id', $loggedInEmpId)
                    ->select('employee_details.*')
                    ->first();
                // dd( $YourBirthday);
                $this->totalExpEmp = $this->expEmpRecord->chatting_id;
                // dd( $this->totalBirthdays);
                if ($YourExp) {
                    $this->isYourJoining = true;
                    $this->totalExpEmp = $this->expEmpRecord->chatting_id - 1;

                    if ($this->totalExpEmp == 1) {
                        $this->getRemainingExpEmp = EmployeeDetails::whereMonth('hire_date', $currentMonth)
                            ->whereDay('hire_date', $currentDay)
                            ->whereYear('hire_date', '!=', date('Y'))
                            ->whereNotIn('employee_status', ['resigned', 'terminated'])
                            ->whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                            ->select('employee_details.*')
                            ->where('employee_details.emp_id', '!=', $loggedInEmpId)
                            ->first();
                        $this->successfulYears = now()->year - Carbon::parse($this->getRemainingExpEmp->hire_date)->year;
                    }
                } elseif ($this->totalExpEmp == 1) {
                    $this->getRemainingExpEmp = EmployeeDetails::whereMonth('hire_date', $currentMonth)
                        ->whereDay('hire_date', $currentDay)
                        ->whereYear('hire_date', '!=', date('Y'))
                        ->whereNotIn('employee_status', ['resigned', 'terminated'])
                        ->whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                        ->select('employee_details.*')
                        ->first();
                }else{
                    $this->getRemainingExpEmp = EmployeeDetails::whereMonth('hire_date', $currentMonth)
                    ->whereDay('hire_date', $currentDay)
                    ->whereYear('hire_date', '!=', date('Y'))
                    ->whereNotIn('employee_status', ['resigned', 'terminated'])
                    ->whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                    ->select('employee_details.*')
                    ->get();
                }
                //  dd( $this->totalBirthdays);

            }


            //fetching data for newly joined employees
            $this->newJoinRecord = ModelsNotification::where('body', $currentDate)
                ->where('assignee', $CompanyId)
                ->where('notification_type', 'new join')
                ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(is_birthday_read, '$.\"$loggedInEmpId\"')) = '0'")
                ->first();
            if ($this->newJoinRecord) {
                $YourJoining = EmployeeDetails::whereMonth('hire_date', $currentMonth)
                    ->whereDay('hire_date', $currentDay)
                    ->whereYear('hire_date', '=', date('Y'))
                    ->whereNotIn('employee_status', ['resigned', 'terminated'])
                    ->whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                    ->where('employee_details.emp_id', $loggedInEmpId)
                    ->select('employee_details.*')
                    ->first();
                // dd( $YourBirthday);
                $this->totalJoinees = $this->newJoinRecord->chatting_id;

                // dd( $this->totalJoinees);
                if ($YourJoining) {
                    $this->isYourJoining = true;
                    $this->totalJoinees = $this->newJoinRecord->chatting_id - 1;

                    if ($this->totalJoinees == 1) {
                        $this->getRemainingJoinees = EmployeeDetails::whereMonth('hire_date', $currentMonth)
                            ->whereDay('hire_date', $currentDay)
                            ->whereYear('hire_date', '=', date('Y'))
                            ->whereNotIn('employee_status', ['resigned', 'terminated'])
                            ->whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                            ->select('employee_details.*')
                            ->where('employee_details.emp_id', '!=', $loggedInEmpId)
                            ->first();
                    }
                } elseif ($this->totalJoinees == 1) {
                    $this->getRemainingJoinees = EmployeeDetails::whereMonth('hire_date', $currentMonth)
                        ->whereDay('hire_date', $currentDay)
                        ->whereYear('hire_date', '=', date('Y'))
                        ->whereNotIn('employee_status', ['resigned', 'terminated'])
                        ->whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                        ->select('employee_details.*')
                        ->first();
                }else{
                    $this->getRemainingJoinees = EmployeeDetails::whereMonth('hire_date', $currentMonth)
                    ->whereDay('hire_date', $currentDay)
                    ->whereYear('hire_date', '=', date('Y'))
                    ->whereNotIn('employee_status', ['resigned', 'terminated'])
                    ->whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                    ->select('employee_details.*')
                    ->get();
                }

            }

            $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
            // working groupby messages notifications

            $this->messagenotifications = DB::table('notifications')
                ->join('employee_details', 'notifications.emp_id', '=', 'employee_details.emp_id')
                ->where('receiver_id', $loggedInEmpId)
                ->where('notification_type', 'message')
                ->where('message_read_at', null)
                ->select('employee_details.first_name', 'employee_details.last_name',  'notifications.emp_id',  'notifications.body as detail', 'notifications.notification_type', 'notifications.created_at', 'notifications.chatting_id', 'notifications.leave_type')
                ->get();
            // ->groupBy('emp_id');

            $this->leaveApproveNotification = DB::table('notifications')
                ->join('employee_details', 'notifications.emp_id', '=', 'employee_details.emp_id')
                ->where('assignee', $loggedInEmpId)
                ->where('notification_type', 'leaveApprove')
                ->where('message_read_at', null)
                ->select('employee_details.first_name', 'employee_details.last_name',  'notifications.emp_id',  'notifications.body as detail', 'notifications.notification_type', 'notifications.created_at', 'notifications.chatting_id', 'notifications.leave_type')
                ->get();
            // dd($this->leaveApproveNotification);

            $this->leaveRejectNotification = DB::table('notifications')
                ->join('employee_details', 'notifications.emp_id', '=', 'employee_details.emp_id')
                ->where('assignee', $loggedInEmpId)
                ->where('notification_type', 'leaveReject')
                ->where('message_read_at', null)
                ->select('employee_details.first_name', 'employee_details.last_name',  'notifications.emp_id',  'notifications.body as detail', 'notifications.notification_type', 'notifications.created_at', 'notifications.chatting_id', 'notifications.leave_type')
                ->get();

            $this->leavenotifications = DB::table('notifications')
                ->join('employee_details', 'notifications.emp_id', '=', 'employee_details.emp_id')
                ->where(function ($query) use ($loggedInEmpId) {
                    $query->whereJsonContains('notifications.applying_to', [['manager_id' => $loggedInEmpId]])
                        ->orWhereJsonContains('notifications.cc_to', [['emp_id' => $loggedInEmpId]]);
                })
                ->where('notification_type', 'leave')
                ->where('is_read', 0)
                ->select('employee_details.first_name', 'employee_details.last_name', 'notifications.emp_id',  'notifications.leave_type as detail', 'notifications.notification_type', 'notifications.created_at', 'notifications.chatting_id', 'notifications.leave_type')
                ->get();

            $this->leavecancelnotifications = DB::table('notifications')
                ->join('employee_details', 'notifications.emp_id', '=', 'employee_details.emp_id')
                ->where(function ($query) use ($loggedInEmpId) {
                    $query->whereJsonContains('notifications.applying_to', [['manager_id' => $loggedInEmpId]])
                        ->orWhereJsonContains('notifications.cc_to', [['emp_id' => $loggedInEmpId]]);
                })
                ->where('notification_type', 'leaveCancel')
                ->where('is_read', 0)
                ->select('employee_details.first_name', 'employee_details.last_name', 'notifications.emp_id',  'notifications.leave_type as detail', 'notifications.notification_type', 'notifications.created_at', 'notifications.chatting_id', 'notifications.leave_type')
                ->get();

            $this->tasknotifications = DB::table('notifications')
                ->join('employee_details', 'notifications.emp_id', '=', 'employee_details.emp_id')
                ->whereRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(notifications.assignee, '(', -1), ')', 1) = ?", [$loggedInEmpId])
                ->where('notification_type', 'task')
                ->where('is_read', 0)
                ->select('employee_details.first_name', 'employee_details.last_name', 'notifications.task_name as detail', 'notifications.emp_id', 'notifications.notification_type', 'notifications.created_at', 'notifications.chatting_id', 'notifications.leave_type')
                ->get();

            // ->groupBy('emp_id');

            $allNotifications = $this->messagenotifications->merge($this->leavenotifications)->merge($this->tasknotifications)->merge($this->leavecancelnotifications)->merge($this->leaveApproveNotification)->merge($this->leaveRejectNotification);

            $groupedNotifications = $allNotifications->groupBy(function ($item) {
                return $item->emp_id . '-' . $item->notification_type;
            });
            $this->totalnotifications = $groupedNotifications->map(function ($items, $key) {
                $firstItem = $items->first();
                $detailsArray = $items->pluck('detail')->toArray();
                $detailsCount = count($detailsArray);
                $latestCreatedAt = $items->max('created_at');
                $humanReadableCreatedAt = Carbon::parse($latestCreatedAt)->diffForHumans();

                return (object)[
                    'first_name' => $firstItem->first_name,
                    'last_name' => $firstItem->last_name,
                    'emp_id' => $firstItem->emp_id,
                    'chatting_id' => $firstItem->chatting_id,
                    'leave_type' => $firstItem->leave_type,
                    'notification_type' => $firstItem->notification_type,
                    'created_at' => $latestCreatedAt,
                    'details_count' => $detailsCount,
                    'details' => $detailsArray,
                    'notify_time' => $humanReadableCreatedAt,
                ];
            })->sortByDesc('created_at')->values();


            if ($this->totalBirthdays > 0 || $this->totalJoinees > 0 || $this->totalExpEmp > 0) {
                $this->totalnotificationscount = $this->totalnotifications->count() 
                                                + ($this->totalBirthdays > 0 ? 1 : 0) 
                                                + ($this->totalJoinees > 0 ? 1 : 0) 
                                                + ($this->totalExpEmp > 0 ? 1 : 0);
            } else {
                $this->totalnotificationscount = $this->totalnotifications->count();
            }



            $this->chatNotificationCount = DB::table('notifications')
                ->where('receiver_id', $loggedInEmpId)
                ->whereNull('message_read_at')
                ->distinct('emp_id')
                ->count('emp_id');

            //    dd( $this->totalnotifications);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function reduceTaskCount($requestId)
    {
        try {
            // DB::table('notifications')
            //     ->where('emp_id', $requestId)
            //     ->where('notification_type', 'task')
            //     ->update(['is_read' => 1]);

            // $this->fetchNotifications();

            return redirect()->route('tasks');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function reduceLeaveRequestCount($requestId)
    {
        try {

            // DB::table('notifications')
            //     ->where('emp_id', $requestId)
            //     ->where('notification_type', 'leave')
            //     ->update(['is_read' => 1]);


            // $this->fetchNotifications();

            return redirect()->route('review', ['tab' => 'leave']);
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function markAsRead($messageId)
    {

        try {
            // DB::table('notifications')
            //     ->where('chatting_id', $messageId)
            //     ->update(['message_read_at' => Carbon::now()]);

            // $this->fetchNotifications();
            return redirect()->route('chat', ['query' => \Vinkla\Hashids\Facades\Hashids::encode($messageId)]);
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function render()
    {
        return view('livewire.notification', [
            'totalJoinees' => $this->totalJoinees,
            'getRemainingJoinees' => $this->getRemainingJoinees,
            'joiningTime' => $this->joiningTime,
            'totalExpEmp' => $this->totalExpEmp,
            'getRemainingExpEmp' => $this->getRemainingExpEmp,
        ]);
    }
}
