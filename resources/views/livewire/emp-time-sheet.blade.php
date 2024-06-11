<div class="employee-timesheet bg-light p-0 my-0 mx-2 border" style="height:100vh;max-height:100vh; overflow-y:auto;">
    <div class="emp-container px-4 d-flex justify-content-between mt-3 mb-2">
        <p class="mb-0 time-sheet-heading">Timesheets</p>
        <div style="position: relative;">
            <input class="form-control" type="text" name="searchfield" placeholder="Search..." style="padding-left: 30px;outline:none;border:1px solid #ccc;border-radius:5px;">
            <i class="fas fa-search" style="color:#778899; position: absolute; left: 10px; top: 70%; transform: translateY(-50%);"></i>
        </div>
    </div>
    <div class="time-sheet-details bg-white px-2 py-2 m-0 border ">
        <div class="d-flex justify-content-between align-items-center px-3">
            <div class="d-flex gap-4 align-items-center">
                <div class="week-details">
                    <span class="week-details-heading">Week :
                        <!-- <span class="heading-value">{{ $currentWeek }}</span>  -->
                        <input type="text" name="daterange2" value="01/01/2018 - 01/15/2018" />
                    </span>
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
                <div class="submit-details">
                    <button class="submit-btn" style='colowr: rgb(2, 17, 79); background-color: #fff; border: 1px solid;'><i class="fas fa-download me-2" style="height: auto; width: auto;"></i>Export</button>
                </div>
                <div class="submit-details">
                    <button class="submit-btn"><i class="far fa-save me-2"></i>Submit</button>
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
                    <!-- <span class="heading-value">{{ $submissionDate }}</span> -->
                    <input type="date" placeholder="Enter submission date" class="form-control">
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
    <div class="mt-3">
        <div class="row m-0 mb-3">
            <div class="col-md-6 ps-2">
                <button class="btn btn-primary submit-btn" wire:click="openTimeSheet">Generate Timesheets</button>
            </div>
            <div class="col-md-6 text-end ps-2">
                @if($openTimeSheettable)
                <a href="#" wire:click.prevent="addNewRow" style="font-size:12px;">
                    <button class="btn btn-outline-primary submit-btn">+ Add New</button>
                </a>
                @endif
            </div>

        </div>
        @if($openTimeSheettable)
        <div class="row m-0 p-0">
            <div class="col p-0">
                <div class="table-responsive" style="max-width:98%;overflow-x:auto;margin:0 auto;">
                    <table class="timesheet-table rounded border mx-2">
                        <thead>
                            <tr>
                                <!-- Removed the "Job" header -->
                                <th style='padding: 0px;'>Task<i class="fas fa-tasks ms-2" style='width: auto; height: auto'></i></th>
                                <th style='padding: 10px;'>Mon</th>
                                <th style='padding: 10px;'>Tue</th>
                                <th style='padding: 10px;'>Wed</th>
                                <th style='padding: 10px;'>Thu</th>
                                <th style='padding: 10px;'>Fri</th>
                                <th style='padding: 10px;'>Sat</th>
                                <th style='padding: 10px;'>Sun</th>
                                <th style='padding: 10px;'>Total</th>
                                <th style='padding: 10px;'>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $row)
                            <tr>
                                @foreach($row as $index => $data)
                                <td>
                                    <!-- Client select menu or Task input field -->
                                    @if($index === 0)
                                    <select class="form-select" aria-label="Task select menu" style="font-size: 12px; margin: 0px;width: 80px;">
                                        <option selected>Choose task</option>
                                        <option value="task1">Task 1</option>
                                        <option value="task2">Task 2</option>
                                        <option value="task3">Task 3</option>
                                    </select>
                                    @else
                                    <input type="number" wire:model="hours.{{ $index }}" style="width:60px;outline:none;border:1px solid #ccc;padding:7px;border-radius:3px;" />
                                    @endif
                                </td>
                                @endforeach
                                <td>
                                    <!-- Buttons for actions -->
                                    <div>
                                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewTotalModal"><i class="far fa-eye" style="font-size: 12px;"></i></button>
                                        <button class="btn btn-outline-danger btn-sm" wire:click="deleteLastRow"><i class="far fa-trash-alt" style="font-size: 12px;"></i></button>
                                    </div>
                                </td>
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
                    <button wire:click="storeTimeSheet" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
        @endif
    </div>
    <!-- Modal -->
    <div class="modal fade" id="viewTotalModal" tabindex="-1" aria-labelledby="viewTotalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewTotalModalLabel">Total Week Hours</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Total hours</p>
                    <p>40 hours 32 minutes</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        $('input[name="daterange2"]').daterangepicker(

            {
                //customClass: 'my-css',
                opens: 'right',
                autoUpdateInput: true,
                //"parentEl": $(this).closest('div'),
                locale: {
                    cancelLabel: 'Clear'
                }

            }).on('show.daterangepicker', function(ev, picker) {
            picker.container.addClass('my-daterange-timesheet');
        });
    });
</script>