<div>
<style>
     .my-button {
            margin: 0px;
            font-size: 0.8rem;
            background-color: #FFFFFF;
            border: 1px solid #a3b2c7;
            /* font-size: 20px;
        height: 50px; */
            padding: 8px 30px;
        }

        .my-button.active-button {
            background-color: rgb(2, 17, 79);
            color: #FFFFFF;
            border-color: rgb(2, 17, 79);
        }

        .my-button.active-button:hover {
            background-color: rgb(2, 17, 79);
            color: #FFFFFF;
            border-color: rgb(2, 17, 79);
        }

        .apply-button {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
            transition: border-color 0.3s, color 0.3s;
            /* Smooth transition effect */
        }

        .apply-button:hover {
            border-color: rgb(2, 17, 79);
            /* Change the border color to green on hover */
            color: rgb(2, 17, 79);
            /* Change the text color to green on hover */
        }

        .apply-button:active {
            background-color: rgb(2, 17, 79);
            /* Change background color to green when clicked */
            color: #FFFFFF;
            border-color: rgb(2, 17, 79);
            /* Change text color to white when clicked */
        }

        .pending-button:hover {
            border-color: rgb(2, 17, 79);
            /* Change the border color to green on hover */
            color: rgb(2, 17, 79);
            /* Change the text color to green on hover */
        }

        .pending-button:active {
            background-color: rgb(2, 17, 79);
            /* Change background color to green when clicked */
            color: #FFFFFF;
            border-color: rgb(2, 17, 79);
            /* Change text color to white when clicked */
        }

        .custom-radio-class {
            vertical-align: middle;
            margin-bottom: 12px;
        }

        .history-button {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }
       
</style>    
    <div class="modal-body">
        <div class="date-filters mb-2 d-flex mt-2 gap-2">
            <div class="form-group col-md-4">
                <label for="from-date">Select Date:</label>
                <input type="date" class="form-control" max="{{ now()->toDateString() }}" id="from-date" wire:model="selectDate" wire:change="updateselectDate">
               
            </div>
            
        </div>
        <div class="button-container-for-employee-swipes-for-reports">
                        <button class="my-button apply-button"
                            style="background-color:{{ $isApply == 1 && $defaultApply == 1 ? 'rgb(2,17,79)' : '#fff' }};color: {{ $isApply == 1 && $defaultApply == 1 ? '#fff' : 'initial' }};"
                            wire:click="viewDoorSwipeButton"><span style="font-size:10px;">View Door Swipe
                                Data</span></button>
                        <button class="my-button history-button"
                            style="background-color:{{ $isPending == 1 && $defaultApply == 0 ? 'rgb(2,17,79)' : '#fff' }};color: {{ $isPending == 1 && $defaultApply == 0 ? '#fff' : 'initial' }};"
                            wire:click="viewWebsignInButton"><span style="font-size:10px;">View Web Sign-In
                                Data</span></button>
        </div>
        <div class="row m-0 p-0 d-flex align-items-center">
            <div class="col-md-6">
            </div>
            <div class="search-container col-md-6 " style="position: relative;">
                <input type="text" wire:model.debounce.500ms="search" id="searchInput" placeholder="Search..." class="form-control placeholder-small border outline-none rounded">
                <button wire:click="searchEmployee" id="searchButtonReportsForRegularisation">
                    <i class="fas fa-search" style="width: 16px; height: 16px;"></i>
                </button>
            </div>
        </div>
              <label class="custom-checkbox">

                        <input type="checkbox" name="employeeCheckbox[]" class="employee-swipes-checkbox" wire:model="selectAll"wire:change="updateSelectAll">

                        <span class="checkmark"></span>
                        Select All Employees


              </label>
        <div class="table-responsive mt-2" style="height:200px;max-height:200px;overflow-y:auto;">
           @if (session('error'))
   
            <span style="color:#f66;fort-size:12px;">{{ session('error') }}</span>

            @endif
            <table class="swipes-table mt-2 border" style="width: 100%;">
                <tr style="background-color: #f6fbfc;">
                    <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Name</th>
                    <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Number</th>

                </tr>
                @foreach ($filteredEmployees as $emp)
                <tr style="border:1px solid #ccc;">
                    <td style="width:50%;font-size: 10px; color: <?php echo ($emp->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px;white-space:nowrap;">
                      <label class="custom-checkbox"> 
                        <input type="checkbox" name="employeeCheckbox[]" class="employee-swipes-checkbox" wire:model="swipeData" value="{{ $emp->emp_id }}">
                        <span class="checkmark"></span>
                        {{ucwords(strtolower($emp->first_name))}}&nbsp;{{ucwords(strtolower($emp->last_name))}}

                      </label>
                    </td>
                    <td style="width:50%;font-size: 10px; color: <?php echo ($emp->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 32px;white-space:nowrap;">{{$emp->emp_id}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="submit-btn"
            wire:click="exportWebSignInData">Run</button>
        <button type="button" data-dismiss="modal" class="cancel-btn1"
            wire:click='resetFields'>Clear</button>

    </div>
</div>