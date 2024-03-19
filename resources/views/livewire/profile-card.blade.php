<div>
    @auth('emp')
    @foreach($employees as $employee)
    <div class="profile-container">
        <div>

                @if($employee->image)
            @php
                $imageUrl = trim($employee->image);
            @endphp
            @if(Storage::disk('public')->exists('employee_image/' . $imageUrl))
                <img class="profile-image" src="{{ asset('storage/employee_image/' . $imageUrl) }}" alt="Profile Image">
            @else
                <img class="profile-image" src="https://img.freepik.com/premium-vector/anonymous-user-circle-icon-vector-illustration-flat-style-with-long-shadow_520826-1931.jpg" alt="Default Image">
            @endif
        @else
            <img class="profile-image" src="https://img.freepik.com/premium-vector/anonymous-user-circle-icon-vector-illustration-flat-style-with-long-shadow_520826-1931.jpg" alt="Default Image">
        @endif



        </div>

        <div class="emp-name">
            <p style="font-size: 13px; color: white; max-width: 110px; word-wrap: break-word; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" class="username">
                {{ ucwords(strtolower($employee->first_name)) }}  {{ ucwords(strtolower($employee->last_name)) }}
            </p>

            <a href="{{ route('profile.info') }}" class="nav-item-1" style="text-decoration: none;color: #EC9B3B;font-weight:500;font-size: 11px;" onclick="changePageTitle()">View My Info</a>

        </div>

        <div class="mx-2">

            <a href="/Settings" onclick="changePageTitle123()">

                <i style="color: white;" class="fas fa-cog"></i>

            </a>

        </div>

    </div>
    @endforeach
    @endauth
    @auth('hr')
    @foreach($hrDetails as $employee)
    <div class="profile-container">


        <img class="profile-image" src="{{ Storage::url($employee->image) }}" >





        <div class="emp-name">

            <p style="font-size: 12px; color: white; max-width: 130px; word-wrap: break-word;" class="username">{{$employee->employee_name}}</p>

            <a href="#" class="nav-item-1" style="text-decoration: none;" onclick="changePageTitle()">View My Info</a>

        </div>

        <div>

            <a href="#" onclick="changePageTitle123()">

                <i style="color: white;" class="fas fa-cog"></i>

            </a>

        </div>

    </div>
    @endforeach
    @endauth
    
    @auth('it')
    @foreach($itDetails as $employee)
    <div class="profile-container">

        <img class="profile-image" src="{{ Storage::url($employee->image) }}" >





        <div class="emp-name">

            <p style="font-size: 12px; color: white; max-width: 130px; word-wrap: break-word;" class="username">{{$employee->employee_name}}</p>

            <a href="#" class="nav-item-1" style="text-decoration: none;" onclick="changePageTitle()">View My Info</a>

        </div>

        <div>

            <a href="#" onclick="changePageTitle123()">

                <i style="color: white;" class="fas fa-cog"></i>

            </a>

        </div>

    </div>
    @endforeach
    @endauth

    @auth('finance')
    @foreach($financeDetails as $employee)
    <div class="profile-container">


        <img class="profile-image" src="{{ Storage::url($employee->image) }}" >





        <div class="emp-name">

            <p style="font-size: 12px; color: white; max-width: 130px; word-wrap: break-word;" class="username">{{$employee->employee_name}}</p>

            <a href="#" class="nav-item-1" style="text-decoration: none;" onclick="changePageTitle()">View My Info</a>

        </div>

        <div>

            <a href="#" onclick="changePageTitle123()">

                <i style="color: white;" class="fas fa-cog"></i>

            </a>

        </div>

    </div>
    @endforeach
    @endauth
</div>