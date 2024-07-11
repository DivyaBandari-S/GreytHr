<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use Carbon\Carbon;

class Notification extends Component
{
    public $matchingLeaveRequestsCount;
    public $chatNotificationCount;
    public $matchingLeaveRequests;
    public $senderDetails;

    public function mount()
    {
        $this->fetchNotifications();
    }

    public function fetchNotifications()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;

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

    public function reduceLeaveRequestCount($requestId)
    {
       DB::table('leave_applications')
            ->where('emp_id', $requestId)
            ->update(['is_read' => 1]);
    
        $this->fetchNotifications();

        return redirect()->route('review');
    }
    

    public function markAsRead($messageId)
    {
        
       
      DB::table('messages')
            ->where('id', $messageId)
            ->update(['read_at' => Carbon::now()]);
          

        $this->fetchNotifications();
       
    }
    

    public function render()
    {
        return view('livewire.notification');
    }
}
