<div>
    <style>
        #remarks::placeholder {
            color: #a3b2c7;
        }
    </style>
    @if(count($regularisations)>0)
    @foreach($regularisations as $r)
    @php
    $regularisationEntries = json_decode($r->regularisation_entries, true);
    $numberOfEntries = count($regularisationEntries);
    $firstItem = reset($regularisationEntries); // Get the first item
    $lastItem = end($regularisationEntries); // Get the last item
    @endphp
    @foreach($regularisationEntries as $r1)
    @if(empty($r1['date']))
    @php
    $numberOfEntries-=1;
    @endphp
    @endif

    @endforeach
    <div class="accordion bg-white  mb-3 rounded">
        <div class="accordion-heading  rounded" onclick="toggleAccordion(this)">

            <div class="accordion-title p-2 rounded">

                <!-- Display leave details here based on $leaveRequest -->

                <div class="accordion-content col">

                    <span style="color: #778899; font-size: 12px; font-weight: 500;">{{ucwords(strtolower($r->employee->first_name))}}&nbsp;{{ucwords(strtolower($r->employee->last_name))}}</span>

                    <span style="color: #36454F; font-size: 12px; font-weight: 500;">{{$r->emp_id}}</span>

                </div>



                <div class="accordion-content col">

                    <span style="color: #778899; font-size: 12px; font-weight: 500;">No. of Days</span>

                    <span style="color: #36454F; font-size: 12px; font-weight: 500;">
                        {{$numberOfEntries}}
                    </span>

                </div>


                <!-- Add other details based on your leave request structure -->



                <div class="arrow-btn">
                    <i class="fa fa-angle-down"></i>
                </div>

            </div>

        </div>
        <div class="accordion-body m-0 p-0">

            <div style="width:100%; height:1px; border-bottom:1px solid #ccc;"></div>

            <div class="content px-4 py-2">

                <span style="color: #778899; font-size: 12px; font-weight: 500;">Dates Applied:</span>

                <span style="font-size: 11px;">
                    @if($r->regularisation_entries_count>1)
                    <span style="font-size: 11px; font-weight: 500;"></span>

                    {{ date('(d', strtotime($firstItem['date'])) }} -

                    <span style="font-size: 11px; font-weight: 500;"></span>

                    @if (!empty($lastItem['date']))
                    {{ date('d)', strtotime($lastItem['date'])) }} {{ date('M Y', strtotime($lastItem['date'])) }}
                    @endif
                    @else
                    {{ date('d', strtotime($firstItem['date'])) }} {{ date('M Y', strtotime($lastItem['date'])) }}
                    @endif

                </span>

            </div>



            <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>

            <div style="display:flex; flex-direction:row; justify-content:space-between;">

                <div class="content mb-2 mt-0 px-4">

                    <span style="color: #778899; font-size: 12px; font-weight: 500;">Applied on:</span>

                    <span style="color: #333; font-size:12px; font-weight: 500;">{{ \Carbon\Carbon::parse($r->created_at)->format('d M, Y') }}
                    </span>

                </div>

                <div class="content mb-2 px-4 d-flex gap-2">
                    <a href="{{ route('review-pending-regularation', ['id' => $r->id]) }}" style="color:rgb(2,17,79);font-size:12px;margin-top:3px;">View Details</a>
                    <button class="rejectBtn" data-toggle="modal" data-target="#rejectModal">Reject</button>
                    <button class="approveBtn" data-toggle="modal" data-target="#approveModal">Approve</button>
                </div>
                <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:rgba(163, 178, 199, 0.15);">
                                <h6 class="modal-title" id="rejectModalLabel" style="color:#666;font-weight:600;">Reject Request</h6>
                                <div style="width: 25px; height: 25px; border-radius: 50%; border:2px solid #666; display: flex; justify-content: center; align-items: center; position: relative;">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none; background-color: transparent; position: absolute; left: 2px;margin-left:-16px">
                                        <span aria-hidden="true" style="font-weight:400;font-size:30px;color:666">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <div class="modal-body">
                                <p style="font-size:14px;">Are you sure you want to reject this application?</p>
                                <div class="form-group">
                                    <label for="remarks" style="font-size:12px;color:#666;font-weight:400;">Remarks</label>
                                    <input type="text" class="form-control" id="remarks" placeholder="Enter reason here" wire:model="remarks" style="height: 100px; padding-bottom: 70px;">
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center" style="border:none;">
                                <button type="button" class="approveBtn" data-dismiss="modal" style="width:90px;">Cancel</button>
                                <button type="button" class="rejectBtn" wire:click="reject({{$r->id}})" style="width:90px;">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:rgba(163, 178, 199, 0.15);">
                                <h5 class="modal-title" id="approveModalLabel" style="color:#666;font-weight:600;">Approve Request</h5>
                                <div style="width: 25px; height: 25px; border-radius: 50%; border:2px solid #666; display: flex; justify-content: center; align-items: center; position: relative;">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none; background-color: transparent; position: absolute; left: 2px;margin-left:-16px">
                                        <span aria-hidden="true" style="font-weight:400;font-size:30px;color:666">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <div class="modal-body">
                                <p style="font-size:14px;">Are you sure you want to approve this application?</p>
                                <div class="form-group">
                                    <label for="remarks" style="font-size:12px;color:#666;font-weight:400;">Remarks:</label>
                                    <input type="text" class="form-control" id="remarks" placeholder="Enter remarks" wire:model="remarks" style="height: 100px; padding-bottom: 70px;">
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center" style="border:none;"> <!-- Centered footer -->
                                <div> <!-- Button wrapper -->
                                    <button type="button" class="approveBtn btn-primary" style="width:90px;" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="rejectBtn" style="width:90px;" wire:click="approve({{$r->id}})">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
    @endforeach
    @else
    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
        <img src="/images/pending.png" alt="Pending Image" style="width:60%; margin:0 auto;">
        <p style="color:#969ea9; font-size:13px; font-weight:400; ">Hey, you have no regularization records to view</p>
    </div>
    @endif


</div>