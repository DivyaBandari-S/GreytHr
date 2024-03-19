<div>
    <div style="text-align:center;justify-content:center;display:flex;padding:5px;align-items:center">
        <div class="row mt-2 mb-2" style="background-color: white;max-width:500px;width:100%;padding:5px;border-radius:5px;height:52px">
            <div class="col-md-4">
                <button style="margin-left: 0;" wire:click="$set('activeTab', 'Apply')" class="button-dl {{ $activeTab === 'Apply' ? 'active' : '' }}">Active</button>
            </div>
            <div class="col-md-4">
                <button wire:click="$set('activeTab', 'Pending')" class="button-dl {{ $activeTab === 'Pending' ? 'active' : '' }}">Pending</button>
            </div>
            <div class="col-md-4">
                <button wire:click="$set('activeTab', 'History')" class="button-dl {{ $activeTab === 'History' ? 'active' : '' }}">Completed</button>
            </div>
        </div>
    </div>
    <div class="custom-form">
        <div class="row">
            <div class="table-responsive">
                <table class="table-start">
                    <thead class="table-header" style="padding: 8px;background-color: rgb(2, 17, 79);color: #fff;">
                        <tr>
                            <th style="padding: 10px;">Employee ID</th>
                            <th>Letter Type</th>
                            <th>Priority</th>
                            <th>Reason</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    @if($activeTab=="Apply")
                    <tbody class="table-body">
                        @if($allRequests->where('status', 'Active')->count() > 0)
                        @foreach ($allRequests->where('status', 'Active') as $request)
                        <tr>
                            <td>{{$request->emp_id}}</td>
                            <td>{{$request->letter_type}}</td>
                            <td>{{$request->priority}}</td>
                            <td>{{$request->reason}}</td>
                            <td style="padding: 5px; font-size: 12px; text-align: center;">
                                <button wire:click="openForLetters('{{$request->id}}')" style="background-color: rgb(2, 17, 79); color: white; border-radius: 3px; padding: 5px;margin-bottom:8px">Complete</button>
                                <button wire:click="pendingForLetters('{{$request->id}}')" style="background-color: rgb(2, 17, 79); color: white; border-radius: 3px; padding: 5px;">Pending</button>

                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5" style="text-align: center;font-size:12px">Active records not found</td>
                        </tr>
                        @endif
                    </tbody>
                    @elseif($activeTab=="Pending")
                    <tbody class="table-body">
                        @if($allRequests->where('status', 'Pending')->count() > 0)
                        @foreach ($allRequests->where('status', 'Pending') as $request)
                        <tr>
                            <td>{{$request->emp_id}}</td>
                            <td>{{$request->letter_type}}</td>
                            <td>{{$request->priority}}</td>
                            <td>{{$request->reason}}</td>
                            <td style="padding: 5px; font-size: 12px; text-align: center;">
                                <button wire:click="comForLetters('{{$request->id}}')" style="background-color: rgb(2, 17, 79); color: white; border-radius: 3px; padding: 5px;margin-bottom:8px">Complete</button>

                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5" style="text-align: center;font-size:12px">Pending records not found</td>
                        </tr>
                        @endif
                    </tbody>
                    @elseif($activeTab=="History")
                    <tbody class="table-body">
                        @if($allRequests->where('status', 'Completed')->count() > 0)
                        @foreach ($allRequests->where('status', 'Completed') as $request)
                        <tr>
                            <td>{{$request->emp_id}}</td>
                            <td>{{$request->letter_type}}</td>
                            <td>{{$request->priority}}</td>
                            <td>{{$request->reason}}</td>
                            <td style="padding: 5px; font-size: 12px; text-align: center;">
                                <button wire:click="actForLetters('{{$request->id}}')" style="background-color: rgb(2, 17, 79); color: white; border-radius: 3px; padding: 5px;margin-bottom:8px">Open</button>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5" style="text-align: center;font-size:12px">Completed records not found</td>
                        </tr>
                        @endif
                    </tbody>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>