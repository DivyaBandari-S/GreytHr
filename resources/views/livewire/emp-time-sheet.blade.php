<div class="employee-timesheet bg-light p-0 my-0 mx-2 border" style="height:100vh;max-height:100vh; overflow-y:auto;">
    <div class="emp-container px-4 d-flex justify-content-between mt-3 mb-2">
        <p class="mb-0 time-sheet-heading">Timesheets</p>
        <div style="position: relative;">
            <input type="text" name="searchfield" placeholder="Search..." style="padding-left: 30px;outline:none;border:1px solid #ccc;border-radius:5px;">
            <i class="fas fa-search" style="color:#778899; position: absolute; left: 10px; top: 70%; transform: translateY(-50%);"></i>
        </div>
    </div>
    <div class="time-sheet-details bg-white px-2 py-2 m-0 border ">
        <div class="d-flex justify-content-between align-items-center px-3">
            <div class="d-flex gap-4 align-items-center">
                <div class="week-details">
                    <span class="week-details-heading">Week : <span class="heading-value">{{ $currentWeek }}</span> </span>
                </div>
                <div class="emp-timesheet-profile d-flex align-items-center gap-1">
                    @if($employeeDetails->image)
                    <div class="employee-profile-image-container">
                        <img height="32" width="32" src="{{ asset('storage/' . $employeeDetails->image) }}" style="border-radius:50%;">
                    </div>
                    @else
                    <div class="employee-profile-image-container">
                        <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" class="employee-profile-image-placeholder" style="border-radius:50%;" height="32" width="32" alt="Default Image">
                    </div>
                    @endif
                    <span class="week-details-heading">{{ ucwords(strtolower($employeeDetails->first_name)) }} {{ ucwords(strtolower($employeeDetails->last_name)) }}</span>
                </div>
            </div>
            <div class="actions d-flex gap-2 align-items-center">
                <div class="export">
                    <span>Export</span>
                </div>
                <div class="submit-details">
                    <button class="submit-btn">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="time-sheet-profile px-2 py-4 d-flex border justify-content-between align-items-start">
        <div class="col">
            <div class="billable-hours d-flex gap-2">
                <div class="d-flex justify-content-center align-items-center" style="width:32px;height:32px;border-radius:50%;background:#dffafe;">
                    <img src="{{ asset('/images/clock-2.png') }}" alt="logo" height="20" width="20" style="border-radius:50%;">
                </div>
                <div class="d-flex flex-column">
                    <span>Billable hours</span>
                    <span class="heading-value">40 hours 32 minutes</span>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="billable-hours d-flex gap-2">
                <div class="d-flex justify-content-center align-items-center" style="width:30px;height:30px;border-radius:50%;background:#d5f7e5;">
                    <img src="{{ asset('/images/save-money.png') }}" alt="logo" height="18" width="19" style="border-radius:50%;">
                </div>
                <div class="d-flex flex-column">
                    <span>Non-Billable hours</span>
                    <span class="heading-value">10 hours 32 minutes</span>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="billable-hours d-flex gap-2">
                <div class="d-flex justify-content-center align-items-center" style="width:30px;height:30px;border-radius:50%;background:#fcd9d6;">
                    <img src="{{ asset('/images/calendar.png') }}" alt="logo" height="18" width="19">
                </div>
                <div class="d-flex flex-column">
                    <span>Submission Date</span>
                    <span class="heading-value">{{ $submissionDate }}</span>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="billable-hours d-flex gap-2">
                <div class="d-flex justify-content-center align-items-center" style="width:30px;height:30px;border-radius:50%;background:#fdead5;">
                    <img src="{{ asset('/images/user.png') }}" alt="logo" height="19" width="19">
                </div>
                <div class="d-flex flex-column">
                    <span>Approved By</span>
                    @if($managerNameOfLogin)
                    <span class="heading-value">{{ $managerNameOfLogin }}</span>
                    @else
                    <span class="heading-value">-</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="px-2 mt-3">
        <div class="col mb-3">
            <button class="btn btn-primary submit-btn" wire:click="openTimeSheet">Generate</button>
        </div>
        @if($openTimeSheettable)
        <div class="row m-0 p-0">
            <div class="col">
                <div class="table-responsive">
                    <table class="timesheet-table rounded border mx-2">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Task</th>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thu</th>
                                <th>Fri</th>
                                <th>Sat</th>
                                <th>Sun</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $row)
                            <tr>
                                @foreach($row as $index => $data)
                                <td>
                                    @if($index< 2)
                                    t<input type="text" class="placeholder-small" wire:model="rows.{{ $loop->parent->index }}.{{ $index }}" style="width:60px;outline:none;border:1px solid #ccc;padding:7px;border-radius:3px;" placeholder="Enter text..." />
                                    @else
                                    <input type="number" wire:model="rows.{{ $loop->parent->index }}.{{ $index }}" style="width:60px;outline:none;border:1px solid #ccc;padding:7px;border-radius:3px;" />
                                    @endif
                                </td>
                                @endforeach

                                <!-- If the number of columns in the body is less than the number of header columns, add empty cells to match the number of header columns -->
                                @for($i = count($row); $i < 10; $i++) <td>
                                    </td>
                                    @endfor
                            </tr>
                            @endforeach
                        </tbody>


                        <tfoot class="border">
                            <tr>
                                <td colspan="2" class="table-footer-header text-end px-2">Total for the week</td>
                                <td>40</td> <!-- Total for Monday -->
                                <td>40</td> <!-- Total for Tuesday -->
                                <td>40</td> <!-- Total for Wednesday -->
                                <td>40</td> <!-- Total for Thursday -->
                                <td>40</td> <!-- Total for Friday -->
                                <td>0</td> <!-- Total for Saturday -->
                                <td>0</td> <!-- Total for Sunday -->
                                <td>100</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="d-flex float-right mt-4">
                        <a href="#" wire:click.prevent="addNewRow" style="font-size:12px;">+ Add New</a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>