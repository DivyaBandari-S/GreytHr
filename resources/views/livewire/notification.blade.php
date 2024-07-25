<div class="d-flex align-items-center">

    <div>
        <a href="/users" class="notification-anchor-tag">
            <i class="fa fa-comment notification-comment-icon">
                @if ($chatNotificationCount > 0)
                <span class="badge bg-danger notification-badge">
                    {{ $chatNotificationCount }}
                </span>
                @endif

            </i>
        </a>
    </div>
    <div class="notification-icon">
        <button id="notificationButton" class="notification-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
            <i class="fas mr-1 fa-bell notification-bell-icon">
                @if ($totalnotificationscount > 0)
                <span id="notificationCount" class="badge bg-danger notification-badge">
                    {{$totalnotificationscount}}
                </span>
                @endif
            </i>
        </button>
    </div>
    <div class="offcanvas offcanvas-end notification-detail-container " style="width: 300px;" tabindex="-1" id="offcanvasRight"  aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header d-flex justify-content-between align-items-center">
            <h6 id="offcanvasRightLabel" class="offcanvasRightLabel">Notifications <span class="lableCount"
                    id="notificationCount">
                    ({{$totalnotificationscount}})</span> </h6>
            <button type="button" class="btn-close text-reset notification-close-btn" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="notification-horizontal-line"></div>
        <div class="offcanvas-body">



            @if ($chatNotificationCount > 0)
            <div class="mb-4">
                <div class="border rounded bg-white p-2 leave-request-container">
                    <p class="mb-0 notification-text">Chat Notifications</p>
                    @foreach ($senderDetails as $senderId => $messages)

                    <div class="border rounded bg-white p-2 mb-2">
                        <a href="{{ route('chat', ['query' => Hashids::encode($messages[0]->chating_id)]) }}"
                            class="notification-head" wire:click="markAsRead({{ $messages[0]->id }})">
                            {{ ucwords(strtolower($messages[0]->first_name)) }}
                            {{ ucwords(strtolower($messages[0]->last_name)) }} (#{{ $senderId }})
                            @if (count($messages) > 1)
                            <span class="badge badge-primary">{{ count($messages) }}</span>
                            @endif
                        </a>
                        @foreach ($messages as $message)
                        <p class="mb-0 notification-text-para">message: {{ ucfirst(strtolower($message->body)) }}</p>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @foreach ($totalnotifications as $notification)
            @if($notification->notification_type=='task')
            <div>
                <div class="border rounded bg-white p-2 mb-2 leave-request-container" >
                    <!-- <p class="mb-0 notification-text">Assigned Task</p> -->


                    <p class="mb-0 notification-text-para">Task is assigned to you, </p>
                    <p class="mb-0 notification-text-para"> by  <a href="#" class="notification-head"
                        wire:click.prevent="reduceTaskCount('{{ $notification->emp_id }}')">
                        {{ ucwords(strtolower($notification->first_name)) }} {{ ucwords(strtolower($notification->last_name)) }}
                        (#{{ $notification->emp_id }})
                    </a></p>

                    <!-- <p  Task Name : {{ ucfirst(strtolower($notification->task_name)) }} </p> -->
                </div>
            </div>
            @elseif($notification->notification_type=='leave')
            <div>
                <div class="border rounded bg-white p-2 mb-2 leave-request-container"  title="{{ $notification->leave_type }}">
                    <p class="mb-0 notification-text">EMPLOYEE LEAVE REQUESTS</p>
                    <a href="#" class="notification-head"
                        wire:click.prevent="reduceLeaveRequestCount('{{ $notification->emp_id }}')">
                        {{ ucwords(strtolower($notification->first_name)) }} {{ ucwords(strtolower($notification->last_name)) }}
                        (#{{ $notification->emp_id }})
                    </a>

                    <p class="mb-0 notification-text-para"> sent a leave request 

                     </p>
                </div>
            </div>
            @else
            <p>messages notifications</p>
            @endif
            @endforeach

            @if ($chatNotificationCount+$totalnotificationscount== 0)
            <div class="text-center mt-4">
                <p class="mb-0 notification-text">No Notifications</p>
            </div>
            @endif
        </div>
    </div>
</div>
