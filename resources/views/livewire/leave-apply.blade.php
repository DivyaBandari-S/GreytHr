<div class="mx-2">
<div class="applyContainer bg-white">
    <p style="font-weight:500; font-size:14px;" >Applying for Leave</p>

    <form wire:submit.prevent="leaveApply" enctype="multipart/form-data">
       <div class="form-group" >
            <label for="leaveType"  style="color: #778899; font-size: 12px; font-weight: 500;">Leave type</label>
                <select class="form-control placeholder-small" wire:model="leave_type" id="leaveType" name="leaveType" style="width: 50%; font-weight: 400; color: #778899;font-size:12px;" onchange="toggleReporting()">
                    <option value="default">Select Type</option>
                    <option value="Causal Leave Probation">Casual Leave</option>
                    <option value="Loss of Pay">Loss of Pay</option>
                    @if($employeeGender && $employeeGender->gender === 'Female')
                    <option value="Maternity Leave">Maternity Leave</option>
                    @else
                    <option value="Maternity Leave">Petarnity Leave</option>
                    @endif
                    <option value="Sick Leave">Sick Leave</option>
                </select>
                  @error('leave_type') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
             <div class="form-row d-flex mt-3">
            <div class="form-group col-md-6">
                <label for="fromDate" style="color: #778899; font-size: 12px; font-weight: 500;">From date</label>
                <input type="date" wire:model="from_date" class="form-control placeholder-small" id="fromDate" name="fromDate" style="color: #778899;font-size:12px;">
            @error('from_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="session" style="color: #778899; font-size: 12px; font-weight: 500;">Sessions</label>
                <select class="form-control placeholder-small" wire:model="from_session" id="session" name="session" style="font-size:12px; ">
                    <option value="default">Select session</option>
                    <option value="Session 1">Session 1</option>
                    <option value="Session 2">Session 2</option>
                </select>
                @error('from_session') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-row d-flex  mt-3">
                <div class="form-group col-md-6">
                    <label for="toDate" style="color: #778899; font-size: 12px; font-weight: 500;">To date</label>
                    <input type="date" wire:model="to_date" class="form-control placeholder-small" id="toDate" name="toDate" style="color: #778899;font-size:12px;">
                  @error('to_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="session" style="color: #778899; font-size: 12px; font-weight: 500;">Sessions</label>
                    <select class="form-control placeholder-small" wire:model="to_session" id="session" name="session" style="font-size:12px;">
                        <option value="default">Select session</option>
                        <option value="Session 1">Session 1</option>
                        <option value="Session 2">Session 2</option>
                    </select>
                    @error('to_session') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <div class="form-group" style="margin-top: 10px;">
                    <div style="display:flex; flex-direction:row;">
                        <label for="applyingToText" id="applyingToText" name="applyingTo" style="color: #778899; font-size: 12px; font-weight: 500; cursor: pointer;" >
                        <img src="https://t4.ftcdn.net/jpg/05/35/51/31/360_F_535513106_hwSrSN1TLzoqdfjWpv1zWQR9Y5lCen6q.jpg" alt="" width="35px" height="32px" style="border-radius:50%;color:#778899;">
                            Applying to
                        </label>
                    </div>
                </div>

                <div class="reporting" style="display:none;">
                    <div>
                        <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars.png" alt="Default User Image" style="width: 35px; height: 35px; border-radius: 50%;">
                    </div>
                    <div class="center p-0 m-0">
                        @empty($loginEmpManager)
                            <p style="font-size:10px;margin-bottom:0;">N/A</p>
                        @else
                            <p id="reportToText" class="ellipsis" style="font-size:12px; text-transform: capitalize;padding:0;margin:0;">{{$loginEmpManager}}</p>
                        @endempty

                        @empty($loginEmpManagerId)
                            <p style="font-size:10px;margin-bottom:0;">#(N/A)</p>
                        @else
                            <p style="color:#778899; font-size:10px;margin-bottom:0;" id="managerIdText"><span class="remaining" >#{{$loginEmpManagerId}}</span></p>
                        @endempty
                    </div>
                    <div class="downArrow" onclick="toggleSearchContainer()">
                        <i class="fas fa-chevron-down" style=" cursor:pointer"></i>
                    </div>

                </div>
                <div class="searchContainer" style="display:none;">
                    <!-- Content for the search container -->
                    <div class="row" style="padding: 0 15px; margin-bottom: 10px;">
                        <div class="col" style="margin: 0px; padding: 0px">
                            <div class="input-group">
                                <input wire:click="filterData" style="font-size: 12px; border-radius: 5px 0 0 5px; cursor: pointer; width:50%;" type="text" class="form-control placeholder-small" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <button style="height: 29px; border-radius: 0 5px 5px 0; background-color: #007BFF; color: #fff; border: none; align-items: center; display: flex;" class="btn" type="button">
                                        <i style="margin-right: 5px;" class="fa fa-search"></i> <!-- Adjust margin-right as needed -->
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach($managerFullName as $employee)
                        <div style="display:flex; gap:10px;align-items:center;" onclick="updateApplyingTo('{{ $employee['full_name'] }}', '{{ $employee['emp_id'] }}')">
                            <div>
                              <input type="checkbox" wire:model="selectedManager" value="{{ $employee['emp_id'] }}">
                            </div>
                            <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars.png" alt="Default User Image" style="width: 35px; height: 35px; border-radius: 50%;">
                            <div class="center mt-2 mb-2">
                            <p style=" font-size:12px; font-weight:500;margin-bottom:0;" value="{{ $employee['full_name'] }}">{{ $employee['full_name'] }}</p>
                            <p style="color:#778899; font-size:10px;margin-bottom:0;" value="{{ $employee['full_name'] }}"> #{{ $employee['emp_id'] }} </p>
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
                <a href="javascript:void(0);" class="text-3 text-secondary control" aria-haspopup="true" onclick="toggleCCField()" style="text-decoration: none;">
                <div class="icon-container" style="display: flex; justify-content: center; align-items: center;">
                    <i class="fa-solid fa-plus" style="color: #778899;"></i>
                </div>

                </a>
                <span class="text-2 text-secondary placeholder" id="ccPlaceholder" style="margin-top: 5px; background: transparent; color: #ccc;">Add</span>

               <div id="addedEmails" style="display: flex; gap: 10px; "></div>
            
            </div>
            <div class="ccContainer" style="display:none;">
                    <!-- Content for the search container -->
                    <div class="row" style="padding: 0 15px; margin-bottom: 10px;">
                        <div class="col" style="margin: 0px; padding: 0px">
                            <div class="input-group">
                                <input  style="font-size: 10px; border-radius: 5px 0 0 5px; cursor: pointer; width:50%;" type="text" class="form-control placeholder-small" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <button wire:click="filterCcData" style="height: 29px; border-radius: 0 5px 5px 0; background-color: #007BFF; color: #fff; border: none; align-items: center; display: flex;" class="btn" type="button" >
                                        <i style="margin-right: 5px;" class="fa fa-search"></i> <!-- Adjust margin-right as needed -->
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @foreach($ccRecipients as $employee)
                        <div style="display:flex; gap:10px; text-transform: capitalize;align-items:center;" onclick="addEmail('{{ ucwords(strtolower($employee['full_name'])) }}')">
                            <input type="checkbox" wire:model="selectedPeople" value="{{ $employee['emp_id'] }}">
                            <img src="{{ $employee['image'] ? $employee['image'] : 'https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars.png' }}" alt="User Image" style="width: 35px; height: 35px; border-radius: 50%;">
                            <div class="center mb-2 mt-2">
                                <p style="font-size: 12px; font-weight: 500; text-transform: capitalize; margin-bottom:0;">{{ ucwords(strtolower($employee['full_name'])) }}</p>
                                <p style=" color: #778899; font-size: 0.69rem;margin-bottom:0;">#{{ $employee['emp_id'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('cc_to') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
            <div class="form-group">
                <label for="contactDetails" style="color: #778899; font-size: 12px; font-weight: 500;">Contact Details</label>
                <input type="text" wire:model="contact_details" class="form-control placeholder-small" id="contactDetails" name="contactDetails" style="color: #778899;width:50%;">
                @error('contact_details') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="reason" style="color: #778899; font-size: 12px; font-weight: 500;">Reason</label>
                <textarea class="form-control" wire:model="reason" id="reason" name="reason" placeholder="Enter a reason" rows="4" style="font-size:12px;color: #778899;"></textarea>
                @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
            <input type="file" wire:model="files" wire:loading.attr="disabled" style="font-size: 12px;color:#778899;" multiple />
                 @error('file_paths') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="buttons1">
              <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-secondary" >Cancel</button>
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
    function addEmail(fullName) {
    const addedEmails = document.getElementById('addedEmails');
    const addSpan = document.getElementById('ccPlaceholder');

    // Split the full name into first and last names
    const names = fullName.split(' ');

    // Get the first letter of the first name
    const firstNameAbbreviation = names.length > 0 ? names[0].charAt(0) : '';

    // Get the first letter of the last name
    const lastNameAbbreviation = names.length > 1 ? names[names.length - 1].charAt(0) : '';

    // Combine the first letters of both names to create the email abbreviation
    const emailAbbreviation = firstNameAbbreviation + lastNameAbbreviation;

    // Check if the email abbreviation is already added
    if (isEmailAlreadyAdded(emailAbbreviation)) {
        return; // Do nothing if the email is already added
    }

    // Create a new element to display the added email abbreviation
    const emailElement = document.createElement('div');
    emailElement.textContent = emailAbbreviation;
    emailElement.className = 'added-email';
    emailElement.style.border = '2px solid #778899';
    emailElement.style.color = '#778899';
    emailElement.style.borderRadius = '50%';

    // Add hover effect
    emailElement.addEventListener('mouseover', function() {
        emailElement.style.cursor = 'pointer';
        emailElement.innerHTML = '&#9587;'; // Change the color to black
    });

    emailElement.addEventListener('mouseout', function() {
        emailElement.innerHTML = emailAbbreviation; // Restore the email abbreviation on mouseout
    });

    // Remove on click
    emailElement.addEventListener('click', function() {
        emailElement.remove();
        removeAddedEmail(emailAbbreviation); // Remove from the list of added emails
        if (addedEmails.children.length === 0) {
            addSpan.style.display = 'block';
        }
    });

    // Append the email element to the addedEmails container
    addedEmails.appendChild(emailElement);
    addSpan.style.display = 'none';
    // Add the email to the list of added emails
    addedEmailList.push(emailAbbreviation);
}

// Array to keep track of added emails
const addedEmailList = [];

// Function to check if an email is already added
function isEmailAlreadyAdded(email) {
    return addedEmailList.includes(email);
}

// Function to remove an email from the list of added emails
function removeAddedEmail(email) {
    const index = addedEmailList.indexOf(email);
    if (index !== -1) {
        addedEmailList.splice(index, 1);
    }
}
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        // console.log(this.checked);
        checkboxes.forEach(checkbox=>{
        checkbox.addEventListener('change', function() {
            const { checked } = checkbox;
            if (!checked) {
                emailElement.remove();
            removeAddedEmail?.(emailAbbreviation); // Remove from the list of added emails
            addedEmails.children.length === 0 && (addSpan.style.display = 'block');
            }
        });
    });
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

    </script>
</body>
</div>