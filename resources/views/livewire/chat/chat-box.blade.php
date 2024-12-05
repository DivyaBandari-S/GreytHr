<div>
    <style>
        .message-content {
            position: relative;
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
            /* Hover color */
        }

        .message {
            position: relative;
            margin-bottom: 10px;
        }
    </style>
    @if ($selectedConversation)
        <div class="chat-body">
            <!-- Loop through the messages to display each one -->
            @foreach ($messages as $message)
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
                                    <!-- Image file -->
                                    <img src="{{ asset('storage/' . $path) }}" alt="media"
                                        style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                                @elseif (in_array($extension, ['mp4', 'mov', 'avi', 'mkv']))
                                    <!-- Video file -->
                                    <video width="320" height="240" controls>
                                        <source src="{{ asset('storage/' . $path) }}" type="video/{{ $extension }}">
                                        Your browser does not support the video tag.
                                    </video>
                                @elseif (in_array($extension, ['pdf', 'docx', 'txt', 'xlsx']))
                                    <!-- Document file -->
                                    <a href="{{ asset('storage/' . $path) }}" target="_blank">Download
                                        {{ strtoupper($extension) }} File</a>
                                @else
                                    <!-- Default file (e.g., zip, unknown) -->
                                    <a href="{{ asset('storage/' . $path) }}" target="_blank">Download
                                        {{ ucfirst($extension) }} File</a>
                                @endif
                            @endforeach

                            <div class="message-actions">
                                {{-- <!-- Emoji Reaction -->
                                <span wire:click="addEmojiReaction({{ $message->id }}, '😊')" class="emoji-reaction"><i
                                        class="fa-regular fa-smile"></i></span>
                                <!-- Edit Message -->
                                <span wire:click="editMessage({{ $message->id }})" class="edit-message"><i
                                        class="fa-solid fa-pen"></i></span>
                                <!-- Delete Message --> --}}
                                <span wire:click="deleteMessage({{ $message->id }})" class="delete-message"><i
                                        class="fa-solid fa-trash"></i></span>
                            </div>
                            <span class="timestamp">{{ $message->created_at->format('h:i A') }}</span>

                            <!-- Message read status -->
                            <span class="message-status">
                                @if ($message->read == 0)
                                    <i class="fa-solid fa-check"></i> <!-- Single tick -->
                                @else
                                    <i class="fa-solid fa-check-double"></i> <!-- Double blue tick -->
                                @endif
                            </span>
                        </div>
                    </div>
                @else
                    <!-- Received message -->
                    <div class="message received">
                        <div class="avatar-chart"> <img
                                src="{{ $receiverInstance->image
                                    ? 'data:image/jpeg;base64,' . $receiverInstance->image
                                    : ($receiverInstance->gender === 'MALE'
                                        ? asset('images/male-default.png')
                                        : asset('images/female-default.jpg')) }}"
                                alt="Avatar"></i></div>
                        <div class="message-content">
                            <p>{{ $message->body }}</p>
                            @foreach ($message->media_path ? json_decode($message->media_path) : [] as $path)
                                @php
                                    $extension = pathinfo($path, PATHINFO_EXTENSION);
                                @endphp

                                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                    <!-- Image file -->
                                    <img src="{{ asset('storage/' . $path) }}" alt="media"
                                        style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                                @elseif (in_array($extension, ['mp4', 'mov', 'avi', 'mkv']))
                                    <!-- Video file -->
                                    <video width="320" height="240" controls>
                                        <source src="{{ asset('storage/' . $path) }}"
                                            type="video/{{ $extension }}">
                                        Your browser does not support the video tag.
                                    </video>
                                @elseif (in_array($extension, ['pdf', 'docx', 'txt', 'xlsx']))
                                    <!-- Document file -->
                                    <a href="{{ asset('storage/' . $path) }}" target="_blank">Download
                                        {{ strtoupper($extension) }} File</a>
                                @else
                                    <!-- Default file (e.g., zip, unknown) -->
                                    <a href="{{ asset('storage/' . $path) }}" target="_blank">Download
                                        {{ ucfirst($extension) }} File</a>
                                @endif
                            @endforeach

                            <div class="message-actions">
                                {{-- <!-- Emoji Reaction -->
                                <span wire:click="addEmojiReaction({{ $message->id }}, '😊')" class="emoji-reaction"><i
                                        class="fa-regular fa-smile"></i></span>
                                <!-- Edit Message -->
                                <span wire:click="editMessage({{ $message->id }})" class="edit-message"><i
                                        class="fa-solid fa-pen"></i></span>
                                <!-- Delete Message --> --}}
                                <span wire:click="deleteMessage({{ $message->id }})" class="delete-message"><i
                                        class="fa-solid fa-trash"></i></span>
                            </div>
                            <span class="timestamp">{{ $message->created_at->format('h:i A') }}</span>

                            <!-- Message read status -->
                            <span class="message-status">
                                @if ($message->read == 0)
                                    <i class="fa-solid fa-check"></i> <!-- Single tick -->
                                @else
                                    <i class="fa-solid fa-check-double"></i> <!-- Double blue tick -->
                                @endif
                            </span>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <!-- Message prompting to select a conversation -->
        <div class="row m-0 text-center">
            <img src="{{ asset('images/conversation-start.png') }}" class="m-auto" style="width: 20em" />
            <p>Please select a conversation and start chatting</p>
        </div>
    @endif
</div>
