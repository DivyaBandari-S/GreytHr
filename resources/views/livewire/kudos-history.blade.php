<div class="container">
    <div class="row justify-content-start people-emp-tab-container">
        <div class="col-3 text-start people-starred-tab-container">
            <a id="starred-tab-link" class="people-manager-tab-link {{ $activeTab === 'Recieved' ? 'active' : '' }}"
                wire:click="setActiveTab('Recieved')" class="links">
                Recieved
            </a>
        </div>
        <div class="col-3 text-start people-starred-tab-container" style="padding-left: 50px;">
            <a id="everyone-tab-link" class="people-manager-tab-link {{ $activeTab === 'Given' ? 'active' : '' }}"
                wire:click="setActiveTab('Given')" class="links">
                Given
            </a>
        </div>
        <div style="{{ $activeTab === 'Recieved' ? 'left: 8px;' : 'left: 114px;' }} z-index:1;"
            class="people-emp-tab-line {{ $activeTab === 'Recieved' ? 'tab-position-emp-starred' : 'tab-position-emp-everyone' }}">
        </div>
    </div>
    @if ($showKudosDialog)
    <div class="modal" tabindex="-1" role="dialog" style="display: block;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <b>Give Kudos</b>
                    </h5>
                    <button type="button" class="btn-close btn-primary" data-dismiss="modal"
                        aria-label="Close" wire:click="close">
                    </button>
                </div>

                <div class="modal-body" style="height: 400px; overflow-y: scroll;">
                    <div class="row">
                        <div class="d-flex col-12 mb-2">
                            <label for="from-date">You are posting in:</label>
                            <select id="postType"
                                wire:change="updatePostType($event.target.value)"
                                wire:model.lazy="postType"
                                class="Employee-select-leave placeholder-big"
                                style="border: none; margin-left: 10px;"
                                @if ($kudoId) disabled @endif>
                                <option value="appreciations">Appreciations</option>
                                <option value="buysellrent">Buy/Sell/Rent</option>
                                <option value="companynews">Company News</option>
                                <option value="events">Events</option>
                                <option value="everyone">Everyone</option>
                                <option value="hyderabad">Hyderabad</option>
                                <option value="technology">Technology</option>


                                <!-- Add other leave types as needed -->
                            </select>
                        </div>
                        <div class="form-group col-12 mb-2">
                            <label for="search1">Search Employee<span
                                    style="color: var(--requiredAlert);">*</span></label>
                            <div class="analytic-view-all-search-bar">
                                <div class="search-wrapper">
                                    @if ($selectedEmployee)
                                    <!-- Show the selected employee's initials and full name -->
                                    <div class="selected-initials-circle">
                                        {{ strtoupper(substr($selectedEmployee->first_name, 0, 1)) . strtoupper(substr($selectedEmployee->last_name, 0, 1)) }}
                                    </div>
                                    <div class="selected-employee-details">
                                        <div class="selected-full-name">
                                            {{ $selectedEmployee->first_name }}
                                            {{ $selectedEmployee->last_name }}
                                        </div>
                                        <div class="selected-employee-id">
                                            #{{ $selectedEmployee->emp_id }}</div>
                                    </div>
                                    @else
                                    <!-- Default search icon -->
                                    <i class="search-icon-user fas fa-user"></i>
                                    @endif

                                    <!-- Search input field -->
                                    <input wire:model.debounce="search1"
                                        wire:change="validateKudos" wire:input="searchEmployees"
                                        type="text" placeholder=""
                                        @if ($kudoId) disabled @endif>

                                    @if ($selectedEmployee && !$kudoId)
                                    <i wire:click="removeSelectedEmployee"
                                        wire:key="remove-selected-employee-{{ $selectedEmployee->emp_id }}"
                                        class="search-icon-search fas fa-times"></i>
                                    @elseif(!$kudoId)
                                    <i class="search-icon-search fas fa-search"></i>
                                    @endif

                                </div>
                            </div>

                            @if (!empty($search1))
                            @if ($employees1->isEmpty())
                            <div class="no-data-found search-results-container p-3"
                                style="font-size: 16px;">No data found</div>
                            @else
                            <div class="search-results-container">
                                @foreach ($employees1 as $employee)
                                <div class="search-result-item"
                                    wire:click="selectEmployee('{{ $employee->emp_id }}')">
                                    <!-- Initials in a circle -->
                                    <div class="initials-circle">
                                        {{ strtoupper(substr($employee->first_name, 0, 1)) . strtoupper(substr($employee->last_name, 0, 1)) }}
                                    </div>

                                    <!-- Full name and employee ID -->
                                    <div class="employee-details">
                                        <div class="full-name">
                                            {{ $employee->first_name }}
                                            {{ $employee->last_name }}
                                        </div>
                                        <div class="employee-id">
                                            #{{ $employee->emp_id }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            @endif

                            @error('selectedEmployee')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-12 mb-2">
                            <label for="recognizeType" class="mb-2">Recognize
                                Values</label>
                            <div class="dropdown-container input-wrapper">


                                <input class="form-select placeholder-small input-field"
                                    wire:click="recognizeToggleDropdown" placeholder="Select" readonly>





                                <!-- Dropdown Content -->
                                @if ($dropdownOpen)
                                <div class="dropdown-content"
                                    style="position: absolute; top: 100%; width: 100%; z-index: 10;">

                                    <!-- Search Field inside Dropdown -->
                                    <input wire:model="searchTerm" class="search-input"
                                        wire:input="searchRecognizeValues"
                                        placeholder="Search..." />

                                    <!-- Options List -->
                                    <div class="options-container">
                                        @if (!empty($searchTerm))
                                        @if (count($recognizeOptions) > 0)
                                        <!-- Display the options if there are search results -->
                                        @foreach ($recognizeOptions as $key => $value)
                                        <label class="option-item">
                                            <input type="checkbox"
                                                wire:model="recognizeType"
                                                value="{{ $key }}">
                                            <div class="option-label">
                                                <div class="option-title">
                                                    {{ $key }}
                                                </div>
                                                <div
                                                    class="option-description">
                                                    {{ $value }}
                                                </div>
                                            </div>
                                        </label>
                                        @endforeach
                                        @else
                                        <!-- No results found for the search -->
                                        <div class="no-results">
                                            <img src="{{ asset('/images/norecognizedata.png') }}"
                                                alt="No results"
                                                class="no-results-image" />
                                            <p
                                                style="font-size: 14px; font-weight: 500; margin: 0px;">
                                                Uh oh!</p>
                                            <span class="no-results-text">Nothing
                                                to show here</span>
                                        </div>
                                        @endif
                                        @else
                                        <!-- Display all options when there is no search term -->
                                        @foreach ($options as $key => $value)
                                        <label class="option-item">
                                            <input type="checkbox"
                                                wire:model="recognizeType"
                                                value="{{ $key }}">
                                            <div class="option-label">
                                                <div class="option-title">
                                                    {{ $key }}
                                                </div>
                                                <div class="option-description">
                                                    {{ $value }}
                                                </div>
                                            </div>
                                        </label>
                                        @endforeach
                                        @endif

                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="selected-items-container">
                                @foreach ($recognizeType as $type)
                                <div class="selected-item">
                                    <span
                                        style="font-size: 11px;color: var(--main-heading-color);font-weight: 500;">{{ $type }}</span>
                                    <button type="button"
                                        wire:click="removeItem('{{ $type }}')"
                                        class="remove-item-btn">x</button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group col-12 mb-2">
                            <label for="message" class="mb-2">Your message<span
                                    style="color: var(--requiredAlert);">*</span></label>

                            <!-- Full-width text area for the rich text editor -->
                            <textarea id="message" wire:model="message" wire:change="validateKudos" rows="4" class="w-100" style="padding: 10px;"
                                placeholder=""></textarea>
                            @error('message')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-12 mb-2">
                            <label for="reactions" class="mb-2">Reactions</label>
                            <div class="reaction-section">
                                <!-- Default Emoji Button with Plus Icon -->
                                <button type="button" wire:click="toggleKudosEmojiPicker1"
                                    class="reaction-btn">
                                    😊 <span class="plus-icon">+</span>
                                </button>

                                <!-- Emoji Picker (Hidden by default) -->
                                @if ($showKudoEmojiPicker1)
                                <div class="kudos-emoji-picker">
                                    <!-- Emojis for reactions -->
                                    @foreach ($this->getReactionEmojis() as $reaction => $emoji)
                                    <button type="button"
                                        wire:click="addReaction('{{ $reaction }}')"
                                        class="emoji-btn">
                                        {{ $emoji }}
                                    </button>
                                    @endforeach
                                </div>
                                @endif

                                <!-- Display Selected Reactions -->
                                <div class="selected-reactions mt-2">

                                    @foreach ($reactions as $reaction)
                                    <span class="selected-reaction">
                                        @if (is_array($reaction) && isset($reaction['emoji']))
                                        <!-- Second condition: Direct emoji (e.g., 👍) -->
                                        {!! $reaction['emoji'] !!}
                                        <button
                                            wire:click="removeKudosReaction('{{ $reaction['employee_id'] }}', '{{ $reaction['emoji'] }}')"
                                            class="remove-btn">×</button>
                                        @endif
                                        <!-- Remove button (cross icon) for each selected reaction -->

                                    </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>



                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="submit-btn"
                            wire:click="submitKudos">Give</button>
                        <button type="button" class="cancel-btn" wire:click="resetFields"
                            style="border:1px solid rgb(2,17,79);">Cancel</button>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show blurred-backdrop"></div>
    @endif
    <!-- Received Container -->
    @if ($activeTab === 'Recieved')

    <div class="col-md-12 col-md-6">



        @if ((is_array($kudos) && empty($kudos)) || ($kudos instanceof \Illuminate\Support\Collection && $kudos->isEmpty()))
        <div class="d-flex flex-column align-items-center justify-content-center">
            <img src="{{ asset('images/thumbs.webp') }}"
                alt="Empty Image" class="rounded-circle mt-4" height="150px" width="150px">
            <h3>Get going!</h3>
            <p>All the Kudos you have received will appear here.</p>
            <button class="submit-btn"><a href="/Feeds" style="color:white;">Go to Engage</a></button>
        </div>
        @else
        <div class="kudoseventsSection" style="height: 450px;">
            @foreach ($kudos as $kudo)
            <div class="col-12 col-md-6" style="margin-top: 15px;">
                <!-- Upcoming Birthdays List -->
                <div class="cards" style="display: flex; flex-direction: column;">
                    <div class="row mt-2">
                        <!-- First Column: Employee Initials in a Circle -->
                        <div class="col-12 col-md-2 text-start mb-2 mb-md-0">
                            <!-- Employee's Initials -->
                            <div class="rounded-circle"
                                style="width: 45px; height: 45px; background-color: #e986ea;color: white; display: flex; align-items: center; justify-content: center; font-size: 14px;">
                                {{ strtoupper(substr($kudo->sender_first_name, 0, 1)) . strtoupper(substr($kudo->sender_last_name, 0, 1)) }}
                            </div>
                        </div>

                        <!-- Second Column: Full Name, Employee ID, and Group (Post Type) -->
                        <div class="col-6 col-md-6 text-start"
                            style="font-size: 12px; margin-left: -14px;">
                            <!-- Adjust padding-left for spacing -->
                            <p class="p-0 m-0">
                                <strong>{{ ucwords(strtolower($kudo->sender_first_name . ' ' . $kudo->sender_last_name)) }}</strong>
                            </p>
                            <p class="p-0 m-0"><span>#{{ $kudo->sender_emp_id }}</span></p>
                            <p class="p-0 m-0">Group:
                                {{ ucwords(strtolower($kudo->post_type)) }}
                            </p>
                            <!-- Post Type -->
                        </div>

                        <!-- Third Column: Time (updated_at) -->

                        <div class="col-6 col-md-4 text-md-end" style="font-size: 12px;">
                            {{ \Carbon\Carbon::parse($kudo->updated_at)->diffForHumans() }}

                            @if (auth()->user()->emp_id === $kudo->sender_emp_id)
                            <!-- Three Dots Icon -->
                            <button class="three-dots-btn"
                                style="border: none; background: none; font-size: 18px; cursor: pointer; margin-left: 10px;"
                                wire:click="showDropdown({{ $kudo->id }})">
                                &#8942; <!-- Unicode for vertical three dots -->
                            </button>
                            @if (isset($showOptions[$kudo->id]) && $showOptions[$kudo->id])
                            <div class="kudos-options-container"
                                style="position: absolute;background-color: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border-radius: 5px; width: 120px; z-index: 999;">
                                <p wire:click="showPopup({{ $kudo->id }})">Delete
                                    Kudos</p>
                                <p wire:click="editKudo({{ $kudo->id }})">Edit Kudos
                                </p>
                            </div>
                            @endif
                            @endif

                            <!-- Time ago -->
                        </div>
                    </div>



                    <div class="row m-0"
                        style="display: flex;justify-content: center; position: relative;">
                        <img src="{{ asset('images/blast.png') }}" alt=""
                            style="width: 250px; height: 150px;">

                        <div class="col-6">
                            <div class="rounded-circle"
                                style="position: absolute; top: 30px; left: 38%; transform: translateX(-50%);width: 80px; height: 80px; background-color: #f3ab63; color: white; display: flex; align-items: center; justify-content: center; font-size: 20px;     margin-left: 35px;    margin-top: 10px;">
                                {{ strtoupper(substr($kudo->recipient_first_name, 0, 1)) . strtoupper(substr($kudo->recipient_last_name, 0, 1)) }}
                            </div>
                            <p style="text-align: center; margin-left: -15px">
                                {{ ucwords(strtolower($kudo->recipient_first_name)) }}
                                {{ ucwords(strtolower($kudo->recipient_last_name)) }}
                            </p>
                        </div>
                    </div>
                    <div class="col-12 text-start">
                        <div class="d-flex justify-content-start flex-wrap">
                            @foreach (json_decode($kudo->recognize_type) ?: [] as $recognize)
                            @php
                            $colors = $this->getRecognitionColor($recognize);
                            @endphp
                            <div class="badge m-1"
                                style="background-color: {{ $colors[0] }};
                                                   border: 1px solid {{ $colors[1] }}; 
                                                   color: {{ $colors[1] }}; 
                                                   padding: 5px 15px; 
                                                   font-size: 12px;
                                                   border-radius: 20px; font-weight: 400;">
                                {{ ucwords(strtolower($recognize)) }}
                            </div>
                            @endforeach

                        </div>
                    </div>

                    <p
                        style="font-size: 14px; margin-top: 10px; font-weight: 100; color: #677A8E;     margin-left: 6px;">
                        {{ $kudo->message }}
                    </p>
                    <div class="d-flex align-items-start mt-2" style="    margin-left: 5px;">
                        @php
                        // Decode the reactions from JSON to array if necessary
                        $reactions = json_decode($kudo->reactions, true);
                        if (!is_array($reactions)) {
                        $reactions = [];
                        }
                        $reactionsCount = count($reactions); // Total count of reactions

                        $reactionsToShow = array_slice($reactions, -3); // Get the last 3 reactions

                        $lastReacted =
                        $reactionsCount > 0 ? $reactions[$reactionsCount - 1] : null; // Last reacted emoji
                        $backgroundColors = ['#eebf7b', '#87CEEB', '#ffb6c1'];
                        @endphp

                        <!-- Loop to display the last 3 reactions -->
                        @foreach ($reactionsToShow as $index => $reaction)
                        <div class="reaction-circle"
                            style="width: 25px;height: 25px;background-color: {{ $backgroundColors[$index] }};border-radius: 50%; display: flex;align-items: center;justify-content: center;margin-right: -10px;">
                            <span style="font-size: 14px;">{{ $reaction['emoji'] }}</span>
                            <!-- Emoji inside the circle -->
                        </div>
                        @endforeach

                        <!-- Show last reacted employee and count of others -->
                        @if ($reactionsCount > 0)
                        <!-- Display the last employee's name who reacted -->
                        @php
                        // Get the last reaction from the array
                        $lastReaction = end($reactions);
                        $lastEmployeeId = $lastReaction['employee_id']; // Get employee_id of last reaction
                        $lastEmployee = \App\Models\EmployeeDetails::where(
                        'emp_id',
                        $lastEmployeeId,
                        )->first(); // Fetch employee details
                        @endphp
                        @if ($lastEmployee)
                        <span
                            style="font-size: 12px; color: #0e82ad; margin-left: 19px; cursor: pointer;"
                            wire:click="showReactions({{ json_encode($reactions) }},{{ $kudo->id }})">
                            {{ $lastEmployee->first_name }}
                            {{ $lastEmployee->last_name }}
                        </span>
                        @endif
                        @endif

                        @if ($reactionsCount > 3)
                        <!-- Show how many extra reactions if there are more than 3 -->
                        <span
                            style="font-size: 12px; color: #0e82ad; margin-left: 5px; cursor: pointer;"
                            wire:click="showReactions({{ json_encode($reactions) }},{{ $kudo->id }})">
                            and {{ $reactionsCount - 3 }} others reacted.
                        </span>
                        @endif

                    </div>
                    @if ($showDialogReactions)
                    <div class="modal d-block" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                            role="document">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title"><b>Reactions</b></h5>
                                    <button type="button" class="btn-close btn-primary"
                                        data-dismiss="modal" aria-label="Close"
                                        wire:click="closeEmojiReactions">
                                    </button>
                                </div>

                                <div class="modal-body">
                                    @foreach ($allEmojis as $emoji)
                                    <div
                                        style="display: flex; align-items: center;margin-top:10px;">

                                        <span>

                                            @php

                                            // Access the 'emp_id' directly since $emoji is an array

                                            $employee = \App\Models\EmployeeDetails::where(
                                            'emp_id',
                                            $emoji['employee_id'],
                                            )->first();

                                            @endphp



                                            @if ($employee && $employee->image && $employee->image !== 'null')
                                            <img style="border-radius: 50%; margin-left: 10px"
                                                height="30" width="30"
                                                src="data:image/jpeg;base64,{{ $employee->image }}">
                                            @else
                                            @if ($employee && $employee->gender == 'Male')
                                            <img style="border-radius: 50%; margin-left: 10px"
                                                height="30" width="30"
                                                src="{{ asset('images/male-default.png') }}"
                                                alt="Default Male Image">
                                            @elseif($employee && $employee->gender == 'Female')
                                            <img style="border-radius: 50%; margin-left: 10px"
                                                height="30" width="30"
                                                src="{{ asset('images/female-default.jpg') }}"
                                                alt="Default Female Image">
                                            @else
                                            <img style="border-radius: 50%; margin-left: 10px"
                                                height="30" width="30"
                                                src="{{ asset('images/user.jpg') }}"
                                                alt="Default Image">
                                            @endif
                                            @endif

                                        </span>



                                        <span
                                            style="font-size: 12px; margin-left: 10px;width:50%">

                                            {{ ucwords(strtolower($employee->first_name)) }}
                                            {{ ucwords(strtolower($employee->last_name)) }}

                                        </span>



                                        <div
                                            style="display: flex; justify-content: center;">



                                            <span
                                                style="font-size: 16px; cursor: pointer; color: inherit;     margin-left: 50px;"
                                                wire:click="removeReaction('{{ $emoji['employee_id'] }}', '{{ $emoji['emoji'] }}','{{ $kudoId }}', '{{ $emoji['created_at'] }}')">

                                                {{ $emoji['emoji'] }}

                                            </span>

                                        </div>

                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-backdrop fade show transparent-backdrop"></div>
                    @endif
                    <hr>
                    <div>
                        <i class="far fa-smile"
                            wire:click.prevent="toggleKudosEmojiPicker({{ $kudo->id }})"></i>

                        @if (isset($showKudoEmojiPicker[$kudo->id]) && $showKudoEmojiPicker[$kudo->id])
                        <div class="reaction-emoji-picker">
                            <!-- Emojis for reactions -->
                            @foreach ($this->getReactionEmojis() as $reaction => $emoji)
                            <button type="button"
                                wire:click="addReaction1('{{ $reaction }}', {{ $kudo->id }})"
                                class="emoji-btn">
                                {{ $emoji }}
                            </button>
                            @endforeach
                        </div>
                        @endif

                    </div>



                    <confirmation-modal class="confirmation-modal">
                        <gt-popup-modal label="modal" size="sm" class="hydrated">
                            <div class="body-content">
                                <div slot="modal-body">
                                    <!-- Content for modal body -->
                                </div>
                            </div>
                            <div slot="modal-footer">
                                <div class="flex justify-end">
                                    <gt-button shade="secondary" name="Cancel"
                                        class="mr-2x hydrated"></gt-button>
                                    <gt-button shade="primary" name="Confirm"
                                        class="hydrated"></gt-button>
                                </div>
                            </div>
                        </gt-popup-modal>
                    </confirmation-modal>
                </div>
            </div>
            @if (isset($showModal[$kudo->id]) && $showModal[$kudo->id])
            <div class="modal" id="logoutModal" tabindex="-1" style="display: block;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header text-white"
                            style=" background-color: rgb(2, 17, 79);">
                            <h6 class="modal-title " id="logoutModalLabel"
                                style="align-items: center;">Delete Kudos</h6>
                        </div>
                        <div class="modal-body text-center"
                            style="font-size: 14px;color:var( --main-heading-color);">
                            Are you sure you want to delete Kudos?
                        </div>
                        <div class="d-flex gap-3 justify-content-center p-3">
                            <button type="button" class="submit-btn mr-3"
                                wire:click="confirmDelete({{ $kudo->id }})">Delete</button>
                            <button type="button" class="cancel-btn1"
                                wire:click="closeModal({{ $kudo->id }})">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>
            @endif
            @endforeach



            @endif
        </div>
        @endif

        <!-- Given Container -->
        @if ($activeTab === 'Given')
        <div class="col-md-12 col-md-6">



            @if ((is_array($kudos) && empty($kudos)) || ($kudos instanceof \Illuminate\Support\Collection && $kudos->isEmpty()))
            <div class="d-flex flex-column align-items-center justify-content-center">
                <img src="{{ asset('images/thumbs.webp') }}"
                    alt="Empty Image" class="rounded-circle mt-4" height="150px" width="150px">
                <h3>Get going!</h3>
                <p>All the Kudos you have received will appear here.</p>
                <button class="submit-btn"><a href="/Feeds" style="color:white;">Go to Engage</a></button>
            </div>
            @else
            <div class="kudoseventsSection" style="height: 450px;">
                @foreach ($kudos as $kudo)
                <div class="col-12 col-md-6" style="margin-top: 15px;">
                    <!-- Upcoming Birthdays List -->
                    <div class="cards" style="display: flex; flex-direction: column;">
                        <div class="row mt-2">
                            <!-- First Column: Employee Initials in a Circle -->
                            <div class="col-12 col-md-2 text-start mb-2 mb-md-0">
                                <!-- Employee's Initials -->
                                <div class="rounded-circle"
                                    style="width: 45px; height: 45px; background-color: #e986ea;color: white; display: flex; align-items: center; justify-content: center; font-size: 14px;">
                                    {{ strtoupper(substr($kudo->sender_first_name, 0, 1)) . strtoupper(substr($kudo->sender_last_name, 0, 1)) }}
                                </div>
                            </div>

                            <!-- Second Column: Full Name, Employee ID, and Group (Post Type) -->
                            <div class="col-6 col-md-6 text-start"
                                style="font-size: 12px; margin-left: -14px;">
                                <!-- Adjust padding-left for spacing -->
                                <p class="p-0 m-0">
                                    <strong>{{ ucwords(strtolower($kudo->sender_first_name . ' ' . $kudo->sender_last_name)) }}</strong>
                                </p>
                                <p class="p-0 m-0"><span>#{{ $kudo->sender_emp_id }}</span></p>
                                <p class="p-0 m-0">Group:
                                    {{ ucwords(strtolower($kudo->post_type)) }}
                                </p>
                                <!-- Post Type -->
                            </div>

                            <!-- Third Column: Time (updated_at) -->

                            <div class="col-6 col-md-4 text-md-end" style="font-size: 12px;">
                                {{ \Carbon\Carbon::parse($kudo->updated_at)->diffForHumans() }}

                                @if (auth()->user()->emp_id === $kudo->sender_emp_id)
                                <!-- Three Dots Icon -->
                                <button class="three-dots-btn"
                                    style="border: none; background: none; font-size: 18px; cursor: pointer; margin-left: 10px;"
                                    wire:click="showDropdown({{ $kudo->id }})">
                                    &#8942; <!-- Unicode for vertical three dots -->
                                </button>
                                @if (isset($showOptions[$kudo->id]) && $showOptions[$kudo->id])
                                <div class="kudos-options-container"
                                    style="position: absolute;background-color: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border-radius: 5px; width: 120px; z-index: 999;">
                                    <p wire:click="showPopup({{ $kudo->id }})">Delete
                                        Kudos</p>
                                    <p wire:click="editKudo({{ $kudo->id }})">Edit Kudos
                                    </p>
                                </div>
                                @endif
                                @endif

                                <!-- Time ago -->
                            </div>
                        </div>



                        <div class="row m-0"
                            style="display: flex;justify-content: center; position: relative;">
                            <img src="{{ asset('images/blast.png') }}" alt=""
                                style="width: 250px; height: 150px;">

                            <div class="col-6">
                                <div class="rounded-circle"
                                    style="position: absolute; top: 30px; left: 38%; transform: translateX(-50%);width: 80px; height: 80px; background-color: #f3ab63; color: white; display: flex; align-items: center; justify-content: center; font-size: 20px;     margin-left: 35px;    margin-top: 10px;">
                                    {{ strtoupper(substr($kudo->recipient_first_name, 0, 1)) . strtoupper(substr($kudo->recipient_last_name, 0, 1)) }}
                                </div>
                                <p style="text-align: center; margin-left: -15px">
                                    {{ ucwords(strtolower($kudo->recipient_first_name)) }}
                                    {{ ucwords(strtolower($kudo->recipient_last_name)) }}
                                </p>
                            </div>
                        </div>
                        <div class="col-12 text-start">
                            <div class="d-flex justify-content-start flex-wrap">
                                @foreach (json_decode($kudo->recognize_type) ?: [] as $recognize)
                                @php
                                $colors = $this->getRecognitionColor($recognize);
                                @endphp
                                <div class="badge m-1"
                                    style="background-color: {{ $colors[0] }}; 
                                               border: 1px solid {{ $colors[1] }}; 
                                               color: {{ $colors[1] }}; 
                                               padding: 5px 15px; 
                                               font-size: 12px; 
                                               border-radius: 20px; font-weight: 400;">
                                    {{ ucwords(strtolower($recognize)) }}
                                </div>
                                @endforeach

                            </div>
                        </div>

                        <p
                            style="font-size: 14px; margin-top: 10px; font-weight: 100; color: #677A8E;     margin-left: 6px;">
                            {{ $kudo->message }}
                        </p>
                        <div class="d-flex align-items-start mt-2" style="    margin-left: 5px;">
                            @php
                            // Decode the reactions from JSON to array if necessary
                            $reactions = json_decode($kudo->reactions, true);
                            if (!is_array($reactions)) {
                            $reactions = [];
                            }
                            $reactionsCount = count($reactions); // Total count of reactions

                            $reactionsToShow = array_slice($reactions, -3); // Get the last 3 reactions

                            $lastReacted =
                            $reactionsCount > 0 ? $reactions[$reactionsCount - 1] : null; // Last reacted emoji
                            $backgroundColors = ['#eebf7b', '#87CEEB', '#ffb6c1'];
                            @endphp

                            <!-- Loop to display the last 3 reactions -->
                            @foreach ($reactionsToShow as $index => $reaction)
                            <div class="reaction-circle"
                                style="width: 25px;height: 25px;background-color: {{ $backgroundColors[$index] }};border-radius: 50%; display: flex;align-items: center;justify-content: center;margin-right: -10px;">
                                <span style="font-size: 14px;">{{ $reaction['emoji'] }}</span>
                                <!-- Emoji inside the circle -->
                            </div>
                            @endforeach

                            <!-- Show last reacted employee and count of others -->
                            @if ($reactionsCount > 0)
                            <!-- Display the last employee's name who reacted -->
                            @php
                            // Get the last reaction from the array
                            $lastReaction = end($reactions);
                            $lastEmployeeId = $lastReaction['employee_id']; // Get employee_id of last reaction
                            $lastEmployee = \App\Models\EmployeeDetails::where(
                            'emp_id',
                            $lastEmployeeId,
                            )->first(); // Fetch employee details
                            @endphp
                            @if ($lastEmployee)
                            <span
                                style="font-size: 12px; color: #0e82ad; margin-left: 19px; cursor: pointer;"
                                wire:click="showReactions({{ json_encode($reactions) }},{{ $kudo->id }})">
                                {{ $lastEmployee->first_name }}
                                {{ $lastEmployee->last_name }}
                            </span>
                            @endif
                            @endif

                            @if ($reactionsCount > 3)
                            <!-- Show how many extra reactions if there are more than 3 -->
                            <span
                                style="font-size: 12px; color: #0e82ad; margin-left: 5px; cursor: pointer;"
                                wire:click="showReactions({{ json_encode($reactions) }},{{ $kudo->id }})">
                                and {{ $reactionsCount - 3 }} others reacted.
                            </span>
                            @endif

                        </div>
                        @if ($showDialogReactions)
                        <div class="modal d-block" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title"><b>Reactions</b></h5>
                                        <button type="button" class="btn-close btn-primary"
                                            data-dismiss="modal" aria-label="Close"
                                            wire:click="closeEmojiReactions">
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        @foreach ($allEmojis as $emoji)
                                        <div
                                            style="display: flex; align-items: center;margin-top:10px;">

                                            <span>

                                                @php

                                                // Access the 'emp_id' directly since $emoji is an array

                                                $employee = \App\Models\EmployeeDetails::where(
                                                'emp_id',
                                                $emoji['employee_id'],
                                                )->first();

                                                @endphp



                                                @if ($employee && $employee->image && $employee->image !== 'null')
                                                <img style="border-radius: 50%; margin-left: 10px"
                                                    height="30" width="30"
                                                    src="data:image/jpeg;base64,{{ $employee->image }}">
                                                @else
                                                @if ($employee && $employee->gender == 'Male')
                                                <img style="border-radius: 50%; margin-left: 10px"
                                                    height="30" width="30"
                                                    src="{{ asset('images/male-default.png') }}"
                                                    alt="Default Male Image">
                                                @elseif($employee && $employee->gender == 'Female')
                                                <img style="border-radius: 50%; margin-left: 10px"
                                                    height="30" width="30"
                                                    src="{{ asset('images/female-default.jpg') }}"
                                                    alt="Default Female Image">
                                                @else
                                                <img style="border-radius: 50%; margin-left: 10px"
                                                    height="30" width="30"
                                                    src="{{ asset('images/user.jpg') }}"
                                                    alt="Default Image">
                                                @endif
                                                @endif

                                            </span>



                                            <span
                                                style="font-size: 12px; margin-left: 10px;width:50%">

                                                {{ ucwords(strtolower($employee->first_name)) }}
                                                {{ ucwords(strtolower($employee->last_name)) }}

                                            </span>



                                            <div
                                                style="display: flex; justify-content: center;">



                                                <span
                                                    style="font-size: 16px; cursor: pointer; color: inherit;     margin-left: 50px;"
                                                    wire:click="removeReaction('{{ $emoji['employee_id'] }}', '{{ $emoji['emoji'] }}','{{ $kudoId }}', '{{ $emoji['created_at'] }}')">

                                                    {{ $emoji['emoji'] }}

                                                </span>

                                            </div>

                                        </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-backdrop fade show transparent-backdrop"></div>
                        @endif
                        <hr>
                        <div>
                            <i class="far fa-smile"
                                wire:click.prevent="toggleKudosEmojiPicker({{ $kudo->id }})"></i>

                            @if (isset($showKudoEmojiPicker[$kudo->id]) && $showKudoEmojiPicker[$kudo->id])
                            <div class="reaction-emoji-picker">
                                <!-- Emojis for reactions -->
                                @foreach ($this->getReactionEmojis() as $reaction => $emoji)
                                <button type="button"
                                    wire:click="addReaction1('{{ $reaction }}', {{ $kudo->id }})"
                                    class="emoji-btn">
                                    {{ $emoji }}
                                </button>
                                @endforeach
                            </div>
                            @endif

                        </div>



                        <confirmation-modal class="confirmation-modal">
                            <gt-popup-modal label="modal" size="sm" class="hydrated">
                                <div class="body-content">
                                    <div slot="modal-body">
                                        <!-- Content for modal body -->
                                    </div>
                                </div>
                                <div slot="modal-footer">
                                    <div class="flex justify-end">
                                        <gt-button shade="secondary" name="Cancel"
                                            class="mr-2x hydrated"></gt-button>
                                        <gt-button shade="primary" name="Confirm"
                                            class="hydrated"></gt-button>
                                    </div>
                                </div>
                            </gt-popup-modal>
                        </confirmation-modal>
                    </div>
                </div>
                @if (isset($showModal[$kudo->id]) && $showModal[$kudo->id])
                <div class="modal" id="logoutModal" tabindex="-1" style="display: block;">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header text-white"
                                style=" background-color: rgb(2, 17, 79);">
                                <h6 class="modal-title " id="logoutModalLabel"
                                    style="align-items: center;">Delete Kudos</h6>
                            </div>
                            <div class="modal-body text-center"
                                style="font-size: 14px;color:var( --main-heading-color);">
                                Are you sure you want to delete Kudos?
                            </div>
                            <div class="d-flex gap-3 justify-content-center p-3">
                                <button type="button" class="submit-btn mr-3"
                                    wire:click="confirmDelete({{ $kudo->id }})">Delete</button>
                                <button type="button" class="cancel-btn1"
                                    wire:click="closeModal({{ $kudo->id }})">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade show"></div>
                @endif
                @endforeach



                @endif
            </div>
            @endif
        </div>