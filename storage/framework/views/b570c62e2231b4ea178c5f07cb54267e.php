<div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="script.js"></script>

    <div class="chat-container " wire:poll>
        <div class="people-list" id="people-list" style=" border: 2px solid silver;border-radius:5px;">
            <div class="row justify-content-center" style="margin: 0;">
            </div>



            <div class="col-md-12 d-flex align-items-center justify-content-between;" style="height: 80px; background-image: url('https://th.bing.com/th/id/OIP.D5JnKq5hq9D54giN_liHTQHaHa?w=163&h=180&c=7&r=0&o=5&dpr=1.5&pid=1.7');width:100%">
                <div class="input-group" style="width: 90%; align-items:center">
                    <input type="text" class="form-control" placeholder="Search..." wire:model="searchTerm" aria-label="Search" aria-describedby="search-addon" wire:input="filter">
                </div>
            </div>



            <main class="grow h-full relative" style="contain: content;background:#FFFFFF " >

                <ul class="p-2 grid w-full space-y-2" style="list-style: none; padding: 0;">
                    <div class="c" style="contain: content; margin-left:20px;overflow-y: auto; height: 420px;">
                        <!--[if BLOCK]><![endif]--><?php if($conversations): ?>


                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $conversation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <li id="conversation-<?php echo e($conversation->id); ?>" wire:key="<?php echo e($conversation->id); ?>" class="py-3 hover:bg-gray-50 rounded-2xl dark:hover:bg-gray-700/70 transition-colors duration-150 flex gap-4 relative w-full cursor-pointer px-2 <?php echo e($conversation->id == $selectedConversation?->emp_id ? 'bg-gray-100/70' : ''); ?>" style="margin-bottom: 10px;height:70px;width:90%; ">
                            <img style="border-radius: 50%; margin-left: auto; margin-right: auto; display: block; height: 40px; width: 40px; margin-top: 5px;" src="<?php echo e(asset('storage/' . $conversation->getReceiver()->image)); ?>" class="card-img-top" alt="...">
                            <aside class="grid grid-cols-12 w-full">

                                <a href="#" wire:click="redirectToEncryptedLink('<?php echo e($conversation->id); ?>')" class="col-span-11 border-b pb-2 border-gray-200 relative truncate leading-5 w-full flex-nowrap p-1" style="display: block; text-decoration: none;">
                                    <div class="flex justify-between w-full items-center">
                                        <div style="display:flex">
                                            <h6 class="truncate font-medium tracking-wider " style="color: black;font-size:12px">
                                                <?php echo e(ucfirst(strtolower($conversation->getReceiver()->first_name))); ?>&nbsp;<?php echo e(ucwords(strtolower($conversation->getReceiver()->last_name))); ?>

                                            </h6>
                                            <small class="text-gray-700" style="color: #888888;margin-left: auto;"><?php echo e($conversation->messages?->last()?->created_at?->shortAbsoluteDiffForHumans()); ?></small>
                                        </div>
                                        <div class="flex gap-x-2 items-center ">
                                            <!--[if BLOCK]><![endif]--><?php if($conversation->messages?->last()?->sender_id == auth()->id()): ?>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <?php
                                            $lastMessage = $conversation->messages
                                            ? $conversation->messages->last()
                                            : null;
                                            ?>
                                            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                                <p class="grow truncate text-sm font-[100]" style="font-size: 10px; margin-right: 5px; flex: 1;color:#888888">
                                                    <?php echo e(Str::limit($lastMessage ? $lastMessage->body : '', 15)); ?>

                                                </p>
                                                
                                                <!--[if BLOCK]><![endif]--><?php if($conversation->unreadMessagesCount() > 0): ?>
                                                <span style="font-weight: bold; padding: 1px 4px; font-size: 0.75rem; border-radius: 50%; background-color: #007bff; color: #ffffff; display: flex; align-items: center; justify-content: center; width: 16px; height: 16px; flex-shrink: 0;">
                                                    <?php echo e($conversation->unreadMessagesCount()); ?>

                                                </span>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>

                                        </div>



                                </a>

                                






                    </div>

                    </aside>

                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </ul>
            </main>
        </div>
        <hr>

        <div class="chat" style="background-image: url('https://i.pinimg.com/originals/39/cf/bc/39cfbc81276720ddf5003854e42c2769.jpg');">

            <div class="chat-header clearfix" style="border-radius:5px;border:2px solid silver;background-image: url('https://th.bing.com/th/id/OIP.D5JnKq5hq9D54giN_liHTQHaHa?w=163&h=180&c=7&r=0&o=5&dpr=1.5&pid=1.7');height:80px">
                <img style="border-radius: 50%; margin-left: auto; margin-right: auto; display: block; height: 50px; width: 50px;margin-top:5px" src="<?php echo e(asset('storage/' . $selectedConversation->getReceiver()->image)); ?>" class="card-img-top" alt="...">
                <div class="chat-about">
                    <div class="chat-with mt-1">
                        <div class="d-flex align-items-center">

                            <div class="name-box">
                                <div style="color:white">
                                    <div>
                                        <?php echo e(ucfirst(strtolower($selectedConversation->getReceiver()->first_name))); ?>&nbsp;<?php echo e(ucwords(strtolower($selectedConversation->getReceiver()->last_name))); ?>

                                    </div>
                                    <div class="text" style="color:white"><?php echo e($selectedConversation->getReceiver()->emp_id); ?></div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>

            </div>

            <div class="chat-history" id="messageList">
                <ul>
                    <li class="message clearfix" id="conversation">
                        <!-- end chat-header -->
                        <!--[if BLOCK]><![endif]--><?php if($loadedMessages): ?>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $loadedMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
             

                                <div
                                    class="message-container clearfix <?php if($message->sender_id === auth()->id()): ?> sent <?php else: ?> received <?php endif; ?>">
                                    
                                    <div class="message-body" style="display:flex">
                                        <div style="display: flex; flex-direction: column;">
                                            <p class="message-content" style="font-size:10px"><?php echo e($message->body); ?>

                                            </p>
                                            <!--[if BLOCK]><![endif]--><?php if($message->file_path): ?>
                                                
                                                <!--[if BLOCK]><![endif]--><?php if(Str::startsWith($message->file_path, 'chating-files') &&
                                                        Str::endsWith($message->file_path, ['.jpg', '.jpeg', '.png', '.gif'])): ?>
                                                    <img src="<?php echo e(asset('uploads/' . $message->file_path)); ?>"
                                                        alt="Attached Image" style="max-width: 100px;">
                                                    
                                                <?php else: ?>
                                                    <button class="message-content"
                                                        style="font-size: 10px;background:white;border:1px solid silver;border-radius:4px;display:flex">
                                                        <a href="<?php echo e(asset('uploads/' . $message->file_path)); ?>"
                                                            target="_blank">
                                                            <span
                                                                style="font-size: 30px;margin-top:10px;color:black">&#8595;</span>
                                                            <?php echo e(basename($message->file_path)); ?>

                                                        </a>
                                                    </button>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        
                                        <div style="display: flex; ">
                                            <span class="message-time"
                                                style="font-size:10px;margin-left:20px"><?php echo e($message->created_at->format('g:i a')); ?></span>
                                            
                                            <!--[if BLOCK]><![endif]--><?php if($message->sender_id === auth()->id()): ?>
                                                <div x-data="{ markAsRead: <?php echo json_encode($message->isRead(), 15, 512) ?> }">
                                                    
                                                    <span x-cloak x-show="markAsRead" class="<?php echo \Illuminate\Support\Arr::toCssClasses('text-gray-200'); ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-check2-all"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z" />
                                                            <path
                                                                d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708z" />
                                                        </svg>
                                                    </span>
                                                    
                                                    <span x-show="!markAsRead" class="<?php echo \Illuminate\Support\Arr::toCssClasses('text-gray-200'); ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-check2"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                                                        </svg>
                                                    </span>
                                                </div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->








                    </li>
                </ul>
            </div>
            <form wire:submit.prevent="sendMessage" method="POST" enctype="multipart/form-data" id="messageForm">
                <?php echo csrf_field(); ?>

                <div class="card-footer">

                    <div class="input-group">
                        <!-- Attachment -->
                        <div class="row" style="width:100%;">
                            <!--[if BLOCK]><![endif]--><?php if($attachment && !$body): ?>
                            <div class="container attachment-container" style="width:100%;height:60px">
                                <!--[if BLOCK]><![endif]--><?php if(Str::startsWith($attachment->getMimeType(), 'image/')): ?>
                                <img src="<?php echo e($attachment->temporaryUrl()); ?>" alt="Selected Image" class="attachment-image" style="height: 50px; width: 100%;">
                                <?php else: ?>
                                <i class="fas fa-file attachment-icon"></i>
                                <?php echo e($attachment->getClientOriginalName()); ?>

                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="input-group-prepend">
                            <label class="btn btn-secondary attach-btn">
                                <i class="fas fa-paperclip"></i>
                                <input type="file" accept="image/*, .pdf, .doc, .docx" wire:model="attachment" style="display: none;width:100%;height:auto;">
                            </label>
                        </div>

                        <!-- Message body -->

                        <textarea name="message-to-send" id="messageInput" placeholder="Type your message..." wire:model="body" class="form-control message-input"></textarea>

                        <!-- Send button -->
                        <div class="input-group-append">
                            <!--[if BLOCK]><![endif]--><?php if($attachment || $body): ?>
                            <button id="sendMessageButton" type="submit" class="btn btn send-btn" style="background-color: rgb(2, 17, 79);color:white">
                                <i class="fas fa-location-arrow"></i> Send
                            </button>
                            <?php else: ?>
                            <button id="sendMessageButton" type="submit" class="btn btn send-btn" style="background-color: rgb(2, 17, 79);color:white">
                                <i class="fas fa-location-arrow"></i> Send
                            </button>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>

                    <!-- Display selected attachment -->

                </div>
                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </form>


        </div>



        <!-- end chat-history -->




    </div>

</div>
<script>
    document.addEventListener('livewire:load', function() {
        Livewire.on('messageSent', function() {
            Livewire.emit('refreshComponent'); // Trigger Livewire refresh
        });
    });
</script>
<script>
    // Function to handle input change and enable/disable send button
    document.getElementById('messageInput').addEventListener('input', function() {
        const sendMessageButton = document.getElementById('sendMessageButton');
        sendMessageButton.disabled = !this.value.trim();
    });

    // Function to handle form submission (simulated)
    function sendMessage(event) {
        event.preventDefault();
        const messageInput = document.getElementById('messageInput');
        const message = messageInput.value.trim();
        if (message) {
            // Simulated sending message
            console.log('Message sent:', message);
            messageInput.value = ''; // Clear input field
            document.getElementById('sendMessageButton').disabled = true; // Disable send button
        }
    }
</script>
<script>
    const $fileInput = $('.file-input');
    const $droparea = $('.file-drop-area');
    const $delete = $('.item-delete');

    $fileInput.on('dragenter focus click', function() {
        $droparea.addClass('is-active');
    });

    $fileInput.on('dragleave blur drop', function() {
        $droparea.removeClass('is-active');
    });

    $fileInput.on('change', function() {
        let filesCount = $(this)[0].files.length;
        let $textContainer = $(this).prev();

        if (filesCount === 1) {
            let fileName = $(this).val().split('\\').pop();
            $textContainer.text(fileName);
            $('.item-delete').css('display', 'inline-block');
        } else if (filesCount === 0) {
            $textContainer.text('or drop files here');
            $('.item-delete').css('display', 'none');
        } else {
            $textContainer.text(filesCount + ' files selected');
            $('.item-delete').css('display', 'inline-block');
        }
    });

    $delete.on('click', function() {
        $('.file-input').val(null);
        $('.file-msg').text('or drop files here');
        $('.item-delete').css('display', 'none');
    });
</script>
<script>
    function toggleDropdown() {
        var dropdownContent = document.getElementById("dropdownContent");
        dropdownContent.classList.toggle("show");
    }

    function viewProfile() {
        // Handle view profile action
    }

    function confirmDelete(id) {
        if (confirm('Are you sure?')) {
            // Handle delete action
            console.log("Deleting conversation with ID: " + id);
        }
    }
</script>
<script>
    document.addEventListener('livewire:load', function() {
        Livewire.hook('message.sent', () => {
            document.getElementById('messageInput').value = '';
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#action_menu_btn').click(function() {
            $('.action_menu').toggle();
        });
    });
</script>



<script id="message-template" type="text/x-handlebars-template">
    <!-- Your message template script here -->
</script>

<script id="message-response-template" type="text/x-handlebars-template">
    <!-- Your message response template script here -->
</script>

<style>
    @import url(https://fonts.googleapis.com/css?family=Lato:400,700);

    /*====== for Codepen Only =======*/
    *,
    *:before,
    *:after {
        box-sizing: border-box;
    }

    /* Styling for the search bar */
    .search-container {
        display: flex;
        align-items: center;
        max-width: 600px;
        margin: 20px auto;
        border-radius: 5px;
    }

    .search-container {
        display: flex;
        align-items: center;
        max-width: 600px;
        margin: 20px auto;
        border-radius: 5px;
    }

    .search-bar {
        flex: 1;
        padding: 10px 15px;
        border: 2px solid #027abf;
        border-radius: 5px 0 0 5px;
        outline: none;
        font-size: 16px;
        height: 50px;
        /* Set height for consistency */
    }

    .search-button {
        padding: 0 20px;
        /* Adjust padding to align height */
        border: none;
        background: #027abf;
        color: white;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
        font-size: 16px;
        height: 50px;
        /* Match the height of the input */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-button:hover {
        background: #025f91;
    }

    /* Send Button Styling */
    .send-button {
        margin-left: 10px;
        /* Add some space between the search bar and the send button */
        border-radius: 5px;
        color: white;
        width: 100px;
        height: 50px;
        /* Match the height of the search bar */
        font-size: 16px;
        background-color: #007bff;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s ease;
    }

    /* Styling for the send button */
    .send-button {
        border-radius: 5px;
        color: white;
        width: 100px;
        height: 50px;
        font-size: 16px;
        background-color: #007bff;
        border: none;
        cursor: pointer;
        justify-content: center;
        transition: background-color 0.3s ease;
    }

    .send-button:hover {
        background-color: #0056b3;
    }


    body {
        background: #f2f5f8;
        font: 14px/20px "Lato", Arial, sans-serif;
        padding: 0;
        color: white;
    }

    /* Dropdown styles */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #fff;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content.show {
        display: block;
    }

    /* Dropdown trigger button styles */
    .dropdown-trigger-btn {
        background-color: transparent;
        border: none;
        cursor: pointer;
    }

    /* Dropdown item styles */
    .dropdown-item {
        width: 100%;
        text-align: left;
        padding: 10px;
        border: none;
        background-color: transparent;
        cursor: pointer;
    }

    .dropdown-item:hover {
        background-color: #f9f9f9;
    }


    /*====> Chat CSS <=====*/
    .chat-container {
        margin: 0 auto;
        width: 100%;
        background: white;
        border-radius: 0;


        display: flex;

    }

    .attach_btn {
        border-radius: 15px 0 0 15px !important;
        background-color: rgba(0, 0, 0, 0.3) !important;
        border: 0 !important;
        color: white !important;
        cursor: pointer;
    }

    .send_btn {
        border-radius: 0 15px 15px 0 !important;
        background-color: rgba(0, 0, 0, 0.3) !important;
        border: 0 !important;
        color: white !important;
        cursor: pointer;
    }

    .people-list {
        width: 400px;
        justify-content: start;
    }

    .people-list .search {
        padding: 20px;

    }

    .people-list input {
        border-radius: 3px;
        border: none;
        padding: 14px;
        color: white;
        /* background: #6a6c75; */
        width: 90%;
        font-size: 14px;
        margin-top: 20px;
        justify-content: center;
        margin-left: 20px;
    }

    .people-list .fa-search {
        position: relative;
        left: -25px;
    }

    .people-list ul {
        padding: 20px;
        height: 100%;

    }

    .people-list ul li {
        padding-bottom: 20px;
    }

    .people-list img {
        float: left;
    }

    .people-list .about {
        float: left;
        margin-top: 8px;
    }

    .people-list .about {
        padding-left: 8px;
    }

    .people-list .status {
        color: #92959e;
    }

    .chat {
        width: calc(100% - 160px);
        background: #f2f5f8;
        color: #434651;
        height: 80%;
        border-radius: 5px;
    }

    .chat .chat-header {
        padding: 0.8px;
        background: white;
        /* background: rgb(1, 16, 70); */
        border-bottom: 2px solid white;
    }

    .chat .chat-header img {
        float: left;
    }

    .chat .chat-header .chat-about {
        float: left;

        padding-left: 10px;
        margin-top: 6px;
    }

    .chat .chat-header .chat-with {
        font-weight: bold;
        font-size: 16px;
    }

    .chat .chat-header .chat-num-messages {
        color: #92959e;
    }

    .chat .chat-header .fa-star {
        float: right;
        color: white;
        font-size: 20px;
        margin-top: 12px;
    }

    .chat .chat-history {
        padding: 30px 30px 20px;
        border-bottom: 2px solid white;
        overflow-y: auto;
        height: 542px;
    }

    .chat .chat-history .message-data {
        margin-bottom: 15px;
    }

    .chat .chat-history .message-data-time {
        color: #a8aab1;
        padding-left: 6px;
    }

    .chat .chat-history .message {
        color: white;
        padding: 18px 20px;
        line-height: 26px;
        font-size: 16px;
        border-radius: 7px;
        margin-bottom: 30px;
        width: 90%;
        position: relative;
    }

    .chat .chat-history .message:after {
        bottom: 100%;
        left: 7%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-bottom-color: #86bb71;
        border-width: 10px;
        margin-left: -10px;
    }

    .chat .chat-history .my-message {
        background: #86bb71;
    }

    .chat .chat-history .other-message {
        background: #94c2ed;
    }

    .chat .chat-history .other-message:after {
        border-bottom-color: #94c2ed;
        left: 93%;
    }

    /* Dropdown styles */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #fff;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .attachment-container {
        width: 100%;
        height: 100%;
        background: white;
        border-radius: 5px;
        position: relative;
    }

    .attachment-image {
        max-width: 100px;
        position: absolute;
        top: 0;
        left: 60px;
    }

    .attachment-icon {
        position: absolute;
        top: 0;
    }

    .date-header {
        text-align: center;
        color: #888;
        font-size: 12px;
        font-weight: bold;
        padding: 10px;
        border-bottom: 1px solid #ddd;
        background-color: #f9f9f9;
        margin: 10px 0;
    }


    .attach-btn {
        height: 100%;
        width: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .message-input {
        height: 60%;
        width: 70%;
    }

    .send-btn {
        height: 100%;
    }


    .dropdown-content.show {
        display: block;
    }

    /* Dropdown trigger button styles */
    .dropdown-trigger-btn {
        background-color: transparent;
        border: none;
        cursor: pointer;
    }

    /* Dropdown item styles */
    .dropdown-item {
        width: 100%;
        text-align: left;
        padding: 10px;
        border: none;
        background-color: transparent;
        cursor: pointer;
    }

    .dropdown-item:hover {
        background-color: #f9f9f9;
    }

    .chat .chat-message {
        padding: 30px;
    }

    .chat .chat-message textarea {
        width: 100%;
        border: none;
        padding: 10px 20px;
        font: 14px/22px "Lato", Arial, sans-serif;
        margin-bottom: 10px;
        border-radius: 5px;
        resize: none;
    }

    .chat .chat-message .fa-file-o,
    .chat .chat-message .fa-file-image-o {
        font-size: 16px;
        color: gray;
        cursor: pointer;
    }

    .chat .chat-message button {
        float: right;
        color: #94c2ed;
        font-size: 16px;
        text-transform: uppercase;
        border: none;
        cursor: pointer;
        font-weight: bold;
        background: #f2f5f8;
    }

    .chat .chat-message button:hover {
        color: #75b1e8;
    }

    .chat-wrapper {
        width: 100%;
    }

    /* CSS for Chat Header */
    .chat-header {
        width: 100%;
    }

    /* CSS for Chat History */
    .chat-history {
        width: 100%;
        overflow-y: auto;
        max-height: 450px;
        /* Adjust as needed */
    }


    .message-container {
        margin-bottom: 10px;
        clear: both;
    }


    .message-body {
        position: relative;
        padding: 10px;
        border-radius: 10px;
        max-width: 100%;
        word-wrap: break-word;
    }

    .message-content {
        margin: 0;
    }

    .message-time {
        font-size: 12px;
        color: #888;
    }

    .sent .message-time {
        color: white;
        /* Set the color of the sent message time to white */
    }


    .message-status {
        position: absolute;
        bottom: 5px;
        right: 5px;
        font-size: 12px;
        color: #888;
    }

    .message-status.read svg {
        fill: #007bff;
    }

    .sent .message-body {
        background-color:rgb(2, 17, 79);
        color: white;

        float: right;
    }

    .received .message-body {
        background-color: #f1f0f0;

        color: #000;
        float: left;
    }


    .hide {
        display: none;
    }

    .show {
        display: block;
    }

    .container {
        height: 100%;
        width: 20%;
        justify-content: start;
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;

    }

    .file-drop-area {
        position: relative;
        display: flex;
        align-items: center;
        width: 350px;
        max-width: 100%;
        padding: 25px;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, .1);
        transition: .3s;
    }

    .file-drop-area.is-active {
        background-color: #1a1a1a;
    }

    .fake-btn {
        flex-shrink: 0;
        background-color: #9699b3;
        border-radius: 3px;
        padding: 8px 15px;
        margin-right: 10px;
        font-size: 12px;
        text-transform: uppercase;
    }

    .file-msg {
        color: #9699b3;
        font-size: 16px;
        font-weight: 300;
        line-height: 1.4;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .item-delete {
        display: none;
        position: absolute;
        right: 10px;
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .item-delete:before {
        content: "";
        position: absolute;
        left: 0;
        transition: .3s;
        top: 0;
        z-index: 1;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg fill='%23bac1cb' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 438.5 438.5'%3e%3cpath d='M417.7 75.7A8.9 8.9 0 00411 73H323l-20-47.7c-2.8-7-8-13-15.4-18S272.5 0 264.9 0h-91.3C166 0 158.5 2.5 151 7.4c-7.4 5-12.5 11-15.4 18l-20 47.7H27.4a9 9 0 00-6.6 2.6 9 9 0 00-2.5 6.5v18.3c0 2.7.8 4.8 2.5 6.6a8.9 8.9 0 006.6 2.5h27.4v271.8c0 15.8 4.5 29.3 13.4 40.4a40.2 40.2 0 0032.3 16.7H338c12.6 0 23.4-5.7 32.3-17.2a64.8 64.8 0 0013.4-41V109.6h27.4c2.7 0 4.9-.8 6.6-2.5a8.9 8.9 0 002.6-6.6V82.2a9 9 0 00-2.6-6.5zm-248.4-36a8 8 0 014.9-3.2h90.5a8 8 0 014.8 3.2L283.2 73H155.3l14-33.4zm177.9 340.6a32.4 32.4 0 01-6.2 19.3c-1.4 1.6-2.4 2.4-3 2.4H100.5c-.6 0-1.6-.8-3-2.4a32.5 32.5 0 01-6.1-19.3V109.6h255.8v270.7z'/%3e%3cpath d='M137 347.2h18.3c2.7 0 4.9-.9 6.6-2.6a9 9 0 002.5-6.6V173.6a9 9 0 00-2.5-6.6 8.9 8.9 0 00-6.6-2.6H137c-2.6 0-4.8.9-6.5 2.6a8.9 8.9 0 00-2.6 6.6V338c0 2.7.9 4.9 2.6 6.6a8.9 8.9 0 006.5 2.6zM210.1 347.2h18.3a8.9 8.9 0 009.1-9.1V173.5c0-2.7-.8-4.9-2.5-6.6a8.9 8.9 0 00-6.6-2.6h-18.3a8.9 8.9 0 00-9.1 9.1V338a8.9 8.9 0 009.1 9.1zM283.2 347.2h18.3c2.7 0 4.8-.9 6.6-2.6a8.9 8.9 0 002.5-6.6V173.6c0-2.7-.8-4.9-2.5-6.6a8.9 8.9 0 00-6.6-2.6h-18.3a9 9 0 00-6.6 2.6 8.9 8.9 0 00-2.5 6.6V338a9 9 0 002.5 6.6 9 9 0 006.6 2.6z'/%3e%3c/svg%3e");
    }

    .item-delete:after {
        content: "";
        position: absolute;
        opacity: 0;
        left: 50%;
        top: 50%;
        width: 100%;
        height: 100%;
        transform: translate(-50%, -50%) scale(0);
        background-color: #f3dbff;
        border-radius: 50%;
        transition: .3s;
    }

    .item-delete:hover:after {
        transform: translate(-50%, -50%) scale(2.2);
        opacity: 1;
    }

    .item-delete:hover:before {
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg fill='%234f555f' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 438.5 438.5'%3e%3cpath d='M417.7 75.7A8.9 8.9 0 00411 73H323l-20-47.7c-2.8-7-8-13-15.4-18S272.5 0 264.9 0h-91.3C166 0 158.5 2.5 151 7.4c-7.4 5-12.5 11-15.4 18l-20 47.7H27.4a9 9 0 00-6.6 2.6 9 9 0 00-2.5 6.5v18.3c0 2.7.8 4.8 2.5 6.6a8.9 8.9 0 006.6 2.5h27.4v271.8c0 15.8 4.5 29.3 13.4 40.4a40.2 40.2 0 0032.3 16.7H338c12.6 0 23.4-5.7 32.3-17.2a64.8 64.8 0 0013.4-41V109.6h27.4c2.7 0 4.9-.8 6.6-2.5a8.9 8.9 0 002.6-6.6V82.2a9 9 0 00-2.6-6.5zm-248.4-36a8 8 0 014.9-3.2h90.5a8 8 0 014.8 3.2L283.2 73H155.3l14-33.4zm177.9 340.6a32.4 32.4 0 01-6.2 19.3c-1.4 1.6-2.4 2.4-3 2.4H100.5c-.6 0-1.6-.8-3-2.4a32.5 32.5 0 01-6.1-19.3V109.6h255.8v270.7z'/%3e%3cpath d='M137 347.2h18.3c2.7 0 4.9-.9 6.6-2.6a9 9 0 002.5-6.6V173.6a9 9 0 00-2.5-6.6 8.9 8.9 0 00-6.6-2.6H137c-2.6 0-4.8.9-6.5 2.6a8.9 8.9 0 00-2.6 6.6V338c0 2.7.9 4.9 2.6 6.6a8.9 8.9 0 006.5 2.6zM210.1 347.2h18.3a8.9 8.9 0 009.1-9.1V173.5c0-2.7-.8-4.9-2.5-6.6a8.9 8.9 0 00-6.6-2.6h-18.3a8.9 8.9 0 00-9.1 9.1V338a8.9 8.9 0 009.1 9.1zM283.2 347.2h18.3c2.7 0 4.8-.9 6.6-2.6a8.9 8.9 0 002.5-6.6V173.6c0-2.7-.8-4.9-2.5-6.6a8.9 8.9 0 00-6.6-2.6h-18.3a9 9 0 00-6.6 2.6 8.9 8.9 0 00-2.5 6.6V338a9 9 0 002.5 6.6 9 9 0 006.6 2.6z'/%3e%3c/svg%3e");
    }

    .file-input {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        cursor: pointer;
        opacity: 0;
    }

    .file-input:focus {
        outline: none;
    }


    .online,
    .offline,
    .me {
        margin-right: 3px;
        font-size: 10px;
    }

    .online {
        color: #86bb71;
    }

    .offline {
        color: #e38968;
    }

    .me {
        color: #94c2ed;
    }

    .align-left {
        text-align: left;
    }

    .align-right {
        text-align: right;
    }

    .float-right {
        float: right;
    }

    .clearfix:after {
        visibility: hidden;
        display: block;
        font-size: 0;
        content: " ";
        clear: both;
        height: 0;
    }
</style>
</div>
</div><?php /**PATH C:\xampp\htdocs\GreytHr\resources\views/livewire/chat/chat-box.blade.php ENDPATH**/ ?>