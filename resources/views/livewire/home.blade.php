<div style="position:relative;">
    <div class="msg-container">
        @if ($showAlert)
            <div id="alert-container" class="d-flex justify-content-center alert-container mb-3" wire:poll.1s="hideAlert"
                style="position: absolute; top: 3%; z-index: 10; width: 100%;">
                <!-- wire:poll.5s="hideAlert" -->
                <p class="alert alert-success" role="alert"
                    style=" font-weight: 400;width:fit-content;padding:10px;border-radius:5px;margin-bottom:0px">
                    {{ session('success') }} 😀
                    <span class="ml-5" style="font-weight:500;margin:0px 10px 0px 20px; cursor: pointer; "
                        wire:click='hideAlert'>x</span>
                </p>
            </div>
        @endif
    </div>
    <div class="content">
        <div class="row m-0 p-0 mb-3">
            <div class="col-md-6 mb-3">
                <div class="row m-0" style="border-radius: 10px; background-color: #02114f;">
                    <div class="col-6 p-0 ps-3 pt-4">
                        @if ($this->greetingText)
                            <p class="morning-city">{{ $greetingText }}</p>
                        @endif
                        <p class="morning-city">Welcome<br>
                            {{ ucwords(strtolower($loginEmployee->first_name)) }}
                            &nbsp;{{ ucwords(strtolower($loginEmployee->last_name)) }}
                        </p>
                    </div>

                    <div class="col-6 p-0">
                        <div class="morning-cardContainer w-100">
                            <div class="morning-card w-100">

                                <div class="morning-weather-image">
                                    @if ($weatherCode == 0)
                                        <img src="{{ asset('images/cloudy.gif') }}" class="skyMornImg"
                                            alt="Clear sky" />
                                    @elseif(in_array($weatherCode, [1, 2]))
                                        <img src="{{ asset('images/cloudy.gif') }}" class="skyMornImg"
                                            alt="Partly Cloudy" />
                                    @elseif($weatherCode == 3)
                                        <img src="{{ asset('images/cloudy.gif') }}" class="skyMornImg" alt="Overcast" />
                                    @elseif(in_array($weatherCode, [51, 53, 55, 61, 63, 65, 80, 81, 82]))
                                        <img src="{{ asset('images/cloudy.gif') }}" class="skyMornImg" alt="Rainy" />
                                    @elseif(in_array($weatherCode, [95, 96, 99]))
                                        <img src="{{ asset('images/cloudy.gif') }}" class="skyMornImg"
                                            alt="Thunderstorm" />
                                    @elseif(in_array($weatherCode, [71, 73, 75, 77, 85, 86]))
                                        <img src="{{ asset('images/cloudy.gif') }}" class="skyMornImg" alt="Snow" />
                                    @elseif(in_array($weatherCode, [45, 48]))
                                        <img src="{{ asset('images/cloudy.gif') }}" class="skyMornImg"
                                            alt="Fog" />
                                    @elseif(in_array($weatherCode, [56, 57, 66, 67]))
                                        <img src="{{ asset('images/cloudy.gif') }}" class="skyMornImg"
                                            alt="Freezing Rain" />
                                    @else
                                        <img src="{{ asset('images/cloudy.gif') }}" class="skyMornImg"
                                            alt="Weather" />
                                    @endif
                                </div>

                                <p class="morning-temp">{{ $temperature }}°C</p>
                                <div class="morning-minmaxContainer">
                                    <div class="morning-min">
                                        <p class="morning-minTemp">Wind Speed</p>
                                        <p class="morning-minHeading">{{ $windspeed }} km/h</p>

                                    </div>
                                    <div class="morning-max">

                                        <p class="morning-maxTemp">Wind Direction</p>
                                        <p class="morning-maxHeading">{{ $winddirection }} °</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="col-md-6">
                <div class="pt-4"
                    style="border-radius: 10px; background-color: #02114f; text-align: -webkit-center; position: relative">

                    <div class="section-banner">
                        <div id="star-1">
                            <div class="curved-corner-star">
                                <div id="curved-corner-bottomright"></div>
                                <div id="curved-corner-bottomleft"></div>
                            </div>
                            <div class="curved-corner-star">
                                <div id="curved-corner-topright"></div>
                                <div id="curved-corner-topleft"></div>
                            </div>
                        </div>

                        <div id="star-2">
                            <div class="curved-corner-star">
                                <div id="curved-corner-bottomright"></div>
                                <div id="curved-corner-bottomleft"></div>
                            </div>
                            <div class="curved-corner-star">
                                <div id="curved-corner-topright"></div>
                                <div id="curved-corner-topleft"></div>
                            </div>
                        </div>

                        <div id="star-3">
                            <div class="curved-corner-star">
                                <div id="curved-corner-bottomright"></div>
                                <div id="curved-corner-bottomleft"></div>
                            </div>
                            <div class="curved-corner-star">
                                <div id="curved-corner-topright"></div>
                                <div id="curved-corner-topleft"></div>
                            </div>
                        </div>

                        <div id="star-4">
                            <div class="curved-corner-star">
                                <div id="curved-corner-bottomright"></div>
                                <div id="curved-corner-bottomleft"></div>
                            </div>
                            <div class="curved-corner-star">
                                <div id="curved-corner-topright"></div>
                                <div id="curved-corner-topleft"></div>
                            </div>
                        </div>

                        <div id="star-5">
                            <div class="curved-corner-star">
                                <div id="curved-corner-bottomright"></div>
                                <div id="curved-corner-bottomleft"></div>
                            </div>
                            <div class="curved-corner-star">
                                <div id="curved-corner-topright"></div>
                                <div id="curved-corner-topleft"></div>
                            </div>
                        </div>

                        <div id="star-6">
                            <div class="curved-corner-star">
                                <div id="curved-corner-bottomright"></div>
                                <div id="curved-corner-bottomleft"></div>
                            </div>
                            <div class="curved-corner-star">
                                <div id="curved-corner-topright"></div>
                                <div id="curved-corner-topleft"></div>
                            </div>
                        </div>

                        <div id="star-7">
                            <div class="curved-corner-star">
                                <div id="curved-corner-bottomright"></div>
                                <div id="curved-corner-bottomleft"></div>
                            </div>
                            <div class="curved-corner-star">
                                <div id="curved-corner-topright"></div>
                                <div id="curved-corner-topleft"></div>
                            </div>
                        </div>


                    </div>
                    <div class="locationGlobe">
                        <i class="fa-solid fa-location-dot me-2" style="color: red;"></i>
                        {{ $city }},{{ $country }}-{{ $postal_code }}
                    </div>
                </div>

            </div>

        </div>


        <!-- main content -->

        <div class="row m-0">
            <div class="col-md-3 mb-4 ">
                <div class="">
                    <div class="homeCard4">
                        <div class="p-3">
                            <p class="payslip-card-title ">{{ $currentDate }}</p>
                            <p style="margin-top: 10px; font-size: 11px;">
                                @php
                                    // Fetch shift times
                                    $EmployeeStartshiftTime = $employeeShiftDetails->shift_start_time;
                                    $EmployeeEndshiftTime = $employeeShiftDetails->shift_end_time;

                                    // Default times
                                    $defaultStartShiftTime = '10:00 am';
                                    $defaultEndShiftTime = '7:00 pm';

                                    // Format the times if they are not null
                                    $formattedStartShiftTime = $EmployeeStartshiftTime
                                        ? (new DateTime($EmployeeStartshiftTime))->format('h:i a')
                                        : $defaultStartShiftTime;
                                    $formattedEndShiftTime = $EmployeeEndshiftTime
                                        ? (new DateTime($EmployeeEndshiftTime))->format('h:i a')
                                        : $defaultEndShiftTime;

                                @endphp
                                {{ substr($currentDay, 0, 3) }} | {{ $formattedStartShiftTime }} to
                                {{ $formattedEndShiftTime }}
                            </p>
                            <div class="d-flex" style="font-size: 14px;margin-top:2em;">
                                <img src="/images/stopwatch.png" class="me-4" alt="Image Description"
                                    style="width: 2.7em;">
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
                            <div class="A"
                                style="display: flex;flex-direction:row;justify-content:space-between; align-items:center;margin-top:2em">
                                <a style="width:50%;font-size:11px;cursor: pointer;color:blue" wire:click="open">View
                                    Swipes</a>
                                <button id="signButton"
                                    style="color: white; width: 80px; height: 26px;font-size:10px; background-color: rgb(2, 17, 79); border: 1px solid #CFCACA; border-radius: 5px; "
                                    wire:click="toggleSignState">
                                    @if ($swipes)
                                        @if ($swipes->in_or_out == 'OUT')
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

            @if ($ismanager)
                <div class="col-md-3 mb-4 ">
                    <div class="payslip-card" style="height: 195px;">
                        <p class="payslip-card-title">Review</p>
                        <!-- <p class="payslip-small-desc">
                    Submit your time sheet for this week.
                </p> -->
                    @if ($this->count > 0)
                    <div class="notify d-flex justify-content-between">
                        <p class="payslip-small-desc" style="font-size: 12px; font-weight: 500;">
                            {{ $count }} <br>
                            <span class="normalTextValue">Things to review</span>
                        </p>
                        <img src="https://png.pngtree.com/png-vector/20190214/ourlarge/pngtree-vector-notes-icon-png-image_509622.jpg"
                            alt="" style="height: 40px; width: 40px;">
                    </div>
                    <div class="leave-display d-flex align-items-center border-top pt-3 gap-3">
                        @php
                        function getRandomColor()
                        {
                        $colors = ['#FFD1DC', '#B0E57C', '#ADD8E6', '#E6E6FA', '#FFB6C1'];
                        return $colors[array_rand($colors)];
                        }
                        @endphp
                        @php
                        // Separate requests into those to show and those to hide
                        $requestsToShow = array_slice($groupedRequests, 0, 3, true);
                        $totalRequests = count($groupedRequests);
                        $requestsToHide = $totalRequests > 3 ? array_slice($groupedRequests, 3, null, true) : [];
                        @endphp

                        @foreach ($requestsToShow as $empId => $data)
                        @php
                        $leaveRequests = $data['leaveRequests'];
                        $count = $data['count'];

                        // Use the first leave request to get employee details
                        $firstLeaveRequest = $leaveRequests[0];
                        if ($firstLeaveRequest && $firstLeaveRequest->employee) {
                        $firstName = $firstLeaveRequest->employee->first_name;
                        $lastName = $firstLeaveRequest->employee->last_name;
                        $initials = strtoupper(substr($firstName, 0, 1)) . strtoupper(substr($lastName, 0, 1));
                        } else {
                        $firstName = 'Unknown';
                        $lastName = '';
                        $initials = '?';
                        }
                        @endphp
                        <div class="circle-container d-flex flex-column mr-3 payslip-small-desc text-center position-relative">
                            <div class="thisCircle d-flex align-items-center justify-content-center"
                                style="border: 2px solid {{ getRandomColor() }}" data-toggle="tooltip"
                                data-placement="top" title="{{ $firstName }} {{ $lastName }}">
                                <span>{{ $initials }}</span>
                            </div>
                            @if ($count > 1)
                            <span class="badge badge-pill badge-info position-absolute translate-middle badge-count">
                                {{ $count }}
                            </span>
                            @endif
                            <span class="leaveText">Leave</span>
                        </div>
                        @endforeach

                        @if ($totalRequests > 3)
                        <div class="payslip-small-desc remainContent d-flex flex-column align-items-center"
                            wire:click="reviewLeaveAndAttendance">
                            <span>+{{ $totalRequests - 3 }}
                            <span>More</span>
                            </span>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <p class="payslip-small-desc mb-2 homeText">
                            Hurrah! You've nothing to review.
                        </p>
                    </div>
                    @endif
                    <a href="/employees-review">
                        <div class="payslip-go-corner">
                            <div class="payslip-go-arrow">→</div>
                        </div>
                    </a>
                </div>

            </div>
            @if ($showReviewLeaveAndAttendance)
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                            <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title">
                                <b>Review</b>
                            </h5>
                            <button type="button" class="btn-close btn-primary" aria-label="Close"
                                wire:click="closereviewLeaveAndAttendance"
                                style="background-color: white; height:10px;width:10px;">
                            </button>
                        </div>
                        <div class="modal-body">
                            <h6 class="normalTextValue">Leave Requests</h6>
                            <div class="d-flex flex-row gap-2">
                                @if ($totalRequests > 3)
                                <div class="d-flex flex-row">
                                    @foreach ($requestsToHide as $empId => $data)
                                    @php
                                    $leaveRequests = $data['leaveRequests'];
                                    $count = $data['count'];

                                    // Use the first leave request to get employee details
                                    $firstLeaveRequest = $leaveRequests[0];
                                    if ($firstLeaveRequest && $firstLeaveRequest->employee) {
                                    $firstName = $firstLeaveRequest->employee->first_name;
                                    $lastName = $firstLeaveRequest->employee->last_name;
                                    $initials = strtoupper(substr($firstName, 0, 1)) . strtoupper(substr($lastName, 0, 1));
                                    } else {
                                    $firstName = 'Unknown';
                                    $lastName = '';
                                    $initials = '?';
                                    }
                                    @endphp
                                    <div class="circle-container d-flex flex-column mr-3 payslip-small-desc text-center position-relative">
                                        <div class="thisCircle d-flex align-items-center justify-content-center"
                                            style="border: 2px solid {{ getRandomColor() }}" data-toggle="tooltip"
                                            data-placement="top" title="{{ $firstName }} {{ $lastName }}">
                                            <span>{{ $initials }}</span>
                                        </div>
                                        @if ($count > 1)
                                        <span class="badge badge-pill badge-info position-absolute translate-middle badge-count">
                                            {{ $count }}
                                        </span>
                                        @endif
                                        <span class="leaveText">Leave</span>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            <h6  class="normalTextValue">Attendance Requests</h6>
                            <div class="d-flex flex-row">
                                @for ($i = 0; $i <= $countofregularisations; $i++)
                                    <?php
                                    // Fetch the regularisation at the current index
                                    $regularisation = $this->regularisations[$i] ?? null;
                                    if ($regularisation && $regularisation->employee) {
                                        $firstName = $regularisation->employee->first_name;
                                        $lastName = $regularisation->employee->last_name;
                                        $initials = strtoupper(substr($firstName, 0, 1)) . strtoupper(substr($lastName, 0, 1));
                                    ?> <div class=" d-flex flex-column mr-3">
                                    <div class="thisCircle d-flex"
                                        style="border: 2px solid {{ getRandomColor() }}"
                                        data-toggle="tooltip" data-placement="top"
                                        title="{{ $firstName }} {{ $lastName }}">
                                        <span>{{ $initials }}</span>
                                    </div>
                                    <span
                                        style="display: block;font-size:10px;color:#778899;text-align:center;overflow: hidden; text-overflow: ellipsis;max-width:30px;white-space:nowrap;">Attendance
                                        Regularisation</span>
                            </div>

                        <?php
                                    }
                        ?>
                        @endfor
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cancel-btn" style="border:1px solid rgb(2,17,79);"
                            data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
        @endif
        @endif

        <div class="col-md-3 mb-4 ">
            <div class="payslip-card" style="height: 195px;">
                <p class="payslip-card-title mb-0">Upcoming Holidays</p>
                @if ($calendarData->isEmpty())
                <p class="payslip-small-desc mt-3">Uh oh! No holidays to show.</p>
                @else
                @php
                $count = 0;
                @endphp

                <div class="row m-0">
                    <div class="col-12 p-0">
                        @foreach ($calendarData as $entry)
                        @if (!empty($entry->festivals))
                        <div>
                            <p class="payslip-small-desc mt-3" style=" font-size:0.75rem;">
                                <span
                                    style="font-weight: 500;">{{ date('d M', strtotime($entry->date)) }}
                                    <span
                                        style="font-size: 10px; font-weight: normal;">{{ date('l', strtotime($entry->date)) }}</span></span>
                                <br>
                                <span
                                    style="font-size: 11px; font-weight: normal;">{{ ucfirst($entry->festivals) }}</span>
                            </p>
                        </div>
                        @php
                        $count++;
                        @endphp
                        @endif

                        @if ($count >= 2)
                        @break
                        @endif
                        @endforeach
                    </div>
                </div>


                @endif
                <a href="/holiday-calendar">
                    <div class="payslip-go-corner">
                        <div class="payslip-go-arrow">→</div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-3 mb-4 ">
            <div class="payslip-card" style="height: 195px;">
                <p class="payslip-card-title">Time Sheet</p>
                <p class="payslip-small-desc">
                    Submit your time sheet for this week.
                </p>
                <a href="/time-sheet">
                    <div class="payslip-go-corner">
                        <div class="payslip-go-arrow">→</div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-3 mb-4 ">
            <div class="payslip-card" style="height: 195px;">
                <p class="payslip-card-title">Apply for a Leave</p>
                <p class="payslip-small-desc">
                    Kindly click on the Arrow button to apply a leave.
                </p>
                <a href="/leave-form-page">
                    <div class="payslip-go-corner">
                        <div class="payslip-go-arrow">→</div>
                    </div>
                </a>
            </div>

        </div>

        @if ($ismanager)
        <div class="col-md-6 mb-4 ">
            <div class="payslip-card">
                <p class="payslip-card-title">Who is in?</p>
                <!-- <p class="payslip-small-desc">
Submit your time sheet for this week.
</p> -->

                <div class="who-is-in d-flex flex-column justify-content-start ">
                    <p class="mb-2  mt-2 section-name payslip-small-desc">
                        Not Yet In ({{ $CountAbsentEmployees }})
                    </p>
                    <div class="team-leave d-flex flex-row gap-3">
                        @php
                        function getRandomAbsentColor()
                        {
                        $colors = ['#FFD1DC', '#D2E0FB', '#ADD8E6', '#E6E6FA', '#F1EAFF', '#FFC5C5'];
                        return $colors[array_rand($colors)];
                        }
                        @endphp
                        @if ($CountAbsentEmployees > 0)
                        @for ($i = 0; $i < min($CountAbsentEmployees, 5); $i++)
                            @if (isset($AbsentEmployees[$i]))
                            @php
                            $employee=$AbsentEmployees[$i];
                            $randomColorAbsent='#' . str_pad(dechex(mt_rand(0, 0xffffff)), 6, '0' , STR_PAD_LEFT);
                            @endphp
                            <a href="/whoisinchart" style="text-decoration: none;">
                            <div class="thisCircle"
                                style="border: 2px solid {{ getRandomAbsentColor() }};"
                                data-toggle="tooltip" data-placement="top"
                                title="{{ ucwords(strtolower($employee['first_name'])) }} {{ ucwords(strtolower($employee['last_name'])) }}">
                                <span class="initials">
                                    {{ strtoupper(substr(trim($employee['first_name']), 0, 1)) }}{{ strtoupper(substr(trim($employee['last_name']), 0, 1)) }}
                                </span>
                            </div>
                            </a>
                            @endif
                            @endfor
                            @else
                            <p class="payslip-small-desc">No employees are absent today</p>
                            @endif
                            @if ($CountAbsentEmployees > 5)
                            <div
                                class="remainContent d-flex flex-column align-items-center payslip-small-desc" wire:click="openAbsentEmployees">
                                <span>+{{ $CountAbsentEmployees - 5 }}</span>
                                <p class="mb-0" style="margin-top:-5px;">More</p>
                            </div>
                            @endif
                    </div>
                </div>
                <!-- /second row -->

                <div class="who-is-in d-flex flex-column justify-content-start ">
                    <p class="mb-2 mt-2 section-name mt-1 payslip-small-desc">
                        Late Arrival ({{ $CountLateSwipes }})
                    </p>
                    <div class="team-leave d-flex flex-row  gap-3">
                        @php
                        function getRandomLateColor()
                        {
                        $colors = ['#FFD1DC', '#D2E0FB', '#ADD8E6', '#E6E6FA', '#F1EAFF', '#FFC5C5'];
                        return $colors[array_rand($colors)];
                        }
                        @endphp
                        @if ($CountLateSwipes > 0)
                        @for ($i = 0; $i < min($CountLateSwipes, 5); $i++)
                            @php $employee=$LateSwipes[$i]; @endphp
                            @if (isset($LateSwipes[$i]))
                            <a href="/whoisinchart" style="text-decoration: none;">
                            <div class="thisCircle"
                                style="border: 2px solid {{ getRandomAbsentColor() }};border-radius:50%;width: 35px;height: 35px;display: flex;align-items: center;justify-content: center;"
                                data-toggle="tooltip" data-placement="top"
                                title="{{ ucwords(strtolower($employee['first_name'])) }} {{ ucwords(strtolower($employee['last_name'])) }}">
                                <span class="initials">
                                    {{ strtoupper(substr(trim($employee['first_name']), 0, 1)) }}{{ strtoupper(substr(trim($employee['last_name']), 0, 1)) }}
                                </span>
                            </div>
                            </a>
                            @endif
                            @endfor
                            @else
                            <p class="payslip-small-desc">No employees arrived late today</p>
                            @endif
                            @if ($CountLateSwipes > 5)
                            <div
                                class="remainContent d-flex flex-column align-items-center payslip-small-desc" wire:click="openLateEmployees">
                                <span>+{{ $CountLateSwipes - 5 }}</span>
                                <p class="mb-0" style="margin-top:-5px;">More</p>
                            </div>
                            @endif
                    </div>
                </div>

                <!-- /third row -->

                <div class="who-is-in d-flex flex-column justify-content-start">
                    <p class="mb-2 mt-2 section-name mt-1 payslip-small-desc">
                        On Time ({{ $CountEarlySwipes }})
                    </p>
                    <div class="team-leave d-flex flex-row gap-3">
                        @php
                        function getRandomEarlyColor()
                        {
                        $colors = ['#FFD1DC', '#D2E0FB', '#ADD8E6', '#E6E6FA', '#F1EAFF', '#FFC5C5'];
                        return $colors[array_rand($colors)];
                        }
                        @endphp
                        @if ($CountEarlySwipes)
                        @for ($i = 0; $i < min($CountEarlySwipes, 5); $i++)
                            @if (isset($EarlySwipes[$i]))
                            @php
                            $employee=$EarlySwipes[$i];
                            $randomColorEarly='#' .
                            str_pad(dechex(mt_rand(0xcccccc, 0xffffff)), 6, '0' , STR_PAD_LEFT);
                            @endphp
                            <a href="/whoisinchart" style="text-decoration: none;">
                            <div class="thisCircle" style="border: 2px solid {{ getRandomAbsentColor() }};border-radius:50%;width: 35px;height: 35px;display: flex;align-items: center;justify-content: center;"
                                data-toggle="tooltip" data-placement="top"
                                title="{{ ucwords(strtolower($employee['first_name'])) }} {{ ucwords(strtolower($employee['last_name'])) }}">
                                <span class="initials">
                                    {{ strtoupper(substr(trim($employee['first_name']), 0, 1)) }}{{ strtoupper(substr(trim($employee['last_name']), 0, 1)) }}
                                </span>
                            </div>
                            </a>
                            @endif
                            @endfor
                            @else
                            <p class="payslip-small-desc">No employees arrived early today</p>
                            @endif
                            @if ($CountEarlySwipes > 5)
                            <div
                                class="remainContent d-flex flex-column align-items-center payslip-small-desc" wire:click="openEarlyEmployees">
                                <span>+{{ $CountEarlySwipes - 5 }}</span>
                                <p class="mb-0" style="margin-top:-5px;">More</p>
                            </div>
                            @endif
                    </div>
                </div>

                <a href="/whoisinchart">
                    <div class="payslip-go-corner">
                        <div class="payslip-go-arrow">→</div>
                    </div>
                </a>
            </div>

        </div>
        @endif

        <!-- TEAM ON LEAVE -->
        @if ($this->showLeaveApplies)
        <div class="col-md-3 mb-4 ">
            <div class="home-hover">
                <div class="reviews">
                    <div class="homeCard4 p-3">
                        <div class="team-heading  mt-2 d-flex justify-content-between">
                            <div>
                                <p class="teamOnLeave"> Team On Leave</pclass>
                            </div>
                            <div>
                                <a href="/team-on-leave-chart" style="font-size:16px; "><img
                                        src="/images/up-arrow.png" alt=""
                                        style="width:20px;height:27px;"></a>
                            </div>
                        </div>
                        @if ($this->teamCount > 0)
                        <div class="team-Notify ">
                            <p class="payslip-small-desc">
                                Today ({{ $teamCount }}) </p>
                            <div class="team-leave d-flex flex-row  gap-3">
                                @php
                                function getRandomLightColor()
                                {
                                $colors = ['#FFD1DC', '#B0E57C', '#ADD8E6', '#E6E6FA', '#FFB6C1'];
                                return $colors[array_rand($colors)];
                                }
                                @endphp

                                @for ($i = 0; $i < min($teamCount, 3); $i++)
                                    <?php
                                    $teamLeave = $this->teamOnLeave[$i] ?? null;
                                    if ($teamLeave) {
                                        $initials = strtoupper(substr($teamLeave->employee->first_name, 0, 1) . substr($teamLeave->employee->last_name, 0, 1));
                                    ?> <div class="thisCircle"
                                    style="  border: 2px solid {{ getRandomLightColor() }};"
                                    data-toggle="tooltip" data-placement="top"
                                    title="{{ ucwords(strtolower($teamLeave->employee->first_name)) }} {{ ucwords(strtolower($teamLeave->employee->last_name)) }}">
                                    <span>{{ $initials }}</span>
                            </div>

                        <?php
                                    }
                        ?>
                        @endfor
                        @if ($teamCount > 3)
                        <div class="remainContent d-flex mt-3 flex-column align-items-center">
                            <a href="/team-on-leave-chart">
                                <span>+{{ $teamCount - 3 }}</span>
                                <p class="mb-0" style="margin-top:-5px;">More</p>
                            </a>
                        </div>
                        @endif
                        </div>

                        <div class="mt-4">
                            <p class="payslip-small-desc">
                                This month ({{ $upcomingLeaveApplications }}) </p>
                            @if ($upcomingLeaveRequests)
                            <div wire:ignore class="mt-2 d-flex align-items-center gap-3 mb-3">
                                @foreach ($upcomingLeaveRequests->take(3) as $requests)
                                @php
                                $randomColorList =
                                '#' .
                                str_pad(dechex(mt_rand(0, 0xffffff)), 6, '0', STR_PAD_LEFT);
                                @endphp
                                <div wire:ignore class="d-flex gap-4 align-items-center">
                                    <div class="thisCircle"
                                        style="border: 1px solid {{ $randomColorList }}">
                                        <span>{{ substr($requests->employee->first_name, 0, 1) }}{{ substr($requests->employee->last_name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                                @if ($upcomingLeaveRequests->count() > 3)
                                <div class="remainContent d-flex flex-column align-items-center">
                                    <!-- Placeholder color -->
                                    <a href="/team-on-leave-chart">
                                        <span>+{{ $upcomingLeaveRequests->count() - 3 }} </span>
                                        <span style="margin-top:-5px;">More</span>
                                    </a>
                                </div>
                                @endif
                            </div>
                            @endif
                            <p class="homeText"><a href="/team-on-leave-chart">Click here</a> to see
                                who will be on leave in the
                                upcoming days!</p>
                        </div>
                    </div>
                    @else
                    <div
                        style="display:flex;justify-content:center;flex-direction:column;align-items:center;">
                        <img src="{{asset('images/no data.png')}}" name="noData" id="noData"
                            alt="Image Description" style="width: 120px; height:100px;">
                        <p class="homeText">
                            Wow! No leaves planned today.
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif




    <div class="col-md-4 mb-4 ">

        <div class="payslip-card">
            <p class="payslip-card-title">Payslip</p>

            @if ($salaryRevision->isEmpty())
            <p class="payslip-small-desc">
                We are working on your payslip!
            </p>
            @else
            @foreach ($salaryRevision as $salaries)
            <div wire:ignore class="d-flex justify-content-between align-items-center mt-3">
                <div style="position: relative;">
                    <!-- {{-- <canvas id="outerPieChart" width="120" height="120"></canvas>
                                                    <canvas id="innerPieChart" width="60" height="60" style="position: absolute; top: 5px;"></canvas> --}} -->
                    <canvas id="combinedPieChart" width="100" height="100"></canvas>
                </div>
                <div class="c"
                    style="font-size: 12px; font-weight: normal; font-weight: 500; color: #9E9696;display:flex; flex-direction:column;justify-content:flex-end;">
                    <p style="color:#333;">{{ date('M Y', strtotime('-1 month')) }}</p>
                    <p
                        style="display:flex;justify-content:end;flex-direction:column;align-items:end; color:#333;">
                        {{ date('t', strtotime('-1 month')) }} <br>
                        <span style="color:#778899;">Paid days</span>
                    </p>
                </div>
            </div>

            <div style="display:flex ;flex-direction:column; margin-top:20px;  ">
                <div class="net-salary">
                    <div style="display:flex;gap:10px;">
                        <div
                            style="padding:2px;width:2px;height:17px;background:#000000;border-radius:2px;">
                        </div>
                        <p style="font-size:11px;margin-bottom:10px;">Gross Pay</p>
                    </div>
                    <p style="font-size:12px;">
                        {{ $showSalary ? '₹ ' . number_format($salaries->calculateTotalAllowance(), 2) : '*********' }}
                    </p>
                </div>
                <div class="net-salary">
                    <div style="display:flex;gap:10px;">
                        <div
                            style="padding:2px;width:2px;height:17px;background:#B9E3C6;border-radius:2px;">
                        </div>
                        <p style="font-size:11px;margin-bottom:10px;">Deduction</p>
                    </div>
                    <p style="font-size:12px;">
                        {{ $showSalary ? '₹ ' . number_format($salaries->calculateTotalDeductions() ?? 0, 2) : '*********' }}
                    </p>

                </div>
                <div class="net-salary">
                    <div style="display:flex;gap:10px;">
                        <div
                            style="padding:2px;width:2px;height:17px;background:#1C9372;border-radius:2px;">
                        </div>
                        <p style="font-size:11px;margin-bottom:10px;">Net Pay</p>
                    </div>
                    @if ($salaries->calculateTotalAllowance() - $salaries->calculateTotalDeductions() > 0)
                    <p style="font-size:12px;">
                        {{ $showSalary ? '₹ ' . number_format(max($salaries->calculateTotalAllowance() - $salaries->calculateTotalDeductions(), 0), 2) : '*********' }}
                    </p>
                    @endif
                </div>
            </div>

            <div class="show-salary"
                style="display: flex; color: #1090D8; justify-content:space-between;font-size: 12px;  margin-top: 20px; font-weight: 100;">
                <a href="/your-download-route" id="pdfLink2023_4" class="pdf-download"
                    download>Download PDF</a>
                <a wire:click="toggleSalary" class="showHideSalary">
                    {{ $showSalary ? 'Hide Salary' : 'Show Salary' }}
                </a>
            </div>
            @endforeach
            @endif

            <a href="/slip">
                <div class="payslip-go-corner">
                    <div class="payslip-go-arrow">→</div>
                </div>
            </a>

        </div>
    </div>

    <div class="col-md-4 mb-4 ">

        <div class="payslip-card mb-3">
            <p class="payslip-card-title">Quick Access</p>
            <!-- <p class="small-desc">
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat
veritatis nobis saepe itaque rerum nostrum aliquid obcaecati odio
officia deleniti. Expedita iste et illum, quaerat pariatur consequatur
eum nihil itaque!
</p> -->
            <div style="display: flex; justify-content: space-between; position: relative;">
                <div class="quick col-md-7 px-3 py-0 ps-0">
                    <a href="/reimbursement" class="quick-link">Reimbursement</a>
                    <a href="/itstatement" class="quick-link">IT Statement</a>
                    <a href="#" class="quick-link">YTD Reports</a>
                    <a href="#" class="quick-link">Loan Statement</a>
                </div>
                <div class="col-md-5"
                    style="text-align: center; background-color: #FFF8F0; padding: 5px 10px; border-radius: 10px; font-size: 8px; font-family: montserrat; position: absolute; bottom: 0; right: 0;">
                    <img src="images/quick_access.png" style="padding-top: 2em; width: 6em">
                    <p class="pt-4">Use quick access to view important salary details.</p>
                </div>
            </div>
            <div class="payslip-go-corner">
                <div class="payslip-go-arrow">→</div>
            </div>
        </div>

        <div class="payslip-card mb-3">
            <p class="payslip-card-title">POI</p>
            <p class="payslip-small-desc">
                Hold on! You can submit your Proof of Investments (POI) once released.
            </p>
            <a href="#">
                <div class="payslip-go-corner">
                    <div class="payslip-go-arrow">→</div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-4 mb-4 ">

        <div class="payslip-card mb-3">

        <div>
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="payslip-card-title">Task Overview</h5>
                <div>
                    <select class="form-select custom-select-width"
                        wire:change="$set('filterPeriod', $event.target.value)">
                        <option value="this_month" selected>This month</option>
                        <option value="last_month">Last month</option>
                        <option value="this_year">This year</option>
                    </select>
                </div>
            </div>


                <div class="row text-center mt-3">
                    <div class="col-4">
                        <h3 class="text-primary mb-1 track-text">{{ $TaskAssignedToCount }}</h3>
                        <p class="mb-0 track-text">Tasks Assigned</p>
                    </div>
                    <div class="col-4">
                        <h3 class="text-success mb-1 track-text">{{ $TasksCompletedCount }}</h3>
                        <p class="mb-0 track-text">Tasks Completed</p>
                    </div>
                    <div class="col-4">
                        <h3 class="text-warning mb-1 track-text">{{ $TasksInProgressCount }}</h3>
                        <p class="mb-0 track-text">Tasks In Progress</p>
                    </div>
                </div>
            </div>
            <a href="/tasks">
                <div class="payslip-go-corner">
                    <div class="payslip-go-arrow">→</div>
                </div>
            </a>
        </div>
        <div class="payslip-card mb-3">
            <p class="payslip-card-title">IT Declaration</p>
            <p class="payslip-small-desc">
                Hurrah! Considered your IT declaration for Apr 2023.
            </p>
            <a href="/formdeclaration">
                <div class="payslip-go-corner">
                    <div class="payslip-go-arrow">→</div>
                </div>
            </a>
        </div>

    </div>


    @if ($showAlertDialog)
    <div class="modal" tabindex="-1" role="dialog" style="display: block;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                    <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title">
                        <b>Swipes</b>
                    </h5>
                    <button type="button" class="btn-close btn-primary" data-dismiss="modal"
                        aria-label="Close" wire:click="close"
                        style="background-color: white; height:10px;width:10px;">
                    </button>
                </div>
                <div class="modal-body" style="max-height:300px;overflow-y:auto">
                    <div class="row">
                        <div class="col" style="font-size: 12px;color:#778899;font-weight:500;">Date :
                            <span style="color: #333;">{{ $currentDate }}</span>
                        </div>
                        <div class="col" style="font-size: 12px;color:#778899;font-weight:500;">Shift
                            Time : <span style="color: #333;">10:00 to 19:00</span></div>
                    </div>
                    <table class="swipes-table mt-2 border" style="width: 100%;">
                        <tr style="background-color: #f6fbfc;">
                            <th
                                style="width:50%;font-size: 12px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;">
                                Swipe Time</th>
                            <th
                                style="width:50%;font-size: 12px; text-align:start;padding:5px 10px;color:#778899;font-weight:500;">
                                Sign-In / Sign-Out</th>
                        </tr>

                        @if (!is_null($swipeDetails) && $swipeDetails->count() > 0)
                        @foreach ($swipeDetails as $swipe)
                        <tr style="border:1px solid #ccc;">
                            <td
                                style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px">
                                {{ $swipe->swipe_time }}
                            </td>
                            <td
                                style="width:50%;font-size: 10px; color: #778899;text-align:start;padding:5px 10px">
                                {{ $swipe->in_or_out }}
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class="homeText" colspan="2">No swipe records found for today.</td>
                        </tr>
                        @endif

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show blurred-backdrop"></div>
    @endif
    @if ($showAllAbsentEmployees)
    <div class="modal" tabindex="-1" role="dialog" style="display: block;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                    <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title">
                        <b>{{ $whoisinTitle }}</b>
                    </h5>
                    <button type="button" class="btn-close btn-primary" data-dismiss="modal"
                        aria-label="Close" wire:click="closeAllAbsentEmployees"
                        style="background-color: white; height:10px;width:10px;">
                    </button>
                </div>
                <div class="modal-body" style="max-height:300px;overflow-y:auto">
                    <div class="team-leave d-flex flex-row gap-3 mb-2">
                        @for ($i = 0; $i < $CountAbsentEmployees; $i++)
                            @if (isset($AbsentEmployees[$i]))
                            @php
                            $employee=$AbsentEmployees[$i];
                            $randomColorAbsent='#' . str_pad(dechex(mt_rand(0, 0xffffff)), 6, '0' , STR_PAD_LEFT);
                            @endphp
                            <a href="/whoisinchart" style="text-decoration: none;">
                            <div class="thisCircle"
                                style="border: 2px solid {{ getRandomAbsentColor() }};"
                                data-toggle="tooltip" data-placement="top"
                                title="{{ ucwords(strtolower($employee['first_name'])) }} {{ ucwords(strtolower($employee['last_name'])) }}">
                                <span class="initials">
                                    {{ strtoupper(substr(trim($employee['first_name']), 0, 1)) }}{{ strtoupper(substr(trim($employee['last_name']), 0, 1)) }}
                                </span>
                            </div>
                            </a>
                            @endif
                            @endfor
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show blurred-backdrop"></div>

    @endif
    @if ($showAllLateEmployees)
    <div class="modal" tabindex="-1" role="dialog" style="display: block;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                    <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title">
                        <b>{{ $whoisinTitle }}</b>
                    </h5>
                    <button type="button" class="btn-close btn-primary" data-dismiss="modal"
                        aria-label="Close" wire:click="closeAllLateEmployees"
                        style="background-color: white; height:10px;width:10px;">
                    </button>
                </div>
                <div class="modal-body" style="max-height:300px;overflow-y:auto">
                    <div class="team-leave d-flex flex-row gap-3">
                        @for ($i = 0; $i < $CountLateSwipes; $i++)
                            @if (isset($LateSwipes[$i]))
                            @php
                            $employee=$LateSwipes[$i];
                            $randomColorLate='#' . str_pad(dechex(mt_rand(0, 0xffffff)), 6, '0' , STR_PAD_LEFT);
                            @endphp
                            <a href="/whoisinchart" style="text-decoration: none;">
                            <div class="thisCircle"
                                style="border: 2px solid {{ getRandomLateColor() }};"
                                data-toggle="tooltip" data-placement="top"
                                title="{{ ucwords(strtolower($employee['first_name'])) }} {{ ucwords(strtolower($employee['last_name'])) }}">
                                <span class="initials">
                                    {{ strtoupper(substr(trim($employee['first_name']), 0, 1)) }}{{ strtoupper(substr(trim($employee['last_name']), 0, 1)) }}
                                </span>
                            </div>
                            </a>
                            @endif
                            @endfor
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show blurred-backdrop"></div>

    @endif
    @if ($showAllEarlyEmployees)
    <div class="modal" tabindex="-1" role="dialog" style="display: block;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px">
                    <h5 style="padding: 5px; color: white; font-size: 15px;" class="modal-title">
                        <b>{{ $whoisinTitle }}</b>
                    </h5>
                    <button type="button" class="btn-close btn-primary" data-dismiss="modal"
                        aria-label="Close" wire:click="closeAllEarlyEmployees"
                        style="background-color: white; height:10px;width:10px;">
                    </button>
                </div>
                <div class="modal-body" style="max-height:300px;overflow-y:auto">
                    <div class="team-leave d-flex flex-row gap-3 ">
                        @for ($i = 0; $i < $CountEarlySwipes; $i++)
                            @if (isset($EarlySwipes[$i]))
                            @php
                            $employee=$EarlySwipes[$i];
                            $randomColorEarly='#' . str_pad(dechex(mt_rand(0, 0xffffff)), 6, '0' , STR_PAD_LEFT);
                            @endphp
                            <a href="/whoisinchart" style="text-decoration: none;">
                            <div class="thisCircle"
                                style="border: 2px solid {{ getRandomEarlyColor() }};"
                                data-toggle="tooltip" data-placement="top"
                                title="{{ ucwords(strtolower($employee['first_name'])) }} {{ ucwords(strtolower($employee['last_name'])) }}">
                                <span class="initials">
                                    {{ strtoupper(substr(trim($employee['first_name']), 0, 1)) }}{{ strtoupper(substr(trim($employee['last_name']), 0, 1)) }}
                                </span>
                            </div>
                            </a>
                            @endif
                            @endfor
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show blurred-backdrop"></div>
    @endif
</div>
</div>

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
</script>
