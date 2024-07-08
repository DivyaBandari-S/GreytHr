<div>
    <div class="modal-body" style="max-height:300px;overflow-y:auto">
        <div class="search-bar">
            <input type="text" wire:model="search" placeholder="Search..." wire:change="searchfilter">
        </div>
        <table class="swipes-table mt-2 border" style="width: 100%;">
            <tr style="background-color: #f6fbfc;">
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Name</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Employee Number</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Father's Name</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Mother's Name</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Father's Date Of Birth</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Mother's Date Of Birth</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Father's Address</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Mother's Address</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Father's Email</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Mother's Email</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Father's Phone</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Mother's Phone</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Father's Occupation</th>
                <th style="width:50%;font-size: 11px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;white-space:nowrap;">Mother's Occupation</th>
            </tr>


            @foreach ($employees as $emp)
            <tr style="border:1px solid #ccc;">
                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px">{{ucwords(strtolower($emp->first_name))}}&nbsp;{{ucwords(strtolower($emp->last_name))}}</td>
                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px">{{$emp->emp_id}}</td>
                @if(!empty($emp->father_first_name))
                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;">{{$emp->father_first_name}}{{$emp->father_last_name}}</td>
                @else
                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;">-</td>
                @endif
                @if(!empty($emp->mother_first_name))
                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;">{{$emp->mother_first_name}}{{$emp->mother_last_name}}</td>
                @else
                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;">-</td>
                @endif
                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;">{{ Carbon\Carbon::parse($emp->father_dob)->translatedFormat('jS F Y') }}</td>
                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;">{{ Carbon\Carbon::parse($emp->mother_dob)->translatedFormat('jS F Y') }}</td>
                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;">{{$emp->father_address}}</td>
                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;">{{$emp->mother_address}}</td>
                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;">{{$emp->father_email}}</td>
                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;">{{$emp->mother_email}}</td>
                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;">{{$emp->father_phone}}</td>
                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;">{{$emp->mother_phone}}</td>
                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;">{{$emp->father_occupation}}</td>
                <td style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px;white-space:nowrap;">{{$emp->mother_occupation}}</td>
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