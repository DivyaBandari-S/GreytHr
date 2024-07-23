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
                @if (($matchingLeaveRequestsCount + $chatNotificationCount) > 0)
                <span id="notificationCount" class="badge bg-danger notification-badge">
                    {{ $matchingLeaveRequestsCount + $chatNotificationCount }}
                </span>
                @endif
            </i>
        </button>
    </div>
    <div class="offcanvas offcanvas-end notification-detail-container" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header d-flex justify-content-between align-items-center">
            <h6 id="offcanvasRightLabel" class="offcanvasRightLabel">Notifications <span class="lableCount"
                    id="notificationCount">
                    ({{ $matchingLeaveRequestsCount + $chatNotificationCount }})</span> </h6>
            <button type="button" class="btn-close text-reset notification-close-btn" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="notification-horizontal-line"></div>
        <div class="offcanvas-body">

            <!-- Include leave notifications -->
            @if ($matchingLeaveRequestsCount > 0)
            @foreach ($matchingLeaveRequests as $request)
            <div>
                <div class="border rounded bg-white p-2 mb-2 leave-request-container"  title="{{ $request->leave_type }}">
                    <p class="mb-0 notification-text">EMPLOYEE LEAVE REQUESTS</p>
                    <a href="#" class="notification-head"
                        wire:click.prevent="reduceLeaveRequestCount('{{ $request->emp_id }}')">
                        {{ ucwords(strtolower($request->first_name)) }} {{ ucwords(strtolower($request->last_name)) }}
                        (#{{ $request->emp_id }})
                    </a>

                    <p class="mb-0 notification-text-para">Above employee applied a leave request of
                        Reason : {{ ucfirst(strtolower($request->reason)) }} </p>
                </div>
            </div>
            @endforeach
            @endif


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

            @if ($chatNotificationCount == 0 && $matchingLeaveRequestsCount == 0)
            <div class="text-center mt-4">
                <p class="mb-0 notification-text">No Notifications</p>
            </div>
            @endif
        </div>
    </div>
</div>
