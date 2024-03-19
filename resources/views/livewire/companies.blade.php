<div>
    <div class="row m-0" style="background-color: #02134F; color: white; padding: 8px;">
        <div class="col-md-2 mb-3" style="text-align: center; margin: auto;">
            <img src="https://xsilica.com/images/xsilica_broucher_final_modified_05082016-2.png" alt="Logo" style="height: 50px; margin-right: 10px;">
        </div>
        
        <div class="col-md-8 mb-3" style="text-align: center; margin: auto;">

            <h1 style="font-size: 21px;">Job Seeker - {{$user->full_name}}</h1>
        </div>
        <div class="col-md-2 mb-3">
        <button class="logout" style="margin-top: 15px;text-align:end" wire:click="logout"> <i class="fas fa-sign-out-alt" style="margin-right: 5px;"></i> Logout</button>
        </div>

    </div>

    <div class="row-1" style="margin-top: 10px; text-align: end; margin-right: 10px;">
        <a href="/Jobs" style="text-decoration: none;">
            <button class="btn btn-primary mb-2" style="font-size:12px;background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
            <i class="fas fa-briefcase" style="margin-right: 5px;"></i>
                Jobs</button>
        </a>
        <a href="/AppliedJobs" style="text-decoration: none;">
            <button class="btn btn-primary mb-2" style="font-size:12px;background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
                <i class="fas fa-check" style="margin-right: 5px;"></i> Applied Jobs</button>
        </a>
        <button class="btn btn-primary mb-2" style="font-size:12px;background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
            <a href="/UserProfile" style="text-decoration: none;color:white"> <i class="fa fa-user" style="margin-right: 5px;"></i> Profile</a>
        </button>
        
    </div>

    <div class="company-list" style="margin-top: 5px;">
        <h4 style="text-align: center;">List Of Companies</h4>
        @foreach ($companies as $company)
        <div class="company-item">
            <div class="row">
                <div class="col-md-4">
                    <div class="company-logo">
                        <img src="{{ $company->company_logo }}" alt="Company Logo">
                    </div>
                </div>
                <div class="col-md-8">
                    <h6>
                        {{ $company->company_name }}
                    </h6>
                    <div class="row">
                        <div class="col">
                            <div class="data">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $company->company_address1 }}, {{ $company->company_address2 }}
                            </div>
                        </div>
                        <div class="col">
                            <div class="data">
                                <i class="far fa-calendar-alt"></i>
                                {{ date('d M Y', strtotime($company->company_registration_date)) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="data">
                                <i class="far fa-envelope"></i>
                                {{ $company->contact_email }}
                            </div>
                        </div>
                        <div class="col">
                            <div class="data">
                                <i class="fas fa-phone"></i>
                                {{ $company->contact_phone }}
                            </div>
                        </div>
                    </div>
                    <!-- Add this code inside your foreach loop to display the right arrow icon and trigger the Livewire action -->
                    <a wire:click="showCompanyJobDetails('{{ $company->company_id }}')" style="text-decoration:none;color:black">
                        <div class="right-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
                    <!-- Add more details as needed -->
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
