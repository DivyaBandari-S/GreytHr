<div class="leavePageContent position-relative">
   <div class="d-flex mt-2 gap-4 align-items-center ">
      @if(session()->has('error'))
      <div class="alert alert-danger position-absolute p-1" style="right: 25%;top:-3%;" id="error-alert">
         {{ session('error') }}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span>X</span>
         </button>
      </div>
      <script>
         setTimeout(function() {
            $('#error-alert').fadeOut('slow');
         }, 3000); // 3 seconds
      </script>
      @endif
   </div>

   <div class="toggle-container">
      <!-- Navigation Buttons -->
      <div class="nav-buttons mt-2 d-flex justify-content-center">
         <ul class="nav custom-nav-tabs border">
            <li class="custom-item m-0 p-0 flex-grow-1">
               <div class="reviewActiveButtons custom-nav-link {{ $activeSection === 'applyButton' ? 'active' : '' }}" wire:click.prevent="toggleSection('applyButton')">Apply</div>
            </li>
            <li class="pendingCustomStyles custom-item m-0 p-0 flex-grow-1">
               <a href="#" class="custom-nav-link {{ $activeSection === 'pendingButton' ? 'active' : '' }}" wire:click.prevent="toggleSection('pendingButton')">Pending</a>
            </li>
            <li class="custom-item m-0 p-0 flex-grow-1">
               <a href="#" class="reviewClosedButtons custom-nav-link {{ $activeSection === 'historyButton' ? 'active' : '' }}" wire:click.prevent="toggleSection('historyButton')">History</a>
            </li>
         </ul>
      </div>

      <!-- Conditional Content Sections -->
      <div class="content-sections mt-3">
         @if($activeSection === 'applyButton')
         <div class="containerWidth">
            <div id="cardElement" class="side">
               <div>
                  <a href="#" class="side-nav-link {{ $activeSubSection === 'leave' ? 'active' : '' }}" wire:click.prevent="toggleSideSection('leave')">Leave</a>
               </div>
               <div class="line"></div>
               <div>
                  <a href="#" class="side-nav-link {{ $activeSubSection === 'restricted' ? 'active' : '' }}" wire:click.prevent="toggleSideSection('restricted')">Restricted Holiday</a>
               </div>
               <div class="line"></div>
               <div>
                  <a href="#" class="side-nav-link {{ $activeSubSection === 'leaveCancel' ? 'active' : '' }}" wire:click.prevent="toggleSideSection('leaveCancel')">Leave Cancel</a>
               </div>
               <div class="line"></div>
               <div>
                  <a href="#" class="side-nav-link {{ $activeSubSection === 'compOff' ? 'active' : '' }}" wire:click.prevent="toggleSideSection('compOff')">Comp Off Grant</a>
               </div>
            </div>
         </div>

         <!-- Sub-Section Content -->
         @if($activeSubSection === 'leave')
         <div class="apply-section ">
            <div class="containerWidth">
               @livewire('leave-apply-page')
            </div>
         </div>
         @elseif($activeSubSection === 'restricted')
         <div class="restricted-section">
            <div class="containerWidth">
               <div class="leave-pending rounded w-100">
                  @if($resShowinfoMessage)
                  <div class="hide-info p-2 mb-2 mt-2 rounded d-flex justify-content-between align-items-center">
                     <p class="mb-0 normalTextSmall">Restricted Holidays (RH) are a set of holidays allocated by the
                        company that are optional for the employee to utilize. The company sets a limit on the
                        amount of holidays that can be used.</p>
                     <p class="mb-0 hideInfo" wire:click="toggleInfoRes">Hide</p>
                  </div>
                  @endif
                  <div class="d-flex justify-content-between">
                     <p class="applyingFor">Applying for
                        Restricted Holiday</p>
                     @if($resShowinfoButton)
                     <p class="info-paragraph" wire:click="toggleInfoRes">Info</p>
                     @endif
                  </div>
                  <img src="{{asset('/images/pending.png')}}" alt="Pending Image" class="imgContainer">
                  <p class="restrictedHoliday">You have no
                     Restricted Holiday balance, as per our record.</p>
               </div>
            </div>
         </div>
         @elseif($activeSubSection === 'leaveCancel')
         <div class="leave-cancel-section">
            <div class="containerWidth">
               @livewire('leave-cancel-page')
            </div>
         </div>
         @elseif($activeSubSection === 'compOff')
         <div class="comp-off-section">
            <div class="containerWidth">
               <div>
                  <div class="leave-pending rounded w-100">
                     @if($compOffShowinfoMessage)
                     <div class="hide-info p-2 mb-2 mt-2 rounded d-flex justify-content-between align-items-center">
                        <p class="mb-0 normalTextSmall">Compensatory Off is additional leave granted as a compensation for working overtime or on
                           an off day.</p>
                        <p class="mb-0 hideInfo" wire:click="toggleInfoCompOff">Hide</p>
                     </div>
                     @endif
                     <div class="d-flex justify-content-between">
                        <p class="applyingFor">Applying for Comp.
                           Off Grant</p>
                        @if($compOffShowinfoButton)
                        <p class="info-paragraph" wire:click="toggleInfoCompOff">Info</p>
                        @endif
                     </div>
                     <img src="{{asset('/images/pending.png')}}" alt="Pending Image" class="imgContainer">
                     <p class="restrictedHoliday">You are not
                        eligible to request for compensatory off grant. Please contact your HR for further
                        information.</p>
                  </div>
               </div>
            </div>
         </div>
         @endif
         @elseif($activeSection === 'pendingButton')
         @if ($showAlert)
         <div class="alert alert-success w-50 position-absolute m-auto p-2" wire:poll.2s="hideAlert" style="right: 25%;top:-11%;" id="success-alert">
            {{ session('cancelMessage') }}
            <button type="button" class="alert-close" data-dismiss="alert" aria-label="Close" wire:click="hideAlert">
               <span>X</span>
            </button>
         </div>
         @endif
         <div class="pending-section">
            <div id="pendingButton" class="pendingContent {{ $activeSection === 'pendingButton' ? '' : 'd-none' }} row rounded mt-3 ">
               @if(empty($combinedRequests) || $combinedRequests->isEmpty())
               <div class="containerWidth">
                  <div class="leave-pending rounded">

                     <img src="{{asset('/images/pending.png')}}" alt="Pending Image" class="imgContainer">

                     <p class="restrictedHoliday">There are no pending records of any leave
                        transaction</p>

                  </div>
               </div>
               @endif
               @if(!empty($combinedRequests))

               @foreach($combinedRequests as $leaveRequest)

               <div class="mt-4 containerWidth">

                  <div class="accordion rounded">

                     <div class="accordion-heading rounded" onclick="toggleAccordion(this)">

                        <div class="accordion-title  rounded">

                           <!-- Display leave details here based on $leaveRequest -->

                           <div class="col accordion-content">

                              <span class="accordionContentSpan">Category</span>

                              <span class="accordionContentSpanValue">{{ $leaveRequest->category_type}}</span>

                           </div>

                           <div class="col accordion-content">

                              <span class="accordionContentSpan">Leave Type</span>

                              <span class="accordionContentSpanValue">{{ $leaveRequest->leave_type}}</span>

                           </div>
                           <div class="col accordion-content">

                              <span class="accordionContentSpan">Pending with</span>
                              @php
                              $applyingToArray = json_decode($leaveRequest->applying_to, true);
                              @endphp
                              <span class="accordionContentSpanValue" title="{{ ucwords(strtolower($applyingToArray[0]['report_to'])) ?? 'No report_to available' }}">
                                 {{ ucwords(strtolower($applyingToArray[0]['report_to'])) ?? 'No report_to available' }}
                              </span>

                           </div>

                           <div class="col accordion-content" style="padding-left: 20px;">

                              <span class="accordionContentSpan">No. of Days</span>

                              <span class="accordionContentSpanValue">

                                 {{ $this->calculateNumberOfDays($leaveRequest->from_date, $leaveRequest->from_session, $leaveRequest->to_date, $leaveRequest->to_session) }}

                              </span>

                           </div>
                           <!-- Add other details based on your leave request structure -->
                           @if(($leaveRequest->category_type === 'Leave') )
                           <div class="col accordion-content">
                              <span class="accordionContentSpanValue" style="color:#cf9b17 !important;">{{ strtoupper($leaveRequest->status) }}</span>
                           </div>
                           @endif
                           <div class="arrow-btn">
                              <i class="fa fa-chevron-down"></i>
                           </div>

                        </div>

                     </div>

                     <div class="accordion-body m-0 p-0">

                        <div class="horizontalLine"></div>

                        <div class="content pt-1 px-3">

                           <span class="normalTextValue">Duration:</span>

                           <span class="normalTextValueSmall">

                              <span class="normalTextValueSmall">
                                 {{ \Carbon\Carbon::parse($leaveRequest->from_date)->format('d-m-Y') }} </span>

                              ( {{ $leaveRequest->from_session }} ) to

                              <span class="normalTextValueSmall">
                                 {{ \Carbon\Carbon::parse($leaveRequest->to_date)->format('d-m-Y') }}</span>

                              ( {{ $leaveRequest->to_session }} )

                           </span>

                        </div>

                        <div class="content pb-1 px-3">

                           <span class="normalTextValue">Reason:</span>

                           <span class="normalTextValueSmall">{{ ucfirst( $leaveRequest->reason) }}</span>

                        </div>

                        <div class="horizontalLine"></div>

                        <div class="d-flex justify-content-between align-items-center py-2 px-3">

                           <div class="content px-1">

                              <span class="normalTextValue">Applied on:</span>

                              <span class="normalText">{{ $leaveRequest->created_at->format('d M, Y') }}</span>

                           </div>

                           <div class="content d-flex gap-2 align-items-center ">

                              <a href="{{ route('leave-history', ['leaveRequestId' => $leaveRequest->id]) }}">

                                 <span class="anchorTagDetails">View
                                    Details</span>
                              </a>
                              @if($leaveRequest->category_type === 'Leave')
                              <button class="withdraw" wire:click="cancelLeave({{ $leaveRequest->id }})">Withdraw</button>
                              @else
                              <button class="withdraw" wire:click="cancelLeaveCancel({{ $leaveRequest->id }})">Withdraw</button>
                              @endif
                           </div>

                        </div>

                     </div>

                  </div>

               </div>

               @endforeach

               @endif

            </div>
         </div>
         @elseif($activeSection === 'historyButton')
         <div class="history-section">
            <div id="historyButton" class="historyContent {{ $activeSection === 'historyButton' ? '' : 'd-none;' }} row rounded mt-3">
               @if($this->leaveRequests->isNotEmpty())

               @foreach($this->leaveRequests->whereIn('status', ['approved', 'rejected','Withdrawn']) as $leaveRequest)

               <div class="containerWidth mt-4">

                  <div class="accordion rounded ">

                     <div class="accordion-heading rounded" onclick="toggleAccordion(this)">

                        <div class="accordion-title">

                           <!-- Display leave details here based on $leaveRequest -->

                           <div class="col accordion-content">

                              <span class="normalTextValue">Category</span>

                              <span class="normalText">{{ $leaveRequest->category_type}}</span>

                           </div>

                           <div class="col accordion-content">

                              <span class="normalTextValue">Leave Type</span>

                              <span class="normalText">{{ $leaveRequest->leave_type}}</span>

                           </div>

                           <div class="col accordion-content">

                              <span class="normalTextValue">No. of Days</span>

                              <span class="normalText">

                                 {{ $this->calculateNumberOfDays($leaveRequest->from_date, $leaveRequest->from_session, $leaveRequest->to_date, $leaveRequest->to_session) }}

                              </span>

                           </div>



                           <!-- Add other details based on your leave request structure -->
                           @if($leaveRequest->category_type == 'Leave Cancel')
                           <div class="col accordion-content">

                              @if(strtoupper($leaveRequest->cancel_status) == 'APPROVED')

                              <span class="approvedColor">{{ strtoupper($leaveRequest->cancel_status) }}</span>

                              @elseif(strtoupper($leaveRequest->cancel_status) == 'REJECTED')

                              <span class="rejectColor">{{ strtoupper($leaveRequest->cancel_status) }}</span>

                              @else

                              <span class="normalTextValue">{{ strtoupper($leaveRequest->cancel_status) }}</span>

                              @endif

                           </div>

                           @else
                           <div class="col accordion-content">

                              @if(strtoupper($leaveRequest->status) == 'APPROVED')

                              <span class="approvedColor">{{ strtoupper($leaveRequest->status) }}</span>

                              @elseif(strtoupper($leaveRequest->status) == 'REJECTED')

                              <span class="rejectColor">{{ strtoupper($leaveRequest->status) }}</span>

                              @else

                              <span class="normalTextValue">{{ strtoupper($leaveRequest->status) }}</span>

                              @endif

                           </div>
                           @endif

                           <div class="arrow-btn">
                              <i class="fa fa-chevron-down"></i>
                           </div>

                        </div>

                     </div>

                     <div class="accordion-body m-0 p-0">

                        <div class="verticalLine"></div>

                        <div class="content pt-1 px-3">

                           <span class="headerText">Duration:</span>

                           <span class="normalTextValueSmall">

                              <span class="normalTextValueSmall"> {{ \Carbon\Carbon::parse($leaveRequest->from_date)->format('d-m-Y') }}</span>

                              ({{ $leaveRequest->from_session }} ) to

                              <span class="normalTextValueSmall"> {{ \Carbon\Carbon::parse($leaveRequest->to_date)->format('d-m-Y') }}</span>

                              ( {{ $leaveRequest->to_session }} )

                           </span>

                        </div>

                        <div class="content  pb-1 px-3">

                           <span class="headerText">Reason:</span>

                           <span class="normalTextValueSmall">{{ ucfirst($leaveRequest->reason) }}</span>

                        </div>

                        <div class="verticalLine"></div>

                        <div class="d-flex flex-row justify-content-between px-3 py-2">

                           <div class="content px-1 ">

                              <span class="headerText">Applied on:</span>

                              <span class="paragraphContent">{{ $leaveRequest->created_at->format('d M, Y') }}</span>

                           </div>

                           <div class="content px-1 ">
                              <a href="{{ route('leave-pending', ['leaveRequestId' => $leaveRequest->id]) }}">
                                 <span class="anchorTagDetails">View
                                    Details</span>
                              </a>

                           </div>

                        </div>

                     </div>

                  </div>

               </div>



               @endforeach

               @else

               <div class="containerWidth">
                  <div class="leave-pending rounded">

                     <img src="{{asset('/images/pending.png')}}" alt="Pending Image" class="imgContainer">

                     <p class="restrictedHoliday">There are no history records of any leave
                        transaction</p>

                  </div>
               </div>

               @endif

            </div>
         </div>
         @endif
      </div>
   </div>
</div>
<script>
   function toggleAccordion(element) {
      const accordionBody = element.nextElementSibling;
      const arrowIcon = element.querySelector('.fa'); // Select the arrow icon

      if (accordionBody.style.display === 'block') {
         accordionBody.style.display = 'none';
         element.classList.remove('active'); // Remove active class
         arrowIcon.classList.remove('rotate'); // Remove rotation class
      } else {
         accordionBody.style.display = 'block';
         element.classList.add('active'); // Add active class
         arrowIcon.classList.add('rotate'); // Add rotation class
      }
   }l
</script>