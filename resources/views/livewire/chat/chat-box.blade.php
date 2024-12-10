<div>
    @if ($selectedConversation)
        <div class="chat-body">
            <!-- Loop through the messages to display each one -->
            @foreach ($messages as $message)
                @if ($message->sender_id == auth()->user()->emp_id)
                    <!-- Sent message -->
                    <div class="message sent">
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
                        <div class="avatar-chart"><i class="fa-regular fa-user"></i></div>
                        <div class="message-content">
                            <p>{{ $message->body }}</p>
                            @if ($message->media_path)
                                <div class="media-preview">
                                    @if ($message->type == 'video')
                                        <video width="100" controls>
                                            <source src="{{ asset('storage/' . $message->media_path) }}"
                                                type="video/mp4">
                                        </video>
                                    @else
                                        <img src="{{ asset('storage/' . $message->media_path) }}" alt="Media"
                                            width="100">
                                    @endif
                                </div>
                            @endif
                            <span class="timestamp">{{ $message->created_at->format('h:i A') }}</span>

                            <!-- Message read status for received messages -->
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
            <img src="images/conversation-start.png" class="m-auto" style="width: 20em" />
            <p>Please select a conversation and start chatting</p>
        </div>
    @endif
</div>
