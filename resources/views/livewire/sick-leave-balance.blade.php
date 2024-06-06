<div style="max-height: 300px;max-width:900px; ">
    @if(session()->has('emp_error'))
        <div class="alert alert-danger">
            {{ session('emp_error') }}
        </div>
    @endif
    @if($Availablebalance == 0)
    <div class="row mb-2">
        <div class="col-md-12" style="max-height: 100px;">
            <div class="card" style="height: 100%;">
                <div class="card-body" style="height: 100%;">
                    <h6 class="card-title">Information</h6>
                    <p class="card-text">HR will add the leaves</p>
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="row mb-2">
            <div class="col-md-4" style="max-height: 100px;">
                <div class="card" style="height: 100%;">
                    <div class="card-body" style="height: 100%;">
                        <h6 class="card-title">Available Balance</h6>
                        <p class="card-text">{{ $Availablebalance }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="max-height: 100px;">
                <div class="card" style="height: 100%;">
                    <div class="card-body" style="height: 100%;">
                        <h6 class="card-title">Granted</h6>
                        @foreach ($employeeLeaveBalances as $leaveBalance)
                            <p class="card-text">{{ $leaveBalance->leave_balance}}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="max-height: 100px;">
                <div class="card" style="height: 100%;">
                    <div class="card-body" style="height: 100%;">
                        <h6 class="card-title">Availed</h6>
                        <p class="card-text">{{ $totalSickDays }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="chart-container" style="margin-top: 20px; margin-bottom: 20px;">
                    <canvas id="sickLeaveChart" width="400" height="200"></canvas>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        var ctx = document.getElementById('sickLeaveChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: <?php echo json_encode($chartData); ?>,
                            options: <?php echo json_encode($chartOptions); ?>
                        });
                    </script>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-striped" style="font-size: 12px;">
                        <thead class="thead-dark">
                            <tr style="background-color:#87CEEB;">
                                <th style="width: 5%; padding: 0.5rem; text-align: center;">Transaction Type</th>
                                <th style="width: 16.66%; padding: 0.5rem;">Posted On</th>
                                <th style="width: 16.66%; padding: 0.5rem;">From</th>
                                <th style="width: 16.66%; padding: 0.5rem;">To</th>
                                <th style="width: 16.66%; padding: 0.5rem;">Days</th>
                                <th style="width: 28.32%; padding: 0.5rem;">Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employeeleaveavlid as $index => $balance)
                                <tr>
                                    <td style="padding: 0.5rem; text-align: center;">
                                        @if ($balance->status == 'approved')
                                            Availed
                                        @endif
                                    </td>
                                    <td style="padding: 0.5rem;">{{ date('d M Y', strtotime($balance->created_at)) }}</td>
                                    <td style="padding: 0.5rem;">{{ date('d M Y', strtotime($balance->from_date)) }}</td>
                                    <td style="padding: 0.5rem;">{{ date('d M Y', strtotime($balance->to_date)) }}</td>
                                    <td style="padding: 0.5rem;">{{ $totalSickDays }}</td>
                                    <td style="padding: 0.5rem;">{{ $balance->reason }}</td>
                                </tr>  
                            @endforeach
                            @foreach($employeeLeaveBalances as $index => $balance)
                                <tr>
                                    <td style="padding: 0.5rem; text-align: center;">{{ $balance->status }}</td>
                                    <td style="padding: 0.5rem;">{{ date('d M Y', strtotime($balance->created_at)) }}</td>
                                    <td style="padding: 0.5rem;">{{ date('d M Y', strtotime($balance->from_date)) }}</td>
                                    <td style="padding: 0.5rem;">{{ date('d M Y', strtotime($balance->to_date)) }}</td>
                                    <td style="padding: 0.5rem;">{{ $balance->leave_balance }}</td>
                                    <td style="padding: 0.5rem;">Annual Grant</td>
                                </tr>  
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif    
</div>
