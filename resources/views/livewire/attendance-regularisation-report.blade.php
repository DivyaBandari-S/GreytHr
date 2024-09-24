<div>
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    @if($showAttendanceRegularisationReportDialog==true)
    <div>
        <div class="modal-body" >
            <div class="row mb-2 mt-2">
                <div class="form-group col-md-4">
                    <label for="from-date">From Date:</label>
                    <input type="date" class="form-control" id="from-date" wire:model="fromDate" wire:change="updatefromDate">
                </div>
                <div class="form-group col-md-4">
                    <label for="to-date">To Date:</label>
                    <input type="date" class="form-control" id="to-date" wire:model="toDate" wire:change="updatetoDate">
                </div>
                <div class="form-group col-md-4">
                    <label for="status">Status:</label>
                    <select id="status" class="form-select placeholder-small" name="year" wire:model="selectedStatus" wire:change="updateselectedStatus">
                        <option value="">Select Status</option>
                        <option value="approved">Accepted</option>
                        <option value="withdrawn">Withdrawn</option>
                        <option value="rejected">Rejected</option>
                        <option value="applied">Applied</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive mt-2" style="height:200px;max-height:200px;overflow-y:auto;">
                <table class="swipes-table mt-2 border" style="width: 100%;">
                    <tr style="background-color: #f6fbfc;">
                        <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Name</th>
                        <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Number</th>

                    </tr>

                    @foreach ($employees as $emp)
                    <tr style="border:1px solid #ccc;">
                        <td style="width:50%;font-size: 10px; color:  <?php echo ($emp->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px;white-space:nowrap;">
                            <input type="checkbox" name="employeeCheckbox[]" class="employee-swipes-checkbox" wire:model="EmployeeId" wire:change="updateEmployeeId" value="{{ $emp->emp_id }}">
                            {{ucwords(strtolower($emp->first_name))}} {{ucwords(strtolower($emp->last_name))}}
                        </td>

                        <td style="width:50%;font-size: 10px; color:  <?php echo ($emp->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px;white-space:nowrap;">{{$emp->emp_id}}</td>

                    </tr>


                    @endforeach

                </table>
            </div>
        </div>

        <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="submit-btn"
                wire:click="downloadAttendanceRegularisationReportInExcel">Run</button>
            <button type="button" data-dismiss="modal" class="cancel-btn1"
                wire:click='resetFields'>Clear</button>

        </div>
    </div>
    @endif
</div>