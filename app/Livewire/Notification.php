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
    public $messagenotifications;
    public $leavenotifications;
    public $tasknotifications;
    public $totalnotifications;
    public $totalnotificationscount;

    public function mount()
    {
        try {
            $this->fetchNotifications();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function fetchNotifications()
    {
        try {
            $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
            // working groupby messages notifications

            $this->messagenotifications = DB::table('notifications')
                ->join('employee_details', 'notifications.emp_id', '=', 'employee_details.emp_id')
                ->where('receiver_id', $loggedInEmpId)
                ->where('notification_type', 'message')
                ->where('message_read_at', null)
                ->select('employee_details.first_name', 'employee_details.last_name',  'notifications.emp_id',  'notifications.body as detail', 'notifications.notification_type', 'notifications.created_at','notifications.chatting_id','notifications.leave_type')
                ->get();
                // ->groupBy('emp_id');

            $this->leavenotifications = DB::table('notifications')
                ->join('employee_details', 'notifications.emp_id', '=', 'employee_details.emp_id')
                ->where(function ($query) use ($loggedInEmpId) {
                    $query->whereJsonContains('notifications.applying_to', [['manager_id' => $loggedInEmpId]])
                        ->orWhereJsonContains('notifications.cc_to', [['emp_id' => $loggedInEmpId]]);
                })
                ->where('notification_type', 'leave')
                ->where('is_read', 0)
                ->select('employee_details.first_name', 'employee_details.last_name', 'notifications.emp_id',  'notifications.leave_type as detail', 'notifications.notification_type', 'notifications.created_at','notifications.chatting_id','notifications.leave_type')
                ->get();
                // ->groupBy('emp_id');


            $this->tasknotifications = DB::table('notifications')
                ->join('employee_details', 'notifications.emp_id', '=', 'employee_details.emp_id')
                ->whereRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(notifications.assignee, '(', -1), ')', 1) = ?", [$loggedInEmpId])
                ->where('notification_type', 'task')
                ->where('is_read', 0)
                ->select('employee_details.first_name', 'employee_details.last_name', 'notifications.task_name as detail', 'notifications.emp_id', 'notifications.notification_type', 'notifications.created_at','notifications.chatting_id','notifications.leave_type')
                ->get();

                // ->groupBy('emp_id');

                $allNotifications = $this->messagenotifications->merge($this->leavenotifications)->merge($this->tasknotifications);

                $groupedNotifications = $allNotifications->groupBy(function($item) {
                    return $item->emp_id . '-' . $item->notification_type;
                });
                $this->totalnotifications = $groupedNotifications->map(function($items, $key) {
                    $firstItem = $items->first();
                    $detailsArray = $items->pluck('detail')->toArray();
                    $detailsCount = count($detailsArray);
                    $latestCreatedAt = $items->max('created_at');

                    return (object)[
                        'first_name' => $firstItem->first_name,
                        'last_name' => $firstItem->last_name,
                        'emp_id' => $firstItem->emp_id,
                        'chatting_id' =>$firstItem->chatting_id,
                        'leave_type'=>$firstItem->leave_type,
                        'notification_type' => $firstItem->notification_type,
                        'created_at' => $latestCreatedAt,
                        'details_count' => $detailsCount,
                        'details' => $detailsArray
                    ];
                })->sortByDesc('created_at')->values();


            $this->totalnotificationscount = $this->totalnotifications->count();



            $this->chatNotificationCount = DB::table('notifications')
            ->where('receiver_id',$loggedInEmpId)
            ->whereNull('message_read_at')
            ->distinct('emp_id')
            ->count('emp_id');



        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function reduceTaskCount($requestId)
    {
        try {
            DB::table('notifications')
                ->where('emp_id', $requestId)
                ->where('notification_type', 'task')
                ->update(['is_read' => 1]);

            $this->fetchNotifications();

            return redirect()->route('tasks');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function reduceLeaveRequestCount($requestId)
    {
        try {

            DB::table('notifications')
                ->where('emp_id', $requestId)
                ->where('notification_type', 'leave')
                ->update(['is_read' => 1]);


            $this->fetchNotifications();

            return redirect()->route('review', ['tab' => 'leave']);
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function markAsRead($messageId)
    {

        try {
            DB::table('notifications')
                ->where('chatting_id', $messageId)
                ->update(['message_read_at' => Carbon::now()]);

            $this->fetchNotifications();
            return redirect()->route('chat', ['query' => \Vinkla\Hashids\Facades\Hashids::encode($messageId)]) ;

        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function render()
    {
        return view('livewire.notification');
    }
}
