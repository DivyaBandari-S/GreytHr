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
            <div
                style="transition: left 0.3s ease-in-out; position: absolute; bottom: 0; left: {{ $tab === 'Letters List' ? '0' : '15%' }}; width: 15%; height: 3px; background-color: rgb(2, 17, 79); text-align: start;border-radius :5px;">
            </div>
        </div>

        <div class="row mt-4" style="background-color: white; border-radius: 5px; height: auto;">
            @if ($tab == 'Letters List')
                <div class="row" style="">
                    <div class="col-md-3">
                        <div class="mb-2" style="margin-top: 5px;">
                            <div>JUMP TO</div>
                        </div>
                        <button wire:click="$set('jumpToTab', 'Confirmation Letter')"
                            class="jump-to {{ $jumpToTab === 'Confirmation Letter' ? 'active' : '' }}">Confirmation
                            Letter</button>
                        <button wire:click="$set('jumpToTab', 'Appointment Order')"
                            class="jump-to {{ $jumpToTab === 'Appointment Order' ? 'active' : '' }}">Appointment
                            Order</button>
                    </div>
                    <div class="col-md-9">
                        <div class="row mt-3 mb-3"
                            style="background-color: #f2f2f2; border-radius:5px; width:100%; box-shadow: {{ $jumpToTab === 'Confirmation Letter' ? '0 0 10px rgba(2,17,70,0.5)' : 'none' }}; overflow: hidden; cursor: pointer;">

                            <h6 style="font-size: 0.9rem; margin-top:5px">
                                <div>Confirmation Letter</div>
                            </h6>

                            <hr
                                style="background-color: black; border-color: black; width: 100%; border-radius:5px; margin:0">

                            @if ($hasConfirmationLetter)
                                <div class="row mt-2 mb-2 confirmation-letter" wire:click="toggleDetails">
                                    <div class="col-md-4">
                                        <div class="test mt-0">Confirmation Letter</div>
                                        <div style="color: gray;font-size:10px">Confirmation Letter</div>
                                    </div>
                                    <div class="col-md-8" style="color: gray; text-align:end; font-size:10px">
                                        Last updated on {{ $confirmationLastUpdated }}
                                    </div>
                                    @if ($showDetails)
                                        <div class="mt-2 mb-2 d-flex justify-content-around"
                                            style="background-color: white; padding: 8px; border-radius: 5px; border: 1px solid #ddd; width: 235px; margin: 10px;">
                                            <div class="d-flex"> <i class="fas fa-file-pdf"
                                                    style="margin-top: 5px;"></i> Confirmation ....pdf</div>

                                            <a wire:click="downloadLetter({{ $confirmationLetter['id'] }})">
                                                <i class="fas fa-download"></i>
                                            </a>

                                            <i class="fas fa-eye" style="margin-top: 5px;"
                                                wire:click="viewLetter({{ $confirmationLetter['id'] }})"></i>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center text-danger mt-2 mb-2">No data found</div>
                            @endif
                        </div>


                        <div class="row mt-3 mb-3"
                            style="background-color: #f2f2f2; border-radius:5px; width:100%; box-shadow: {{ $jumpToTab === 'Appointment Order' ? '0 0 10px rgba(2,17,70,0.5)' : 'none' }}; overflow: hidden; cursor: pointer;">

                            <h6 style="font-size: 0.9rem; margin-top:5px">
                                <div>Appointment Order</div>
                            </h6>

                            <hr
                                style="background-color: black; border-color: black; width: 100%; border-radius:5px; margin:0">

                            @if ($hasAppointmentOrder)
                                <div class="row mt-2 mb-2 appointment-order" wire:click="toggleDetails">
                                    <div class="col-md-4">
                                        <div class="test mt-0">Appointment Order</div>
                                        <div style="color: gray;font-size:10px">Appointment Order</div>
                                    </div>
                                    <div class="col-md-8" style="color: gray; text-align:end; font-size:10px">
                                        Last updated on {{ $lastUpdated }}
                                    </div>
                                    @if ($showDetails)
                                        <div class="mt-2 mb-2 d-flex justify-content-around"
                                            style="background-color: white; padding: 8px; border-radius: 5px; border: 1px solid #ddd; width: 235px; margin: 10px;">
                                            <div class="d-flex"> <i class="fas fa-file-pdf"
                                                    style="margin-top: 5px;"></i> Appointment ....pdf</div>




                                            <a wire:click="downloadLetter({{ $appointmentOrder['id'] }})">
                                                <i class="fas fa-download"></i>
                                            </a>

                                            <i class="fas fa-eye"
                                                wire:click="viewLetter({{ $appointmentOrder['id'] }})"
                                                data-bs-toggle="modal" data-bs-target="#letterModal"
                                                style="margin-top: 5px;"></i>



                                        </div>
                                    @endif
                                @else
                                    <div class="text-center text-danger mt-2 mb-2">No data found</div>
                            @endif
                        </div>

                        <!-- Modal Popup -->
@if ($showLetterModal)
@php
 
 $preparedBy = Auth::user()->emp_id;
 $employee = App\Models\EmployeeDetails::where('emp_id', $preparedBy)->first();


@endphp

<div class="modal fade show d-block" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $letter->template_name ?? 'Letter' }}</h5>
                <button type="button" class="btn-close" wire:click="closeLetterModal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 400px; height: 400px; overflow-y: scroll;">
                <div class="header1" style="text-align: center;">
                    <p>Xsilica Software Solutions Pvt. Ltd.</p>
                    <p>Unit No - 4, Kapil Kavuri Hub, 3rd floor, Nanakramguda, 
                        Serilingampally, Ranga Reddy, Telangana-500032.</p>
                </div>
            
                <p>{{ now()->format('d M Y') }}</p>
            
                <p>To,<br>
                    {{ $employeeName }}<br>  <!-- Accessing name from decoded array -->
                    Employee ID: {{ $employeeId}}<br>  <!-- Accessing id -->
                    {{ $employeeAddress }}
                </p>
                @if ($letter->template_name == 'Appointment Order')
                <p class="text-align-center" style="font-size: 16px;"> <strong>Sub: Appointment Order</strong></p>
                <p><strong>Dear</strong> {{ $employeeName }},</p>
                <p>We are pleased to offer you the position of <strong>Software Engineer I</strong> at Xsilica Software Solutions Pvt. Ltd., as per the discussion we had with you. Below are the details of your appointment:</p>
                <p><strong>1. Start Date:</strong> 02 Jan 2023 (Your appointment will be considered withdrawn if you do not report to our office on this date.)</p>
                <p><strong>2. Compensation:</strong> Your Annual Gross Compensation is Rs. <strong>{{ number_format($letter->ctc) }}/-</strong> (subject to statutory deductions).</p>
                <p><strong>3. Probation Period:</strong> You will be under probation for six calendar months from your date of joining.</p>
                <p><strong>4. Confirmation of Employment:</strong> Upon successful completion of probation, you will be confirmed in employment.</p>
                <p><strong>5. Performance Reviews:</strong> You will undergo annual performance reviews and appraisals.</p>
                <p><strong>6. Absence from Duty:</strong> Unauthorized absence for 8 consecutive days will lead to termination of service.</p>
                <p><strong>7. Leave Policy:</strong> You are entitled to leave as per law and company policy, including one sick leave per month.</p>
                <p><strong>8. Confidentiality:</strong> Any products or materials developed during your employment will remain the property of Xsilica.</p>
                <p><strong>9. Termination of Employment:</strong> Voluntary resignation requires a 60-day notice period. Immediate termination can occur for consistent underperformance or providing incorrect information.</p>
                <p><strong>We are excited to have you as a part of our team and look forward to your contribution!</strong></p>
                <p>Thank you.</p>
        
            @elseif ($letter->template_name == 'Confirmation Letter')
                <p class="text-align-center" style="font-size: 16px;"> <strong>Sub: Confirmation Letter</strong></p>
                <p><strong>Dear</strong> {{ $employeeName }},</p>
                <p>Further to your appointment/joining dated <strong>{{ \Carbon\Carbon::parse($employee->hire_date)->format('d M Y') }}
                </strong>, your employment with us is confirmed with effect from <strong>{{ now()->format('d M Y') }}</strong>.</p>
                <p>All the terms mentioned in the Offer/Appointment letter will remain unaltered.</p>
                <p>We thank you for your contribution so far and hope that you will continue to perform equally well in the future.</p>
                <p><strong>We wish you the best of luck!</strong></p>
                <p>Thank you.</p>
            @else
                <p>Invalid template selected.</p>
            @endif
        
            <div class="signature">
                <p>Yours faithfully,</p>
                <p>For <strong>Xsilica Software Solutions Pvt. Ltd.</strong></p>
                <p><strong>{{ $fullName }}</strong></p>
                <img src="data:image/jpeg;base64,{{ $signature }}" alt="Signature" style="width:150px; height:auto;">
                <p><strong>{{ $designation }}</strong></p>
            </div>
            <div class="cc">
                <p><strong>Cc:</strong> Reporting Manager, Personal File</p>
            </div>
                {{-- @if ($letter->template_name == 'Appointment Order')
                    <div class="container">
                        <div class="header" style="text-align: center;">
                            <p>Xsilica Software Solutions Pvt. Ltd.</p>
                            <p>Unit No - 4, Kapil Kavuri Hub, 3rd floor, Nanakramguda, <br>
                            Serilingampally, Ranga Reddy, Telangana-500032.</p>
                        </div>
                        <p style="text-align: left;">{{ now()->format('d M Y') }}</p>
                        <p>To,<br>{{ $employeeName }}<br>
                            Employee ID: {{ $employeeId }}<br>{{ $employeeAddress }}</p>
                        <p class="text-center"><strong>Sub: Appointment Order</strong></p>
                        <p><strong>Dear</strong> {{ $employeeName }},</p>
                        <p>We are pleased to offer you the position of <strong>Software Engineer I</strong> at Xsilica Software Solutions Pvt. Ltd., as per the discussion we had with you. Below are the details of your appointment:</p>
                        <ul>
                            <li><strong>1. Start Date:</strong> 02 Jan 2023</li>
                            <li><strong>2. Compensation:</strong> Rs. 2,40,000/-</li>
                            <li><strong>3. Probation Period:</strong> Six calendar months from your joining date.</li>
                            <li><strong>4. Confirmation of Employment:</strong> After probation.</li>
                        </ul>
                        <p><strong>We are excited to have you as a part of our team!</strong></p>
                        <div class="signature">
                            <p>Yours faithfully,</p>
                            <p>For <strong>Xsilica Software Solutions Pvt. Ltd.</strong></p>
                            <p style="font-size: 12px;"><strong>{{ $fullName }}</strong></p>
                            @if ($signature)
                                <img src="data:image/jpeg;base64,{{ $signature }}" alt="Signature" style="width:150px; height:auto;">
                            @endif
                            <p style="font-size: 12px;"><strong>{{ $designation }}</strong></p>
                        </div>
                    </div>
                @elseif ($letter->template_name == 'Confirmation Letter')
               
                    <div class="container">
                        <div class="header1" style="text-align: center;">
                            <p>Xsilica Software Solutions Pvt. Ltd.</p>
                            <p>Unit No - 4, Kapil Kavuri Hub, 3rd floor, Nanakramguda, <br>
                            Serilingampally, Ranga Reddy, Telangana-500032.</p>
                        </div>
                        <p style="text-align: left;">{{ now()->format('d M Y') }}</p>
                        <p>To,<br>{{ $employeeName }}<br>
                            Employee ID: {{ $employeeId }}<br>{{ $employeeAddress }}</p>
                        <p class="text-center"><strong>Sub: Confirmation Letter</strong></p>
                        <p><strong>Dear</strong> {{ $employeeName }},</p>
                        <p>Your employment with us is confirmed effective from <strong>{{ now()->format('d M Y') }}</strong>.</p>
                        <div class="signature">
                            <p>Yours faithfully,</p>
                            <p>For <strong>Xsilica Software Solutions Pvt. Ltd.</strong></p>
                            <p style="font-size: 12px;"><strong>{{ $fullName }}</strong></p>
                            @if ($signature)
                                <img src="data:image/jpeg;base64,{{ $signature }}" alt="Signature" style="width:150px; height:auto;">
                            @endif
                            <p style="font-size: 12px;"><strong>{{ $designation }}</strong></p>
                        </div>
                    </div>
                @else
                    <p>Invalid template selected.</p>
                @endif --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeLetterModal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif



                    </div>

                </div>
        </div>
        @endif
    </div>
    @if ($tab == 'Request Letter')
        <div class="nav-buttons mt-2 mb-3 d-flex justify-content-center">
            <ul class="nav custom-nav-tabs border">
                <li class="custom-item m-0 p-0 flex-grow-1 mbl-dev-active">
                    <div class="reviewActiveButtons custom-nav-link {{ $activeTab === 'Apply' ? 'active' : '' }} "
                        wire:click="$set('activeTab', 'Apply')">Apply</div>
                </li>
                <li class="pendingCustomStyles custom-item m-0 p-0 flex-grow-1">
                    <a href="#" class="custom-nav-link {{ $activeTab === 'Pending' ? 'active' : '' }}"
                        wire:click="$set('activeTab', 'Pending')">Pending</a>
                </li>
                <li class="custom-item m-0 p-0 flex-grow-1 mbl-dev-closed">
                    <a href="#"
                        class="reviewClosedButtons custom-nav-link {{ $activeTab === 'History' ? 'active' : '' }}"
                        wire:click="$set('activeTab', 'History')">History</a>
                </li>
            </ul>
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
            @if ($activeTab == 'Apply')
                <div class="row">
                    <div><strong>New Request</strong></div>
                    <div style="color: gray;margin-top:5px">Looks like you did not find the letter you were looking
                        for. You can request a new one here.</div>
                </div>

                <div class="row" style="margin-top:15px;">
                    <div class="col-md-6">
                        <form>
                            <div class="form-group mb-3 row">
                                <label for="letter_type" class="col-sm-4 col-form-label">Letter Type</label>
                                <div class="col-sm-8">
                                    <select wire:model="letter_type" wire:change="validateField('letter_type')"
                                        style="font-size: 12px;" class="form-control" id="letter_type"
                                        name="letter_type">
                                        <option value="">Select Type</option>
                                        <option value="Confirmation Letter">Confirmation Letter</option>
                                        <option value="Appointment Order">Appointment Order</option>
                                        <option value="Offer Letter">Offer Letter</option>
                                    </select>
                                    @error('letter_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <label for="priority" class="col-sm-4 col-form-label">Priority</label>
                                <div class="col-sm-8">
                                    <select wire:model="priority" wire:change="validateField('priority')"
                                        style="font-size: 12px;" class="form-control" id="priority"
                                        name="priority">
                                        <option value="">Select Priority</option>
                                        <option value="Low">Low</option>
                                        <option value="Medium">Medium</option>
                                        <option value="High">High</option>
                                    </select>
                                    @error('priority')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <label for="reason" class="col-sm-4 col-form-label">Reason</label>
                                <div class="col-sm-8">
                                    <textarea wire:model="reason" wire:keydown.debounce.500ms="validateField('reason')" style="font-size: 12px;"
                                        placeholder="Enter reason" class="form-control" id="reason" name="reason" rows="3"></textarea>
                                    @error('reason')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div style="text-align: center;">
                                <button class="submit-btn mt-2" type="button"
                                    wire:click="submitRequest">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <img style="width: 450px;"
                            src="https://proofed.com/wp-content/webp-express/webp-images/uploads/2023/07/28-Graphic-Funding-Request-Letter-Template.png.webp"
                            alt="">
                    </div>
                </div>
            @endif
            @if ($activeTab == 'Pending')
                <div class="row">
                    <div class="table-responsive">
                        <table class="table-start">
                            <thead class="table-header">
                                <tr style="background-color: rgb(2,17,79);color:white;padding:8px">
                                    <th style="padding: 8px;width:20%;">Employee ID</th>
                                    <th style="width:20%;">Letter Type</th>
                                    <th style="width:20%;">Priority</th>
                                    <th style="width:20%;">Reason</th>
                                    <th style="width:20%;">Status</th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                @forelse ($allRequests->where('status', 5) as $request)
                                    <tr>
                                        <td style="width:20%;">{{ $request->emp_id }}</td>
                                        <td style="width:20%;">{{ $request->letter_type }}</td>
                                        <td style="width:20%;">{{ $request->priority }}</td>
                                        <td style="width:20%;"> {{ ucfirst($request->reason) }}</td>
                                        <td style="width:20%;">Pending</td>
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
            @if ($activeTab == 'History')
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
                                        <td>{{ $request->emp_id }}</td>
                                        <td>{{ $request->letter_type }}</td>
                                        <td>{{ $request->priority }}</td>
                                        <td>{{ ucfirst($request->reason) }}</td>
                                        <td>Closed</td>
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
