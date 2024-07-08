<div class="container-fluid bg-white" style="height: 100vh;">
    <div class="row">
        @foreach($employees as $employee)
        <div class="col-md-12">
            <h5 style="color: orange; margin-top: 30px; margin-left: 20px;"><b>WorkFlow Delegates</b></h5>
            <div class="d-flex justify-content-center mt-3">
                <button wire:click="submitForm" id="show-delegate-form-button" class="btn btn-primary" style="width: 120px; height: 30px; border-radius: 5px; font-size: 12px;background: rgb(2, 17, 79); color: white;">Add Delegates</button>
            </div>
        </div>
        <div class="col-md-8 mt-3">
            <div class="bg-white" style="height: 400px; border: 1px solid skyblue; border-radius: 5px;max-height: 400px; overflow-y: auto;">
                <table style="width: 100%; border-collapse: collapse;margin-top:5px;">
                    <thead style="background: rgb(2, 17, 79); color: white;height:40px">
                        <tr>
                            <th style=" font-size: 8px; text-align: center; ">User</th>
                            <th style=" font-size: 8px; text-align: center; ">Workflow</th>
                            <th style=" font-size: 8px; text-align: center; ">From Date</th>
                            <th style=" font-size: 8px; text-align: center; ">To Date</th>
                            <th style=" font-size: 8px; text-align: center; ">Delegate</th>
                        </tr>
                    </thead>
                    @foreach ($retrievedData as $data)
                    @if ($data->emp_id == auth()->guard('emp')->user()->emp_id)
                    <tr style="height:auto">
                        <td style="border: 1px solid #8D939D;text-align:center; font-size: 7px; font-family: Montserrat">
                            {{ $data->first_name }} {{ $data->last_name }} ({{ $data->emp_id }})
                        </td>
                        <td style="border: 1px solid #8D939D; ; font-size: 7px;text-align:center;">{{ $data->workflow }}</td>
                        <td style="border: 1px solid #8D939D;  font-size: 7px; text-align:center;">{{ date('d M Y', strtotime($data->from_date)) }}</td>
                        <td style="border: 1px solid #8D939D;  font-size: 7px;text-align:center;">{{ date('d M Y', strtotime($data->to_date)) }}</td>
                        <td style="border: 1px solid #8D939D;  font-size: 7px; text-align:center;">{{ $data->delegate }}</td>
                    </tr>
                    @endif
                    @endforeach
                </table>
            </div>
        </div>
        <div class="col-md-4 mt-3" id="delegate-form-container">
            <div>
                <form wire:submit.prevent="submitForm" style="margin-left:10px;font-size:10px;">
                    <div class="form-group" style="margin-left:5px">
                        <h2 style="font-size: 16px; margin-top: 2px;">
                            <b style="display: inline-block; border-bottom: 1px solid skyblue; margin-top: 5px;">Add/ Edit Work Flow Delegates:</b>
                        </h2>
                        <div class="column" style="display:flex;font-size:8px">
                            <h3 class="form-label" style="margin-top:30px;font-size:12px">User:</h3>
                            <p style="margin-left:-30px;font-size:12px;font-weight:400"> {{$employee->first_name}} {{$employee->last_name}} ({{$employee->emp_id}})</p>
                        </div>
                    </div>
                    <div class="form-group" style="color: black;margin-top:-20px">
                        <label class="form-label" style="color: black;font-size:10px">WorkFlow</label>
                        <select name="workflow" class="form-control" style="width: 200px; color: black;font-size:10px" wire:model="workflow">
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
                    <div class="form-group">
                        <label class="form-label" style="font-size:10px">From Date</label>
                        @error('fromDate') <span class="text-danger">{{ $message }}</span> @enderror
                        <input type="date" name="fromDate" style="color: black;font-size:10px;width:200px" class="form-control" style="width: 280px" wire:model="fromDate">
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-size:10px">To Date</label>
                        @error('toDate') <span class="text-danger">{{ $message }}</span> @enderror
                        <input type="date" style="color: black;font-size:10px;width:200px" name="toDate" class="form-control" style="width: 280px" wire:model="toDate">
                    </div>
                    <div class="form-group" style="color: black;font-size:10px">
                        <div class="row m-0 p-0">
                            <p style="font-size: 12px;">
                                <strong>Delegate: </strong>
                                {{ implode(', ', array_unique($selectedPeopleNames)) }}
                            </p>
                        </div>
                        <div class="row m-0">
                            <div class="row">
                                <div class="row m-0">
                                    <div class="mb-3 p-0">
                                        <button type="button" class="btn btn-outline-primary" wire:click="NamesSearch">
                                            <i class="fa fa-plus me-4"></i>
                                            Add
                                        </button>
                                    </div>
                                    @error('delegate') <span class="text-danger" style="margin-left:20px">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            @if($isNames)
                            <div style="border-radius:5px;background-color:grey;padding:8px;width:320px;margin-top:10px;overflow-y:auto;max-height:300px">
                                <div class="input-group" style="margin-bottom: 10px;">
                                    <input wire:model="searchTerm" style="font-size: 10px;cursor: pointer; border-radius: 5px 0 0 5px;" type="text" class="form-control" placeholder="Search for Emp.Name or ID" aria-label="Search" aria-describedby="basic-addon1">
                                    <div class="input-group-append">
                                        <button wire:click="filter" style="border-radius: 0 5px 5px 0; background-color: #007BFF; color: #fff; border: none;" class="btn me-3" type="button">
                                            <i style="text-align: center;" class="fa fa-search"></i>
                                        </button>
                                        <button wire:click="closePeoples" type="button" style="margin-top: -7px;" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" style="color: white; font-size: 24px; font-weight: 300">x</span>
                                        </button>
                                    </div>
                                </div>
                                @if ($peopleData->isEmpty())
                                <div class="container" style="text-align: center; color: white;font-size:12px;overflow-y:auto;max-height:300px">
                                    No People Found
                                </div>
                                @else
                                @foreach($peopleData as $people)
                                <div wire:model="delegate" wire:click="selectPerson('{{ $people->emp_id }}')" class="container" style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px;">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <input type="checkbox" wire:model="selectedPeople" value="{{ $people->emp_id }}" wire:click="selectPerson({{ $people->emp_id }})">
                                        </div>
                                        <div class="col">
                                            <h6 class="username" style="font-size: 12px; color: white;">
                                                {{ $people->first_name }}
                                                {{ $people->last_name }}</h6>
                                            <p class="mb-0" style="font-size: 12px; color: white;">
                                                (#{{ $people->emp_id }})</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            @endif
                        </div>
                        <div class="form-actions">
                            <button class="btn submit-btn submit" type="submit" >Submit</button>
                            <button id="cancel-button" class="btn cancel-btn reset" type="reset" style="border:1px solid rgb(2,17,79)">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
<script>
    document.getElementById('show-delegate-form-button').addEventListener('click', function () {
        var delegateFormContainer = document.getElementById('delegate-form-container');
        if (delegateFormContainer.style.display === 'none' || delegateFormContainer.style.display === '') {
            delegateFormContainer.style.display = 'block';
        } else {
            delegateFormContainer.style.display = 'none';
        }
    });
 
    document.getElementById('cancel-button').addEventListener('click', function () {
        var delegateFormContainer = document.getElementById('delegate-form-container');
        delegateFormContainer.style.display = 'none';
    });
</script>
 