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
        <button style="width: 200px; border-radius: 5px; background-color: rgb(2, 17, 79); color: white;"><a href="/JobSeekersAppliedJobs" style="text-decoration: none;color:white">Job Seekers Applied Jobs</a></button>
        <button style="width:200px; border-radius: 5px; background-color: rgb(2, 17, 79); color: white;"><a href="/empregister" style="text-decoration: none;color:white">Employee Register</a></button>
        <button style="width:200px; border-radius: 5px; background-color: rgb(2, 17, 79); color: white;"><a href="/emplist" style="text-decoration: none;color:white">Employees List</a></button>
    </div>

    <div class="job-seekers-applied-jobs">
        <h5 class="text-2xl font-semibold mb-4" style="text-align: center;">Vendors Submitted CVs</h5>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Vendor ID</th>
                    <th>Full Name</th>
                    <th>Job ID</th>
                    <th>Job Title</th>
                    <th>Company Name</th>
                    <th>CVs</th>
                    <th>Applied Date</th>
                    <th>Expiry Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($submittedCVs as $submitDetails)
                <tr>
                    <td>{{ $submitDetails->user->user_id }}</td>
                    <td>{{ $submitDetails->user->full_name }}</td>
                    <td>{{ $submitDetails->job->job_id }}</td>
                    <td>{{ $submitDetails->job->title }}</td>
                    <td>{{ $submitDetails->job->company_name }}</td>
                    <td>
                        Total CV's : <strong>{{ count($submitDetails->cv) }}</strong>
                        @foreach ($submitDetails->cv as $key=> $cv)
                        <div style="margin-bottom: 8px">
                            {{ $key + 1 }}
                            <a style="text-decoration: none;margin-right:5px" class="preview-button" href="{{ asset('storage/' . $cv['cv']) }}" target="_blank">Preview CV{{ $key + 1 }} </a>
                            <a style="text-decoration: none;" class="download-button" href="{{ asset('storage/' . $cv['cv']) }}" download>Download CV{{ $key + 1 }} </a>
                        </div>
                        @endforeach
                    </td>
                    <td>{{ date('d-M-Y', strtotime($submitDetails->created_at)) }}</td>
                    <td>{{ date('d-M-Y', strtotime($submitDetails->job->expire_date)) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    function previewOrDownload(content, action) {
        var blob = new Blob([content], {
            type: 'text/html'
        });
        var url = window.URL.createObjectURL(blob);

        if (action === 'preview') {
            window.open(url, '_blank');
        } else if (action === 'download') {
            var link = document.createElement('a');
            link.href = url;
            link.download = 'resume.html'; // Specify the desired file name.
            link.style.display = 'none';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
</script>