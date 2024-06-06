<div class="bg-white border rounded px-4" style="height:100vh; max-width:950px;overflow-x:auto; margin:0 auto;">
    @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif


    <div class="table-responsive mt-2 p-2">
        <form wire:submit.prevent="addNewRow">
            <div>
                <button class="submit-btn" type="submit">Add New Row</button>
            </div>
        </form>

        <table class="employee-asset-details mt-4 border rounded">
            <thead>
                <tr>
                    <th>S No.</th>
                    <th>Asset ID</th>
                    <th>Asset Tag</th>
                    <th>Status</th>
                    <th>Manufacturer</th>
                    <th>Asset Type</th>
                    <th>Asset Model</th>
                    <th>Asset Specification</th>
                    <th>Serial Number</th>
                    <th>Color</th>
                    <th>Current Owner</th>
                    <th>Previous Owner</th>
                    <th>Windows Version</th>
                    <th>Assign Date</th>
                    <th>Purchase Date</th>
                    <th>Invoice Number</th>
                    <th>Taxable Amount</th>
                    <th>GST (Central)</th>
                    <th>GST (State)</th>
                    <th>Invoice Amount</th>
                    <th>Vendor</th>
                    <th>Other Assets</th>
                    <th>Sophos Antivirus</th>
                    <th>VPN Creation</th>
                    <th>Teramind</th>
                    <th>System Name</th>
                    <th>System Upgradation</th>
                    <th>Screenshot of Programs</th>
                    <th>OneDrive</th>
                    <th>MAC Address</th>
                    <th>Laptop Received</th>
                    <th>Laptop Received Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($employeeAssets && !$employeeAssets->isEmpty())
                @foreach($employeeAssets as $asset)
                <tr wire:key="{{ $asset->id }}">
                    <td>{{ $asset->id }}</td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'asset_id')
                            <input wire:model="editedAsset.{{ $asset->id }}.asset_id" type="text" value="{{ $editedAsset[$asset->id]['asset_id'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->asset_id }}
                            <button class="btn btn-link p-0 " wire:click="edit({{ $asset->id }}, 'asset_id')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'asset_tag')
                            <input wire:model="editedAsset.{{ $asset->id }}.asset_tag" type="text" value="{{ $editedAsset[$asset->id]['asset_tag'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->asset_tag ? ucfirst(strtolower($asset->asset_tag)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'asset_tag')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'status')
                            <input wire:model="editedAsset.{{ $asset->id }}.status" type="text" value="{{ $editedAsset[$asset->id]['status'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->status ? ucfirst(strtolower($asset->status)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'status')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>

                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'manufacturer')
                            <input wire:model="editedAsset.{{ $asset->id }}.manufacturer" type="text" value="{{ $editedAsset[$asset->id]['manufacturer'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->manufacturer ? ucfirst(strtolower($asset->manufacturer)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'manufacturer')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'asset_type')
                            <input wire:model="editedAsset.{{ $asset->id }}.asset_type" type="text" value="{{ $editedAsset[$asset->id]['asset_type'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->asset_type ? ucfirst(strtolower($asset->asset_type)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'asset_type')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'asset_model')
                            <input wire:model="editedAsset.{{ $asset->id }}.asset_model" type="text" value="{{ $editedAsset[$asset->id]['asset_model'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->asset_model ? ucfirst(strtolower($asset->asset_model)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'asset_model')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'asset_specification')
                            <input wire:model="editedAsset.{{ $asset->id }}.asset_specification" type="text" value="{{ $editedAsset[$asset->id]['asset_specification'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->asset_specification ? ucfirst(strtolower($asset->asset_specification)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'asset_specification')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'serial_number')
                            <input wire:model="editedAsset.{{ $asset->id }}.serial_number" type="text" value="{{ $editedAsset[$asset->id]['serial_number'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->serial_number ? $asset->serial_number : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'serial_number')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'color')
                            <input wire:model="editedAsset.{{ $asset->id }}.color" type="text" value="{{ $editedAsset[$asset->id]['color'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->color ? ucfirst(strtolower($asset->color)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'color')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'current_owner')
                            <input wire:model="editedAsset.{{ $asset->id }}.current_owner" type="text" value="{{ $editedAsset[$asset->id]['current_owner'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->current_owner ? ucwords(strtolower($asset->current_owner)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'current_owner')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'previous_owner')
                            <input wire:model="editedAsset.{{ $asset->id }}.previous_owner" type="text" value="{{ $editedAsset[$asset->id]['previous_owner'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->previous_owner ? ucwords(strtolower($asset->previous_owner)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'previous_owner')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'windows_version')
                            <input wire:model="editedAsset.{{ $asset->id }}.windows_version" type="text" value="{{ $editedAsset[$asset->id]['windows_version'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->windows_version ? $asset->windows_version : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'windows_version')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'assign_date')
                            <input wire:model="editedAsset.{{ $asset->id }}.assign_date" type="date" value="{{ $editedAsset[$asset->id]['assign_date'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->assign_date ? date('d M, Y', strtotime($asset->assign_date)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'assign_date')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'purchase_date')
                            <input wire:model="editedAsset.{{ $asset->id }}.purchase_date" type="date" value="{{ $editedAsset[$asset->id]['purchase_date'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->purchase_date ? date('d M, Y', strtotime($asset->purchase_date)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'purchase_date')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'invoice_no')
                            <input wire:model="editedAsset.{{ $asset->id }}.invoice_no" type="number" value="{{ $editedAsset[$asset->id]['invoice_no'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->invoice_no ? $asset->invoice_no : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'invoice_no')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'taxable_amount')
                            <input wire:model="editedAsset.{{ $asset->id }}.taxable_amount" type="number" value="{{ $editedAsset[$asset->id]['taxable_amount'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->taxable_amount ? '₹ ' . number_format($asset->taxable_amount) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'taxable_amount')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'gst_central')
                            <input wire:model="editedAsset.{{ $asset->id }}.gst_central" type="number" value="{{ $editedAsset[$asset->id]['gst_central'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->gst_central ? '₹ ' . number_format($asset->gst_central) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'gst_central')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'gst_state')
                            <input wire:model="editedAsset.{{ $asset->id }}.gst_state" type="number" value="{{ $editedAsset[$asset->id]['gst_state'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->gst_state ? '₹ ' . number_format($asset->gst_state) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'gst_state')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'invoice_amount')
                            <input wire:model="editedAsset.{{ $asset->id }}.invoice_amount" type="number" value="{{ $editedAsset[$asset->id]['invoice_amount'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->invoice_amount ? '₹ ' . number_format($asset->invoice_amount) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'invoice_amount')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'vendor')
                            <input wire:model="editedAsset.{{ $asset->id }}.vendor" type="text" value="{{ $editedAsset[$asset->id]['vendor'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->vendor ? ucwords(strtolower($asset->vendor)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'vendor')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'other_assets')
                            <input wire:model="editedAsset.{{ $asset->id }}.other_assets" type="text" value="{{ $editedAsset[$asset->id]['other_assets'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->other_assets ? ucfirst(strtolower($asset->other_assets)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'other_assets')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'sophos_antivirus')
                            <select wire:model="editedAsset.{{ $asset->id }}.sophos_antivirus" style="width:50px;">
                                <option value="Yes" {{ $editedAsset[$asset->id]['sophos_antivirus'] === 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ $editedAsset[$asset->id]['sophos_antivirus'] === 'No' ? 'selected' : '' }}>No</option>
                            </select>
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->sophos_antivirus ? ucfirst(strtolower($asset->sophos_antivirus)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'sophos_antivirus')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>

                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'vpn_creation')
                            <select wire:model="editedAsset.{{ $asset->id }}.vpn_creation" style="width:50px;">
                                <option value="Yes" {{ $editedAsset[$asset->id]['vpn_creation'] === 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ $editedAsset[$asset->id]['vpn_creation'] === 'No' ? 'selected' : '' }}>No</option>
                            </select>
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->vpn_creation ? ucfirst(strtolower($asset->vpn_creation)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'vpn_creation')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>

                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'teramind')
                            <select wire:model="editedAsset.{{ $asset->id }}.teramind" style="width:50px;">
                                <option value="Yes" {{ $editedAsset[$asset->id]['teramind'] === 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ $editedAsset[$asset->id]['teramind'] === 'No' ? 'selected' : '' }}>No</option>
                            </select>
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->teramind ? ucfirst(strtolower($asset->teramind)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'teramind')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'system_name')
                            <input wire:model="editedAsset.{{ $asset->id }}.system_name" type="number" value="{{ $editedAsset[$asset->id]['system_name'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->system_name ? $asset->system_name : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'system_name')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'system_upgradation')
                            <select wire:model="editedAsset.{{ $asset->id }}.system_upgradation" style="width:50px;">
                                <option value="Yes" {{ $editedAsset[$asset->id]['system_upgradation'] === 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ $editedAsset[$asset->id]['system_upgradation'] === 'No' ? 'selected' : '' }}>No</option>
                            </select>
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->system_upgradation ? ucfirst(strtolower($asset->system_upgradation)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'system_upgradation')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'screenshot_of_programms')
                            <input wire:model="editedAsset.{{ $asset->id }}.screenshot_of_programms" type="text" value="{{ $editedAsset[$asset->id]['screenshot_of_programms'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->screenshot_of_programms ? ucfirst(strtolower($asset->screenshot_of_programms)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'screenshot_of_programms')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'one_drive')
                            <select wire:model="editedAsset.{{ $asset->id }}.one_drive" style="width:50px;">
                                <option value="Yes" {{ $editedAsset[$asset->id]['one_drive'] === 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ $editedAsset[$asset->id]['one_drive'] === 'No' ? 'selected' : '' }}>No</option>
                            </select>
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->one_drive ? ucfirst(strtolower($asset->one_drive)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'one_drive')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'mac_address')
                            <input wire:model="editedAsset.{{ $asset->id }}.mac_address" type="text" value="{{ $editedAsset[$asset->id]['mac_address'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->mac_address ? $asset->mac_address : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'mac_address')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'laptop_received')
                            <select wire:model="editedAsset.{{ $asset->id }}.laptop_received" style="width:50px;">
                                <option value="Yes" {{ $editedAsset[$asset->id]['laptop_received'] === 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ $editedAsset[$asset->id]['laptop_received'] === 'No' ? 'selected' : '' }}>No</option>
                            </select>
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->laptop_received ? ucfirst(strtolower($asset->laptop_received)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'laptop_received')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="asset-fields d-flex justify-content-between align-items-center">
                            @if($editMode[$asset->id] && $fieldToEdit[$asset->id] === 'laptop_received_date')
                            <input wire:model="editedAsset.{{ $asset->id }}.laptop_received_date" type="date" value="{{ $editedAsset[$asset->id]['laptop_received_date'] }}">
                            <button class="btn btn-link p-0" wire:click="update({{ $asset->id }})">
                                <i class="fas fa-save" style="font-size: 12px;color:grey;"></i> <!-- Save icon -->
                            </button>
                            @else
                            {{ $asset->laptop_received_date ? date('d M, Y', strtotime($asset->laptop_received_date)) : 'N/A' }}
                            <button class="btn btn-link p-0" wire:click="edit({{ $asset->id }}, 'laptop_received_date')">
                                <i class="fas fa-edit" style="font-size: 10px;color:grey;"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-end align-items-center">
                            <!-- Delete icon -->
                            <button class="btn btn-link p-0" wire:click="deleteAsset({{ $asset->id }})">
                                <i class="fas fa-trash-alt" style="font-size: 12px;color:red;"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="33" style="text-align:center;font-size:14px;">No data found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>