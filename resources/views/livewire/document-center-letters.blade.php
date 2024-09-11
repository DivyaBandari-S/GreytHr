<div>
<ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="/document">Document Center</a></li>
        <li class="breadcrumb-item active" aria-current="page">Letters</li>

    </ul>
    <!-- <button class="back-button" style="margin-left:20px;"><a class="a-back" href="/document">Back</a></button> -->
    <div class="container" style="font-size: 0.9rem; ;">
        <div class="row m-0 mt-2 p-0" style="position: relative;">
            <div class="row mb-2">
                <div wire:click="$set('tab', 'Letters List')" class="col-md-2">
                    <div class="tab {{ $tab === 'Letters List' ? 'active' : '' }}">Letters List</div>
                </div>
                <div wire:click="$set('tab', 'Request Letter')" class="col-md-10">
                    <div class="tab {{ $tab === 'Request Letter' ? 'active' : '' }}">Request Letter</div>
                </div>
            </div>
            <div style="transition: left 0.3s ease-in-out; position: absolute; bottom: 0; left: {{ $tab === 'Letters List' ? '0' : '15%' }}; width: 15%; height: 6px; background-color: rgb(2, 17, 79); text-align: start;border-radius :5px;"></div>
        </div>

        <div class="row mt-4" style="background-color: white; border-radius: 5px; height: auto;">
            @if($tab=="Letters List")
            <div class="row" style="">
                <div class="col-md-3">
                    <div class="mb-2" style="margin-top: 5px;">
                        <div>JUMP TO</div>
                    </div>
                    <button wire:click="$set('jumpToTab', 'Confirmation Letter')" class="jump-to {{ $jumpToTab === 'Confirmation Letter' ? 'active' : '' }}">Confirmation Letter</button>
                    <button wire:click="$set('jumpToTab', 'Appointment Order')" class="jump-to {{ $jumpToTab === 'Appointment Order' ? 'active' : '' }}">Appointment Order</button>
                </div>
                <div class="col-md-9">
                    <div class="row mt-3" style="background-color: #f2f2f2; border-radius: 5px; height: auto; width: 100%; box-shadow: {{ $jumpToTab === 'Confirmation Letter' ? '0 0 10px rgba(2,17,70,0.5)' : 'none' }}; overflow: hidden;">
                        <h6 style="font-size: 0.9rem; ;margin-top:5px">
                            <div>Confirmation Letter</div>
                        </h6>
                        <hr style="background-color: black; border-color: black; width: 100%; border-radius: 5px; margin: 0;">
                        <div class="row mt-2 mb-2 confirmation-letter">
                            <div class="col-md-4">
                                <div class="test mt-0">Confirmation Letter</div>
                                <div style="color: gray;font-size:10px">Confirmation Letter</div>
                            </div>
                            <div class="col-md-8" style="color: gray;text-align:end;font-size:10px">
                                Last updated on 17 Nov, 2023
                            </div>
                        </div>
                    </div>


                    <div class="row mt-3 mb-3" style="background-color: #f2f2f2; border-radius:5px; height: auto; width:100%;box-shadow: {{ $jumpToTab === 'Appointment Order' ? '0 0 10px rgba(2,17,70,0.5)' : 'none' }};overflow: hidden;">
                        <h6 style="font-size: 0.9rem; ;margin-top:5px">
                            <div>Appointment Order</div>
                        </h6>
                        <hr style="background-color: black; border-color: black; width: 100%;border-radius :5px;margin:0">
                        <div class="row mt-2 mb-2 appointment-order">
                            <div class="col-md-4">
                                <div class="test mt-0">Appointment Order</div>
                                <div style="color: gray;font-size:10px">Appointment Order</div>
                            </div>
                            <div class="col-md-8" style="color: gray;text-align:end;font-size:10px">
                                Last updated on 22 Nov, 2023
                            </div>
                        </div>
                        <div class="row mt-2 mb-2 appointment-order">
                            <div class="col-md-4">
                                <div class="test mt-0">Appointment Order</div>
                                <div style="color: gray;font-size:10px">Appointment Order</div>
                            </div>
                            <div class="col-md-8" style="color: gray;text-align:end;font-size:10px">
                                Last updated on 17 Nov, 2023
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @if($tab=="Request Letter")
        <div style="text-align:center;justify-content:center;display:flex;padding:5px;align-items:center">
            <div class="row mt-2 mb-2" style="background-color: white;max-width:500px;width:100%;padding:5px;border-radius:5px;height:52px">
                <div class="col-md-4">
                    <button style="margin-left: 0;" wire:click="$set('activeTab', 'Apply')" class="button-dl {{ $activeTab === 'Apply' ? 'active' : '' }}">Apply</button>
                </div>
                <div class="col-md-4">
                    <button wire:click="$set('activeTab', 'Pending')" class="button-dl {{ $activeTab === 'Pending' ? 'active' : '' }}">Pending</button>
                </div>
                <div class="col-md-4">
                    <button wire:click="$set('activeTab', 'History')" class="button-dl {{ $activeTab === 'History' ? 'active' : '' }}">History</button>
                </div>
            </div>
        </div>
        @if (Session::has('success'))
        <div style="text-align: center;" id="success-alert" class="alert alert-success show">
            {{ Session::get('success') }}
        </div>

        <script>
            setTimeout(function() {
                document.getElementById('success-alert').style.display = 'none';
            }, 5000); // 5000 milliseconds (5 seconds)
        </script>
        @endif


        <div class="container custom-form">
            @if($activeTab=="Apply")
            <div class="row">
                <div><strong>New Request</strong></div>
                <div style="color: gray;margin-top:5px">Looks like you did not find the letter you were looking for. You can request a new one here.</div>
            </div>

            <div class="row" style="margin-top:15px;">
                <div class="col-md-6">
                    <form>
                        <div style="margin-bottom: 8px;" class="form-group row">
                            <label for="priority" class="col-sm-4 col-form-label">Letter Type</label>
                            <div class="col-sm-8">
                                <select wire:model="letter_type" style="font-size: 0.9rem;" class="form-control" id="priority" name="priority">
                                    <option value="">Select Type</option>
                                    <option value="Confirmation Letter">Confirmation Letter</option>
                                    <option value="Appointment Order">Appointment Order</option>
                                    <option value="Offer Letter">Offer Letter</option>
                                </select>
                            </div>
                            @error('letter_type') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div style="margin-bottom: 8px;" class="form-group row">
                            <label for="priority" class="col-sm-4 col-form-label">Priority</label>
                            <div class="col-sm-8">
                                <select wire:model="priority" style="font-size: 0.9rem;" class="form-control" id="priority" name="priority">
                                    <option value="">Select Priority</option>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>
                            @error('priority') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div style="margin-bottom: 8px;" class="form-group row">
                            <label for="reason" class="col-sm-4 col-form-label">Reason</label>
                            <div class="col-sm-8">
                                <textarea wire:model="reason" style="font-size: 0.9rem;" placeholder="Enter reason" class="form-control" id="reason" name="reason" rows="3"></textarea>
                            </div>
                            @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div style="text-align: center;">
                            <button class="submit-for-LR" type="button" wire:click="submitRequest" style="background-color: rgb(2,17,79);color:white;padding:5px;border-radius:5px;border:none">Submit</button>
                        </div>
                    </form>

                </div>
                <div class="col-md-6">
                    <img style="width: 450px;" src="https://proofed.com/wp-content/webp-express/webp-images/uploads/2023/07/28-Graphic-Funding-Request-Letter-Template.png.webp" alt="">
                </div>
            </div>
            @endif
            @if($activeTab=="Pending")
            <div class="row">
                <div class="table-responsive">
                    <table class="table-start">
                        <thead class="table-header">
                            <tr style="background-color: rgb(2,17,79);color:white;padding:8px">
                                <th style="padding: 8px;width:20%;">Employee ID</th>
                                <th style="width:20%;" >Letter Type</th>
                                <th style="width:20%;">Priority</th>
                                <th style="width:20%;">Reason</th>
                                <th style="width:20%;">Status</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @forelse ($allRequests->where('status', 'Pending') as $request)
                            <tr>
                                <td style="width:20%;">{{$request->emp_id}}</td>
                                <td style="width:20%;">{{$request->letter_type}}</td>
                                <td style="width:20%;">{{$request->priority}}</td>
                                <td style="width:20%;"> {{$request->reason}}</td>
                                <td style="width:20%;">{{$request->status}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No Records Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
            @endif
            @if($activeTab=="History")
            <div class="row">
                <div class="table-responsive">
                    <table class="table-start">
                        <thead class="table-header">
                            <tr style="background-color: rgb(2,17,79);color:white;padding:8px">
                                <th style="padding: 8px;">Employee ID</th>
                                <th>Letter Type</th>
                                <th>Priority</th>
                                <th>Reason</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @forelse($allRequests as $request)
                            <tr>
                                <td>{{$request->emp_id}}</td>
                                <td>{{$request->letter_type}}</td>
                                <td>{{$request->priority}}</td>
                                <td>{{$request->reason}}</td>
                                <td>{{$request->status}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No Records Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
            @endif
        </div>

        @endif
    </div>
</div>
