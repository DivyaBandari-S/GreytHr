<div class="d-flex align-items-center gap-3">

    <div  id="notificationButton" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
        <a href="#" class="nav-link">
            <i class='fas fa-bell icon' ></i>
            @if ($totalnotificationscount > 0)
            <span class="badge">{{$totalnotificationscount}}</span>
            @endif
        </a>
    </div>
    <div>
        <a href="/users" class="nav-link">
            <i class='fas fa-comment-dots icon' ></i>
            @if ($chatNotificationCount > 0)
            <span class="badge">
                {{ $chatNotificationCount }}
            </span>
            @endif

            </i>
        </a>
    </div>
    <div class="offcanvas offcanvas-end notification-detail-container " style="width: 300px;" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header d-flex justify-content-between align-items-center">
            <h6 id="offcanvasRightLabel" class="offcanvasRightLabel">Notifications <span class="lableCount" id="notificationCount">
                    ({{$totalnotificationscount}})</span> </h6>
            <button type="button" class="btn-close text-reset notification-close-btn" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="notification-horizontal-line"></div>
        <div class="offcanvas-body">

            @if($totalnotifications->isEmpty())
            <div class="text-center mt-4">
                <p class="mb-0 notification-text">No Notifications</p>
            </div>
            @else
            @foreach ($totalnotifications as $notification)
            @if($notification->notification_type=='task')
            <div>
                <div class="border rounded bg-white p-2 mb-2 leave-request-container">
                    <p class="mb-0 notification-text-para"> <a href="#" class="notification-head" wire:click.prevent="reduceTaskCount('{{ $notification->emp_id }}')">
                            {{ ucwords(strtolower($notification->first_name)) }} {{ ucwords(strtolower($notification->last_name)) }}
                            (#{{ $notification->emp_id }})
                        </a></p>
                    @if($notification->details_count>1 && $notification->details_count<=10 ) <p class="mb-0 notification-text-para"> Has assigned {{$notification->details_count}} tasks to you.
                        @elseif($notification->details_count>10)
                        <p class="mb-0 notification-text-para"> Has assigned 10+ tasks to you.</p>
                        @else
                        <p class="mb-0 notification-text-para">Has assigned task to you. </p>
                        <div style="display: flex; justify-content:end">
                           <p style="margin-bottom: 0px;font-size:xx-small;color: #535f6b;">{{$notification->notify_time}}</p>
                        </div>
                    @endif


                </div>
            </div>
            @elseif($notification->notification_type=='leave')
            <div>
                <div class="border rounded bg-white p-2 mb-2 leave-request-container" title="{{ $notification->leave_type }}">
                    <p class="mb-0 notification-text"></p>
                    <a href="#" class="notification-head" wire:click.prevent="reduceLeaveRequestCount('{{ $notification->emp_id }}')">
                        {{ ucwords(strtolower($notification->first_name)) }} {{ ucwords(strtolower($notification->last_name)) }}
                        (#{{ $notification->emp_id }})
                    </a>

                    @if($notification->details_count>1 && $notification->details_count<=10 )
                        <p class="mb-0 notification-text-para"> Sent {{$notification->details_count}} leave requests.</p>
                        @elseif($notification->details_count>10)
                        <p class="mb-0 notification-text-para"> Sent 10+ leave requests.</p>
                        @else
                        <p class="mb-0 notification-text-para"> Sent a leave request.</p>
                        <div style="display: flex; justify-content:end">
                           <p style="margin-bottom: 0px;font-size:xx-small;color: #535f6b;">{{$notification->notify_time}}</p>
                        </div>
                     @endif

                </div>
            </div>
            @elseif($notification->notification_type=='message')
            <div class="border rounded bg-white p-2 mb-2">

                <p class="mb-0 notification-text-para">
                    <a href="#" wire:click.prevent="markAsRead({{ $notification->chatting_id }})" class="notification-head">
                        {{ ucwords(strtolower($notification->first_name)) }}
                        {{ ucwords(strtolower($notification->last_name)) }} (#{{ $notification->emp_id }})

                    </a>
                </p>

                @if($notification->details_count>1 && $notification->details_count<=10 ) <p class="mb-0 notification-text-para"> sent {{$notification->details_count}} messages. </p>
                    @elseif($notification->details_count>10)
                    <p class="mb-0 notification-text-para"> sent 10+ messages.</p>
                    @else
                    <p class="mb-0 notification-text-para"> sent a message.</p>
                    @endif

                    <div style="display: flex; justify-content:end">
                        <p style="margin-bottom: 0px;font-size:xx-small;color: #535f6b;">{{$notification->notify_time}}</p>
                    </div>
            </div>

            @endif

            @endforeach
            @endif
        </div>
    </div>
</div>