<div>
<!-- <x-loading-indicator /> -->
<style>
        #remarks::placeholder {
            color: #a3b2c7;
            font-size: 12px;
        }

    </style>
    <div>
    <div class="row m-0 p-0 mt-3">
                    <div class="search-container d-flex align-items-end justify-content-end p-1">
                        <input type="text" wire:model.debounce.500ms="searchQuery" id="searchInput"
                            placeholder="Enter employee name" class="border outline-none rounded">
                        <button wire:click="searchRegularisation" id="searchButton"
                            style="border:none;outline:none;background:#fff;border-radius:5px;padding:1px 10px;">
                            <i class="fas fa-search" style="width:7px;height:7px;"></i>
                        </button>
                    </div>
                </div>
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
    @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
    @elseif (session()->has('success'))
           <div class="alert alert-danger">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
    @endif


    <div class="accordion bg-white border mb-3 rounded">
        <div class="accordion-heading rounded" onclick="toggleAccordion(this)">

            <div class="accordion-title p-2 rounded">

                <!-- Display leave details here based on $leaveRequest -->

                <div class="accordion-content col">

                    <span style="color: #778899; font-size: 12px; font-weight: 500;">{{ucwords(strtolower($r->employee->first_name))}}&nbsp;{{ucwords(strtolower($r->employee->last_name))}}</span>

                    <span style="color: #36454F; font-size: 10px; font-weight: 500;">{{$r->emp_id}}</span>

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
                    <button class="rejectBtn"wire:click="openRejectModal">Reject</button>
                    <button class="approveBtn"wire:click="openApproveModal">Approve</button>
                </div>
                @if($openRejectPopupModal==true)
                <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #f5f5f5; height: 50px">
                                <h5 class="modal-title" id="rejectModalTitle"style="color:#778899;">Reject Request</h5>
                                <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="closeRejectModal" style="background-color: #f5f5f5;border-radius:20px;border:2px solid #778899;height:20px;width:20px;" >
                                </button>
                            </div>
                            <div class="modal-body" style="max-height:300px;overflow-y:auto">
                                    <p style="font-size:14px;">Are you sure you want to reject this application?</p>
                                    <div class="form-group">
                                            <label for="remarks" style="font-size:12px;color:#666;font-weight:400;">Remarks</label>
                                            <input type="text" class="form-control placeholder-small" id="remarks" placeholder="Enter reason here" wire:model="remarks" style="height: 100px; padding-bottom: 70px;">
                                    </div>

                            </div>
                            <div class="modal-footer">
                                    <button type=
                                    "button"class="approveBtn"wire:click="closeRejectModal">Cancel</button>
                                    <button type="button"class="rejectBtn"wire:click="reject({{$r->id}})">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade show blurred-backdrop"></div>
                @endif
                @if($openApprovePopupModal==true)
                        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #f5f5f5; height: 50px">
                                        <h5 class="modal-title" id="approveModalTitle"style="color:#778899;">Approve Request</h5>
                                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="closeApproveModal" style="background-color: #f5f5f5;border-radius:20px;border:2px solid #778899;height:20px;width:20px;" >
                                        </button>
                                    </div>
                                    <div class="modal-body" style="max-height:300px;overflow-y:auto">
                                            <p style="font-size:14px;">Are you sure you want to approve this application?</p>
                                            <div class="form-group">
                                                    <label for="remarks" style="font-size:12px;color:#666;font-weight:400;">Remarks</label>
                                                    <input type="text" class="form-control" id="remarks" placeholder="Enter reason here" wire:model="remarks" style="height: 100px; padding-bottom: 70px;">
                                            </div>

                                    </div>
                                    <div class="modal-footer">
                                            <button type=
                                            "button"class="approveBtn"wire:click="closeApproveModal">Cancel</button>
                                            <button type="button"class="rejectBtn"wire:click="approve({{$r->id}})">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-backdrop fade show blurred-backdrop"></div>
                @endif
            </div>
        </div>



    </div>
      @endforeach
    @else
    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                    <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
                    <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no regularization records to view
                    </p>
        </div>
    @endif
    </div>

</div>
