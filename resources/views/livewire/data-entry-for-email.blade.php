<div>
    <style>
        .form-label {
            color: #778899;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .vertical-divider {
            position: absolute;
            top: 0;
            right: -1px;
            bottom: 0;
            width: 1px;
            background-color: #ccc;
        }
    </style>
    <div class="row m-0 p-0">
        <!-- Left column: Table -->
        <div class="col-9">
            <div class="p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h6>Client Data</h6>
                    <p class="mb-0 text-red">Note : <span>This Data will be sent to client on Friday : {{ $nextFridayDate }}</span></p>
                </div>
                <div class="table-frame px-2 py-1">
                    <div class="table-container">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width:40px;">#</th>
                                    @foreach(['employee_name', 'employee_title', 'project_title', 'employee_email',
                                    'work_location', 'project_manager', 'access_network', 'po_number', 'hourly_paid', 'mark_up',
                                    'hourly_max', 'start_date', 'sow_end_date', 'background_check', 'on_site_resource',
                                    'vaccination_status'] as $field)
                                    <th style="width:150px;">{{ str_replace('_', ' ', ucfirst($field)) }}</th>
                                    @endforeach
                                    <th style="width:100px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataEntries as $index => $entry)
                                <tr>
                                    <td style="width:40px;">{{ $index + 1 }}</td>
                                    @foreach(['employee_name', 'employee_title', 'project_title', 'employee_email',
                                    'work_location', 'project_manager', 'access_network', 'po_number', 'hourly_paid', 'mark_up',
                                    'hourly_max', 'start_date', 'sow_end_date', 'background_check', 'on_site_resource',
                                    'vaccination_status'] as $field)
                                    <td wire:click="editCell({{ $index }}, '{{ $field }}')" class="table-cell" style="width:150px;">
                                        @if($editIndex === $index && $editField === $field)
                                        @if (in_array($field, ['start_date', 'sow_end_date']))
                                        <!-- Check if field is a date field -->
                                        <input type="date" class="form-control" wire:model="dataEntries.{{ $index }}.{{ $field }}" wire:blur="updateRow({{ $index }})">
                                        @else
                                        <input type="text" class="form-control" wire:model="dataEntries.{{ $index }}.{{ $field }}" wire:blur="updateRow({{ $index }})">
                                        @endif
                                        @else
                                        @if (in_array($field, ['start_date', 'sow_end_date']))
                                        {{ isset($entry[$field]) ? \Carbon\Carbon::parse($entry[$field])->format('d M, Y') : '' }}
                                        @else
                                        {{ $entry[$field] }}
                                        @endif
                                        @endif
                                    </td>
                                    @endforeach

                                    <td class="action-buttons" style="width:50px;">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button class="btn-update" wire:click="updateRow({{ $index }})" style="font-size: 0.65rem;padding:1px 5px;">
                                                Update
                                            </button>
                                            <button class="btn-delete" wire:click="deleteRow({{ $index }})" style="font-size: 0.65rem;padding:1px 5px;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center align-items-center gap-3">
                    <button wire:click="addRow" class="btn-update">Add Row</button>
                    <button wire:click="save" class="btn-save">Save</button>
                </div>
            </div>
        </div>
        <!-- Right column: Email fields -->
        <div class="col-3">
            <div class="p-4">
                <div class="mb-3">
                    <label for="toEmail" class="form-label">To </label>
                    <input type="email" class="form-control" id="toEmail" wire:model.lazy="toEmail" style="font-size: 0.75rem;">
                    @error('toEmail') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="ccEmail" class="form-label">CC to</label>
                    <input type="email" class="form-control" id="ccEmail" wire:model.lazy="ccEmail" style="font-size: 0.75rem;">
                    @error('ccEmail') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="ccEmail" class="form-label">Subject</label>
                    <input type="email" class="form-control" id="ccEmail" wire:model.lazy="ccEmail" style="font-size: 0.75rem;">
                    @error('ccEmail') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="d-flex justify-content-center align-items-center gap-3">
                    <button wire:click="sendEmails" class="btn-update">Send Emails</button>
                </div>
            </div>
        </div>
    </div>

</div>