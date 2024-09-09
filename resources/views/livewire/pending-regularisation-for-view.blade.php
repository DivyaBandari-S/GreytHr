<div>
@foreach($pendingRegularisations as $pr)
@if ($pr->regularisation_entries!='[]')
@php
$regularisationEntries = json_decode($pr->regularisation_entries, true);
$numberOfEntries = count($regularisationEntries);
$firstItem = reset($regularisationEntries); // Get the first item
$lastItem = end($regularisationEntries); // Get the last item
@endphp
<div class="accordion-heading rounded" style="margin-top:10px;">

    <div class="accordion-title p-2 rounded">

        <!-- Display leave details here based on $leaveRequest -->

        <div class="col accordion-content">

            <span style="color: #778899; font-size: 12px; font-weight: 500;">Pending&nbsp;With</span>
            @if(!empty($EmployeeDetails))
            <span style="color: #36454F; font-size: 12px; font-weight: 500;">{{ucwords(strtolower($EmployeeDetails->first_name))}}&nbsp;{{ucwords(strtolower($EmployeeDetails->last_name))}}</span>
            @else
            <span style="color: #36454F; font-size: 12px; font-weight: 500;">Manager Details not Available</span>
            @endif
        </div>



        <div class="col accordion-content">

            <span style="color: #778899; font-size: 12px; font-weight: 500;">No. of Days</span>

            <span style="color: #36454F; font-size: 12px; font-weight: 500;">

                {{$numberOfEntries}}

            </span>

        </div>


        <!-- Add other details based on your leave request structure -->

        <div class="col accordion-content">

            <span style="margin-top:0.625rem; font-size: 12px; font-weight: 400; color:#cf9b17;text-transform:uppercase;">{{$pr->status}}</span>

        </div>

        <div class="arrow-btn" wire:click="togglePendingAccordion({{ $pr->id }})"style="color:{{ $openAccordionForPending === $pr->id ? '#3a9efd' : '#778899' }};border:1px solid {{ $openAccordionForPending === $pr->id ? '#3a9efd' : '#778899' }}">
            <i class="fa fa-angle-{{ $openAccordionForPending === $pr->id ? 'up' : 'down' }}"style="color:{{ $openAccordionForPending === $pr->id ? '#3a9efd' : '#778899' }}"></i>
        </div>

    </div>

</div>

              
<div class="accordion-body m-0 p-0"style="display: {{ $openAccordionForPending === $pr->id ? 'block' : 'none' }}">

    <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>

    <div class="content px-2">

        <span class="normalTextValue">Dates Applied:</span>
        @if($numberOfEntries>1)
        <span style="font-size: 11px;">

            <span style="font-size: 11px; font-weight: 500;"></span>

            {{ date('(d', strtotime($firstItem['date'])) }} -


            <span style="font-size: 11px; font-weight: 500;"></span>

            @if (!empty($lastItem['date']))
            {{ date('d)', strtotime($lastItem['date'])) }} {{ date('M Y', strtotime($lastItem['date'])) }}
            @endif


        </span>
        @else
        <span style="font-size: 11px;">

            <span style="font-size: 11px; font-weight: 500;">
                {{ date('d', strtotime($lastItem['date'])) }}
                {{ date('M Y', strtotime($lastItem['date'])) }}
                <!-- This will retrieve the day -->
            </span>

        @endif
    </div>



    <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>

    <div style="display:flex; flex-direction:row; justify-content:space-between;">

        <div class="content px-2">

            <span style="color: #778899; font-size: 12px; font-weight: 500;">Applied on:</span>

            <span style="color: #333; font-size:12px; font-weight: 500;">{{ date('d M, Y', strtotime($pr->created_at)) }}</span>

        </div>

        <div class="content px-2">

            <a href="{{ route('regularisation-pending', ['id' => $pr->id]) }}">

                <span style="color: #3a9efd; font-size: 12px; font-weight: 500;">View Details</span>

            </a>
            <button class="withdraw mb-2"wire:click="openWithdrawModal">Withdraw</button>

        </div>

    </div>

</div>
@if($withdrawModal==true)
<div class="modal" tabindex="-1" role="dialog" style="display: block;">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #f5f5f5; height: 50px">
                                        <h5 class="modal-title" id="approveModalTitle"style="color:#778899;">Withdraw Confirmation</h5>
                                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="closewithdrawModal" style="background-color: #f5f5f5;font-size:12px;border-radius:20px;border:2px solid #778899;height:15px;width:15px;" >
                                        </button>
                                    </div>
                                    <div class="modal-body" style="max-height:300px;overflow-y:auto">
                                         <p style="font-size:14px;">Are you sure you want to withdraw this application?</p>
  
                                    </div>
                                    <div class="modal-footer">
                                            <button type="button"class="approveBtn"wire:click="withdraw({{$pr->id}})">Confirm</button>
                                            <button type="button"class="rejectBtn"wire:click="closewithdrawModal">Cancel</button>
                                           
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-backdrop fade show blurred-backdrop" style="background-color: rgba(0, 0, 0, 0.2);"></div>
 

@endif
@endif
@endforeach

</div>
