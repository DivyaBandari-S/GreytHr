<div class="d-flex align-items-center">

    <div>
        <a href="/users" style="color: white; text-decoration: none;">
            <i class="fa fa-comment" style="position: relative;display: inline-block; vertical-align: middle;font-size: 18px; margin-left: 10px; margin-right: 8px;margin-bottom: 5px;">
                @if ($chatNotificationCount > 0)
                <span class="badge bg-danger" style="position: absolute; top: -10px; right: -3px; font-size:10px;">
                    {{ $chatNotificationCount }}
                </span>
                @endif

            </i>
        </a>
    </div>
    <div class="notification-icon" style="margin-right: -10px; margin-top: 5px;">
        <button id="notificationButton" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" style="background:none;border:none;">
            <i style="color: white; position: relative;" class="fas mr-1 fa-bell" style="margin-bottom: 7px;">
                @if (($matchingLeaveRequestsCount + $chatNotificationCount) > 0)
                <span id="notificationCount" class="badge bg-danger" style="position: absolute; top: -9px; right: -1px; font-size:10px;">
                    {{ $matchingLeaveRequestsCount + $chatNotificationCount }}
                </span>
                @endif
            </i>
        </button>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" style="width:320px;background:#f5f8f9;">
        <div class="offcanvas-header d-flex justify-content-between align-items-center">
            <h6 id="offcanvasRightLabel" class="offcanvasRightLabel">Notifications <span class="lableCount" id="notificationCount">
                    ({{ $matchingLeaveRequestsCount + $chatNotificationCount }})</span> </h6>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close" style="font-size: 7px; width: 15px; height: 15px; border-radius: 50%; padding: 2px;border:1px solid #778899;"></button>
        </div>
        <div style="border-bottom:1px solid #ccc;"></div>
        <div class="offcanvas-body">
            <!-- Include leave notifications -->
            @if ($matchingLeaveRequestsCount > 0)
            @foreach ($matchingLeaveRequests as $request)
            <div class="leave-request-container">
                <div class="border rounded bg-white p-2 mb-2" style="text-decoration:none;" title="{{ $request->leave_type }}">
                    <p class="mb-0 notification-text">EMPLOYEE LEAVE REQUESTS</p>
                    <a href="#" class="notification-head" wire:click.prevent="reduceLeaveRequestCount('{{ $request->emp_id }}')">{{ ucwords(strtolower($request->first_name)) }}
                        {{ ucwords(strtolower($request->last_name)) }} (#{{ $request->emp_id }})</a>
                    <p class="mb-0 notification-text-para">Above employee applied a leave request of
                        Reason : {{ ucfirst(strtolower($request->reason)) }} </p>
                </div>
            </div>
            @endforeach
            @endif


            @if ($chatNotificationCount > 0)
            <div class="leave-request-container mb-4">
                <div class="border rounded bg-white p-2" style="text-decoration:none;">
                    <p class="mb-0 notification-text">Chat Notifications</p>
                    @foreach ($senderDetails as $senderId => $messages)

                    <div class="border rounded bg-white p-2 mb-2">
                        <a href="{{ route('chat', ['query' => Hashids::encode($messages[0]->chating_id)]) }}" class="notification-head" wire:click="markAsRead({{ $messages[0]->id }})">
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