<div>
    <div class="modal-body" style="max-height:300px;overflow-y:auto">
        <div class="search-bar">
            <input type="text" wire:model="search" placeholder="Search..." wire:change="searchfilter">
        </div>
        

        <table class="swipes-table mt-2 border" style="width: 100%;">
            <tr style="background-color: #f6fbfc;">
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Name</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Number</th>
            </tr>


            @foreach ($Employees as $emp)
            <tr style="border:1px solid #ccc;">
                
                                 
           
                <td style="width:50%;font-size: 10px; color:  <?php echo ($emp->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px">
                <input type="checkbox" name="employeeCheckbox[]" class="employee-swipes-checkbox" wire:model="EmployeeId" wire:change="updateEmployeeId" value="{{ $emp->emp_id }}">
                       {{ucwords(strtolower($emp->first_name))}}&nbsp;{{ucwords(strtolower($emp->last_name))}}
                </td>
                <td style="width:50%;font-size: 10px; color: <?php echo ($emp->employee_status == 'active') ? '#778899' : '#f66'; ?>;text-align:start;padding:5px 10px">{{$emp->emp_id}}</td>
              
            </tr>
            @endforeach


        </table>
    </div>
    <div class="modal-footer" style="background-color: rgb(2, 17, 79); height: 50px">
        <button type="button" style="background-color: white; height:30px;width:100px;border-radius:5px;border:none;">Options
        </button>
        <button type="button" style="background-color: white; height:30px;width:100px;border-radius:5px;border:none;" wire:click="downloadInExcel">Run
        </button>
        <button type="button" data-dismiss="modal" wire:click="close" style="background-color: white; height:30px;width:100px;border-radius:5px;border:none;">Close
        </button>
    </div>
</div>