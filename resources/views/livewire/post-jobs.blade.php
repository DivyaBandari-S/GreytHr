<div>
    <div class="container-11" style="background-color: #02134F; color: white; padding:2px;height:53px">
        <div style="display: flex; align-items: start; justify-content: start;">
            <img src="{{$hrDetails->company_logo}}" alt="Logo" style="width: 200px;height:50px;margin-right: 10px;">
            <h1 style="font-size: 20px; margin-left:25%;margin-top:10px">HR - {{$hrDetails->hr_name}}</h1>

            <div style="margin-left:25%;">
                <button style="margin-bottom: 10px;" class="logout" style="text-align:end" wire:click="logout"> <i class="fas fa-sign-out-alt"></i> Logout</button>
            </div>
        </div>
    </div>
    <div style="margin-top:5px;margin-bottom:5px">
        <button style="width: 200px; border-radius: 5px; background-color: rgb(2, 17, 79); color: white;margin-left:34%"><a href="/JobSeekersAppliedJobs" style="text-decoration: none;color:white">Job Seekers Applied Jobs</a></button>
        <button style="width:200px; border-radius: 5px; background-color: rgb(2, 17, 79); color: white;"><a href="/VendorsSubmittedCVs" style="text-decoration: none;color:white">Vendors Submitted CVs</a></button>
        <button style="width:200px; border-radius: 5px; background-color: rgb(2, 17, 79); color: white;"><a href="/empregister" style="text-decoration: none;color:white">Employee Register</a></button>
        <button style="width:200px; border-radius: 5px; background-color: rgb(2, 17, 79); color: white;"><a href="/emplist" style="text-decoration: none;color:white">Employees List</a></button>
    </div>
    @if(Session::has('success'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade show" style="
            height: 30px;
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
            align-items: center;
            display: flex;
            justify-content: center;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: lightgreen;
            color: white;
            margin-bottom: 5px;
            font-size: 12px;">
        {{ Session::get('success') }}
    </div>
    @endif

    <div class="job-posting-form">
        <h2 style="text-align: center;font-size:16px">Job Posting Form</h2>
        <form wire:submit.prevent="submitJob">
            <div class="form-group">
                <label for="company_id">Company ID:</label>
                <select wire:model="company_id" class="form-control" wire:change="selectedCompanyId">
                    <option value="">Select a company ID</option>
                    @foreach ($companies as $company)
                    <option value="{{ $company->company_id }}">{{ $company->company_id }}</option>
                    @endforeach
                </select>
                @error('company_id') <span class="text-danger">{{ $message }}</span> @enderror

            </div>

            <div class="form-group">
                <label for="company_name">Company Name:</label>
                <input wire:model="company_name" type="text" class="form-control" readonly>
            </div>


            <div class="form-group">
                <label for="title">Job Title:</label>
                <input wire:model="title" type="text" class="form-control">
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror

            </div>

            <div class="form-group">
                <label for="description">Job Description:</label>
                <textarea wire:model="description" class="form-control" rows="5"></textarea>
                @error('description') <span class="text-danger">{{ $message }}</span> @enderror

            </div>

            <div class="form-group">
                <label for="location">Job Location:</label>
                <input wire:model="location" type="text" class="form-control">
                @error('location') <span class="text-danger">{{ $message }}</span> @enderror

            </div>

            <div class="form-group">
                <label for="salary">Salary:</label>
                <input wire:model="salary" type="number" class="form-control">
                @error('salary') <span class="text-danger">{{ $message }}</span> @enderror

            </div>


            <div class="form-group">
                <label for="expire_date">Expire Date:</label>
                <input wire:model="expire_date" type="date" class="form-control" min="{{ date('Y-m-d') }}">
                @error('expire_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="vacancies">Number of Vacancies:</label>
                <input wire:model="vacancies" type="number" class="form-control">
                @error('vacancies') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="education_requirement">Education Requirement:</label>
                <input wire:model="education_requirement" type="text" class="form-control">
                @error('education_requirement') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="experience_requirement">Experience Requirement:</label>
                <input wire:model="experience_requirement" type="text" class="form-control">
                @error('experience_requirement') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="skills_">Skills Required:</label>
                <input wire:model="skills_required" type="text" class="form-control">
                @error('skills_required') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="is_featured">Featured Job:</label>
                <input wire:model="is_featured" type="checkbox">
                @error('is_featured') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="is_active">Active Job:</label>
                <input wire:model="is_active" type="checkbox">
                @error('is_active') <span class="text-danger">{{ $message }}</span> @enderror
            </div>


            <div class="form-group">
                <label for="application_link">Application Link (optional):</label>
                <input wire:model="application_link" type="url" class="form-control">
            </div>

            <div class="form-group">
                <label for="job_type">Job Type:</label>
                <select wire:model="job_type" class="form-control">
                    <option value="Full-time">Full-time</option>
                    <option value="Part-time">Part-time</option>
                    <option value="Contract">Contract</option>
                    <option value="Temporary">Temporary</option>
                    <option value="Internship">Internship</option>
                </select>
                @error('job_type') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="responsibilities">Responsibilities (optional):</label>
                <textarea wire:model="responsibilities" class="form-control" rows="5"></textarea>
            </div>

            <div class="form-group">
                <label for="benefits">Job Benefits (optional):</label>
                <textarea wire:model="benefits" class="form-control" rows="5"></textarea>
            </div>

            <div class="form-group">
                <label for="application_instructions">Application Instructions (optional):</label>
                <textarea wire:model="application_instructions" class="form-control" rows="5"></textarea>
            </div>

            <div style="text-align: center;">
                <button type="button" wire:click="submitJob" class="btn btn-primary">Post Job</button>
            </div>
        </form>
    </div>

</div>