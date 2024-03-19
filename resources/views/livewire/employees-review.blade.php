<div class="row p-0 m-0">
    <div class="col-md-3">
        <div class="d-flex flex-column" style="line-height:2;">
            <span style="color:#A9A9A9;font-size:13px;"  class="mt-2"  class="mt-2"  class="mt-2">ATTENDANCE</span>
            <a wire:click="showContent('Attendance Regularization')" 
               style="cursor:pointer;color:#778899; font-size:12px; {{ $currentSection === 'Attendance Regularization' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;' : '' }}">
               Attendance Regularization
            </a>
        </div>
        <div class="d-flex flex-column" style="line-height:2.2;">
            <span style="color:#A9A9A9;font-size:13px;"  class="mt-2">EMPINFO</span>
            <a wire:click="showContent('Confirmation')" 
                style="cursor:pointer;color:#778899; font-size:12px; {{ $currentSection === 'Confirmation' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;' : '' }}">
                Confirmation
            </a>
            <a wire:click="showContent('Resignations')" style="cursor:pointer;color:#778899;font-size:12px;{{ $currentSection === 'Resignations' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;' : '' }}">Resignations</a>
            <a wire:click="showContent('Helpdesk')" style="cursor:pointer;color:#778899;font-size:12px;{{ $currentSection === 'Helpdesk' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;' : '' }}">Helpdesk</a>
        </div>
        <div class="d-flex flex-column" style="line-height:2;">
        <span style="color:#A9A9A9;font-size:12px;"  class="mt-2"  class="mt-2">LEAVE</span>
            <a wire:click="showContent('Leave')" style="cursor:pointer;color:#778899;font-size:12px;{{ $currentSection === 'Leave' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;' : '' }}">Leave
                @if(($this->count) > 0)
                <span class="count-pending -leaves text-center my-0 mx-1 font-weight-500" style=" background: #FAE392; border-radius:50%;font-size:8px;color: #2f363d;padding:2px 5px;">
                {{$count}}
                </span>
                @endif
            </a>
            <a wire:click="showContent('Leave Cancel')" style="cursor:pointer;color:#778899;font-size:12px;{{ $currentSection === 'Leave Cancel' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;' : '' }}">Leave Cancel</a>
            <a wire:click="showContent('Leave Comp Off')" style="cursor:pointer;color:#778899;font-size:12px;{{ $currentSection === 'Leave Comp Off' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;' : '' }}">Leave Comp Off</a>
            <a wire:click="showContent('Restricted Holiday')" style="cursor:pointer;color:#778899;font-size:12px;{{ $currentSection === 'Restricted Holiday' ? 'border-left: 2px solid rgb(2, 17, 79); padding-left: 5px;' : '' }}">Restricted Holiday</a>
        </div>
    </div>
    <div class="col-md-9 mx-0 px-0">
        @if($currentSection === 'Attendance Regularization')
            <div class="d-flex align-items-center justify-content-center gap-5">
                <button wire:click="toggleContent('Attendance Regularization')" class="btn btn-sm btn-primary">Active</button>
               <button wire:click="toggleContent('Attendance Regularization')" class="btn btn-sm btn-danger">Closed</button>
            </div>
                <div class="mt-5">
                    @if($activeButton['Attendance Regularization'])
                      <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                        <img src="/images/pending.png" alt="Pending Image" style="width:60%; margin:0 auto;">
                        <p style="color:#969ea9; font-size:13px; font-weight:400; ">Hey, you have no regularization records to view</p>
                      </div>
                    @else
                    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                        <img src="/images/pending.png" alt="Pending Image" style="width:60%; margin:0 auto;">
                        <p style="color:#969ea9; font-size:13px; font-weight:400; ">Hey, you have no closed regularization records to view</p>
                    </div>
                    @endif
                </div>
            
        @elseif($currentSection === 'Confirmation')
        <div class="d-flex align-items-center justify-content-center gap-5 ">
            <button wire:click="toggleContent('Confirmation')" class="btn btn-sm btn-primary">Active</button>
            <button wire:click="toggleContent('Confirmation')" class="btn btn-sm btn-danger">Closed</button>
        </div>
        <div class="mt-5">
            @if($activeButton['Confirmation'])
            <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                <img src="/images/pending.png" alt="Pending Image" style="width:60%; margin:0 auto;">
                <p style="color:#969ea9; font-size:13px; font-weight:400; ">Hey, you have no  confirmation records to view</p>
            </div>
            @else
            <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                <img src="/images/pending.png" alt="Pending Image" style="width:60%; margin:0 auto;">
                <p style="color:#969ea9; font-size:13px; font-weight:400; ">Hey, you have no closed confirmation records to view</p>
            </div>
            @endif
        </div>
        @elseif($currentSection === 'Resignations')
            <div class="d-flex align-items-center justify-content-center gap-5">
                <button wire:click="toggleContent('Resignations')" class="btn btn-sm btn-primary">Active</button>
               <button wire:click="toggleContent('Resignations')" class="btn btn-sm btn-danger">Closed</button>
            </div>
                <div class="mt-5">
                    @if($activeButton['Resignations'])
                      <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                        <img src="/images/pending.png" alt="Pending Image" style="width:60%; margin:0 auto;">
                        <p style="color:#969ea9; font-size:13px; font-weight:400; ">Hey, you have no Resignations records to view</p>
                      </div>
                    @else
                    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                        <img src="/images/pending.png" alt="Pending Image" style="width:60%; margin:0 auto;">
                        <p style="color:#969ea9; font-size:13px; font-weight:400; ">Hey, you have no closed Resignations records to view</p>
                    </div>
                    @endif
                </div>
        @elseif($currentSection === 'Helpdesk')
        <div class="d-flex align-items-center justify-content-center gap-5">
                <button wire:click="toggleContent('Helpdesk')" class="btn btn-sm btn-primary">Active</button>
               <button wire:click="toggleContent('Helpdesk')" class="btn btn-sm btn-danger">Closed</button>
            </div>
                <div class="mt-5">
                    @if($activeButton['Helpdesk'])
                      <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                        <img src="/images/pending.png" alt="Pending Image" style="width:60%; margin:0 auto;">
                        <p style="color:#969ea9; font-size:13px; font-weight:400; ">Hey, you have no Helpdesk records to view</p>
                      </div>
                    @else
                    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                        <img src="/images/pending.png" alt="Pending Image" style="width:60%; margin:0 auto;">
                        <p style="color:#969ea9; font-size:13px; font-weight:400; ">Hey, you have no closed Helpdesk records to view</p>
                    </div>

                    @endif
                </div>
        @elseif($currentSection === 'Leave')
        <div class="d-flex align-items-center justify-content-center gap-5 ">
            <button wire:click="toggleContent('Leave')" class="btn btn-sm btn-primary">Active</button>
            <button wire:click="toggleContent('Leave')" class="btn btn-sm btn-danger">Closed</button>
        </div>
        <div class="mt-5">
            @if($activeButton['Leave'])
            <div class="pending-leaves-container"  style="width:100%; max-height:400px; overflow-y:auto; margin-top:10px;"  >
                @if($this->leaveApplications)
                     <div class="reviewList"  >
                        @livewire('view-pending-details')
                    </div>
                 @else
                <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                    <img src="/images/pending.png" alt="Pending Image" style="width:60%; margin:0 auto;">
                    <p style="color:#969ea9; font-size:13px; font-weight:400; ">Hey, you have no  leave records to view</p>
                </div>
                @endif
            </div>
            @else
            <div class="closed-leaves-container" style="width:100%; max-height:400px; overflow-y:auto; margin-top:10px;" >
                       @if(!empty($approvedLeaveApplicationsList))
                       @foreach($approvedLeaveApplicationsList as $leaveRequest)
                                <div class="accordion rounded mb-3">
                                    <div class="accordion-heading rounded p-3" onclick="toggleAccordion(this)">
                                        <div class="accordion-head rounded d-flex justify-content-between m-auto " >
                                            <!-- Display leave details here based on $leaveRequest -->
                                            <thead>
                                                <tr>
                                                    <td colspan="4"> <!-- Assuming you have 4 columns -->
                                                        <div class="accordion-content">
                                                            <div class="accordion-profile" style="display:flex; gap:7px; margin:auto 0;align-items:center;justify-content:center;">
                                                                @if(isset($leaveRequest['approvedLeaveRequest']->image))
                                                                    <img src="{{ $leaveRequest['approvedLeaveRequest']->image }}" alt="User Profile Image" style="width: 40px; height: 40px; border-radius: 50%;">
                                                                @else
                                                                    <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars.png" alt="Default User Image" style="width: 45px; height: 45px; border-radius: 50%;">
                                                                @endif
                                                                <div>
                                                                    @if(isset($leaveRequest['approvedLeaveRequest']->first_name))
                                                                        <p style="font-size: 12px; font-weight: 500; text-align: center;margin: auto;">
                                                                            {{ $leaveRequest['approvedLeaveRequest']->first_name }}  {{ $leaveRequest['approvedLeaveRequest']->last_name }} <br>
                                                                            @if(isset($leaveRequest['approvedLeaveRequest']->emp_id))
                                                                                <span style="color: #778899; font-size: 10px; text-align: start;">
                                                                                    #{{ $leaveRequest['approvedLeaveRequest']->emp_id }}
                                                                                </span>
                                                                            @endif
                                                                        </p>
                                                                    @else
                                                                        <p style="font-size: 12px; font-weight: 500; text-align: center;">Name Not Available</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"> <!-- Assuming you have 4 columns -->
                                                        <div class="accordion-content">
                                                            <span style="color: #778899; font-size: 12px; font-weight: 500;">Leave Type</span>
                                                            <span style="color: #36454F; font-size: 12px; font-weight: 500;">{{$leaveRequest['approvedLeaveRequest']->leave_type}}</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"> <!-- Assuming you have 4 columns -->
                                                        <div class="accordion-content">
                                                            <span style="color: #778899; font-size:12px; font-weight: 500;">No. of Days</span>
                                                            <span style="color: #36454F; font-size:12px; font-weight: 500;">
                                                                {{ $this->calculateNumberOfDays($leaveRequest['approvedLeaveRequest']->from_date, $leaveRequest['approvedLeaveRequest']->from_session, $leaveRequest['approvedLeaveRequest']->to_date, $leaveRequest['approvedLeaveRequest']->to_session) }}
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"> <!-- Assuming you have 4 columns -->
                                                        <div class="accordion-content">
                                                            @if(strtoupper($leaveRequest['approvedLeaveRequest']->status) == 'APPROVED')
                                                                <span style=" font-size: 12px; font-weight: 500; color:#32CD32;">{{ strtoupper($leaveRequest['approvedLeaveRequest']->status) }}</span>
                                                            @elseif(strtoupper($leaveRequest['approvedLeaveRequest']->status) == 'REJECTED')
                                                                <span style=" font-size: 12px; font-weight: 500; color:#FF0000;">{{ strtoupper($leaveRequest['approvedLeaveRequest']->status) }}</span>
                                                            @else
                                                                <span style=" font-size: 12px; font-weight: 500; color:#778899;">{{ strtoupper($leaveRequest['approvedLeaveRequest']->status) }}</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"> <!-- Assuming you have 4 columns -->
                                                        <div class="arrow-btn">
                                                            <i class="fa fa-angle-down"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </thead>


                                            </div>

                                        </div>

                                        <div class="accordion-body m-0 p-0" >

                                            <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:5px;"></div>

                                            <div class="review-content" style="display: flex;justify-content:start;align-items: center;gap:7px;padding:5px;margin-bottom: 3px;">

                                                <span style="color: #778899; font-size: 12px; font-weight: 500;">Duration:</span>

                                                <span style="font-size: 12px;">

                                                <span style="font-size: 12px; font-weight: 500;">{{ $leaveRequest['approvedLeaveRequest']->formatted_from_date }}</span>

                                                ({{ $leaveRequest['approvedLeaveRequest']->from_session }} ) to

                                                <span style="font-size: 12px; font-weight: 500;">{{ $leaveRequest['approvedLeaveRequest']->formatted_to_date }}</span>

                                            ( {{ $leaveRequest['approvedLeaveRequest']->to_session }} )

                                                </span>

                                            </div>

                                            <div class="review-content" style="display: flex;justify-content:start;align-items: center;gap:7px;padding:5px;margin-bottom: 3px;">

                                                <span style="color: #778899; font-size: 12px; font-weight: 500;">Reason:</span>

                                                <span style="font-size: 12px;">{{ucfirst( $leaveRequest['approvedLeaveRequest']->reason) }}</span>

                                            </div>

                                            <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>

                                            <div style="display:flex; flex-direction:row; justify-content:space-between;">

                                                <div class="review-content" style="display: flex;justify-content:start;align-items: center;gap:7px;padding:5px;margin-bottom: 3px;">

                                                    <span style="color: #778899; font-size: 12px; font-weight: 400;">Applied on:</span>

                                                <span style="color: #333; font-size: 11px; font-weight: 500;">{{ $leaveRequest['approvedLeaveRequest']->created_at->format('d M, Y') }}</span>

                                            </div>
                                            <div class="review-content" style="display: flex;justify-content:start;align-items: center;gap:7px;padding:5px;margin-bottom: 3px;">
                                                <span style="color: #778899; font-size: 12px; font-weight: 500;">Leave Balance:</span>
                                                @if(!empty($leaveRequest['leaveBalances']))
                                                        <div style=" flex-direction:row; display: flex; align-items: center;justify-content:center;">
                                                        <!-- Sick Leave -->
                                                            <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #e6e6fa; display: flex; align-items: center; justify-content: center; margin-left:15px;">
                                                                <span style="font-size: 10px; color: #50327c;font-weight:500;">SL</span>
                                                        </div>
                                                            <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['sickLeaveBalance'] }}</span>
                                                        <!-- Casual Leave -->
                                                        <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #e7fae7; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                                                <span style="font-size: 10px; color: #1d421e;font-weight:500;">CL</span>
                                                        </div>
                                                            <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['casualLeaveBalance'] }}</span>
                                                        <!-- Loss of Pay -->
                                                        <div style="width: 20px; height: 20px; border-radius: 50%; background-color: #ffebeb; display: flex; align-items: center; justify-content: center; margin-left: 15px;">
                                                                <span style="font-size: 10px; color: #890000;font-weight:500;">LP</span>
                                                        </div>
                                                            <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">{{ $leaveRequest['leaveBalances']['lossOfPayBalance'] }}</span>
                                                    </div>
                                                    @else
                                                    <span style="font-size: 12px; font-weight: 500; color: #333; margin-left: 5px;">0</span>
                                                @endif
                                            </div>
                            
                                                <div class="review-content" style="display: flex;justify-content:start;align-items: center;gap:7px;padding:5px;margin-bottom: 3px;">

                                                    <a href="{{ route('approved-details', ['leaveRequestId' => $leaveRequest['approvedLeaveRequest']->id]) }}">
                                                        <span style="color: #3a9efd; font-size: 11px; font-weight: 500;">View Details</span>
                                                    </a>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                    @endforeach

                                </div>
                           

                        @else
                        <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                            <img src="/images/pending.png" alt="Pending Image" style="width:60%; margin:0 auto;">
                            <p style="color:#969ea9; font-size:13px; font-weight:400; ">Hey, you have no closed leave records to view</p>
                        </div>
                        @endif
                    </div>
            @endif
        </div>
        @elseif($currentSection === 'Leave Cancel')
        <div class="d-flex align-items-center justify-content-center gap-5">
                <button wire:click="toggleContent('Leave Cancel')" class="btn btn-sm btn-primary">Active</button>
               <button wire:click="toggleContent('Leave Cancel')" class="btn btn-sm btn-danger">Closed</button>
            </div>
                <div class="mt-5">
                    @if($activeButton['Leave Cancel'])
                      <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                        <img src="/images/pending.png" alt="Pending Image" style="width:60%; margin:0 auto;">
                        <p style="color:#969ea9; font-size:13px; font-weight:400; ">Hey, you have no Leave Cancel records to view</p>
                      </div>
                    @else
                    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                        <img src="/images/pending.png" alt="Pending Image" style="width:60%; margin:0 auto;">
                        <p style="color:#969ea9; font-size:13px; font-weight:400; ">Hey, you have no closed Leave Cancel records to view</p>
                    </div>
                    @endif
                </div>
        @elseif($currentSection === 'Leave Comp Off')
        <div class="d-flex align-items-center justify-content-center gap-5">
                <button wire:click="toggleContent('Leave Comp Off')" class="btn btn-sm btn-primary">Active</button>
               <button wire:click="toggleContent('Leave Comp Off')" class="btn btn-sm btn-danger">Closed</button>
            </div>
                <div class="mt-5">
                    @if($activeButton['Leave Comp Off'])
                      <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                        <img src="/images/pending.png" alt="Pending Image" style="width:60%; margin:0 auto;">
                        <p style="color:#969ea9; font-size:13px; font-weight:400; ">Hey, you have no Leave Comp Off records to view</p>
                      </div>
                    @else
                    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                        <img src="/images/pending.png" alt="Pending Image" style="width:60%; margin:0 auto;">
                        <p style="color:#969ea9; font-size:13px; font-weight:400; ">Hey, you have no closed Leave Comp Off records to view</p>
                    </div>
                    @endif
                </div>
        @elseif($currentSection === 'Restricted Holiday')
        <div class="d-flex align-items-center justify-content-center gap-5">
                <button wire:click="toggleContent('Restricted Holiday')" class="btn btn-sm btn-primary">Active</button>
               <button wire:click="toggleContent('Restricted Holiday')" class="btn btn-sm btn-danger">Closed</button>
            </div>
                <div class="mt-5">
                    @if($activeButton['Restricted Holiday'])
                      <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                        <img src="/images/pending.png" alt="Pending Image" style="width:60%; margin:0 auto;">
                        <p style="color:#969ea9; font-size:13px; font-weight:400; ">Hey, you have no Restricted Holiday records to view</p>
                      </div>
                    @else
                    <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                        <img src="/images/pending.png" alt="Pending Image" style="width:60%; margin:0 auto;">
                        <p style="color:#969ea9; font-size:13px; font-weight:400; ">Hey, you have no closed Restricted Holiday records to view</p>
                    </div>
                    @endif
                </div>
        @endif
    </div>
</div>
<script>
        function toggleAccordion(element) {

const accordionBody = element.nextElementSibling;

if (accordionBody.style.display === 'block') {

    accordionBody.style.display = 'none';

    element.classList.remove('active'); // Remove active class

} else {

    accordionBody.style.display = 'block';

    element.classList.add('active'); // Add active class

}
}
</script>
