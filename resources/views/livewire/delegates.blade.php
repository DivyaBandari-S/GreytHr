<div class="container-fluid bg-white " >
    <div class="position-absolute" wire:loading
        wire:target="showForm,hideForm,submitForm,delete,cancel,editform,showAlertModel,getDelegates">
        <div class="loader-overlay">
            <div class="loader">
                <div></div>
            </div>

        </div>
    </div>
    <style>
        .text-danger{
            font-size: 10px;
        }
    </style>
    <div class="row">

        <div class="col-md-12">
            <h5 style="color: orange; margin-top: 30px; margin-left: 20px;"><b>WorkFlow Delegates</b></h5>
        </div>
        <div class="col-md-8">
            <div class="d-flex  mt-3 mb-2" style="justify-content: space-between;align-items:center">
                <div class="form-group" style="color: black;margin-top:5px">
                    <select name="workflow" class="form-select" style="width: 200px; color: black;font-size:10px" wire:model.lazy="selectedWorkflow" wire:change='getDelegates'>
                        <option style="color: black;font-size:10px" value="">All</option>
                        <option style="color: black;font-size:10px" value="Delegate All Workflow">Delegate All Workflow</option>
                        <option style="color: black;font-size:10px" value="Attendance Regularization">Attendance Regularization</option>
                        <option style="color: black;font-size:10px" value="Confirmation">Confirmation</option>
                        <option style="color: black;font-size:10px" value="Resignations">Resignations</option>
                        <option style="color: black;font-size:10px" value="Leave">Leave</option>
                        <option style="color: black;font-size:10px" value="Leave Cancel">Leave Cancel</option>
                        <option style="color: black;font-size:10px" value="Leave Comp Off">Leave Comp Off</option>
                        <option vstyle="color: black;font-size:10px" alue="Restricted Holiday Leave">Restricted Holiday Leave</option>
                        <option style="color: black;font-size:10px" value="Help Desk">Help Desk</option>
                        <!-- Add your workflow options here -->
                    </select>
                </div>
                <button id="show-delegate-form-button" class="btn btn-primary" style="width: 120px; border-radius: 5px; font-size: 12px;background: rgb(2, 17, 79); color: white;" wire:click='showForm'>Add Delegates</button>
            </div>
        </div>
        <div class="col-md-9 mb-2">
            <div class="bg-white" style="height: 300px; border: 1px solid rgb(2, 17, 79); border-radius: 5px; max-height: 400px; overflow-y: auto;">
                <table class="delegate-table" style="width: 100%; border-collapse: collapse;justify-content:space-between">
                    <thead>
                        <tr class="delegate-header">
                            <th class="delegate-cell-header">User</th>
                            <th class="delegate-cell-header">Workflow</th>
                            <th class="delegate-cell-header">From Date</th>
                            <th class="delegate-cell-header">To Date</th>
                            <th class="delegate-cell-header">Delegate</th>
                            <th class="delegate-cell-header">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($retrievedData ?? [] as $data)
                        <tr class="delegate-row" style="justify-content:space-between;{{ $editid === $data->id ? 'background-color: yellow;' : '' }}">
                            <td class="delegate-cell">
                            @php
                            $createdBy = \App\Models\Delegate::getEmployeeName($data->emp_id );
                            @endphp
                               {{$createdBy}}
                            </td>
                            <td class="delegate-cell">
                                {{ $data->workflow }}
                            </td>
                            <td class="delegate-cell">
                                {{ date('d M, Y', strtotime($data->from_date)) }}
                            </td>
                            <td class="delegate-cell">
                                {{ date('d M, Y', strtotime($data->to_date)) }}
                            </td>
                            @php
                            $updatedBy = \App\Models\Delegate::getEmployeeName($data->delegate);
                            @endphp
                            <td class="delegate-cell">
                                {{ $updatedBy }}
                            </td>
                            <td class="delegate-cell">
                                <div style="display:flex;flex-direction:row;gap:10px;border:0px;align-items:center;justify-content:center">
                                    <div style="border-radius:5px;">
                                        <i
                                            style="color:black; font-size:13px; cursor: {{ $data->emp_id === $loginemp_id ? 'pointer' : 'not-allowed' }}"
                                            class='fa fa-edit'
                                            @if ($data->emp_id === $loginemp_id)wire:click="editform({{ $data->id }})"@endif>
                                        </i>
                                    </div>
                                    <div style="border-radius:5px;">
                                        <i style="color:black;font-size:13px;cursor: {{ $data->emp_id === $loginemp_id ? 'pointer' : 'not-allowed' }}" class='fa fa-trash'
                                            @if ($data->emp_id === $loginemp_id)wire:click="showAlertModel({{ $data->id }})"@endif>
                                        </i>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            @if($showform)
            <div class="">
                <div>
                    <form wire:submit="submitForm" style="margin-left:10px;font-size:10px;">
                        <div class="form-group">
                            <h2 style="font-size: 16px; margin-top: 20px;">
                                <b style="display: inline-block; border-bottom: 1px solid skyblue; margin-top: 5px;">Add/ Edit Work Flow Delegates:</b>
                            </h2>
                            <div class="column" style="display:flex;font-size:8px">
                                <h3 class="form-label" style="margin-top:5px;font-size:12px">User: <span style="margin-left:5px;font-size:12px;font-weight:400;text-transform: capitalize;">{{$employeeDetails->first_name}} {{$employeeDetails->last_name}} ({{$employeeDetails->emp_id}})</span></h3>

                            </div>
                        </div>
                        <div class="form-group" style="margin-top:5px">
                            <label class="form-label" style="font-size:10px">WorkFlow</label>
                            <select name="workflow" class="form-select" style="width: 200px; color: black;font-size:10px" wire:model.lazy="workflow">
                                <option style="color: black;font-size:10px" value="">Select workflow</option>
                                <option style="color: black;font-size:10px" value="Delegate All Workflow">Delegate All Workflow</option>
                                <option style="color: black;font-size:10px" value="Attendance Regularization">Attendance Regularization</option>
                                <option style="color: black;font-size:10px" value="Confirmation">Confirmation</option>
                                <option style="color: black;font-size:10px" value="Resignations">Resignations</option>
                                <option style="color: black;font-size:10px" value="Leave">Leave</option>
                                <option style="color: black;font-size:10px" value="Leave Cancel">Leave Cancel</option>
                                <option style="color: black;font-size:10px" value="Leave Comp Off">Leave Comp Off</option>
                                <option vstyle="color: black;font-size:10px" alue="Restricted Holiday Leave">Restricted Holiday Leave</option>
                                <option style="color: black;font-size:10px" value="Help Desk">Help Desk</option>
                                <!-- Add your workflow options here -->
                            </select>
                            @error('workflow') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-size:10px;margin-top:5px">From Date</label>

                            <input type="date" name="fromDate" style="color: black;font-size:10px;width:200px" class="form-control" style="width: 280px" wire:model.lazy="fromDate" min="{{ $isedit && $fromDate ? \Carbon\Carbon::parse($fromDate)->toDateString() : \Carbon\Carbon::today()->toDateString() }}">
                            @error('fromDate') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-size:10px;margin-top:5px">To Date</label>

                            <input type="date" style="color: black;font-size:10px;width:200px" name="toDate" class="form-control" style="width: 280px" wire:model.lazy="toDate" min="{{ $isedit && $fromDate ? \Carbon\Carbon::parse($fromDate)->toDateString() : \Carbon\Carbon::today()->toDateString() }}">
                            @error('toDate') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group" style="margin-top:5px">

                            <label class="form-label" style="font-size:10px;margin-top:5px">Delegatee</label>
                            <select class="form-select" style="width: 200px; color: black;font-size:10px;text-transform: capitalize;" wire:model.lazy="delegate">
                                <option style="color: black;font-size:10px;text-transform:capitalize" value="">Select delegatee</option>
                                @foreach($peoples as $employees)
                                <option style="color: black;font-size:10px;text-transform:capitalize" value="{{$employees->emp_id}}">{{$employees->first_name}} {{$employees->last_name}} #{{$employees->emp_id}}</option>
                                @endforeach
                            </select>
                            @error('delegate') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-actions mt-3" style="display: flex;justify-content: center;gap: 5px;">
                            <button class="submit-btn submit" type="submit">Submit</button>
                            <button class="cancel-btn reset" type="reset" style="border: 1px solid rgb(2, 17, 79);" wire:click='hideForm'>Cancel</button>

                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>

    @if ($showalertmodel)
    <div class="modal fade show" tabindex="-1" style="display: block;" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-white logout2">
                    <h6 class="modal-title logout3" id="logoutModalLabel">Confirm Deletion</h6>
                </div>
                <div class="modal-body text-center">
                    <p>Are you sure you want to delete?</p>
                </div>
                <div class="modal-footer text-center" style="justify-content: center;">
                    <button type="button" class="submit-btn mr-3" wire:click="delete">Confirm</button>
                    <button type="button" class="cancel-btn1" wire:click="cancel">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif

</div>
