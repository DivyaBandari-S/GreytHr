<div style="width: 90%;margin:0 auto;">
    <style>
        .teamOnLeavetable {
            width: 100%;
            border-collapse: collapse;
        }

        .teamOnLeavetable th {
            background-color: #ecf9ff;
            /* Header background color */
            color: #778899;
            /* Text color for headers */
            padding: 8px;
            font-weight: 500;
            font-size: 0.8rem;
            text-align: left;
        }

        .teamOnLeavetable td {
            background-color: #fff;
            /* Body background color */
            color: #3b4452;
            /* Text color for body cells */
            padding: 8px;
            border: 1px solid #ddd;
            /* Optional: border for table cells */
        }

        .teamOnLeavetable tbody tr:nth-child(even) td {
            background-color: #fcfcfc;
            /* Optional: alternate row color */
        }
    </style>

    <div style="padding:10px 15px; width:80%; margin:0;">
        <label for="duration" class="normalTextValue" style="font-size:0.85rem;">Select Duration:</label>
        <select class="normalTextValue" id="duration" wire:change="updateDuration($event.target.value)" style="font-size:0.8rem;">
            <option value="this_month">This Month</option>
            <option value="today">Today</option>
        </select>
    </div>

    <div style="width:100%;display:flex; flex-direction:column;margin:0 auto;border:1px solid #ccc;">
        <!-- Other HTML content -->
        <div style="display:flex; flex-direction:row; background:white;padding:10px 15px; border-bottom:1px solid #ccc; gap:10px;">
            <p class="mb-0 normalTextValue" style="font-size: 0.75rem;">Duration Selected:</p>
            <p class="mb-0 normalText">{{ \Carbon\Carbon::now()->startOfMonth()->format('d M, Y') }} <span style="color:#ccc;margin:0 10px;">TO </span> {{ \Carbon\Carbon::now()->endOfMonth()->format('d M, Y') }}</p>
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
        <h6 class="normalText" style="color:#778899;font-size:0.925rem;">Leave Applications</h6>


        @if(empty($leaveApplications))

        <p class="normalTextValue">No leave applications for the selected duration.</p>
        @else
        <div class="row">
            <div class="col-md-6" style="padding:10px 15px;  margin:0;">
                <label for="search" class="normalTextValue">Search Employee:</label>
                <input class="rounded placeholder-small p-1 border" style="width:150px;border:none;outline:none;" type="text" id="search" wire:model='search' wire:input="updateSearch($event.target.value)" placeholder="Search...">
            </div>
            <div class="col-md-6" style="padding:10px 15px;  margin:0;">
                <label for="leaveTypeFilter" class="normalTextValue">Select Leave Type:</label>
                <select class="rounded border normalText p-1" style="width:130px;outline:none;" id="leaveTypeFilter" wire:model="leaveTypeFilter" wire:change=updateLeaveTypeFilter($event.target.value)>
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
                    <th>Employee Id</th>
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
                        $days = $this->calculateNumberOfDays($leaveApplication->from_date, $leaveApplication->from_session, $leaveApplication->to_date, $leaveApplication->to_session);
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