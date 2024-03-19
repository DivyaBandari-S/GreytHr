<div>

    <div class="container-11" style="background-color: #02134F; color: white; padding:2px;height:53px">

        <div style="display: flex; align-items: start; justify-content: start;">
            <img src="{{$hrDetails->company_logo}}" alt="Logo" style="width: 200px; height: 50px; margin-right: 10px;">
            <h1 style="font-size: 20px; margin-left:25%;margin-top:10px">HR - {{$hrDetails->hr_name}}</h1>

            <div style="margin-left:25%;">
                <button style="margin-bottom: 10px;" class="logout" style="text-align:end" wire:click="logout"> <i class="fas fa-sign-out-alt"></i> Logout</button>
            </div>
        </div>
    </div>
    <div style="margin-top:5px;margin-bottom:5px">
        <button style="width: 100px; border-radius: 5px; background-color: rgb(2, 17, 79); color: white;margin-left:43%"><a href="/PostJobs" style="text-decoration: none;color:white">Post Jobs</a></button>
        <button style="width:200px; border-radius: 5px; background-color: rgb(2, 17, 79); color: white;"><a href="/VendorsSubmittedCVs" style="text-decoration: none;color:white">Vendors Submitted CVs</a></button>
        <button style="width:200px; border-radius: 5px; background-color: rgb(2, 17, 79); color: white;"><a href="/empregister" style="text-decoration: none;color:white">Employee Register</a></button>
        <button style="width:200px; border-radius: 5px; background-color: rgb(2, 17, 79); color: white;"><a href="/emplist" style="text-decoration: none;color:white">Employees List</a></button>
    </div>

    @if($showSuccessMessage)
    <div class="alert alert-success" id="success-message">
        Job application has been successfully shortlisted!
        <button class="close-message" wire:click="dismissMessage">×</button>
    </div>
    @elseif($showSuccessMessageForOL)
    <div class="alert alert-success" id="success-message">
        🎉 Offer letter sent successfully!
        <button class="close-message" wire:click="dismissMessageForOL">×</button>
    </div>
    @elseif ($errors->has('duplicate'))
    <div class="alert alert-danger" id="error-message">
        {{ $errors->first('duplicate') }}
        <button class="close" wire:click="dismissError">×</button>
    </div>
    @elseif($showExaminationMessage)
    <div style="text-align: center;" class="alert alert-success" id="success-exam-message">
        The examination link has been successfully sent!
        <button class="close-exam-message" wire:click="dismissExamMessage">×</button>
    </div>
    @endif
    <div class="job-seekers-applied-jobs">
        <h5 class="text-2xl font-semibold mb-4" style="text-align: center;">Job Seekers Applied Jobs</h5>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Jobseeker ID</th>
                    <th>Full Name</th>
                    <th>Job ID</th>
                    <th>Job Title</th>
                    <th>Company Name</th>
                    <th>CV</th>
                    <th>Applied Date</th>
                    <th>Expiry Date</th>
                    <th>Application Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appliedJobs as $appliedJob)
                <tr>
                    <td>{{ $appliedJob->user->user_id }}</td>
                    <td>{{ ucwords($appliedJob->user->full_name) }}</td>
                    <td>{{ $appliedJob->job_id }}</td>
                    <td>{{ $appliedJob->job_title }}</td>
                    <td>{{ $appliedJob->company_name }}</td>
                    <td style="max-width: 150px;">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <a href="{{ asset('storage/' . $appliedJob->user->resume) }}" target="_blank">
                                        <button class="preview-button">Preview CV</button>
                                    </a>
                                </div>
                                <div class="col">
                                    <button class="download-button" wire:click="downloadResumeHTML('{{ $appliedJob->user->resume }}')">Download CV</button>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td> {{ date('d-M-Y', strtotime($appliedJob->created_at)) }}</td>
                    <td> {{ date('d-M-Y', strtotime($appliedJob->job->expire_date)) }}</td>
                    <td>
                        @if($appliedJob->application_status == "Shortlisted")
                        <button class="status" style="background-color: lightgreen;color:white;width:90px;margin-bottom:5px" disabled>Shortlist</button>
                        <button wire:click="openExamPopUp('{{$appliedJob->job_id}}')" class="status" style="background-color:  blue;color:white;width:90px">Examination</button> <br>
                        <button wire:click="openInterview('{{$appliedJob->job_id}}')" class="status" style="background-color:  grey;color:white;width:90px;margin-bottom:5px">Interview</button>
                        @else
                        <button wire:click="open('{{$appliedJob->id}}')" class="status" style="background-color: green;color:white;width:90px">Shortlist</button>
                        @endif
                        @if($appliedJob->application_status=="Rejected")
                        <button class="status" style="background-color:  #FF9999;color:white;width:90px" disabled>Reject</button>
                        @else
                        <button wire:click="reject('{{$appliedJob->id}}')" class="status" style="background-color: red;color:white;width:90px">Reject</button> <br>
                        @if($appliedJob->application_status=="Shortlisted")
                        <button wire:click="showOL('{{$appliedJob->id}}')" style="background-color: rgb(2, 17, 79);color:white;border:none;border-radius:5px">Offer Letter</button>
                        @endif
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>






        @if($isOpen=="true")
        <div class="modal" tabindex="-1" role="dialog" style="display: block;overflow-y:auto">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                        <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b>Add Interview Details</b></h5>
                        <button style="border: none;" type="button" wire:click="close">
                            <span aria-hidden="true" style="color: black;">×</span>
                        </button>
                    </div>
                    <div style="padding: 5px;">
                        <label style="font-size: 12px;" for="date">Date:</label>
                        <input style="font-size: 12px;" class="input-fields" wire:model="date" type="date" id="date" name="date"><br>
                        @error('date') <span class="text-danger">{{ $message }}</span> @enderror <br>

                        <label style="font-size: 12px;" for="time">Time:</label>
                        <input style="font-size: 12px;" class="input-fields" wire:model="time" type="time" id="time" name="time"><br>
                        @error('time') <span class="text-danger">{{ $message }}</span> @enderror <br>

                        <label style="font-size: 12px;" for="location">Location Link:</label>
                        <input style="font-size: 12px;" class="input-fields" wire:model="location_link" type="text" id="location" name="location"><br>
                        @error('location_link') <span class="text-danger">{{ $message }}</span> @enderror <br>

                        <label style="font-size: 12px;" for="instructions">Instructions:</label>
                        <input style="font-size: 12px;" class="input-fields" wire:model="instructions" type="text" id="instructions" name="instructions"><br>
                        @error('instructions') <span class="text-danger">{{ $message }}</span> @enderror <br>

                        <label style="font-size: 12px;" for="companyWebsite">Company Website:</label>
                        <input style="font-size: 12px;" class="input-fields" wire:model="company_website" type="text" id="companyWebsite" name="companyWebsite"><br>
                        @error('company_website') <span class="text-danger">{{ $message }}</span> @enderror <br>

                        <div class="row" style="text-align: center">
                            <div class="col">
                                <button type="button" wire:click="submit" style="background-color: blue;color:white;border:none;border-radius:5px">
                                    Send
                                </button>
                            </div>
                            <div class="col">
                                <button type="button" wire:click="close" style="background-color: red;color:white;border:none;border-radius:5px">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($ol=="true")
    <!-- resources/views/livewire/send-email.blade.php -->
    <div class="modal" tabindex="-1" role="dialog" style="display: block;overflow-y:auto">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                    <h6 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b>Offer Letter Email Automation Form</b></h6>
                    <button class="bb" type="button" wire:click="closeOL" style="border:none">
                        <span aria-hidden="true" style="color: black;border:none">×</span>
                    </button>
                </div>
                <div>
                 
                    @if ($showErrorMessageForOL)
                    <div style="font-size: 10px;" class="alert alert-danger" id="error-message">
                        {{$errorMessageForOL}} <br>
                        <button style="border: none;border-radius:50%" class="close" wire:click="dismissErrorMessageForOL">×</button>
                    </div>
                    @endif
                    <!DOCTYPE html>
                    <html lang="en">

                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    
                    </head>

                    <body>
                        <div class="card-start">
                            <div class="container">
                                <form wire:submit.prevent="sendOfferLetter">
                                    <div class="form" style="text-align: center;">
                                        <div class="form-group">
                                            <label for="email">Password:</label>
                                            <div class="input-group">
                                                <input type="password" wire:model="password" placeholder="Password" class="form-control">
                                                <button type="button" onclick="openInNewTab('https://myaccount.google.com/apppasswords')" class="generate-password">Generate Password</button>
                                            </div>
                                            @error('password') <div class="error-message">{{ $message }}</div> @enderror
                                        </div>


                                        <div class="form-group">
                                            <label for="cc">Cc To:</label>
                                            <input wire:change="ccTo" type="email" wire:model="cc" placeholder="Cc To (comma-separated)" class="form-control">
                                            @error('cc') <div class="error-message">{{ $message }}</div> @enderror
                                        </div>

                                        @if ($cc && count(explode(',', $cc)) > 0)
                                        <div class="form-group">
                                            <strong class="cc-label">CC addresses:</strong>
                                            <div class="cc-grid">
                                                @foreach (explode(',', $cc) as $ccAddress)
                                                <div class="cc-to">
                                                    <span>{{ $loop->iteration }}.</span>
                                                    <span>{{ $ccAddress }}</span>
                                                    <i class="fas fa-times-circle cancel-icon" wire:click="removeCC('{{ $ccAddress }}')"></i>
                                                </div>
                                                @endforeach
                                            </div>

                                        </div>
                                        @endif


                                        <div class="form-group">
                                            <label for="name">Start Date:</label>
                                            <input placeholder="Start Date" class="form-control" id="startDate" type="text" wire:model="startDate" x-data x-init="initDatepicker($refs.startDate, 'M-d-Y')" x-ref="startDate">
                                            @error('startDate') <div class="error-message">{{ $message }}</div> @enderror
                                        </div>



                                        <div class="form-group">
                                            <label for="name">Salary:</label>
                                            <input type="number" wire:model="salary" placeholder="Salary per annum" class="form-control">
                                            @error('salary') <div class="error-message">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Pre-Inform Date:</label>
                                            <input placeholder="Please inform before the pre-inform date" class="form-control" id="informDate" type="text" wire:model="informDate" x-data x-init="initDatepicker($refs.informDate, 'M-d-Y')" x-ref="informDate">
                                            @error('informDate') <div class="error-message">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Signature:</label>
                                            <input type="text" wire:model="signature" placeholder="Signature" class="form-control">
                                            @error('signature') <div class="error-message">{{ $message }}</div> @enderror
                                        </div>


                                        <button class="button" type="button" wire:click="sendOfferLetter">Send</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </body>

                    </html>
                </div>
            </div>
        </div>
    </div>

    @endif

    @if($examPopUp=="true")
    <div class="modal" tabindex="-1" role="dialog" style="display: block;overflow-y:auto">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                    <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b>Examination Link</b></h5>
                    <button style="border: none;" type="button" wire:click="closeExamPopUp">
                        <span aria-hidden="true" style="color: black;">×</span>
                    </button>
                </div>
                <div style="padding: 5px;">
                    <label style="font-size: 12px;" for="date">Date:</label>
                    <input style="font-size: 12px;" class="input-fields" wire:model="examDate" type="date" id="date" readonly><br>
                    @error('examDate') <span class="text-danger">{{ $message }}</span> @enderror <br>

                    <label style="font-size: 12px;" for="time">Time:</label>
                    <input style="font-size: 12px;" class="input-fields" wire:model="examTime" type="time" readonly><br>
                    @error('examTime') <span class="text-danger">{{ $message }}</span> @enderror <br>

                    <label style="font-size: 12px;" for="location">Examination Link:</label>
                    <input style="font-size: 12px;" class="input-fields" wire:model="examLink" type="text"><br>
                    @error('examLink') <span class="text-danger">{{ $message }}</span> @enderror <br>

                    <div class="row" style="text-align: center">
                        <div class="col">
                            <button type="button" wire:click="sendExamLink" style="background-color: blue;color:white;border:none;border-radius:5px">
                                Send
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" wire:click="closeExamPopUp" style="background-color: red;color:white;border:none;border-radius:5px">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif


@if($interviewPopup=="true")
<div class="modal" tabindex="-1" role="dialog" style="display: block;overflow-y:auto">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b>Interview Details</b></h5>
                <button style="border: none;" type="button" wire:click="closeInterview">
                    <span aria-hidden="true" style="color: black;">×</span>
                </button>
            </div>
            <div style="padding: 5px;">
                <label style="font-size: 12px;" for="date">Date:</label>
                <input style="font-size: 12px;" class="input-fields" wire:model="examDate" type="date" id="date" readonly><br>
                @error('examDate') <span class="text-danger">{{ $message }}</span> @enderror <br>

                <label style="font-size: 12px;" for="time">Time:</label>
                <input style="font-size: 12px;" class="input-fields" wire:model="examTime" type="time" readonly><br>
                @error('examTime') <span class="text-danger">{{ $message }}</span> @enderror <br>

                <label style="font-size: 12px;" for="location">Examination Link:</label>
                <input style="font-size: 12px;" class="input-fields" wire:model="examLink" type="text"><br>
                @error('examLink') <span class="text-danger">{{ $message }}</span> @enderror <br>

                <div class="row" style="text-align: center">
                    <div class="col">
                        <button type="button" wire:click="sendExamLink" style="background-color: blue;color:white;border:none;border-radius:5px">
                            Send
                        </button>
                    </div>
                    <div class="col">
                        <button type="button" wire:click="closeInterview" style="background-color: red;color:white;border:none;border-radius:5px">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endif
</div>
</div>
<script>
    function openInNewTab(url) {
        window.open(url, '_blank');
    }

    function initDatepicker(el, format) {
        flatpickr(el, {
            dateFormat: format,
        });
    }
</script>