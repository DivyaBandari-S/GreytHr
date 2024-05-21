<div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <div>
        <div class="row m-0" style="background-color: #02134F; color: white; padding-top: 8px;">
            <div class="col-md-2 mb-3" style="text-align: center; margin: auto;">
                <img src="https://xsilica.com/images/xsilica_broucher_final_modified_05082016-2.png" alt="Logo" style="height: 50px; margin-right: 10px;">
            </div>
            <div class="col-md-7 mb-3" style="text-align: center; margin: auto;">
            <h1 style="font-size: 21px;">Job Seeker - {{ optional($user)->full_name }}</h1>
            </div>
            <div class="col-md-1 mb-3" style="text-align: center; margin: auto;">
                <a href="/AllNotifications" style="text-decoration: none; color: white">
                    <span><i class="fas fa-bell"></i> <!-- FontAwesome bell icon for notifications -->
                        <span class="badge">
                            {{$allNotificationCount}}
                        </span>
                    </span>
                </a>
            </div>
            <div class="col-md-2 mb-3">
            <button class="logout"wire:click="logout" style="text-align:end"> <i class="fas fa-sign-out-alt" ></i> Logout</button>
            </div>

        </div>

    </div>

    <div class="row-1" style="margin-top: 10px; text-align: end; margin-right: 10px;">

    <a href="/CreateCV" style="text-decoration: none;">
            <button class="btn btn-primary mb-2" style="font-size:12px;background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
                <i class="fas fa-file-alt" style="margin-right: 5px;"></i>
                Create CV</button>
        </a>
    
            <a href="/Companies" style="text-decoration: none;">
                <button class="btn btn-primary mb-2" style="font-size:12px; background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
                    <i class="fas fa-building" style="margin-right: 5px;"></i>
                    Companies</button>
            </a>
        
            <a href="/AppliedJobs" style="text-decoration: none;">
                <button class="btn btn-primary mb-2" style="font-size:12px; background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
                    <i class="fas fa-check" style="margin-right: 5px;"></i> Applied Jobs</button>
            </a>
            <button class="btn btn-primary mb-2" style="font-size:12px; background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
                <a href="/UserProfile" style="text-decoration: none;color:white"> <i class="fa fa-user" style="margin-right: 5px;"></i> Profile</a>
            </button>
    </div>


    <div class="container">
        <h2 style="text-align: center;
            font-family: Montserrat;
            ">All Jobs List</h2>
        @if($showSuccessMessage)
        <div class="alert alert-success" id="success-message">
            Your job application has been submitted successfully!
            <button class="close-message" wire:click="dismissMessage">×</button>
        </div>
        @elseif ($errors->has('duplicate'))
        <div class="alert alert-danger" id="error-message">
            {{ $errors->first('duplicate') }}
            <button class="close" wire:click="dismissError">×</button>
        </div>
        @endif
        @if (!is_null($jobs) && $jobs->count() > 0)

        <div class="row m-0">
            @foreach ($jobs as $job)
            <div class="col-md-6 mb-2">
                <div class="job-card">
                    <a wire:click="showJobDetails('{{$job->job_id}}')" style="text-decoration: none;color:black">
                        <h3 class="job-title">{{ $job->title }}</h3>
                        <p class="job-company"><strong class="subtitle">{{ $job->company_name }}</strong></p>

                        <div class="row m-0">
                            <div class="col-md-4 p-0">
                                <p class="job-location">
                                    <i class="fas fa-map-marker-alt"></i> {{ $job->location }}
                                </p>
                            </div>
                            <div class="col-md-4 p-0">
                                <p class="job-salary">
                                    <strong style="margin-right: 10px;">₹</strong>{{ number_format($job->salary, 2) }}
                                    PA
                                </p>
                            </div>
                            <div class="col-md-4 p-0">
                                <p class="job-posted-at">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ date('d M Y', strtotime($job->expire_date)) }}
                                    <strong style="font-size: 10px;">(Expired)</strong>
                                </p>
                            </div>
                        </div>

                        <div class="row m-0">
                            <div class="col-md-4 p-0">
                            <p class="job-vacancies">
                                        <i class="fas fa-users"></i> Vacancies: {{ $job->vacancies }}
                                    </p>
                            </div>
                            <div class="col-md-4 p-0">
                            <p class="job-education-requirement" >
                                        <i class="fas fa-graduation-cap"></i> Education:
                                        {{ $job->education_requirement }}
                                    </p>
                            </div>
                            <div class="col-md-4 p-0">
                            <p class="job-experience-requirement" style="width:150px;">
                                        <i class="fas fa-briefcase"></i> Experience: {{ $job->experience_requirement }}
                                    </p>
                            </div>
                        </div>

                        <p class="job-skills-required">
                            <i class="fas fa-tools"></i> Skills: {{ $job->skills_required }}
                        </p>

                    </a>
                    <div class="form-group">
                    <table>
                        <tr>
                            <th>
                                <label style="font-size:12px;
            font-family: Montserrat;
                                    " for="resume">CV:</label>
                            </th>
                            <th>
                                <input wire:model="user_resume" style="font-size:12px" type="file" class="form-control">
                            </th>
                        </tr>
                    </table>
                </div>
                @error('user_resume') <span class="error">{{ $message }}</span> @enderror <br>
                    <div style="text-align: center;">
                        <a wire:click="showJobApplication('{{$job->job_id}}')" class="apply-button">Apply</a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        @else
        <div style="text-align:center;margin-top:10px">No Jobs Found</div>
        @endif
    </div>
</div>
</div>
