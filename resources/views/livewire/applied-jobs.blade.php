<div>

    <div class="row m-0" style="background-color: #02134F; color: white; padding: 8px;">
        <div class="col-md-2 mb-3" style="text-align: center; margin: auto;">
            <img src="https://xsilica.com/images/xsilica_broucher_final_modified_05082016-2.png" alt="Logo" style="height: 50px; margin-right: 10px;">
        </div>
        <div class="col-md-8 mb-3" style="text-align: center; margin: auto;">
            <h1 style="font-size: 21px">Job Seeker - {{$user->full_name}}</h1>
        </div>
        <div class="col-md-2 mb-3">
        <button class="logout" style="margin-top: 15px;text-align:end" wire:click="logout"> <i class="fas fa-sign-out-alt" style="margin-right: 5px;"></i> Logout</button>
        </div>

    </div>

    <div class="row-1" style="margin-top: 10px; text-align: end; margin-right: 10px;">
        <a href="/Jobs" style="text-decoration: none;">
            <button class="btn btn-primary mb-2" style="font-size:12px;background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
            <i class="fas fa-briefcase" style="margin-right: 5px;"></i> </i>
                Jobs</button>
        </a>
        <a href="/Companies" style="text-decoration: none;">
            <button class="btn btn-primary mb-2" style="font-size:12px;background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
                <i class="fas fa-building" style="margin-right: 5px;"></i>
                Companies</button>
        </a>
        <button class="btn btn-primary mb-2" style="font-size:12px;background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
            <a href="/UserProfile" style="text-decoration: none;color:white"> <i class="fa fa-user" style="margin-right: 5px;"></i> Profile</a>
        </button>
    </div>
    <div class="container">
        <h4 style="text-align: center;">Applied Jobs</h4>
        @if(count($appliedJobs) > 0)
        <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Job ID</th>
                    <th>Job Title</th>
                    <th>Company Name</th>
                    <th>Applied Date</th>
                    <th>Expired Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appliedJobs as $appliedJob)
                <tr>
                    <td>{{ $appliedJob->job_id }}</td>
                    <td>{{ $appliedJob->job_title }}</td>
                    <td>{{ $appliedJob->company_name }}</td>
                    <td> {{ date('d-M-Y', strtotime($appliedJob->created_at)) }}</td>
                    <td> {{ date('d-M-Y', strtotime($appliedJob->expire_date)) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        @else
        <p>No applied jobs found.</p>
        @endif
    </div>
</div>