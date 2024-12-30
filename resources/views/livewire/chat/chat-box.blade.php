<div>
    <style>
        .message-content {
            position: relative;
            word-wrap: break-word; /* Ensures text content wraps properly */
            max-width: 80%; /* Limit width for better readability */
        }

        .message-content p {
            font-size: 1rem; /* Default font size */
            line-height: 1.5;
            margin: 0;
        }

        .message-actions {
            display: none;
            position: absolute;
            top: 0;
            right: 0;
            z-index: 10;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 5px;
            padding: 5px;
            margin-top: 5px;
        }

        .message:hover .message-actions {
            display: block;
        }

        .message-actions span {
            margin: 0 5px;
            cursor: pointer;
            color: white;
        }

        .message-actions span:hover {
            color: #f0a500;
        }

        .message {
            position: relative;
            margin-bottom: 10px;
            display: flex;
            align-items: flex-start;
        }

        .date-label {
            text-align: center;
            font-size: 14px;
            color: #888;
            margin: 10px 0;
        }

        /* New container for the timestamp and message status */
        .message-footer {
            display: flex;
            flex-direction: column; /* Stack the items vertically */
            font-size: 0.8rem;
            color: #888;
        }

        .timestamp {
            margin-bottom: 5px; /* Space between timestamp and status */
        }

        .message-status {
            display: flex;
            align-items: center;
        }

        .message-status i {
            margin-left: 5px;
        }

        /* Media Queries for Responsive Design */
        @media (max-width: 768px) {
            .message-content p {
                font-size: 0.9rem; /* Slightly smaller font for tablets */
            }

            .message-content {
                max-width: 100%; /* Full width for small screens */
            }

            .message {
                margin-bottom: 15px; /* More space between messages on smaller screens */
            }
        }

        @media (max-width: 576px) {
            .message-content p {
                font-size: 0.8rem; /* Smaller font for mobile devices */
            }

            .message-content {
                max-width: 100%; /* Ensure the text takes full width */
                padding-right: 10px; /* Add padding to avoid edge issues */
            }

            .message {
                margin-bottom: 12px; /* Adjust space for smaller screens */
            }
        }
    </style>




    @if ($selectedConversation)
        <div class="chat-profile d-flex align-items-center p-3 bg-light border-bottom">
            <div class="avatar me-3">
                <img src="{{ $receiverInstance->image
                    ? 'data:image/jpeg;base64,' . $receiverInstance->image
                    : ($receiverInstance->gender === 'MALE'
                        ? asset('images/male-default.png')
                        : asset('images/female-default.jpg')) }}"
                    alt="Profile Picture" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
            </div>
            <div class='profile'>
                <h6 class="mb-0 text-solid">{{ $receiverInstance->first_name ?? '' }}
                    {{ $receiverInstance->last_name ?? '' }}</h6>
                <small class="text-primary">{{ $receiverInstance->email ?? '' }}</small>
            </div>
            <div class="ms-auto">
                {{-- <button class="btn btn-sm btn-outline-primary" title="Start Video Call">
                    <i class="fas fa-video"></i>
                </button>
                <button class="btn btn-sm btn-outline-secondary" title="Start Voice Call">
                    <i class="fas fa-phone"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger" title="Block User">
                    <i class="fas fa-ban"></i>
                </button> --}}
            </div>
        </div>
        <div id="chatBody" class="chat-body">
            @php
                $previousDate = null;
            @endphp

            <!-- Loop through the messages to display each one -->
            @foreach ($messages as $message)
                @php
                    $messageDate = \Carbon\Carbon::parse($message->created_at);
                    $formattedDate = $messageDate->isToday() ? 'Today' : ($messageDate->isYesterday() ? 'Yesterday' : $messageDate->format('M d, Y'));
                @endphp

                <!-- Show the date label when it changes -->
                @if ($previousDate !== $formattedDate)
                    <div class="date-label">
                        {{ $formattedDate }}
                    </div>
                    @php
                        $previousDate = $formattedDate;
                    @endphp
                @endif

                @if ($message->sender_id == auth()->user()->emp_id)
                    <!-- Sent message -->
                    <div class="message sent">
                        <div class="avatar-chart">
                            <img src="{{ $senderInstance->image
                                ? 'data:image/jpeg;base64,' . $senderInstance->image
                                : ($senderInstance->gender === 'MALE'
                                    ? asset('images/male-default.png')
                                    : asset('images/female-default.jpg')) }}"
                                alt="Avatar">
                        </div>
                        <div class="message-content">
                            <p>{{ $message->body }}</p>
                            @foreach ($message->media_path ? json_decode($message->media_path) : [] as $path)
                                @php
                                    $extension = pathinfo($path, PATHINFO_EXTENSION);
                                @endphp

                                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                    <img src="{{ asset('storage/' . $path) }}" alt="media"
                                        style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                                @elseif (in_array($extension, ['mp4', 'mov', 'avi', 'mkv']))
                                    <video width="320" height="240" controls>
                                        <source src="{{ asset('storage/' . $path) }}" type="video/{{ $extension }}">
                                        Your browser does not support the video tag.
                                    </video>
                                @elseif (in_array($extension, ['pdf', 'docx', 'txt', 'xlsx']))
                                    <div class="file-container text-center" style="width: 100px;height: 100px; margin-left: 96px; margin-top: -65px;">
                                        <a href="{{ asset('storage/' . $path) }}" target="_blank">
                                            <i class="fas fa-file fa-3x"></i>
                                            <p>{{ strtoupper($extension) }} File</p>
                                        </a>
                                    </div>
                                @else
                                    <div class="file-container text-center">
                                        <a href="{{ asset('storage/' . $path) }}" target="_blank">
                                            <i class="fas fa-file fa-3x"></i>
                                            <p>{{ ucfirst($extension) }} File</p>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                            <div class="message-footer">
                                <span class="timestamp">{{ $message->created_at->format('h:i A') }}</span>
                                <span class="message-status">
                                    @if ($message->read == 0)
                                        <i class="fa-solid fa-check"></i>
                                    @else
                                        <i class="fa-solid fa-check-double"></i>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Received message -->
                    <div class="message received">
                        <div class="avatar-chart">
                            <img src="{{ $receiverInstance->image
                                ? 'data:image/jpeg;base64,' . $receiverInstance->image
                                : ($receiverInstance->gender === 'MALE'
                                    ? asset('images/male-default.png')
                                    : asset('images/female-default.jpg')) }}"
                                alt="Avatar">
                        </div>
                        <div class="message-content">
                            <p>{{ $message->body }}</p>
                            @foreach ($message->media_path ? json_decode($message->media_path) : [] as $path)
                                @php
                                    $extension = pathinfo($path, PATHINFO_EXTENSION);
                                @endphp

                                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                    <img src="{{ asset('storage/' . $path) }}" alt="media"
                                        style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                                @elseif (in_array($extension, ['mp4', 'mov', 'avi', 'mkv']))
                                    <video width="320" height="240" controls>
                                        <source src="{{ asset('storage/' . $path) }}" type="video/{{ $extension }}">
                                        Your browser does not support the video tag.
                                    </video>
                                @elseif (in_array($extension, ['pdf', 'docx', 'txt', 'xlsx']))
                                    <div class="file-container text-center" style="width: 100px;height: 100px;">
                                        <a href="{{ asset('storage/' . $path) }}" target="_blank">
                                            <i class="fas fa-file fa-3x"></i>
                                            <p>{{ strtoupper($extension) }} File</p>
                                        </a>
                                    </div>
                                @else
                                    <div class="file-container text-center">
                                        <a href="{{ asset('storage/' . $path) }}" target="_blank">
                                            <i class="fas fa-file fa-3x"></i>
                                            <p>{{ ucfirst($extension) }} File</p>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                            <span class="timestamp">{{ $message->created_at->format('h:i A') }}</span>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="row m-0 text-center">
            <img src="{{ asset('images/conversation-start.png') }}" class="m-auto" style="width: 20em" />
            <p>Please select a conversation and start chatting</p>
        </div>
    @endif
    <audio id="receiveSound" src="{{ asset('sounds/receive-sound.mp3') }}"></audio>
</div>

<script>
    window.addEventListener('rowChatToBottom', function() {
        const chatBody = document.getElementById('chatBody');
        chatBody.scrollTop = chatBody.scrollHeight;
    });

    // Play sound when a message is received
    window.addEventListener('receiveMessageSound', () => {
        document.getElementById('receiveSound').play();
    });
</script>
{{-- <script>
    window.addEventListener('rowChatToBottom', function() {
        const chatBody = document.getElementById('chatBody');
        // Scroll to the bottom
        chatBody.scrollTop = chatBody.scrollHeight;

        // After that, adjust the scroll position to be from the bottom upwards
        chatBody.scrollTop = chatBody.scrollHeight - chatBody.clientHeight;
    });
</script> --}}
