<div>
    <div class="modal-body" style="max-height:300px;overflow-y:auto">

        <div class="date-filters mt-2">
            <label for="from-date" style="font-size: 11px; color: #778899;">From Date:</label>
            <input type="date" id="from-date" wire:model="fromDate" wire:change="updatefromDate" style="font-size: 11px; color: #778899; margin-right: 10px;">

            <label for="to-date" style="font-size: 11px; color: #778899;">To Date:</label>
            <input type="date" id="to-date" wire:model="toDate" wire:change="updatetoDate" style="font-size: 11px; color: #778899;">

            <div class="search-bar">
                <input type="text" wire:model="search" placeholder="Search..." wire:change="searchfilter">
            </div>
        </div>

        <table class="swipes-table mt-2 border" style="width: 100%;">
            <tr style="background-color: #f6fbfc;">
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Name</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Number</th>

            </tr>
            @foreach ($filteredEmployees as $emp)
            <tr style="border:1px solid #ccc;">

                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;">
                    <input type="checkbox" name="employeeCheckbox[]" class="employee-swipes-checkbox" wire:model="shiftSummary" wire:change="updateshiftSummary" value="{{ $emp->emp_id }}">
                    {{ucwords(strtolower($emp->first_name))}}&nbsp;{{ucwords(strtolower($emp->last_name))}}
                </td>
                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;">{{$emp->emp_id}}</td>
            </tr>
            @endforeach
        </table>
        <div class="modal-footer" style="background-color: rgb(2, 17, 79); height: 50px">
            <button type="button" style="background-color: white; height:30px;width:100px;border-radius:5px;border:none;">Options</button>
            <button type="button" style="background-color: white; height:30px;width:100px;border-radius:5px;border:none;" wire:click="downloadShiftSummaryReportInExcel">Run</button>
            <button type="button" dsata-dismiss="modal" wire:click="close" style="background-color: white; height:30px;width:100px;border-radius:5px;border:none;">Close</button>
        </div>
    </div>
</div>