<div>


    <div >
        <label for="duration" class="normalTextValue team-on-leave-label " >Select Duration:</label>
        <select class="normalTextValue team-on-leave-duration-select"wire:model='duration' id="duration" wire:change="updateDuration($event.target.value)" >
            <option value="this_month">This Month</option>
            <option value="last_month">Last Month</option>
            <option value="today">Today</option>
        </select>
    </div>

    <div class="team-on-leave-chart-div" >
        <!-- Other HTML content -->
        <div class="team-on-leave-duration-div">
            <p class="mb-0 normalTextValue team-on-leave-duration" >Duration Selected:</p>
            @if($duration!='today')
            <p class="mb-0 normalText">{{ $fromDateFormatted  }} <span class="team-on-leave-to" >TO </span> {{$toDateFormatted }}</p>
            @else
            <p class="mb-0 normalText">{{ $todaysDate  }} </p>
            @endif
        </div>


        <canvas id="barChart" height="300" class="team_on_leave-bar-chart bg-white"></canvas>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof Livewire !== 'undefined') {
                    // Livewire component initialization code
                    var ctx = document.getElementById("barChart").getContext("2d");

                    // Define chartData and chartOptions from the Livewire variables
                    var chartData = @json($chartData);
                    console.log(chartData);
                    var chartOptions = @json($chartOptions);

                    // Define a color palette for different leave types
                    var colorPalette = ['#B2FFD6', '#D6B2FF', '#B2D6FF', '#B2FFf7', '#D6B2FE', '#B2D7FF'];

                    // Create a new Bar Chart instance
                    var barChart = new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: chartData.labels,
                            datasets: Object.keys(chartData.datasets).map(function(leaveType, index) {
                                return {
                                    label: leaveType,
                                    data: Object.values(chartData.datasets[leaveType]),
                                    backgroundColor: colorPalette[index], // Use color from the palette
                                    borderColor: colorPalette[index],
                                    borderWidth: 1,
                                };
                            }),
                        },
                        options: {
                            ...chartOptions, // Keep existing options
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12, // Adjust the box width if needed
                                    fontSize: 12, // Adjust the font size if needed
                                },
                            },
                        },
                    });
                }
            });
        </script>





    </div>

    <div class="mt-3">
        <h6 class="normalText team-on-leave-application" >Leave Applications</h6>


        @if(empty($leaveApplications))

        <p class="normalTextValue">No leave applications for the selected duration.</p>
        @else
        <div class="row">
            <div class="col-md-6 team-on-leave-search" >
                <label for="search" class="normalTextValue">Search Employee:</label>
                <input class="rounded placeholder-small p-1 border " type="text" id="search" wire:model='search' wire:input="updateSearch($event.target.value)" placeholder="Search...">
            </div>
            <div class="col-md-6 team-on-leave-type" >
                <label for="leaveTypeFilter" class="normalTextValue ">Select Leave Type:</label>
                <select class="rounded border normalText p-1 team-on-leave-type-select"  id="leaveTypeFilter" wire:model="leaveTypeFilter" wire:change=updateLeaveTypeFilter($event.target.value)>
                    <option value="">All</option>
                    @foreach($this->leaveTypes as $leaveType)
                    <option value="{{ $leaveType }}">{{ $leaveType }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if($leaveApplications->isEmpty())
        <div class="normalTextValue mt-2 text-center bg-white border p-2 rounded">No leave applications found for the selected duration and search criteria.</div>
        @else
        <table class="teamOnLeavetable">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Leave Type</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Days</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaveApplications as $leaveApplication)
                <tr>
                    <td>{{ $leaveApplication->emp_id }}</td>
                    <td>{{ ucwords(strtolower($leaveApplication->first_name)) }} {{ ucwords(strtolower($leaveApplication->last_name)) }}</td>
                    <td>{{ $leaveApplication->leave_type }}</td>
                    <td>{{ \Carbon\Carbon::parse($leaveApplication->from_date)->format('d M, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($leaveApplication->to_date)->format('d M, Y') }}</td>
                    <td>
                        @php
                        $days = $this->calculateNumberOfDays($leaveApplication->from_date, $leaveApplication->from_session, $leaveApplication->to_date, $leaveApplication->to_session,$leaveApplication->leave_type);
                        @endphp
                        {{ $days }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        @endif
    </div>
</div>
