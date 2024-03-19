<div>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <style>
        .text {
            --tw-text-opacity: 1;
            color: rgba(23, 30, 37);
            font-size: 18px;
        }
 
        #duration {
        padding: 4px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-top: 8px;
        outline:none;
        margin-bottom: 16px;
    }
    option{
        background:#fff;
    }
 
    </style>
</head>
<body>
    <div style="padding:10px 15px; width:90%;">
        <label for="duration" style="color:#778899; font-weight:500;">Select Duration:</label>
        <select id="duration" wire:model="duration">
            <option value="this_month">This Month</option>
            <option value="today">Today</option>
        </select>
    </div>

   <div class="conatiner" style="width:90%;display:flex; flex-direction:column;margin:0 auto;border:1px solid #ccc;">
    <!-- Other HTML content -->
    <div style="display:flex; flex-direction:row; background:white;padding:10px 15px; border-bottom:1px solid #ccc; gap:10px;">
        <p style="color:#778899; font-weight:500;">Duration Selected:</p>
         <p style="font-size:0.875rem;font-weight:500;">{{ \Carbon\Carbon::now()->startOfMonth()->format('d M, Y') }} <span style="color:#ccc;margin:0 10px;">TO </span> {{ \Carbon\Carbon::now()->endOfMonth()->format('d M, Y') }}</p>
    </div>
    @if (count($leaveApplications) > 0)
        <canvas id="barChart" width="420" height="130" style="background: white;padding:10px 15px;"></canvas>
        
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                if (typeof Livewire !== 'undefined') {
                    // Livewire component initialization code
                    var ctx = document.getElementById("barChart").getContext("2d");

                    // Define chartData and chartOptions from the Livewire variables
                    var chartData = @json($chartData);
                    var chartOptions = @json($chartOptions);

                    // Define a color palette for different leave types
                    var colorPalette = ['#B2FFD6', '#D6B2FF', '#B2D6FF', '#B2FFD6', '#D6B2FF', '#B2D6FF'];

                    // Create a new Bar Chart instance
                    var barChart = new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: chartData.labels,
                            datasets: Object.keys(chartData.datasets).map(function (leaveType, index) {
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



    @else
        <p>No leave requests available.</p>
    @endif
</div>

</body>
</html>
 
</div>