<div style="width: 100%">
    @if ($selectedConversation)
        <form wire:submit.prevent="sendMessage">
            <!-- Error Message -->
            <div id="errorMessageContainer" class="error-message-container">
                @if (session()->has('error'))
                    <div id="errorMessage" class="alert alert-danger error-message">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <div class="input-group textArea">
                <input type="text" class="form-control" wire:model="body" placeholder="Enter Message..."
                    aria-label="Example text with button addon" aria-describedby="button-addon1" id="messageInput"
                    wire:keydown="clearError">

                {{-- <button class="btn btn-outline-secondary pe-1" type="button" id="button-addon1 ms-2">
                    <i class="fa-solid fa-microphone"></i>
                </button> --}}

                <button class="btn btn-outline-secondary pe-1" type="button" id="emojiButton"
                    onclick="emojiPickerOpen()">
                    <i class="fa-solid fa-face-smile"></i>
                </button>

                <button class="btn btn-outline-secondary pe-1" type="button" id="attachButton"
                    onclick="document.getElementById('fileInput').click();">
                    <i class="fa-solid fa-paperclip"></i>
                </button>

                <input type="file" id="fileInput" wire:model="media" style="display: none;" multiple
                    wire:change="clearError" />

                <button class="btn btn-outline-secondary" type="submit" id="sendMessageButton">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>

            @if (count($mediaPreviews) > 0)
                <div id="filePreview" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                    @foreach ($mediaPreviews as $preview)
                        <div class="preview-item" style="flex: 0 0 auto; position: relative; text-align: center;">
                            @if ($preview['type'] === 'image')
                                <!-- Image Preview -->
                                <img src="{{ $preview['url'] }}" class="img-thumbnail" width="100"
                                    alt="Image preview">
                            @else
                                <!-- Non-image file preview -->
                                <div style="font-size: 2rem;"> <!-- Adjust icon size -->
                                    <i class="{{ $preview['icon'] }}"></i>
                                </div>
                                <div style="font-size: 0.8rem; margin-top: 5px;"> <!-- Smaller file name -->
                                    {{ Str::limit($preview['fileName'], 10) }} <!-- Limit file name length -->
                                </div>
                            @endif

                            <!-- Delete Button in top-right corner -->
                            <button type="button" class="btn btn-danger btn-sm"
                                wire:click="deleteMedia({{ $loop->index }})"
                                style="position: absolute; top: 0; right: 0; z-index: 10; margin: 5px; padding: 2px 5px; font-size: 12px;">
                                <i class="fa fa-times"></i>
                            </button>

                        </div>
                    @endforeach
                </div>
            @endif
            <emoji-picker id="emojiPicker" style="display: none;" class="light"></emoji-picker>
        </form>
    @endif
    <!-- Sound Effect Scripts -->
    <audio id="sendSound" src="{{ asset('sounds/send-sound.mp3') }}"></audio>
    <audio id="receiveSound" src="{{ asset('sounds/receive-sound.mp3') }}"></audio>
</div>

<script>
    function emojiPickerOpen() {
        const emojiPicker = document.getElementById('emojiPicker');
        emojiPicker.style.display = emojiPicker.style.display === 'none' ? 'block' : 'none';
        emojiPicker.removeEventListener('emoji-click', handleEmojiClick);
        emojiPicker.addEventListener('emoji-click', handleEmojiClick);
    }

    function handleEmojiClick(event) {
        const emoji = event.detail.unicode || event.detail.char;
        document.getElementById('messageInput').value += emoji;
        Livewire.dispatch('emojiBody', {
            emoji
        });
    }
    // document.addEventListener('livewire:init', () => {
    //     Livewire.on('show-error', (messages) => {
    //         if (Array.isArray(messages) && messages.length > 0 && messages[0].message) {
    //             const errorMessage = messages[0].message;
    //             console.log(errorMessage);

    //             const errorMessageElement = document.getElementById('livewireErrorMessage');
    //             document.getElementById('errorMessageText').innerText = errorMessage;

    //             // Show the error message
    //             errorMessageElement.classList.add('show');

    //             // Hide after 5 seconds
    //             setTimeout(() => {
    //                 errorMessageElement.classList.remove('show');
    //             }, 5000);
    //         } else {
    //             console.error('No valid error message received.');
    //         }
    //     });
    // });

    // Play sound when a message is sent
    window.addEventListener('sendMessageSound', () => {
        document.getElementById('sendSound').play();
    });

    // Play sound when a message is received
    window.addEventListener('receiveMessageSound', () => {
        document.getElementById('receiveSound').play();
    });
</script>
