<?php

namespace App\Livewire;

use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use Livewire\Component;
use App\Models\EmployeeAsset as AssetModel;
use Illuminate\Support\Facades\Log;

class EmployeeAssetsDetails extends Component
{
    public $employeeAssets;
    public $assetId;
    public $empId;
    public $assetTag;
    public $status;
    public $manufacturer;
    public $assetType;
    public $assetModel;
    public $assetSpecification;
    public $serialNumber;
    public $color;
    public $currentOwner;
    public $previousOwner;
    public $windowsVersion;
    public $assignDate;
    public $purchaseDate;
    public $invoiceNo;
    public $taxableAmount;
    public $gstCentral;
    public $gstState;
    public $invoiceAmount;
    public $vendor;
    public $otherAssets;
    public $sophosAntivirus;
    public $vpnCreation;
    public $teramind;
    public $systemName;
    public $systemUpgradation;
    public $screenshotOfProgramms;
    public $oneDrive;
    public $macAddress;
    public $laptopReceived;
    public $editMode = [];
    public $fieldToEdit = [];
    public $editedAsset = [];
    public $asset_tag;
    public $asset_type;
    public $asset_model;
    public $asset_specification;
    public $serial_number;
    public $current_owner;
    public $previous_owner;
    public $windows_version;
    public $assign_date;
    public $purchase_date;
    public $invoice_no;
    public $taxable_amount;
    public $gst_central;
    public $gst_state;
    public $invoice_amount;
    public $other_assets;
    public $system_name;
    public $screenshot_of_programms;
    public $mac_address;
    public $laptop_received;
    public $laptop_received_date;

    public function mount()
    {
        $this->employeeAssets = AssetModel::all();
        foreach ($this->employeeAssets as $asset) {
            $this->editMode[$asset->id] = false;
        }
    }
    // Inside your `EmployeeAssetsDetails` Livewire component class
    public function addNewRow()
{

        // Create a new instance of AssetModel with default values
        $newAsset = AssetModel::create([
            'asset_tag' => $this->asset_tag,
            'status' => $this->status,
            'manufacturer' => $this->manufacturer,
            'asset_type' => $this->asset_type,
            'asset_model' => $this->asset_model,
            'asset_specification' => $this->asset_specification,
            'serial_number' => $this->serial_number,
            'color' => $this->color,
            'current_owner' => $this->current_owner,
            'previous_owner' => $this->previous_owner,
            'windows_version' => $this->windows_version,
            'assign_date' => $this->assign_date,
            'purchase_date' => $this->purchase_date,
            'invoice_no' => $this->invoice_no,
            'taxable_amount' => $this->taxable_amount,
            'gst_central' => $this->gst_central,
            'gst_state' => $this->gst_state,
            'invoice_amount' => $this->invoice_amount,
            'vendor' => $this->vendor,
            'other_assets' => $this->other_assets,
            'system_name' => $this->system_name,
            'screenshot_of_programms' => $this->screenshot_of_programms,
            'mac_address' => $this->mac_address,
            'laptop_received_date' => $this->laptop_received_date,
        ]);

        // Refresh the employeeAssets collection to include the newly created asset
        $this->employeeAssets = AssetModel::all();

        // Get the ID of the newly created asset
        $newAssetId = $newAsset->id;

        // Flash success message
        session()->flash('success', 'New asset added successfully ');

}




    public function edit($assetId, $field)
    {
        try {
            $this->editMode[$assetId] = true;
            $this->fieldToEdit[$assetId] = $field;
            // Fetch the specific field data for the asset being edited
            $asset = AssetModel::findOrFail($assetId);
            $this->editedAsset[$assetId][$field] = $asset->{$field} ?? null;
        } catch (\Exception $e) {
            // Log the exception or handle it accordingly
            Log::error('Error editing asset: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while editing the asset.');
        }
    }

    public function update($assetId)
    {
        try {
            if (!isset($this->fieldToEdit[$assetId]) || empty($this->fieldToEdit[$assetId])) {
                return;
            }

            $fieldToEdit = $this->fieldToEdit[$assetId];
            $asset = AssetModel::findOrFail($assetId);
            // Check if the edited asset array is set and contains the field
            if (isset($this->editedAsset[$assetId][$fieldToEdit])) {
                $asset->{$fieldToEdit} = $this->editedAsset[$assetId][$fieldToEdit];
                $asset->save();
                $this->editMode[$assetId] = false;
                $this->fieldToEdit[$assetId] = null;
                $this->editedAsset[$assetId] = [];

                session()->flash('success', 'Asset updated successfully.');
            } else {
                return;
            }
        } catch (\Exception $e) {
            // Log the exception or handle it accordingly
            Log::error('Error updating asset: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while updating the asset.');
        }
    }

    public function deleteAsset($assetId)
    {
        try {
            // Find the asset by its ID
            $asset = AssetModel::findOrFail($assetId);
            
            // Delete the asset
            $asset->delete();
    
            // Refresh the employeeAssets collection after deletion
            $this->employeeAssets = AssetModel::all();
    
            // Flash success message
            session()->flash('success', 'Asset deleted successfully.');
        } catch (\Exception $e) {
            // Log the exception or handle it accordingly
            session()->flash('error', 'An error occurred while deleting the asset.');
        }
    }

    public function render()
    {
        $this->employeeAssets = AssetModel::all();
        return view(
            'livewire.employee-assets-details',
            [
                'employeeAssets' => $this->employeeAssets
            ]
        );
    }
}
