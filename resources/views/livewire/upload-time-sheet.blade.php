<div>
    <div class="row m-0 p-0" style="position: relative;">
        @if (session()->has('message'))
        <div id="successMessage" class="alert alert-success d-flex justify-content-between" style="position: absolute; top: 10px; left: 0px; right: 0px; width: 50%; margin: 0 auto;">
            {{ session('message') }}
            <button type="button" class="close" aria-label="Close" wire:click="dismissMessage" style="background: none; border: none; padding: 0; margin-left: 10px; cursor: pointer;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="col-md-3">
            <div>
                <div class="d-flex align-items-center mt-4">
                    <div>
                        <div class="email-form p-4 m-0 bg-white border rounded">
                            <p class="mb-4 text-center title">Attune Global Solutions</p>
                            <hr>
                            <form>
                                <div class="mb-3">
                                    <label for="to" class="form-label">To:</label>
                                    <input type="email" class="form-control small-padding-input" id="to" wire:model="to" wire:change="To" style="font-size: 0.75rem;" required>
                                    @error('to') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                @if ($to && count(explode(',', $to)) > 0)
                                <div class="form-group">
                                    <p class="cc-label mb-2">To addresses:</p>
                                    <div class="cc-grid mt-2 mb-3">
                                        @foreach (explode(',', $to) as $toAddress)
                                        <div class="row cc-to">
                                            <div class="col">
                                                <div class="p-2 border mb-2 d-flex align-items-center justify-content-between" style="border-radius: 20px;">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <span>{{ $loop->iteration }}.</span>
                                                        <span class="email-link">{{ $toAddress }}</span>
                                                    </div>
                                                    <i class="fas fa-times-circle cancel-icon" style="cursor: pointer;" wire:click="removeTo('{{ $toAddress }}')"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                <div class="mb-3">
                                    <label for="cc" class="form-label">CC To:</label>
                                    <input type="email" class="form-control small-padding-input" id="cc" wire:change="ccTo" wire:model="cc" style="font-size: 0.75rem;">
                                    @error('cc') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                @if ($cc && count(explode(',', $cc)) > 0)
                                <div class="form-group">
                                    <p class="cc-label mb-2">CC addresses:</p>
                                    <div class="cc-grid mt-2 mb-3">
                                        @foreach (explode(',', $cc) as $ccAddress)
                                        <div class="row cc-to">
                                            <div class="col">
                                                <div class="p-2 border mb-2 d-flex align-items-center justify-content-between" style="border-radius: 20px;">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <span>{{ $loop->iteration }}.</span>
                                                        <span class="email-link">{{ $ccAddress }}</span>
                                                    </div>
                                                    <i class="fas fa-times-circle cancel-icon" style="cursor: pointer;" wire:click="removeCC('{{ $ccAddress }}')"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject:</label>
                                    <input type="text" class="form-control small-padding-input" id="subject" wire:model="subject" style="font-size: 0.75rem;">
                                    @error('subject') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="files" class="form-label">Upload File:</label>
                                    <input type="file" class="form-control small-padding-input" id="file" wire:model="files" style="font-size: 0.75rem;" multiple>
                                    @error('file') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                @if($showTimeInput)
                                <div class="mb-3">
                                    <label for="scheduledDateTime" class="form-label">Schedule Date & Time:</label>
                                    <input type="datetime-local" class="form-control small-padding-input" id="scheduledDateTime" wire:model="scheduledDateTime" style="font-size: 0.75rem;">
                                    @error('scheduledDateTime') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                @endif
                                <div class="mt-4 mb-0 d-flex gap-3">
                                    <button type="button" class="btn btn-primary btn-sm py-1 px-2" wire:click="sendEmailImmediate" style="font-size: 0.75rem;">Send Immediate</button>
                                    <button type="button" class="btn btn-primary btn-sm py-1 px-4" wire:click="sendEmailAfter" style="font-size: 0.75rem;">Send After</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div>
                <!-- resources/views/livewire/toggle-content.blade.php -->

                <div class="mt-4">
                    <div class=" d-flex gap-3">
                    <div class="flex mb-4">
                        <button wire:click="setActiveButton('history')" class="btn @if($activeButton == 'history') btn-active @else btn-inactive @endif">
                            History
                        </button>
                        <button wire:click="setActiveButton('queued')" class="btn ml-2 @if($activeButton == 'queued') btn-active @else btn-inactive @endif">
                            Queued
                        </button>
                    </div>
                    <div>
                         <a class="btn btn-primary" href="/data-entry">Data Entry</a>
                    </div>
                    </div>
                    <div class="content-container border" style="height:500px;max-height:500px;overflow-y:auto;">
                        @if($showHistory)
                        <div>
                            <h6 class="mb-2">Email Logs</h6>
                            <table class="table min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th >Serial No.</th>
                                        <th >Subject</th>
                                        <th >To</th>
                                        <th >CC</th>
                                        <th >Files</th>
                                        <th >Scheduled At</th>
                                        <th >Actual Sent</th>
                                        <th >Send Date & Time</th>
                                    </tr>
                                </thead>
                                <tbody style="cursor:pointer;">
                                    @if($emailLogs->where('scheduled_status', 'pending')->isNotEmpty() || $emailLogs->where('scheduled_status', 'sent')->isNotEmpty())
                                    @foreach($emailLogs->whereIn('scheduled_status', ['pending', 'sent']) as $index => $log)
                                    <tr>
                                        <td style="padding: 10px;">{{ $index + 1 }}</td>
                                        <td style="padding: 10px;">{{ ucwords(strtolower($log->subject)) }}</td>
                                        <td class="truncate-ellipsis" style="max-width: 200px;padding: 10px;" title="To: {{ implode(', ', json_decode($log->to, true)) }}">{{ implode(', ', json_decode($log->to, true)) }}</td>
                                        <td class="truncate-ellipsis" style="max-width: 200px;padding: 10px;" title="CC: {{ $log->cc ? implode(', ', json_decode($log->cc, true)) : 'N/A' }}">{{ $log->cc ? implode(', ', json_decode($log->cc, true)) : 'N/A' }}</td>
                                        <td style="padding: 10px;">
                                            @if (json_decode($log->files, true))
                                            @foreach(json_decode($log->files, true) as $file)
                                            <a href="{{ Storage::url($file) }}" target="_blank" style="text-decoration: none; color: #007BFF;">View File</a><br>
                                            @endforeach
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td style="padding: 10px;">
                                            @if ($log->scheduled_at)
                                            {{ \Carbon\Carbon::parse($log->scheduled_at)->format('d M, Y H:i') }}
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td style="padding: 10px;">{{ \Carbon\Carbon::parse($log->updated_at)->format('d M, Y H:i') }}</td>
                                        <td style="padding: 10px;">{{ \Carbon\Carbon::parse($log->created_at)->format('d M, Y H:i') }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="8" class="text-center py-4">No pending or sent emails found</td>
                                    </tr>
                                    @endif
                                </tbody>

                            </table>
                        </div>
                        @endif

                        @if($showQueued)
                        <div>
                            <h6 class="mb-2">Email Logs</h6>
                            <table class="table min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th>Serial No.</th>
                                        <th>Subject</th>
                                        <th>To</th>
                                        <th>CC</th>
                                        <th>Files</th>
                                        <th>Scheduled At</th>
                                        <th>Send Date & Time</th>
                                    </tr>
                                </thead>
                                <tbody style="cursor:pointer;">
                                    @php
                                    $queuedIndex = 1;
                                    @endphp
                                    @forelse ($emailLogs->where('scheduled_status', 'scheduled')->whereNotNull('scheduled_at') as $logs)
                                    <tr>
                                        <td>{{ $queuedIndex++ }}</td>
                                        <td>{{ ucwords(strtolower($logs->subject)) }}</td>
                                        <td class="truncate-ellipsis" style="max-width: 200px;" title="To: {{ implode(', ', json_decode($logs->to, true)) }}">{{ implode(', ', json_decode($logs->to, true)) }}</td>
                                        <td class="truncate-ellipsis" style="max-width: 200px;" title="CC: {{ $logs->cc ? implode(', ', json_decode($logs->cc, true)) : 'N/A' }}">{{ $logs->cc ? implode(', ', json_decode($logs->cc, true)) : 'N/A' }}</td>
                                        <td>
                                            @if (json_decode($logs->files, true))
                                            @foreach(json_decode($logs->files, true) as $file)
                                            <a href="{{ Storage::url($file) }}" target="_blank" style="text-decoration: none; color: #007BFF;">View File</a><br>
                                            @endforeach
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if ($logs->scheduled_at)
                                            {{ \Carbon\Carbon::parse($logs->scheduled_at)->format('d M, Y H:i') }}
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($logs->created_at)->format('d M, Y H:i') }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">No pending scheduled emails found</td>
                                    </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>