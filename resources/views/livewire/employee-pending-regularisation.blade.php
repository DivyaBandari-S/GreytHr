<div>
@if(count($pendingRegularisations)>0)
  @foreach($pendingRegularisations as $pr) 
                                    @php
                                            $regularisationEntries = json_decode($pr->regularisation_entries, true);
                                            $numberOfEntries = count($regularisationEntries);
                                            $firstItem = reset($regularisationEntries); // Get the first item
                                            $lastItem = end($regularisationEntries); // Get the last item
                                    @endphp
                                     <div class="accordion-heading rounded" style="margin-top:10px;">
                                        <div class="accordion-title p-2 rounded">
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
                                        <div class="col accordion-content">
 
                                              <span style="margin-top:0.625rem; font-size: 12px; font-weight: 400; color:#cf9b17;text-transform:uppercase;">{{$pr->status_name}}</span>
 
                                        </div>
                                        <div class="arrow-btn" wire:click="togglePendingAccordion({{ $pr->id }})" style="color:{{ in_array($pr->id, $openAccordionForPending) ? '#3a9efd' : '#778899' }};border:1px solid {{ in_array($pr->id, $openAccordionForPending) ? '#3a9efd' : '#778899' }}">
                                              <i class="fa fa-angle-{{ in_array($pr->id, $openAccordionForPending) ? 'up' : 'down' }}" style="color:{{ in_array($pr->id, $openAccordionForPending) ? '#3a9efd' : '#778899' }}"></i>
                                        </div>
                                     </div>
  @endforeach
 
@else
<div class="hidden-pending-box">
    <img src="{{ asset('images/pending.png') }}" style="margin-top:50px;" height="180" width="180">
    <p style="color: #a3b2c7;font-weight:400;font-size: 14px;margin-top:-10px;">Hey, you have no
        regularization records to view.</p>
</div>
@endif
</div>
