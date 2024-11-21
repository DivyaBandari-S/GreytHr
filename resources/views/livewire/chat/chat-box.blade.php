
<div>
    @if ($selectedConversation)
    
    <div class="chat-body">
        <!-- Received message -->
        <div class="message received">
            <div class="avatar-chart"><i class="fa-regular fa-user"></i></div>
            <div class="message-content">
                <p>Hello, how can I help you today?</p>
                <span class="timestamp">11:24 AM</span>
            </div>
        </div>

        <!-- Sent message -->
        <div class="message sent">
            <div class="message-content">
                <p>Hi! I have a question about the project...</p>
                <span class="timestamp">11:25 AM</span>
            </div>
        </div>
    </div>
    <div class="chat-footer">
        <div class="input-group textArea">
            <input type="text" class="form-control" placeholder="Enter Message..." aria-label="Example text with button addon" aria-describedby="button-addon1" autofocus>
            <button class="btn btn-outline-secondary pe-1" type="button" id="button-addon1 ms-2"><i class="fa-solid fa-microphone"></i></button>
            <button class="btn btn-outline-secondary pe-1" type="button" id="button-addon1 ms-2"><i class="fa-solid fa-face-smile"></i></button>
            <button class="btn btn-outline-secondary pe-1" type="button" id="button-addon1 ms-2"><i class="fa-solid fa-paperclip"></i></button>
            <button class="btn btn-outline-secondary" type="button" id="button-addon1 ms-2"><i class="fa-solid fa-paper-plane"></i></button>
        </div>
    </div>
    @else
    <div>Please select conversation and start chat</div>
    @endif
</div>
