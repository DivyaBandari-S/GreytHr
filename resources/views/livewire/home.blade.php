<div>
<body>
    <div class="msg-container">
    @if (session()->has('success'))
        <div x-data x-init="checkFadeIn()" class="custom-alert alert-success successAlert row mx-auto" style="text-align:center;">
            <p class="mx-auto">{{ session('success') }} 😀</p>
        </div>
        <script>
            setTimeout(function() {
                const successMessage = document.querySelector('.custom-alert');
                if (successMessage) {
                    successMessage.style.display = 'none';
                }
            }, 1000);
        </script>
    @endif


        </div>
        <div class="content">
            <div class="row m-0 mb-3 fade-in-section">
                <div class="col-md-6 mb-4">
                <div class="homeCard4" style="height: 20em; padding: 1em 10px; background: url('images/home_banner_bg.gif') no-repeat center #ffffff;">
                        <div class="greeat">
                        @if($this->greetingText)
                        <h1 class="greet-text text-secondary-500 pb-1.5x" style="font-size: 30px; font-family: montserrat;;color:rgb(2, 17, 79); font-weight: 600;">{{$greetingText}}</h1>
                        @endif
                        </div>
<!--
                        <div>
                            <carousel class="ng-star-inserted" style="width:470px">
                            </carousel>
                            <div class="quote-text" style="font-size:12px; line-height:1.6; font-weight: 600; color: #02114f;">
                            </div>
                            <div class="author-text" style="font-size:12px; line-height:1.6; font-weight: 600; color: #02114f;">
                            </div>
                        </div> -->
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                @if($this->greetingImage)
                    <img src="{{ asset('/images/' . $greetingImage) }}" alt=" " style="width: 100%; border-radius: 10px; height: 20em">
                @endif
                <!-- <img id="greeting-image" src="" alt="Greeting Image" style="height: 200px; width:300px ;margin-left:50px; "> -->
        </div>
            </div>


            <!-- main content -->

            <div class="row m-0">
                <div class="col-md-3 mb-4 fade-in-section">
                <div class="home-hover">
                        <div class="homeCard4">
                            <div style="color: black; padding:10px 15px;">
                                <p style="font-size:12px;">{{$currentDate}}</p>
                                <p style="margin-top: 10px; color: #9E9696; font-size: 12px;">
                                    {{$currentDay}} | 10:00 AM to 07:00 PM
                                </p>
                                <div style="font-size: 14px; display: flex">
                                    <img src="/images/stopwatch.png" class="me-4" alt="Image Description" style="width: 2.7em;">
                                    <p id="current-time" style="margin: auto 0;"></p>
                                </div>
                                <script>
                                    function updateTime() {
                                        const currentTimeElement = document.getElementById('current-time');
                                        const now = new Date();
                                        const hours = String(now.getHours()).padStart(2, '0');
                                        const minutes = String(now.getMinutes()).padStart(2, '0');
                                        const seconds = String(now.getSeconds()).padStart(2, '0');
                                        const currentTime = `${hours} : ${minutes} : ${seconds}`;
                                        currentTimeElement.textContent = currentTime;
                                    }
                                    updateTime();
                                    setInterval(updateTime, 1000);
                                </script>
                                <div class="A" style="display: flex;flex-direction:row;justify-content:space-between; align-items:center;margin-top:2.5em;">
                                    <a style="width:40%;font-size:12px;cursor: pointer;color:blue" wire:click="open">View Swipes</a>
                                    <button  id="signButton" style="color: white; width: 80px; height: 26px;font-size:10px; background-color: rgb(2, 17, 79); border: 1px solid #CFCACA; border-radius: 5px; " wire:click="toggleSignState">
                                        @if($swipes)
                                        @if ($swipes->in_or_out=="OUT")
                                        Sign In
                                        @else
                                        Sign Out
                                        @endif
                                        @else
                                        Sign In
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4 fade-in-section">
                    <div class="home-hover">
                        <div class="reviews">
                            <div class="homeCard1">
                                <div class="home-heading d-flex justify-content-between px-3 py-2">
                                    <div class="rounded">
                                        <p style="font-size:12px;color:#778899;font-weight:500;">  Review</p>
                                    </div>
                                    <div >
                                        <a href="/employees-review" style="font-size:16px; "><img src="/images/up-arrow.png" alt="" style="width:20px;height:27px;"></a>
                                    </div>
                                </div>
                            @if(($this->count) > 0)
                                    <div class="notify d-flex justify-content-between  px-3">
                                        <p style="color: black; font-size: 12px; font-weight: 500;">
                                            {{$count}} <br>
                                            <span style="color: #778899; font-size:11px; font-weight: 500;">Things to review</span>
                                        </p>
                                        <img src="https://png.pngtree.com/png-vector/20190214/ourlarge/pngtree-vector-notes-icon-png-image_509622.jpg" alt="" style="height: 40px; width: 40px;">
                                    </div>
                                    <div class="leave-display d-flex border-top p-3 gap-2" >
                                    @php
                                        function getRandomColor() {
                                            $colors = ['#FFD1DC', '#B0E57C', '#ADD8E6', '#E6E6FA', '#FFB6C1'];
                                                return $colors[array_rand($colors)];
                                        }
                                    @endphp
                                    @for ($i = 0; $i < min($count, 4); $i++)
                                        <?php
                                        $leaveRequest = $this->leaveApplied[$i]['leaveRequest'] ?? null;
                                        if ($leaveRequest && $leaveRequest->employee) {
                                            $firstName = $leaveRequest->employee->first_name;
                                            $lastName = $leaveRequest->employee->last_name;
                                            $initials = strtoupper(substr($firstName, 0, 1)) . strtoupper(substr($lastName, 0, 1));
                                        ?>
                                        <div class="circle-container d-flex flex-column mr-3">
                                        <div class="circle d-flex" style="border-radius: 50%;width: 35px;height: 35px;align-items: center;justify-content: center;border: 2px solid {{getRandomColor() }}" data-toggle="tooltip" data-placement="top" title="{{ $firstName }} {{ $lastName }}">
                                            <span style="color: #778899; font-weight: 500; font-size: 11px;">{{ $initials }}</span>
                                        </div>
                                        <span style="display: block; text-align: center;font-size:10px;color:#778899;">Leave</span>
                                    </div>

                                        <?php
                                        }
                                        ?>
                                    @endfor

                                        @if ($count > 4)
                                            <div class="circle-notify d-flex flex-column mt-3" style="cursor:pointer; align-items:center;">
                                                <a href="#" style="color:blue;font-size:10px">+{{ $count - 4 }}</a>
                                                <p style="color:blue;font-size:10px;margin-top:-5px;"><span class="remaining" >More</span></p>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div style="display:flex;flex-direction:column;justify-content:center;align-items:center;">
                                        <img src="/images/not_found.png" alt="Image Description" style="width: 7em;">
                                        <p style="color: #677A8E; font-size: 12px; ">
                                            Hurrah! You've nothing to review.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4 fade-in-section">
                <div class="home-hover">
                        <div class="homeCard6" style="padding:10px 15px;">
                            <div style="display:flex; justify-content:space-between;">
                                <p style="font-size:12px;color:#778899;font-weight:500;">Upcoming Holidays</p>
                                <a href="/holiday-calender" style="font-size:16px; "><img src="/images/up-arrow.png" alt="" style="width:20px;height:27px;"></a>
                            </div>

                            @if($calendarData->isEmpty())
                            <p style="color:#778899;font-size:10px;">Uh oh! No holidays to show.</p>
                            @else
                                @php
                                    $count = 0;
                                @endphp

                                <div class="row m-0">
                                    <div class="col-7 p-0">
                                        @foreach($calendarData as $entry)
                                            @if(!empty($entry->festivals))
                                                <div>
                                                    <p style="color: #677A8E; font-size: 11px; ">
                                                        <span style="font-weight: 500;">{{ date('d M', strtotime($entry->date)) }}  <span style="font-size: 10px; font-weight: normal;">{{ date('l', strtotime($entry->date)) }}</span></span>
                                                        <br>
                                                        <span style="font-size: 10px; font-weight: normal;">{{ $entry->festivals }}</span>
                                                    </p>
                                                </div>
                                                @php
                                                    $count++;
                                                @endphp
                                            @endif

                                            @if($count >= 3)
                                                @break
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-5 m-auto p-0">
                                        <img src="/images/A day off.gif" style="width: 8em">
                                    </div>
                                </div>


                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4 fade-in-section">
                    <div class="home-hover">
                        <div class="homeCard2" style="padding:10px 15px;justify-content:center;display: flex;flex-direction:column;">
                            <div>
                                <p style="font-size:12px;color:#778899;font-weight:500;">IT Declaration</p>
                            </div>
                            <div style="display: flex;gap:10px;margin-top:10px;">
                                <img src="images/thumb-up.png" alt="Image Description" style="width: 5em;">
                                <p style="font-size:12px;color:#778899;">Hurrah! Considered your IT declaration for Apr 2023.</p>
                            </div>
                            <div class="B" style="color:  #677A8E;   font-size: 12px;display:flex;justify-content:end; margin-top: 2em;">
                                <a href="/formdeclaration" class="button-link">
                                    <button class="custom-btn" style="width:60px;border:1px solid #058383;border-radius:5px;padding:3px 5px;color:#058383;background:#fff;">View</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                @if($ismanager)
                <div class="col-md-8 mb-4 fade-in-section">
                    <div class="home-hover">
                        <div class="homeCard6" style="padding:10px 15px;">
                            <div style="color: #677A8E;  font-weight:500; display:flex;justify-content:space-between;">
                                <p style="font-size:12px;"> Who is in?</p>
                                <a href="/whoisinchart" style="font-size:16px; "><img src="/images/up-arrow.png" alt="" style="width:20px;height:27px;"></a>
                            </div>
                                    <div>
                                        <div class="who-is-in d-flex flex-column justify-content-start ">
                                            <p class="section-name">
                                                    Not Yet In ({{ $CountAbsentEmployees }})
                                                </p>
                                            <div class="team-leave d-flex flex-row gap-3">
                                            @php
                                                function getRandomAbsentColor() {
                                                            $colors = ['#FFD1DC', '#D2E0FB', '#ADD8E6', '#E6E6FA', '#F1EAFF','#FFC5C5'];
                                                            return $colors[array_rand($colors)];
                                                        }
                                                @endphp 
                                            @for ($i = 0; $i < min($CountAbsentEmployees, 4); $i++)
                                            @if(isset($AbsentEmployees[$i]))
                                            @php
                                                $employee = $AbsentEmployees[$i];

                                                $randomColorAbsent = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
                                            @endphp

                                            <div class="circle" style="border: 2px solid {{getRandomAbsentColor() }};border-radius:50%;width: 35px;height: 35px;display: flex;align-items: center;justify-content: center;" data-toggle="tooltip" data-placement="top" title="{{ $employee['first_name'] }} {{ $employee['last_name'] }}">
                                                <span class="initials">
                                                    {{ strtoupper(substr(trim($employee['first_name']), 0, 1)) }}{{ strtoupper(substr(trim($employee['last_name']), 0,1)) }}
                                                </span>
                                            </div>
                                        @endif
                                    @endfor
                                        @if ($CountAbsentEmployees > 4)
                                        <div class="circle-notify" style="color:blue;cursor:pointer;display:flex;flex-direction:column;align-items:center;margin-top:10px;">
                                            <a href="#" style="color:blue;font-size:10px;">+{{ $CountAbsentEmployees - 4 }}</a>
                                            <p style="font-size:10px;margin-top:-5px;"><span class="remaining" >More</span></p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            <!-- /second row -->
                                
                                <div class="who-is-in d-flex flex-column justify-content-start ">
                                            <p  class="section-name mt-1">
                                                    Late Arrival({{ $CountLateSwipes }})
                                                </p>
                                            <div class="team-leave d-flex flex-row  gap-3">
                                            @php
                                                function getRandomLateColor() {
                                                            $colors = ['#FFD1DC', '#D2E0FB', '#ADD8E6', '#E6E6FA', '#F1EAFF','#FFC5C5'];
                                                            return $colors[array_rand($colors)];
                                                        }
                                            @endphp
                                            @for ($i = 0; $i < min($CountLateSwipes, 4); $i++)            
                                                @php
                                                    $employee = $LateSwipes[$i];
                                                @endphp
                                            
                                                @if(isset($LateSwipes[$i]))                   
                                            <div class="circle" style="border: 2px solid {{getRandomAbsentColor() }};border-radius:50%;width: 35px;height: 35px;display: flex;align-items: center;justify-content: center;" data-toggle="tooltip" data-placement="top" title="{{ $employee['first_name'] }} {{ $employee['last_name'] }}">
                                                    <span class="initials">
                                                        {{ strtoupper(substr(trim($employee['first_name']), 0, 1)) }}{{ strtoupper(substr(trim($employee['last_name']), 0,1)) }}
                                                    </span>
                                                </div>
                                                @endif
                                            @endfor
                                        @if ($CountLateSwipes > 4)
                                        <div class="circle-notify" style="color:blue;cursor:pointer;display:flex;flex-direction:column;align-items:center;margin-top:10px;">
                                            <a href="#" style="color:blue;font-size:0.725rem;">+{{ $CountLateSwipes - 4 }}</a>
                                            <p style="font-size:0.725rem;margin-top:-5px;"><span class="remaining" >More</span></p>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- /third row -->
                                
                                <div class="who-is-in d-flex flex-column justify-content-start">
                                            <p  class="section-name mt-1">
                                                    On Time({{ $CountEarlySwipes }})
                                                </p>
                                            <div class="team-leave d-flex flex-row mr gap-3">
                                            @php
                                                function getRandomEarlyColor() {
                                                            $colors = ['#FFD1DC', '#D2E0FB', '#ADD8E6', '#E6E6FA', '#F1EAFF','#FFC5C5'];
                                                            return $colors[array_rand($colors)];
                                                        }
                                            @endphp  
                                            @for ($i = 0; $i < min($CountEarlySwipes, 4); $i++)
                                            @if(isset($EarlySwipes[$i]))
                                            @php
                                                $employee = $EarlySwipes[$i];

                                                $randomColorEarly = '#' . str_pad(dechex(mt_rand(0xCCCCCC, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);

                                            @endphp
                                                
                                            <div class="circle" style="border: 2px solid {{getRandomAbsentColor() }};border-radius:50%;width: 35px;height: 35px;display: flex;align-items: center;justify-content: center;" data-toggle="tooltip" data-placement="top" title="{{ $employee['first_name'] }} {{ $employee['last_name'] }}">
                                                <span class="initials">
                                                    {{ strtoupper(substr(trim($employee['first_name']), 0, 1)) }}{{ strtoupper(substr(trim($employee['last_name']), 0,1)) }}
                                                </span>
                                            </div>
                                        @endif
                                    @endfor
                                        @if ($CountEarlySwipes > 4)
                                        <div class="circle-notify" style="color:blue;cursor:pointer;display:flex;flex-direction:column;align-items:center;margin-top:10px;">
                                            <a href="#" style="color:blue;font-size:0.725rem;">+{{ $CountEarlySwipes - 4 }}</a>
                                            <p style="font-size:0.725rem;margin-top:-5px;"><span class="remaining" >More</span></p>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @endif

                 <!-- TEAM ON LEAVE -->
                 @if($this->showLeaveApplies)
                <div class="col-md-4 mb-4 fade-in-section">
                    <div class="home-hover">
                        <div class="reviews">
                            <div class="homeCard4">
                                <div class="team-heading px-3 mt-2" style="display:flex; justify-content:space-between;">
                                    <div>
                                        <p style="font-size:12px;color:#778899;font-weight:500;"> Team On Leave</p>
                                    </div>
                                    <div >
                                        <a href="/team-on-leave-chart" style="font-size:16px; "><img src="/images/up-arrow.png" alt="" style="width:20px;height:27px;"></a>
                                    </div>
                                </div>
                                @if(($this->teamCount) > 0)
                                    <div class="team-Notify">
                                        <p style="color: #778899; font-size: 12px; font-weight: 500;">
                                            Today({{$teamCount}}) </p>
                                            <div class="team-leave d-flex flex-row mr gap-3" >
                                                @php
                                                    function getRandomLightColor() {
                                                        $colors = ['#FFD1DC', '#B0E57C', '#ADD8E6', '#E6E6FA', '#FFB6C1'];
                                                        return $colors[array_rand($colors)];
                                                    }
                                                @endphp

                                                @for ($i = 0; $i < min($teamCount, 4); $i++)
                                                        <?php
                                                            $teamLeave = $this->teamOnLeave[$i] ?? null;
                                                            if ($teamLeave) {
                                                                $initials = strtoupper(substr($teamLeave->employee->first_name, 0, 1) . substr($teamLeave->employee->last_name, 0, 1));
                                                        ?>
                                                            <div class="circle-notify" style=" border-radius: 50%; background: #fcfdfe; padding: 7px 8px; border: 2px solid {{ getRandomLightColor() }};" data-toggle="tooltip" data-placement="top" title="{{ $firstName }} {{ $lastName }}">
                                                                <span style="color:#778899;font-weight:500;font-size:12px;">{{$initials}}</span>
                                                            </div>
                                                            
                                                        <?php
                                                            }
                                                        ?>
                                                @endfor
                                                    @if ($teamCount > 4)
                                                        <div class="circle-notify" style="color:blue;cursor:pointer; margin-top:20px;display:flex;flex-direction:column;align-items:center;">
                                                        <a href="#" style="color:blue;font-size:0.725rem;">+{{ $teamCount - 4 }}</a>
                                                        <p style="font-size:0.725rem;margin-top:-5px;"><span class="remaining" >More</span></p>
                                                        </div>
                                                    @endif
                                                </div>

                                            <div style="margin-top:20px;">
                                            <p style="color: #778899; font-size: 0.825rem; font-weight: 500;">
                                            This month({{$upcomingLeaveApplications}}) </p>
                                            <p style="color: #778899; font-size: 0.825rem; font-weight: 400;"><a href="/team-on-leave-chart">Click here</a> to see who will be on leave in the upcoming days!</p>
                                            </div>
                                    </div>
                                @else
                                    <div style="display:flex;justify-content:center;flex-direction:column;align-items:center;">
                                        <img src="https://i.pinimg.com/originals/52/4c/6c/524c6c3d7bd258cd165729ba9b28a9a2.png" alt="Image Description" style="width: 120px; height:100px;">
                                        <p style="color: #677A8E; font-size: 11px; ">
                                            Wow!No leaves planned today.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif




                <div class="col-md-4 mb-4 fade-in-section">
                    <div class="home-hover">
                        @if($salaryRevision->isEmpty())
                        <div class="homeCard5">
                            <div class="py-2 px-3">
                                <div class="d-flex justify-content-between">
                                    <p style="font-size:12px;color:#778899;font-weight:500;">Payslip</p>
                                    <a href="/slip" style="font-size:16px; "><img src="/images/up-arrow.png" alt="" style="width:20px;height:27px;"></a>
                                </div>

                                <div style="display:flex;align-items:center;flex-direction:column;">
                                        <img src="https://cdn3.iconfinder.com/data/icons/human-resources-70/133/9-512.png" alt="" style="height:75px;width:75px;">
                                    <p style="color: #677A8E;  margin-bottom: 20px; font-size:12px;"> We are working on your payslip!</p>
                                </div>
                            </div>
                        </div>
                            @else
                                @foreach($salaryRevision as $salaries)
                                <div class="homeCard5" style="padding:10px 15px;">
                                    <div  class="d-flex justify-content-between">
                                        <p style="font-size:12px;color:#778899;font-weight:500;">Payslip</p>
                                        <a href="/slip" style="font-size:16px; "><img src="/images/up-arrow.png" alt="" style="width:20px;height:27px;"></a>
                                    </div>

                                    <div wire:ignore style="display:flex;justify-content:space-between;margin-top:20px;">
                                            <div style="position: relative;">
                                                    <!-- {{-- <canvas id="outerPieChart" width="120" height="120"></canvas>
                                                        <canvas id="innerPieChart" width="60" height="60" style="position: absolute; top: 5px;"></canvas> --}} -->
                                                        <canvas id="combinedPieChart" width="100" height="100"></canvas>
                                            </div>
                                        <div class="c" style="font-size: 12px; font-weight: normal; font-weight: 500; color: #9E9696;display:flex; flex-direction:column;justify-content:flex-end;">
                                            <p style="color:#333;">{{ date('M Y', strtotime('-1 month')) }}</p>
                                            <p style="display:flex;justify-content:end;flex-direction:column;align-items:end; color:#333;">{{ date('t', strtotime('-1 month')) }} <br>
                                                <span style="color:#778899;">Paid days</span>
                                            </p>
                                        </div>
                                    </div>

                                    <div style="display:flex ;flex-direction:column; margin-top:20px;  ">
                                        <div class="net-salary">
                                            <div style="display:flex;gap:10px;">
                                                <div style="padding:2px;width:2px;height:17px;background:#000000;border-radius:2px;"></div>
                                                <p style="font-size:11px;">Gross Pay</p>
                                            </div>
                                            <p style="font-size:12px;">{{ $showSalary ? '₹ ' . number_format($salaries->calculateTotalAllowance(), 2) : '*********' }}</p>
                                        </div>
                                        <div class="net-salary">
                                            <div style="display:flex;gap:10px;">
                                                <div style="padding:2px;width:2px;height:17px;background:#B9E3C6;border-radius:2px;"></div>
                                                <p style="font-size:11px;">Deduction</p>
                                            </div>
                                            <p style="font-size:12px;">{{ $showSalary ? '₹ ' . number_format($salaries->calculateTotalDeductions() ?? 0, 2) : '*********' }}</p>

                                        </div>
                                        <div class="net-salary">
                                            <div style="display:flex;gap:10px;">
                                                <div style="padding:2px;width:2px;height:17px;background:#1C9372;border-radius:2px;"></div>
                                                <p style="font-size:11px;">Net Pay</p>
                                            </div>
                                            @if ($salaries->calculateTotalAllowance() - $salaries->calculateTotalDeductions() > 0)
                                            <p style="font-size:12px;"> {{ $showSalary ? '₹ ' .number_format(max($salaries->calculateTotalAllowance() - $salaries->calculateTotalDeductions(), 0), 2) : '*********' }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="show-salary" style="display: flex; color: #1090D8; justify-content:space-between;font-size: 12px;  margin-top: 20px; font-weight: 100;">
                                        <a href="/your-download-route" id="pdfLink2023_4" class="pdf-download" download >Download PDF</a>
                                        <a wire:click="toggleSalary" class="showHideSalary">
                                            {{ $showSalary ? 'Hide Salary' : 'Show Salary' }}
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                    </div>
                </div>

                <div class="col-md-4 mb-4 fade-in-section">
                    <div class="home-hover mb-4">
                        <div class="homeCard2">
                        <div class="px-3 py-2" style="color: #677A8E; font-weight:500;">
                                    <p style="font-size:12px;">Quick Access</p>
                                </div>
                                <div style="display: flex; justify-content: space-between; position: relative;">
                                    <div class="quick col-md-7 px-3 py-0">
                                        <a href="/reimbursement" class="quick-link">Reimbursement</a>
                                        <a href="/itstatement" class="quick-link">IT Statement</a>
                                        <a href="#" class="quick-link">YTD Reports</a>
                                        <a href="#" class="quick-link">Loan Statement</a>
                                    </div>
                                <div class="col-md-5" style="text-align: center; background-color: #FFF8F0; padding: 5px 10px; border-radius: 10px; font-size: 8px; font-family: montserrat; position: absolute; bottom: 0; right: 0;">
                                    <img src="images/quick_access.png" style="padding-top: 2em; width: 6em">
                                    <p class="pt-4">Use quick access to view important salary details.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="home-hover">
                        <div class="homeCard4" style="padding:10px 15px;justify-content:center;display: flex;flex-direction:column;">
                            <div >
                                <p style="font-size:12px;color:#778899;font-weight:500;">POI</p>
                            </div>
                            <div style="display:flex;gap:10px;align-items:center;margin-bottom:10px;">
                                <img src="images/pen.png" alt="Image Description" style="width: 4em;">
                                <p style="color: #677A8E;  font-size: 12px;margin-top:5px;">Hold on! You can submit your Proof of Investments (POI) once released.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4 fade-in-section">
                    <div class="home-hover">
                        <div class="homeCard1">
                            <div style="color: #677A8E;font-weight:500; margin-left: 20px;  margin-top: 10px;">
                            <p style="font-size:12px;">Track</p>
                            </div>

                            <div style="text-align: center">
                                <img src="images/track.png" alt="Image Description" style="width: 9em;">
                                <div class="B" style="color: black; ">
                                    <p style="color: #677A8E; font-size: 11px; margin-top: 20px;">All good! You've nothing new to track.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($showAlertDialog)
                <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                                <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title"><b>Swipes</b></h5>
                                <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="close" style="background-color: white; height:10px;width:10px;" >
                                </button>
                            </div>
                            <div class="modal-body" style="max-height:500;overflow-y:auto">
                                <div class="row">
                                    <div class="col" style="font-size: 10px;">Date : <b>{{$currentDate}}</b></div>
                                    <div class="col" style="font-size: 10px;">Shift Time : <b>10:00 to 19:00</b></div>
                                </div>
                                <table class="swipes-table" style="width: 100%;">
                                    <tr style="background-color: #f2f2f2;color:black">
                                        <th style="font-size: 12px; text-align:center;padding:5px">Swipe Time</th>
                                        <th style="font-size: 12px; text-align:center;padding:5px">Sign-In / Sign-Out</th>
                                    </tr>

                                    @if (!is_null($swipeDetails) && $swipeDetails->count() > 0)
                                    @foreach ($swipeDetails as $swipe)
                                    <tr style="border:1px solid #f2f2f2;">
                                        <td style="font-size: 10px; color: black;text-align:center;padding:5px">{{ $swipe->swipe_time }}</td>
                                        <td style="font-size: 10px; color: black;text-align:center;padding:5px">{{ $swipe->in_or_out }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td style="font-size: 10px; color: black;text-align:center;padding:5px" colspan="2">No swipe records found for today.</td>
                                    </tr>
                                    @endif

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade show blurred-backdrop"></div>
                @endif

            </div>
   </div>


</body>

</div>
<script>
    // Function to check if an element is in the viewport
    function isElementInViewport(el) {
        var rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    // Function to check for elements to fade in
    function checkFadeIn() {
        // alert("scroll");
        const fadeInSection = document.querySelectorAll('.fade-in-section');
        fadeInSection.forEach((element) => {
            if (isElementInViewport(element)) {
                element.classList.add('fade-in');
            }
        });
    }

    // Event listener for scroll event
    // window.addEventListener('scroll', checkFadeIn);
    // document.getElementById("homeBody").onscroll = function() {checkFadeIn()};

    // Initial check on page load
    window.addEventListener('load', checkFadeIn);

    // Function to change the quote text
    function changeQuote() {
        const quotes = [{
                text: "Life is 10% what happens to us and 90% how we react to it.",
                author: "Dennis P. Kimbro"
            },
            {
                text: "Your new Employee Self Service portal is here. Watch the video to learn more.",
                author: "Anonymous"
            },
            {
                text: "Things usually work out in the end. What if they don't? That just means you haven't come to the end yet.",
                author: "Jeanette Walls"
            }
            // Add more quotes here as needed
        ];

        const quoteElement = document.querySelector('.quote-text');
        const authorElement = document.querySelector('.author-text');
        const randomIndex = Math.floor(Math.random() * quotes.length);
        const randomQuote = quotes[randomIndex];

        quoteElement.textContent = randomQuote.text;
        authorElement.textContent = `- ${randomQuote.author}`;
    }

    // Call the function to initially set the quote
    changeQuote();

    // Set an interval to change the quote every 5 seconds (5000 milliseconds)
    setInterval(changeQuote, 5000);


    var combinedData = {
    datasets: [
        {
            data: [
                {{ !empty($salaries) ? $salaries->calculateTotalAllowance() : 0 }},
                2, // Placeholder value for the second dataset
            ],
            backgroundColor: [
                '#000000', // Color for Gross Pay
            ],
        },
        {
            data: [
                {{ !empty($salaries) && method_exists($salaries, 'calculateTotalDeductions') ? $salaries->calculateTotalDeductions() : 0 }},
                {{ !empty($salaries) && method_exists($salaries, 'calculateTotalAllowance') ? $salaries->calculateTotalAllowance() - $salaries->calculateTotalDeductions() : 0 }},
            ],
            backgroundColor: [
                '#B9E3C6', // Color for Deductions
                '#1C9372', // Color for Net Pay
            ],
        },
    ],
};

var outerCtx = document.getElementById('combinedPieChart').getContext('2d');

var combinedPieChart = new Chart(outerCtx, {
    type: 'doughnut',
    data: combinedData,
    options: {
        cutout: '60%', // Adjust the cutout to control the size of the outer circle
        legend: {
            display: false,
        },
        tooltips: {
            enabled: false,
        },
    },
}
);


</script>
