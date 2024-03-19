<div>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    </head>

    <body>
        <div>
            <div class="container" style="background-color: #02134F; color: white; padding: 8px;">
                <div style="display: flex; align-items: start; justify-content: start;">
                    <img src="https://xsilica.com/images/xsilica_broucher_final_modified_05082016-2.png" alt="Logo" style="width: 200px; height: 50px; margin-right: 10px;">
                    <h1 style="font-size: 21px; margin-left: 21%">Job Seeker - {{$user->full_name}}</h1>
                    <div style="margin-left:25%">
                        <button class="logout" style="margin-top: 15px;text-align:end" wire:click="logout"> <i class="fas fa-sign-out-alt" style="margin-right: 5px;"></i> Logout</button>
                    </div>
                </div>
            </div>

        </div>

        <div class="row" style="margin-left: 58%;margin-top:10px">
            <a href="/Jobs" style="text-decoration: none;">
                <button style="font-size:12px;width: 130px;height:30px; border-radius: 5px; margin: 0; background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
                    <i class="fas fa-briefcase" style="margin-right: 5px;"></i>
                    Jobs</button>
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

        <div class="card" id="notification-popup">
            <h4>All Notifications</h4>
            <div class="notification-options">
                <label class="radio-option">
                    <input type="radio" name="formType" value="register" wire:click="$set('activeTab', 'Shorlisted')" checked> Shorlisted
                </label>
                <label class="radio-option">
                    <input type="radio" name="formType" value="register" wire:click="$set('activeTab', 'Rejected')"> Rejected
                </label>
                <label class="radio-option">
                    <input type="radio" name="formType" value="register" wire:click="$set('activeTab', 'Examinations')"> Examinations
                </label>
                <label class="radio-option">
                    <input type="radio" name="formType" value="register" wire:click="$set('activeTab', 'Interviews')"> Interviews
                </label>
            </div>

            @if($activeTab=="Shorlisted")
            @if($notificationList)
            @foreach($notificationList as $key=> $list)
            <div class="notification-list">
                <a wire:click="showShortlistedJobInterviewDetails('{{$list->job->job_id}}')" class="notification-item">
                    <strong>{{ $key + 1 }}.</strong> Congratulations! Your CV has been shortlisted for the position of <strong>{{$list->job->title}}</strong> at <strong>{{$list->job->company_name}}</strong> Company.
                </a>
            </div>
            @endforeach
            @else
            <div style="text-align: center;margin-top:15px">Not Found</div>
            @endif
            @endif
            @if($activeTab=="Rejected")
            @if($rejectedJobs)
            @foreach($rejectedJobs as $key=> $list)
            <div class="notification-list">
                <a wire:click="showJobDetails('{{$list->job->job_id}}')" class="notification-item">
                    <strong>{{ $key + 1 }}.</strong> Your application has not been shortlisted for the position of <strong>{{$list->job->title}}</strong> at <strong>{{$list->job->company_name}}</strong> Company. Keep your spirits high and continue your job search. The right opportunity is out there waiting for you.
                </a>
            </div>
            @endforeach
            @else
            <div style="text-align: center;margin-top:15px">Not Found</div>
            @endif
            @endif

            @if($activeTab == "Examinations")
            @if($examinations->isNotEmpty())
            @foreach($examinations as $key => $exam)
            <div class="examination-notification" style="font-size: 12px; border-radius: 5px; border: 1px solid grey; padding: 10px; margin-bottom: 8px; text-align: left;">
                <p class="notification-content">
                    {{$key+1}}. 🚀 Congratulations,
                    Your application for the position of <strong>{{$exam->job->title}}</strong> at <strong>{{$exam->job->company_name}}</strong> company has advanced to the next stage. We're thrilled to invite you to the examination phase. Click the link below to access your examination details:
                </p>
                <p class="exam-link" style="margin-top: 10px;">
                    <strong><a href="{{$exam->exam_link}}">{{$exam->exam_link}}</a></strong>
                </p>
                <p class="best-of-luck-text" style="margin-top: 10px;">Best of luck! 🌟</p>
            </div>

            @endforeach
            @else
            <div style="margin-top: 10px;" class="not-found-message">No examinations found at the moment.</div>
            @endif
            @endif

        </div>
    </body>

    </html>

</div>