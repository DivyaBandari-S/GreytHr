<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Notification extends Component
{
    public $matchingLeaveRequestsCount;
    public $chatNotificationCount;
    public $matchingLeaveRequests;
    public $senderDetails;
    public $totalnotifications;
    public $totalnotificationscount;

    public function mount()
    {
        try{
            $this->fetchNotifications();
        }
        catch (\Exception $e) {
            abort(404);
        }

    }

    public function fetchNotifications()
    {
        try {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        // Fetch tasks notifications  from notifications table

        $this->totalnotifications= DB::table('notifications')
        ->join('employee_details', 'notifications.emp_id', '=', 'employee_details.emp_id')
        ->select('employee_details.first_name', 'employee_details.last_name', 'notifications.task_name', 'notifications.emp_id','notifications.leave_type','notifications.notification_type')
        ->where(function ($query) use ($loggedInEmpId) {
            $query->whereRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(notifications.assignee, '(', -1), ')', 1) = ?", [$loggedInEmpId])
                  ->orWhere(function ($query) use ($loggedInEmpId) {
                      $query->whereJsonContains('notifications.applying_to', [['manager_id' => $loggedInEmpId]])
                            ->orWhereJsonContains('notifications.cc_to', [['emp_id' => $loggedInEmpId]]);
                  });
        })
        ->where('notifications.is_read', 0)
        ->get();
        $this->totalnotificationscount = $this->totalnotifications->count();

        // Fetch matching leave requests
        $this->matchingLeaveRequests = DB::table('leave_applications')
            ->join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
            ->select('employee_details.first_name', 'employee_details.last_name', 'leave_applications.leave_type', 'leave_applications.emp_id', 'leave_applications.reason')
            ->where('leave_applications.status', 'pending')
            ->where(function ($query) use ($loggedInEmpId) {
                $query->whereJsonContains('leave_applications.applying_to', [['manager_id' => $loggedInEmpId]])
                      ->orWhereJsonContains('leave_applications.cc_to', [['emp_id' => $loggedInEmpId]]);
            })
            ->where('leave_applications.is_read', 0)
            ->get();

        $this->matchingLeaveRequestsCount = $this->matchingLeaveRequests->count();

        // Count chat notifications
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->senderDetails = DB::table('messages')
            ->join('employee_details', 'messages.sender_id', '=', 'employee_details.emp_id')
            ->where('receiver_id', $employeeId)
            ->whereNull('messages.read_at') // Only fetch unread messages
            ->select('messages.*', 'employee_details.first_name', 'employee_details.last_name')
            ->get()
            ->groupBy('sender_id');

        $this->chatNotificationCount = $this->senderDetails->count();


        }
        catch (\Exception $e) {
            abort(404);
        }
    }

    public function reduceTaskCount($requestId)
    {
        try {
       DB::table('notifications')
            ->where('emp_id', $requestId)
            ->where('notification_type','task')
            ->update(['is_read' => 1]);

        $this->fetchNotifications();

        return redirect()->route('tasks');
        }
        catch (\Exception $e) {
            abort(404);
        }
    }

    public function reduceLeaveRequestCount($requestId)
    {
        try {
       DB::table('notifications')
            ->where('emp_id', $requestId)
            ->where('notifications_type','leave')
            ->update(['is_read' => 1]);

        $this->fetchNotifications();

        return redirect()->route('review', ['tab' => 'leave']);
        }
        catch (\Exception $e) {
            abort(404);
        }
    }


    public function markAsRead($messageId)
    {

        try {
      DB::table('messages')
            ->where('id', $messageId)
            ->update(['read_at' => Carbon::now()]);


        $this->fetchNotifications();
        }
        catch (\Exception $e) {
            abort(404);
        }

    }


    public function render()
    {
        return view('livewire.notification');
    }
}
