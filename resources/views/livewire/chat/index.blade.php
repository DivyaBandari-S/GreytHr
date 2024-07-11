<div>

    <div class="chat-container ">
        <div class="people-list" id="people-list" style=" border: 1px solid silver;">
            <div class="row" style="display: flex;">
                <p style="font-size:20px; font-weight: 500; color: black; margin: 20px 10px 20px 20px;">Chats</p>

            </div>


            <div class="search-container">
                <input type="text" placeholder="Search..." class="search-bar">


            </div>

            <main class="grow h-full relative" style="contain: content; ">

                <ul class="p-2 grid w-full space-y-2" style="list-style: none; padding: 0;">
                    <div class="c" style="contain: content; overflow-y: auto; max-height: 400px;margin-left:20px">
                        @if ($conversations)


                            @foreach ($conversations as $key => $conversation)
                                <li id="conversation-{{ $conversation->id }}" wire:key="{{ $conversation->id }}"
                                    class="py-3 hover:bg-gray-50 rounded-2xl dark:hover:bg-gray-700/70 transition-colors duration-150 flex gap-4 relative w-full cursor-pointer px-2 {{ $conversation->id == $selectedConversation?->emp_id ? 'bg-gray-100/70' : '' }}"
                                    style="margin-bottom: 10px;height:70px;width:90%; ">
                                    <img style="border-radius: 50%; margin-left: auto; margin-right: auto; display: block; height: 40px; width: 40px; margin-top: 5px;"
                                        src="{{ asset('storage/' . $conversation->getReceiver()->image) }}"
                                        class="card-img-top" alt="...">
                                    <aside class="grid grid-cols-12 w-full">
                                        <a href="{{ route('chat', $conversation->id) }}"
                                            class="col-span-11 border-b pb-2 border-gray-200 relative overflow-hidden truncate leading-5 w-full flex-nowrap p-1"
                                            style="display: block; color: #000000; text-decoration: none;">
                                            <div class="flex justify-between w-full items-center">
                                                <div style="display:flex">
                                                    <h6 class="truncate font-medium tracking-wider text-gray-900"
                                                        style="color: #333333;font-size:12px">
                                                        {{ $conversation->getReceiver()->first_name }}{{ $conversation->getReceiver()->last_name }}
                                                    </h6>
                                                    <small class="text-gray-700"
                                                        style="color: #888888;margin-left: auto;">{{ $conversation->messages?->last()?->created_at?->shortAbsoluteDiffForHumans() }}</small>
                                                </div>
                                                <div class="flex gap-x-2 items-center ">
                                                    @if ($conversation->messages?->last()?->sender_id == auth()->id())
                                                    @endif
                                                    @php
                                                        $lastMessage = $conversation->messages
                                                            ? $conversation->messages->last()
                                                            : null;
                                                    @endphp
                                                    <span>
                                                        <p class="grow truncate text-sm font-[100]"
                                                            style="color: #555555;font-size:10px">
                                                            {{ Str::limit($lastMessage ? $lastMessage->body : '', 15) }}
                                                        </p>
                                                        {{-- unread count --}}
                                                        @if ($conversation->unreadMessagesCount() > 0)
                                                            <span
                                                                style="font-weight: bold; padding: 1px 4px; font-size: 0.75rem; border-radius: 12px; background-color: #007bff; color: #ffffff;">
                                                                {{ $conversation->unreadMessagesCount() }}
                                                            </span>
                                                        @endif
                                                    </span>

                                                </div>



                                        </a>

                                        {{-- Dropdown --}}






                    </div>

                    </aside>

                    </li>
                    @endforeach

                    @endif
                </ul>
            </main>
        </div>
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
                height: 40px;
                width: 250px;

                border-radius: 5px;

            }

            .search-bar {
                flex: 1;
                border: none;
                height: 40px;
                padding: 10px;
                font-size: 14px;
            }

            .search-button {
                background-color: blue;
                color: white;
                border: none;
                cursor: pointer;
                padding: 10px 20px;
                height: 40px;
                margin-top: 17px;
                border-radius: 0 5px 5px 0;
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
                background: #f2f5f8;
                border-radius: 0;
                display: flex;

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
                height: 100%;
            }

            .chat .chat-header {
                padding: 20px;
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
                color: #d8dadf;
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
                max-height: 300px;
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
                background-color: #007bff;
                color: #fff;
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
