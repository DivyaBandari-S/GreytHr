<div>

    <div class="container" style="background-color: #02134F; color: white; padding: 8px;">
        <div style="display: flex; align-items: start; justify-content: start;">
            <img src="https://xsilica.com/images/xsilica_broucher_final_modified_05082016-2.png" alt="Logo" style="width: 200px; height: 50px; margin-right: 10px;">
            <h1 style="font-size: 21px; margin-left:21%">Job Seeker - {{$user->full_name}}</h1>
        <button class="logout" style="margin-top: 15px;text-align:end;margin-left:20%" wire:click="logout"> <i class="fas fa-sign-out-alt" style="margin-right: 5px;"></i> Logout</button>
        </div>

    </div>

    <div class="row" style="margin-left: 46%;margin-top:10px">
        <a href="/CreateCV" style="text-decoration: none;">
            <button style="font-size:12px;width: 130px;height:30px; border-radius: 5px; margin: 0; background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
                <i class="fas fa-file-alt" style="margin-right: 5px;"></i>
                Create CV</button>
        </a>
        <a href="/Jobs" style="text-decoration: none;">
            <button style="font-size:12px;width: 130px;height:30px; border-radius: 5px; margin: 0; background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
                <i class="fas fa-briefcase" style="margin-right: 5px;"></i> Jobs
            </button>
        </a>
        <a href="/Companies" style="text-decoration: none;">
            <button style="font-size:12px;width: 130px;height:30px; border-radius: 5px; margin: 0; background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
                <i class="fas fa-building" style="margin-right: 5px;"></i>
                Companies</button>
        </a>
        <a href="/AppliedJobs" style="text-decoration: none;">
            <button style="font-size:12px;width: 130px;height:30px; border-radius: 5px; margin: 0; background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
                <i class="fas fa-check" style="margin-right: 5px;"></i> Applied Jobs</button>
        </a>
        <button style="font-size:12px;width: 100px; border-radius: 5px;height:30px; background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
            <a href="/UserProfile" style="text-decoration: none;color:white"> <i class="fa fa-user" style="margin-right: 5px;"></i> Profile</a>
        </button>
    </div>

    <div class="container">
        <h4 style="text-align: center;">Company Based Job List</h4>
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
        @if (!is_null($jobList) && $jobList->count() > 0)
        <div class="job-listings" style="padding: 5px;">
            @foreach ($jobList as $job)
            <div class="job-card" style="text-align: start;">
                <a wire:click="showJobDetails('{{$job->job_id}}')" style="text-decoration: none;color:black">
                    <h3 class="job-title">{{ $job->title }}</h3>
                    <p class="job-company"><strong class="subtitle">{{ $job->company_name }}</strong></p>

                    <div>
                        <table>
                            <tr>
                                <th style="font-size: 12px; text-align: start;">
                                    <p class="job-location" style="width: 150px;">
                                        <i class="fas fa-map-marker-alt"></i> {{ $job->location }}
                                    </p>
                                </th>
                                <th style="font-size: 12px; text-align: start;">
                                    <p class="job-salary" style="width:250px">
                                        <strong style="margin-right: 10px;">₹</strong>{{ number_format($job->salary, 2) }}
                                        PA
                                    </p>
                                </th>
                                <th style="font-size: 12px; text-align: start;">
                                    <p class="job-posted-at" style="width:150px">
                                        <i class="far fa-calendar-alt"></i>
                                        {{ date('d M Y', strtotime($job->expire_date)) }}
                                        <strong style="font-size: 10px;">(Expired)</strong>
                                    </p>
                                </th>
                            </tr>
                        </table>
                    </div>

                    <table>
                        <tr>
                            <th style="font-size: 12px; text-align: start;">
                                <p class="job-vacancies" style="width:150px">
                                    <i class="fas fa-users"></i> Vacancies: {{ $job->vacancies }}
                                </p>
                            </th>
                            <th style="font-size: 12px; text-align: start;">
                                <p class="job-education-requirement" style="width:250px;margin-right: 10px;">
                                    <i class="fas fa-graduation-cap"></i> Education: {{ $job->education_requirement }}
                                </p>
                            </th>
                            <th style="font-size: 12px; text-align: start;">
                                <p class="job-experience-requirement" style="width:150px;">
                                    <i class="fas fa-briefcase"></i> Experience: {{ $job->experience_requirement }}
                                </p>
                            </th>
                        </tr>
                    </table>

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
                    <a style="text-decoration: none;" wire:click="showJobApplication('{{$job->job_id}}')" class="apply-button">Apply</a>
                </div>
            </div>
            @endforeach

        </div>
        @else
        <div style="text-align:center;margin-top:10px">No Jobs Found</div>
        @endif
    </div>
</div>