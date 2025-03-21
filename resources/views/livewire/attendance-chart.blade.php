<div>
    <div id="attendanceChart"></div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener('livewire:load', function () {
                var options = {
                    chart: {
                        type: 'donut',
                        width: 600,
                        height: 400,
                    },
                    series: [
                        @json($absent),
                        @json($present),
                        @json($leaveTaken),
                        @json($holidays),
                    ],
                    labels: ['Absent', 'Present', 'Leave Taken', 'Holiday'],
                    colors: ['rgb(184, 208, 221)', 'rgb(192, 238, 249)', 'rgb(255, 221, 189)', 'rgb(183, 227, 192)'],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chart = new ApexCharts(document.querySelector("#attendanceChart"), options);
                chart.render();
            });
        </script>
    @endpush
</div>