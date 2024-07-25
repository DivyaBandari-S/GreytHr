<div style="width: 90%;margin:0 auto;">


    <div style="padding:10px 15px; width:80%; margin:0;">
        <label for="duration" style="color:#778899; font-weight:500;">Select Duration:</label>
        <select style="height:30px" id="duration" wire:change=updateDuration($event.target.value)>
            <option value="this_month">This Month</option>
            <option value="today">Today</option>
        </select>
    </div>


    <div style="width:90%;display:flex; flex-direction:column;margin:0 auto;border:1px solid #ccc;">
        <!-- Other HTML content -->
        <div style="display:flex; flex-direction:row; background:white;padding:10px 15px; border-bottom:1px solid #ccc; gap:10px;">
            <p style="color:#778899; font-weight:500;">Duration Selected:</p>
            <p style="font-size:0.875rem;font-weight:500;">{{ \Carbon\Carbon::now()->startOfMonth()->format('d M, Y') }} <span style="color:#ccc;margin:0 10px;">TO </span> {{ \Carbon\Carbon::now()->endOfMonth()->format('d M, Y') }}</p>
        </div>


        <canvas id="barChart" width="420" height="130" style="background: white;padding:10px 15px;"></canvas>

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
        <h3>Leave Applications</h3>


        @if(empty($leaveApplications))

        <p>No leave applications for the selected duration.</p>
        @else
        <div style="display: flex;">

            <div style="padding:10px 15px; width:80%; margin:0;">
                <label for="search" style="color:#778899; font-weight:500;">Search Employee:</label>
                <input style="height:30px" type="text" id="search" wire:model='search' wire:input="updateSearch($event.target.value)" placeholder="Enter first or last name">
            </div>
            <div style="padding:10px 15px; width:80%; margin:0;">
                <label for="leaveTypeFilter" style="color:#778899; font-weight:500;">Select Leave Type:</label>
                <select style="height:30px" id="leaveTypeFilter" wire:model="leaveTypeFilter" wire:change=updateLeaveTypeFilter($event.target.value)>
                    <option value="">All</option>
                    @foreach($this->leaveTypes as $leaveType)
                    <option value="{{ $leaveType }}">{{ $leaveType }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if($leaveApplications->isEmpty())
        <p>No leave applications found for the selected duration and search criteria.</p>
        @else
        <table class="table">
            <thead>
                <tr>

                    <th style="color:#778899">Employee Id</th>
                    <th style="color:#778899">Employee Name</th>
                    <th style="color:#778899">Leave Type</th>
                    <th style="color:#778899">From Date</th>
                    <th style="color:#778899">To Date</th>
                    <th style="color:#778899">Days</th>
                </tr>
            </thead>
            <tbody >
                @foreach($leaveApplications as $leaveApplication)
                <tr>
                    <td>
                        {{ $leaveApplication->emp_id }}
                    </td>
                    <td>
                        {{ $leaveApplication->first_name }} {{ $leaveApplication->last_name }}
                    </td>
                    <td>{{ $leaveApplication->leave_type }}</td>
                    <td>

                        {{\Carbon\Carbon::parse($leaveApplication->from_date)->format('d/m/Y');}}



                    </td>
                    <td>

                        {{\Carbon\Carbon::parse($leaveApplication->to_date)->format('d/m/Y');}}

                    </td>
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
    <!-- <div style="width:90%;display:flex; flex-direction:column;margin:0 auto;border:1px solid #ccc;">

            <div style="display:flex; flex-direction:row; background:white;padding:10px 15px; border-bottom:1px solid #ccc; gap:10px;">
                <p style="color:#778899; font-weight:500;">Duration Selected:</p>
                <p style="font-size:0.875rem;font-weight:500;">{{ \Carbon\Carbon::now()->startOfMonth()->format('d M, Y') }} <span style="color:#ccc;margin:0 10px;">TO </span> {{ \Carbon\Carbon::now()->endOfMonth()->format('d M, Y') }}</p>
            </div>


            <canvas id="barchart" width="420" height="130" style="background: white;padding:10px 15px;"></canvas>

            <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchChartData();

            document.getElementById('duration').addEventListener('change', function() {
                fetchChartData();
            });
        });

        function fetchChartData() {
            fetch('/chart-data')
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error fetching chart data:', data.error);
                        return;
                    }
                    updateChart(data);
                })
                .catch(error => console.error('Error fetching chart data:', error));
        }

        function updateChart(data) {
            var ctx = document.getElementById("barchart").getContext("2d");
            var colorPalette = ['#B2FFD6', '#D6B2FF', '#B2D6FF', '#B2FFD6', '#D6B2FF', '#B2D6FF'];

            if (window.barChart) {
                window.barChart.data.labels = data.labels;
                window.barChart.data.datasets = Object.keys(data.datasets).map((leaveType, index) => ({
                    label: leaveType,
                    data: Object.values(data.datasets[leaveType]),
                    backgroundColor: colorPalette[index],
                    borderColor: colorPalette[index],
                    borderWidth: 1,
                }));
                window.barChart.options = data.options;
                window.barChart.update();
            } else {
                window.barChart = new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: data.labels,
                        datasets: Object.keys(data.datasets).map((leaveType, index) => ({
                            label: leaveType,
                            data: Object.values(data.datasets[leaveType]),
                            backgroundColor: colorPalette[index],
                            borderColor: colorPalette[index],
                            borderWidth: 1,
                        })),
                    },
                    options: data.options,
                });
            }
        }
    </script>






        </div> -->







</div>
