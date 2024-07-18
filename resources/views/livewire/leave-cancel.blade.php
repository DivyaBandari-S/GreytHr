<div>

    <div class="applyContainer">
        @if($LeaveShowinfoMessage)
        <div class="hide-info p-2 mb-2 mt-2 rounded d-flex justify-content-between align-items-center">
            <p class="mb-0" style="font-size:11px;">Leave Cancel enables you to apply for cancellation of approved leave applications. Please select a leave type to get started..</p>
            <p class="mb-0 hideInfo" wire:click="toggleInfoLeave">Hide</p>
        </div>
        @endif

        <div class="d-flex justify-content-between">
            <p class="applyingFor">Applying for Leave Cancel</p>
            @if($LeaveShowinfoButton)
            <p class="info-paragraph"  wire:click="toggleInfoLeave">Info</p>
            @endif
        </div>

        <form wire:submit.prevent="leaveApply" enctype="multipart/form-data">
            <div>
                <div class="form-group" style="margin-top: 10px;">
                    <div style="display:flex; flex-direction:row;">
                        <label for="applyingToText" id="applyingToText" name="applyingTo" style="color: #778899; font-size: 12px; font-weight: 500; cursor: pointer;">
                            Applying To
                        </label>
                    </div>
                </div>

                <div class="reporting" style="display:none;">
                    <div>
                        <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars.png" alt="Default User Image" style="width: 40px; height: 40px; border-radius: 50%;">
                    </div>
                    <div class="center">
                        <p id="reportToText" class="ellipsis">{{$reportTo}}</p>
                        <p style="margin-top:-20px; color:#778899; font-size:0.69rem;" id="managerIdText"><span class="remaining">#{{$managerId}}</span></p>
                    </div>
                    <div class="downArrow" onclick="toggleSearchContainer()">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <!-- Details to show on hover -->

                </div>
                <div class="searchContainer" style="display:none;">
                    <!-- Content for the search container -->
                    <div class="row" style="padding: 0 15px; margin-bottom: 10px;">
                        <div class="col" style="margin: 0px; padding: 0px">
                            <div class="input-group">
                                <input wire:model="searchTerm" style="font-size: 10px; border-radius: 5px 0 0 5px; cursor: pointer; width:50%;" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <button style="height: 29px; border-radius: 0 5px 5px 0; background-color: #007BFF; color: #fff; border: none; align-items: center; display: flex;" class="btn" type="button" wire:click="searchOnClick">
                                        <i style="margin-right: 5px;" class="fa fa-search"></i> <!-- Adjust margin-right as needed -->
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach($employeeDetails as $employee)
                    <div style="display:flex; gap:10px;" onclick="updateApplyingTo" ({{ $employee['report_to'] }}, {{ $employee['manager_id'] }})">
                        <input type="checkbox" wire:model="selectedManager" value="{{ $employee['manager_id'] }}">
                        <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars.png" alt="Default User Image" style="width: 40px; height: 40px; border-radius: 50%;">
                        <div class="center">
                            <p style=" font-size:0.875rem; font-weight:500;" value="{{ $employee['report_to'] }}">{{ $employee['report_to'] }}</p>
                            <p style="margin-top:-15px; color:#778899; font-size:0.69rem;" value="{{ $employee['manager_id'] }}">#{{ $employee['manager_id'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @error('applying_to') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="ccToText" wire:model="from_date" id="applyingToText" name="applyingTo" style="color: #778899; font-size: 12px; font-weight: 500;">
                    CC to
                </label>
                <div class="control-wrapper" style="display: flex; flex-direction: row; gap: 10px;">
                    <a href="javascript:void(0);" class="text-3 text-secondary control" aria-haspopup="true" wire:click="openCcRecipientsContainer" style="text-decoration: none;">
                        <div class="icon-container" style="display: flex; justify-content: center; align-items: center;">
                            <i class="fa-solid fa-plus" style="color: #778899;"></i>
                        </div>
                    </a>
                    <span class="text-2 text-secondary placeholder" id="ccPlaceholder" style="margin-top: 5px; background: transparent; color: #ccc; pointer-events: none;">Add</span>
                    <div id="addedEmails" style="display: flex; gap: 10px; "></div>

                </div>
                <div class="ccContainer" style="display:none;">
                    <!-- Content for the search container -->
                    <div class="row" style="padding: 0 15px; margin-bottom: 10px;">
                        <div class="col" style="margin: 0px; padding: 0px">
                            <div class="input-group">
                                <input wire:model="searchTerm" style="font-size: 10px; border-radius: 5px 0 0 5px; cursor: pointer; width:50%;" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <button style="height: 29px; border-radius: 0 5px 5px 0; background-color: #007BFF; color: #fff; border: none; align-items: center; display: flex;" class="btn" type="button" wire:click="searchOnClick">
                                        <i style="margin-right: 5px;" class="fa fa-search"></i> <!-- Adjust margin-right as needed -->
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach($ccRecipients as $employee)
                    <div style="display:flex; gap:10px;" onclick="addEmail('{{ $employee['full_name'] }}')">
                        <input type="checkbox" wire:model="selectedPeople" value="{{ $employee['emp_id'] }}">
                        <img src="{{ $employee['image'] ? $employee['image'] : 'https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars.png' }}" alt="User Image" style="width: 40px; height: 40px; border-radius: 50%;">
                        <div class="center">
                            <p style="font-size: 0.875rem; font-weight: 500;">{{ $employee['full_name'] }}</p>
                            <p style="margin-top: -15px; color: #778899; font-size: 0.69rem;">#{{ $employee['emp_id'] }}</p>
                        </div>

                    </div>
                    @endforeach
                </div>
                @error('cc_to') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="contactDetails" style="color: #778899; font-size: 12px; font-weight: 500;">Contact Details</label>
                <input type="text" wire:model="contact_details" class="form-control" id="contactDetails" name="contactDetails" style="color: #778899;width:50%;">
                @error('contact_details') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="reason" style="color: #778899; font-size: 12px; font-weight: 500;">Reason for Leave</label>
                <textarea class="form-control" wire:model="reason" id="reason" name="reason" placeholder="Enter Reason" rows="4"></textarea>
                @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="cancelButtons d-flex align-items-center gap-2 justify-content-center">
                <button type="submit" class="submit-btn">Submit</button>
                <button type="button" class="cancel-btn" style="border:1px solid rgb(2,17,79);">Cancel</button>
            </div>
        </form>
    </div>
    <script>
        function toggleReporting() {
            const leaveType = document.getElementById('leaveType');
            const reportingDiv = document.querySelector('.reporting');
            const applyingToTextDiv = document.getElementById('applyingToText');

            // Show or hide the reporting div based on the selected leave type
            if (leaveType.value !== 'default') {
                reportingDiv.style.display = 'flex';
                applyingToTextDiv.style.display = 'none';
            } else {
                reportingDiv.style.display = 'none';
                applyingToTextDiv.style.display = 'flex';
            }
        }

        function toggleSearchContainer() {
            const searchContainer = document.querySelector('.searchContainer');
            const reportingContainer = document.querySelector('.reporting');
            // Toggle the display of the search container
            searchContainer.style.display = searchContainer.style.display === 'none' ? 'block' : 'none';
            if (searchContainer.style.display === 'block') {
                reportingContainer.classList.add('active');
            } else {
                reportingContainer.classList.remove('active');
            }
        }

        function toggleCCField() {
            const ccContainer = document.querySelector('.ccContainer');
            const iconContainer = document.querySelector('.icon-container');

            // Toggle the display of the search container
            ccContainer.style.display = ccContainer.style.display === 'none' ? 'block' : 'none';
            if (ccContainer.style.display === 'block') {
                iconContainer.classList.add('active');
            } else {
                iconContainer.classList.remove('active');
            }
        }


        function updateApplyingTo(reportTo, managerId) {
            // Update the values in the reporting container
            document.getElementById('reportToText').innerText = reportTo;
            document.getElementById('managerIdText').innerText = '#' + managerId;

            // Optionally, you can also hide the search container here
            toggleSearchContainer();
        }

        function toggleDetails(tabId) {
            const tabs = ['leaveApply', 'restricted-content', 'leaveCancel-content', 'compOff-content'];

            tabs.forEach(tab => {
                const tabElement = document.getElementById(tab);
                if (tab === tabId) {
                    tabElement.style.display = 'block';
                } else {
                    tabElement.style.display = 'none';
                }
            });
        }

        function toggleInfo() {
            const hideInfoDiv = document.querySelector('.hide-info');
            const infoParagraph = document.querySelector('.info-paragraph');

            hideInfoDiv.style.display = hideInfoDiv.style.display === 'none' ? 'flex' : 'none';
            infoParagraph.style.display = infoParagraph.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</div>