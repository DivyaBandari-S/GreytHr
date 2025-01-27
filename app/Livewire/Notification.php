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
    public $delegatenotifications;
    public $leaveApproveNotification;

    public $regularisationNotifications;
    public $leaveRejectNotification;
    public $leavenotifications, $leavecancelnotifications;
    public $tasknotifications;
    public $successfulYears;
    public $expEmpRecord;

    public $totalnotifications;
    public $totalnotificationscount;
    public $birthdayRecord;
    public $getRemainingExpID;
    public $totalExpEmp;
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

    public $getRemainingExpEmp;
    public $empIdForRegularisation;

    public $regularisationRejectNotifications;
    public $getRemainingJoineesID;
    public function mount()
    {
        try {

            $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
            $CompanyId = Auth::user()->company_id[0];
            $this->getExpEmpList();
            $this->getNewlyJoinedEmpList();
            $this->fetchNotifications();
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

    public function getNotification($ids)
    {
        try {
            $loggedInEmpId = auth()->user()->emp_id;

            // Check if $ids is an array (multiple IDs)
            if (is_array($ids)) {
                // Process each notification ID in the array
                foreach ($ids as $id) {
                    $findID = ModelsNotification::find($id);
                    // Check if the notification exists
                    if (!$findID) {
                        continue; // Skip if the notification is not found
                    }

                    // Decode the 'is_birthday_read' field (assumed to be a JSON string)
                    $isBirthdayRead = json_decode($findID->is_birthday_read, true);

                    // Check if the 'is_birthday_read' field is decoded properly
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        continue; // Skip this notification if there's an error decoding
                    }

                    // Check if the emp_id exists in the 'is_birthday_read' array
                    if (array_key_exists($loggedInEmpId, $isBirthdayRead)) {
                        // Check if the value is 0, then remove the entry
                        if ($isBirthdayRead[$loggedInEmpId] == 0) {
                            // Remove the entry from the array
                            unset($isBirthdayRead[$loggedInEmpId]);

                            // Save the updated 'is_birthday_read' field back to the database
                            $findID->is_birthday_read = json_encode($isBirthdayRead); // Encode back to JSON
                            $findID->save(); // Save the updated data
                        }
                    }
                }
            } else {
                // Handle single ID case (previously implemented logic)
                $findID = ModelsNotification::find($ids);

                // Check if the notification exists
                if (!$findID) {
                    return redirect()->route('Feeds')->with('error', 'Notification not found.');
                }

                // Decode the 'is_birthday_read' field (assumed to be a JSON string)
                $isBirthdayRead = json_decode($findID->is_birthday_read, true);

                // Check if the 'is_birthday_read' field is decoded properly
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return redirect()->route('Feeds')->with('error', 'Error decoding notification data.');
                }

                // Check if the emp_id exists in the 'is_birthday_read' array
                if (array_key_exists($loggedInEmpId, $isBirthdayRead)) {
                    // Check if the value is 0, then remove the entry
                    if ($isBirthdayRead[$loggedInEmpId] == 0) {
                        // Remove the entry from the array
                        unset($isBirthdayRead[$loggedInEmpId]);

                        // Save the updated 'is_birthday_read' field back to the database
                        $findID->is_birthday_read = json_encode($isBirthdayRead); // Encode back to JSON
                        $findID->save(); // Save the updated data
                    }
                }
            }

            // After handling, redirect to the feeds route
            return redirect()->route('Feeds');
        } catch (\Exception $e) {
            // Catch any exception and redirect with an error message
            return redirect()->route('Feeds')->with('error', 'An error occurred: ' . $e->getMessage());
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
                        // Check if data exists
                        if ($this->getRemainingExpEmp) {
                            // If data exists, join with the notification table and filter by emp_id
                            $this->getRemainingExpID = ModelsNotification::where('emp_id', $this->getRemainingExpEmp->emp_id)
                                ->where('notification_type', 'Experience') // Filter by 'Experience' notification type
                                ->get();
                        }
                    }
                } elseif ($this->totalExpEmp == 1) {
                    $this->getRemainingExpEmp = EmployeeDetails::whereMonth('hire_date', $currentMonth)
                        ->whereDay('hire_date', $currentDay)
                        ->whereYear('hire_date', '!=', date('Y'))
                        ->whereNotIn('employee_status', ['resigned', 'terminated'])
                        ->whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                        ->select('employee_details.*')
                        ->first();
                    if ($this->getRemainingExpEmp) {
                        // If data exists, join with the notification table and filter by emp_id
                        $this->getRemainingExpID = ModelsNotification::where('emp_id', $this->getRemainingExpEmp->emp_id)
                            ->where('notification_type', 'Experience') // Filter by 'new join' notification type
                            ->get();
                    }
                } else {
                    $this->getRemainingExpEmp = EmployeeDetails::whereMonth('hire_date', $currentMonth)
                        ->whereDay('hire_date', $currentDay)
                        ->whereYear('hire_date', '!=', date('Y'))
                        ->whereNotIn('employee_status', ['resigned', 'terminated'])
                        ->whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                        ->select('employee_details.*')
                        ->get();
                    $this->getRemainingExpID = collect();  // Initialize an empty collection to hold the notifications

                    foreach ($this->getRemainingExpEmp as $data) {
                        // If data exists, join with the notification table and filter by emp_id
                        $notifications = ModelsNotification::where('emp_id', $data->emp_id)
                            ->where('notification_type', 'Experience') // Filter by 'new join' notification type
                            ->get();
                        // Merge the notifications into the main collection
                        $this->getRemainingExpID = $this->getRemainingExpID->merge($notifications);
                    }
                }
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
                        // Check if data exists
                        if ($this->getRemainingJoinees) {
                            // If data exists, join with the notification table and filter by emp_id
                            $this->getRemainingJoineesID = ModelsNotification::where('emp_id', $this->getRemainingJoinees->emp_id)
                                ->where('notification_type', 'new join') // Filter by 'new join' notification type
                                ->get();
                        }
                    }
                } elseif ($this->totalJoinees == 1) {
                    // First, retrieve the remaining joinees based on the initial criteria
                    $this->getRemainingJoinees = EmployeeDetails::whereMonth('hire_date', $currentMonth)
                        ->whereDay('hire_date', $currentDay)
                        ->whereYear('hire_date', '=', date('Y'))
                        ->whereNotIn('employee_status', ['resigned', 'terminated'])
                        ->whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                        ->select('employee_details.*')
                        ->first();

                    // Check if data exists
                    if ($this->getRemainingJoinees) {
                        // If data exists, join with the notification table and filter by emp_id
                        $this->getRemainingJoineesID = ModelsNotification::where('emp_id', $this->getRemainingJoinees->emp_id)
                            ->where('notification_type', 'new join') // Filter by 'new join' notification type
                            ->get();
                    }

                    // // Check the result
                    // dd($this->getRemainingJoineesID->first()->id);
                } else {
                    $this->getRemainingJoinees = EmployeeDetails::whereMonth('hire_date', $currentMonth)
                        ->whereDay('hire_date', $currentDay)
                        ->whereYear('hire_date', '=', date('Y'))
                        ->whereNotIn('employee_status', ['resigned', 'terminated'])
                        ->whereRaw("JSON_CONTAINS(employee_details.company_id, JSON_QUOTE(?))", [$CompanyId])
                        ->select('employee_details.*')
                        ->get();
                    // Check if data exists
                    $this->getRemainingJoineesID = collect();  // Initialize an empty collection to hold the notifications

                    foreach ($this->getRemainingJoinees as $data) {
                        // If data exists, join with the notification table and filter by emp_id
                        $notifications = ModelsNotification::where('emp_id', $data->emp_id)
                            ->where('notification_type', 'new join') // Filter by 'new join' notification type
                            ->get();
                        // Merge the notifications into the main collection
                        $this->getRemainingJoineesID = $this->getRemainingJoineesID->merge($notifications);
                    }
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


            $this->leaveRejectNotification = DB::table('notifications')
                ->join('employee_details', 'notifications.emp_id', '=', 'employee_details.emp_id')
                ->where('assignee', $loggedInEmpId)
                ->where('notification_type', 'leaveReject')
                ->where('message_read_at', null)
                ->select('employee_details.first_name', 'employee_details.last_name',  'notifications.emp_id',  'notifications.body as detail', 'notifications.notification_type', 'notifications.created_at', 'notifications.chatting_id', 'notifications.leave_type')
                ->get();

            $this->regularisationNotifications =  DB::table('notifications')
                ->join('employee_details', 'notifications.emp_id', '=', 'employee_details.emp_id')

                ->where('notification_type', 'regularisationApply')
                ->where('is_read', 0)
                ->select('employee_details.first_name', 'employee_details.last_name', 'notifications.emp_id',  'notifications.leave_type as detail', 'notifications.notification_type', 'notifications.created_at', 'notifications.chatting_id', 'notifications.leave_type')
                ->get();
            $this->regularisationRejectNotifications =  DB::table('notifications')
                ->join('employee_details', 'notifications.emp_id', '=', 'employee_details.emp_id')

                ->where('notification_type', 'regularisationReject')
                ->where('is_read', 0)
                ->select('employee_details.first_name', 'employee_details.last_name', 'notifications.emp_id',  'notifications.leave_type as detail', 'notifications.notification_type', 'notifications.created_at', 'notifications.chatting_id', 'notifications.leave_type')
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

                $this->delegatenotifications= DB::table('notifications')
                ->join('employee_details', 'notifications.emp_id', '=', 'employee_details.emp_id')
                ->where('assignee', $loggedInEmpId)
                ->where('notification_type', 'delegate')
                ->where('message_read_at', null)
                ->select('employee_details.first_name', 'employee_details.last_name',  'notifications.emp_id',  'notifications.body as detail', 'notifications.notification_type', 'notifications.created_at', 'notifications.chatting_id', 'notifications.leave_type')
                ->get();


            // ->groupBy('emp_id');
// dd($this->tasknotifications);
            $allNotifications = $this->messagenotifications->merge($this->leavenotifications)->merge($this->tasknotifications)->merge($this->leavecancelnotifications)->merge($this->leaveApproveNotification)->merge($this->leaveRejectNotification)->merge($this->regularisationNotifications)->merge($this->regularisationRejectNotifications)->merge($this->delegatenotifications);
// dd( $allNotifications);
            $groupedNotifications = $allNotifications->groupBy(function ($item) {
                return $item->emp_id . '-' . $item->notification_type;
            });
            // dd($groupedNotifications);
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

// dd(  $this->totalnotifications);

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
            'getRemainingJoineesID' => $this->getRemainingJoineesID,
            'getRemainingExpID' => $this->getRemainingExpID,
        ]);
    }
}
