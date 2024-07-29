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

        @if(!empty($regularisationDetails))
        <table class="swipes-table mt-2 border" style="width: 100%;">
            <tr style="background-color: #f6fbfc;">
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Name</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Number</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Status</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Date</th>
            </tr>

            @foreach ($regularisationDetails as $rd)

            @if($rd->regularisation_entries!='[]')
            <tr style="border:1px solid #ccc;">
                
                <td style="width:50%;font-size: 10px; color:  <?php echo ($rd->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px;white-space:nowrap;">{{ucwords(strtolower($rd->first_name))}} {{ucwords(strtolower($rd->last_name))}}</td>
                <td style="width:50%;font-size: 10px; color:  <?php echo ($rd->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px;white-space:nowrap;">{{$rd->emp_id}}</td>
                @if($rd->status=='pending'&&$rd->is_withdraw==0)
                <td style="width:50%;font-size: 10px; color:  <?php echo ($rd->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px;white-space:nowrap;">Applied</td>
                <td style="width:50%;font-size: 10px; color:  <?php echo ($rd->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px;white-space:nowrap;"></td>
                @elseif($rd->status=='pending'&&$rd->is_withdraw==1)
                <td style="width:50%;font-size: 10px; color:  <?php echo ($rd->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px;white-space:nowrap;">Withdrawn</td>
                <td style="width:50%;font-size: 10px; color:  <?php echo ($rd->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px;white-space:nowrap;">{{ date('jS M,Y', strtotime($rd->withdraw_date)) }}</td>
                @else
                <td style="width:50%;font-size: 10px; color:  <?php echo ($rd->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px;white-space:nowrap;">{{ucwords(strtolower($rd->status))}}</td>
                @if($rd->status=='approved')
                <td style="width:50%;font-size: 10px; color:  <?php echo ($rd->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px;white-space:nowrap;">{{date('jS M,Y',strtotime($rd->approved_date))}}</td>
                @elseif($rd->status=='rejected')
                <td style="width:50%;font-size: 10px; color:  <?php echo ($rd->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px;white-space:nowrap;">{{date('jS M,Y',strtotime($rd->rejected_date))}}</td>
                @endif
                @endif

            </tr>

            @endif
            @endforeach

        </table>
        @endif
        <div class="modal-footer" style="background-color: rgb(2, 17, 79); height: 50px">
            <button type="button" style="background-color: white; height:30px;width:100px;border-radius:5px;border:none;">Options</button>
            <button type="button" style="background-color: white; height:30px;width:100px;border-radius:5px;border:none;" wire:click="downloadAttendanceRegularisationReportInExcel">Run</button>
            <button type="button" data-dismiss="modal" wire:click="closeAttendanceRegularisationReport" style="background-color: white; height:30px;width:100px;border-radius:5px;border:none;">Close</button>
        </div>
    </div>
    @endif
</div>