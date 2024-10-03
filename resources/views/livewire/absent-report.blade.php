<div>
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    @if($showAbsentReportDialog==true)
    <div>
        <div class="modal-body">
            <div class="date-filters mb-2 d-flex mt-2 gap-2">
                <div class="form-group col-md-6">
                    <label for="from-date">From Date:</label>
                    <input class="form-control" type="date" id="from-date" wire:model="fromDate" wire:change="updatefromDate">
                </div>
                <div class="form-group col-md-6">
                    <label for="to-date">To Date:</label>
                    <input class="form-control" type="date" id="to-date" wire:model="toDate" wire:change="updatetoDate">
                </div>
            </div>
            <div class="row mt-3 mb-3 m-0 p-0 d-flex align-items-center">
                <div class="col-md-6">

                </div>
                <div class=" form-group col-md-6">
                    <div class="search-container" style="position: relative;">
                        <input type="text" wire:model.debounce.500ms="search" id="searchInput" placeholder="Search..." class="form-control placeholder-small border outline-none rounded">
                        <button wire:click="searchfilter" id="searchButtonReports">
                            <i class="fas fa-search" style="width: 16px; height: 16px;"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="table-responsive" style="height:200px;max-height:200px;overflow-y:auto;">
                <table class="swipes-table mt-2 w-100 border">
                    <tr style="background-color: #f6fbfc;">
                        <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Name</th>
                        <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Number</th>
                    </tr>
                    @foreach ($employees as $emp)
                    <tr style="border:1px solid #ccc;">
                        <td style="width:50%;font-size: 10px; color: <?php echo ($emp->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px;white-space:nowrap;">
                            <input type="checkbox" wire:model="selectedEmployees" wire:click="$emit('employeeSelected', {{$emp->emp_id}})" name="employee_checkbox[]" value="{{$emp->emp_id}}">
                            {{ucwords(strtolower($emp->first_name))}}&nbsp;{{ucwords(strtolower($emp->last_name))}}
                        </td>
                        <td style="width:50%;font-size: 10px; color: <?php echo ($emp->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 32px;white-space:nowrap;">{{$emp->emp_id}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">

            <button type="button" class="submit-btn"

                wire:click="downloadAbsentReportInExcel">Run</button>
            <button type="button" data-dismiss="modal" class="cancel-btn1"

                wire:click='resetFields'>Clear</button>

        </div>
    </div>
    @endif
</div>