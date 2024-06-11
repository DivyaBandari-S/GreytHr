<div>
    @if(session()->has('emp_error'))
    <div class="alert alert-danger">
        {{ session('emp_error') }}
    </div>
    @endif
    @auth('emp')
    @foreach($employees as $employee)
    <div class="profile-container">
        <div>
            @if($employee->image)
            <div class="employee-profile-image-container">
                <img height="35px" width="35px" src="{{ asset('storage/' . $employee->image) }}" style="border-radius:50%;border:2px solid green;">
            </div>
            @else
            <div class="employee-profile-image-container">
                <img src="https://th.bing.com/th/id/OIP.Ii15573m21uyos5SZQTdrAHaHa?rs=1&pid=ImgDetMain" class="employee-profile-image-placeholder" style="border-radius:50%;" height="35px" width="35px" alt="Default Image">
            </div>
            @endif
        </div>
        <div class="emp-name p-0">
            <p style="font-size: 13px; color: white; max-width: 110px; word-wrap: break-word; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;margin-left:10px;" class="username">
               Hi &nbsp; {{ ucwords(strtolower($employee->first_name)) }}
            </p>

            <a href="{{ route('profile.info') }}" class="nav-item-1" style="text-decoration: none;color: #EC9B3B;font-weight:500;font-size: 11px;margin-left:10px;" onclick="changePageTitle()">View My Info</a>

        </div>

        <div class="p-0 m-0">

            <a href="/Settings" onclick="changePageTitle123()">

                <i style="color: white;    width: 16px;height: 16px;  margin-left: 10px;" class="fas fa-cog"></i>

            </a>

        </div>

    </div>
    @endforeach
    @endauth
    @auth('hr')
    @foreach($hrDetails as $employee)
    <div class="profile-container">
        <img class="profile-image" src="{{ Storage::url($employee->image) }}">
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

        <img class="profile-image" src="{{ Storage::url($employee->image) }}">
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


        <img class="profile-image" src="{{ Storage::url($employee->image) }}">




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