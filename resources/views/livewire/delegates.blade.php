<div class="container-fluid bg-white" style="height: 100vh;">
    <div class="row">
        @foreach($employees as $employee)
        <div class="col-md-12">
            <h5 style="color: orange; margin-top: 30px; margin-left: 20px;"><b>WorkFlow Delegates</b></h5>
            <div class="d-flex justify-content-center mt-3">
                <button  id="show-delegate-form-button" class="btn btn-primary" style="width: 120px; height: 30px; border-radius: 5px; font-size: 12px;background: rgb(2, 17, 79); color: white;">Add Delegates</button>
            </div>
        </div>
        <div class="col-md-8 mt-3">
    <div class="bg-white" style="height: 460px; border: 1px solid skyblue; border-radius: 5px; max-height: 400px; overflow-y: auto;">
        <table class="delegate-table" style="width: 100%; border-collapse: collapse; margin-top: 5px;justify-content:space-between">
            <thead >
                <tr class="delegate-header">
                    <th class="delegate-cell"  >User</th>
                    <th class="delegate-cell" >Workflow</th>
                    <th class="delegate-cell" >From Date</th>
                    <th class="delegate-cell" >To Date</th>
                    <th class="delegate-cell">Delegate</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($retrievedData ?? [] as $data)
    <tr class="delegate-row" style="justify-content:space-between">
        <td class="delegate-cell" style="width:20%">
            {{ $data->first_name }} {{ $data->last_name }} ({{ $data->emp_id }})
        </td>
        <td class="delegate-cell" style="width:20%">
            {{ $data->workflow }}
        </td>
        <td class="delegate-cell" style="width:20%">
            {{ date('d M Y', strtotime($data->from_date)) }}
        </td>
        <td class="delegate-cell" style="width:20%">
            {{ date('d M Y', strtotime($data->to_date)) }}
        </td>
        <td class="delegate-cell" style="width:20%">
            {{ $data->delegate }}
        </td>
    </tr>
@endforeach


            </tbody>
        </table>
    </div>
</div>

        <div class="col-md-4 mt-3" id="delegate-form-container">
            <div>
                <form wire:submit.prevent="submitForm" style="margin-left:10px;font-size:10px;">
                    <div class="form-group" >
                        <h2 style="font-size: 16px; margin-top: 2px;">
                            <b style="display: inline-block; border-bottom: 1px solid skyblue; margin-top: 5px;">Add Work Flow Delegates:</b>
                        </h2>
                        <div class="column" style="display:flex;font-size:8px">
                            <h3 class="form-label" style="margin-top:5px;font-size:12px">User: <span style="margin-left:5px;font-size:12px;font-weight:400">{{$employee->first_name}} {{$employee->last_name}} ({{$employee->emp_id}})</span></h3>

                        </div>
                    </div>
                    <div class="form-group" style="color: black;margin-top:5px">
                        <label class="form-label" style="font-size:10px">WorkFlow</label>
                        <select name="workflow" class="form-control" style="width: 200px; color: black;font-size:10px" wire:model.lazy="workflow">
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
                       
                        <input type="date" name="fromDate" style="color: black;font-size:10px;width:200px" class="form-control" style="width: 280px" wire:model.lazy="fromDate">
                        @error('fromDate') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-size:10px;margin-top:5px">To Date</label>
                       
                        <input type="date" style="color: black;font-size:10px;width:200px" name="toDate" class="form-control" style="width: 280px" wire:model.lazy="toDate">
                        @error('toDate') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group" style="color: black;font-size:10px">
                
                        <div class="row " style="margin-top: 10px;">
                            <div class="col">
                                <div class="row m-0 p-0">
                                    <div class="row m-0 p-0">
                                        <div style="margin: 0px;padding:0;">
                                            <div>
                                                <div style="font-size: 12px;color:#778899;margin-bottom:10px;font-weight:500;" wire:model="delegate" id="delegate">Delegates : {{ implode(', ', array_unique($selectedPeopleNames)) }}</div>
                                            </div>
                                            <button type="button" style="border-radius: 50%; color: #778899; border: 1px solid #778899;" class="add-button" wire:click="toggleRotation">
                        <div class="icon-container">
                            <i class="fas fa-plus" style="color: #778899;"></i>
                        </div>
                    </button>
                    <span style="color: #778899; font-size: 12px;">Add</span>
                </div>
                                        @error('delegate') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                @if($isRotated)
                                <div style="border-radius:5px;background-color:grey;padding:8px;width:300px;margin-top:10px;height:200px;overflow-y:auto;">
                                <div class="input-group3" style="display: flex; align-items: center; width: 100%;">
    <input 
        wire:model="searchTerm" 
        style="font-size: 10px; cursor: pointer; border-radius: 5px 0 0 5px; width: 250px; height: 30px; padding: 5px;" 
        type="text" 
        class="form-control" 
        placeholder="Search for Emp.Name or ID" 
        aria-label="Search" 
        aria-describedby="basic-addon1"
    >
    <div class="input-group-append" style="display: flex; align-items: center;">
        <button 
            wire:click="filter" 
            style="height: 30px; border-radius: 0 5px 5px 0; background-color: rgb(2, 17, 79); color: #fff; border: none; padding: 0 10px;" 
            class="btn" 
            type="button"
        >
            <i style="text-align: center;" class="fa fa-search"></i>
        </button>

        <button 
            wire:click="closePeoples"  
            type="button" 
            class="close rounded px-1 py-0" 
            aria-label="Close" 
            style="background-color: rgb(2,17,79); height: 30px; width: 30px; margin-left: 5px; display: flex; align-items: center; justify-content: center;"
        >
            <span aria-hidden="true" style="color: white; font-size: 24px; line-height: 0;">×</span>
        </button>
    </div>
</div>
@if ($peopleData && $peopleData->isEmpty())
    <div class="container" style="text-align: center; color: white; font-size: 12px; margin-top: 5px">
        No People Found
    </div>
@else
    @foreach($peopleData->sortBy(function($person) {
        return $person->first_name . ' ' . $person->last_name;
    }) as $people)
        <label wire:click="selectPerson('{{ $people->emp_id }}')" class="container" style="cursor: pointer; background-color: darkgrey; padding: 5px; margin-bottom: 8px; width: 300px; border-radius: 5px; margin-top: 5px">
            <div class="row align-items-center">
                <div class="col-auto">
                    <input type="checkbox" wire:model="selectedPeople" value="{{ $people->emp_id }}" {{ in_array($people->emp_id, $selectedPeople) ? 'checked' : '' }}>
                </div>
                <div class="col-auto">
                    @if (!empty($people->image) && $people->image !== 'null')
                        <!-- Display the actual image if available -->
                        <img class="profile-image" src="{{ 'data:image/jpeg;base64,' . base64_encode($people->image) }}">
                    @else
                        <!-- If image is not available, check the gender and show default images -->

                            @php
                                // Debugging step to check gender
                                $gender = $people->gender ?? null;
                            @endphp
                            @if ($gender === 'Male')
                                <img class="profile-image" src="{{ asset('images/male-default.png') }}" alt="Default Male Image">
                            @elseif($gender === 'Female')
                                <img class="profile-image" src="{{ asset('images/female-default.jpg') }}" alt="Default Female Image">
                          
                        @else
                            <!-- Fallback if emp is not available -->
                            <img class="profile-image" src="{{ asset('images/user.jpg') }}" alt="Default Image">
                        @endif
                    @endif
                </div>
                <div class="col">
                    <h6 class="username" style="font-size: 12px; color: white;">{{ ucwords(strtolower($people->first_name)) }} {{ ucwords(strtolower($people->last_name)) }}</h6>
                    <p class="mb-0" style="font-size: 12px; color: white;">(#{{ $people->emp_id }})</p>
                </div>
            </div>
        </label>
    @endforeach
@endif


        </div>
        @endif
    </div>
</div>

                        <div class="form-actions mt-3">
                        <button  class="submit-btn submit" type="submit">Submit</button>
                        <button id="cancel-button" class="cancel-btn reset" type="reset" style="border: 1px solid rgb(2, 17, 79);">Cancel</button>
                            
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
 