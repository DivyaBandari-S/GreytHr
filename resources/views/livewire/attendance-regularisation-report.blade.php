<div>
    @if($showAttendanceRegularisationReportDialog==true)
    <div class="modal-body" style="max-height:300px;overflow-y:auto">

        <div class="date-filters mt-2">
            <label for="from-date" style="font-size: 11px; color: #778899;">From Date:</label>
            <input type="date" id="from-date" wire:model="fromDate" wire:change="updatefromDate" style="font-size: 11px; color: #778899; margin-right: 10px;">

            <label for="to-date" style="font-size: 11px; color: #778899;">To Date:</label>
            <input type="date" id="to-date" wire:model="toDate" wire:change="updatetoDate" style="font-size: 11px; color: #778899;">

            <select name="year" wire:model="selectedStatus" wire:change="updateselectedStatus">
                <option value="">Select Status</option>
                <option value="approved">Accepted</option>
                <option value="withdrawn">Withdrawn</option>
                <option value="rejected">Rejected</option>
                <option value="applied">Applied</option>
            </select>
        </div>

      
        <table class="swipes-table mt-2 border" style="width: 100%;">
            <tr style="background-color: #f6fbfc;">
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Name</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Number</th>

            </tr>

            @foreach ($employees as $emp)

            
            <tr style="border:1px solid #ccc;">
                
                <td style="width:50%;font-size: 10px; color:  <?php echo ($emp->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px;white-space:nowrap;">
                <input type="checkbox" wire:model="selectedEmployees" wire:click="$emit('employeeSelected', {{$emp->emp_id}})" name="employee_checkbox[]" value="{{$emp->emp_id}}">
                {{ucwords(strtolower($emp->first_name))}} {{ucwords(strtolower($emp->last_name))}}</td>
              
                <td style="width:50%;font-size: 10px; color:  <?php echo ($emp->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px;white-space:nowrap;">{{$emp->emp_id}}</td>
               
            </tr>

          
            @endforeach

        </table>
       
        <div class="mt-2" style="background-color: rgb(2, 17, 79); display: flex;justify-content: center; padding: 10px; gap: 15px;">
                            
                            <button type="button" class="submit-btn" style="background-color: white; color: rgb(2, 17, 79);"
                                wire:click="downloadAttendanceRegularisationReportInExcel">Run</button>
                            <button type="button" data-dismiss="modal" class="cancel-btn1"
                                wire:click='resetFields'>Clear</button>

                        </div>
    </div>
    @endif
</div>