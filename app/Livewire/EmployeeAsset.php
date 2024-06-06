<?php

namespace App\Livewire;

use App\Models\EmployeeAsset as AssetModel;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class EmployeeAsset extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return AssetModel::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('emp_id')
            ->add('asset_tag')
            ->add('status')
            ->add('manufacturer')
            ->add('asset_type')
            ->add('asset_model')
            ->add('asset_specification')
            ->add('serial_number')
            ->add('color')
            ->add('current_owner')
            ->add('previous_owner')
            ->add('windows_version')
            ->add('assign_date_formatted', fn (AssetModel $model) => Carbon::parse($model->assign_date)->format('d/m/Y'))
            ->add('purchase_date_formatted', fn (AssetModel $model) => Carbon::parse($model->purchase_date)->format('d/m/Y'))
            ->add('invoice_no')
            ->add('taxable_amount')
            ->add('gst_central')
            ->add('gst_state')
            ->add('invoice_amount')
            ->add('vendor')
            ->add('other_assets')
            ->add('sophos_antivirus')
            ->add('vpn_creation')
            ->add('teramind')
            ->add('system_name')
            ->add('system_upgradation')
            ->add('screenshot_of_programms')
            ->add('one_drive')
            ->add('mac_address')
            ->add('laptop_received')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Emp id', 'emp_id')
                ->sortable()
                ->searchable(),

            Column::make('Asset tag', 'asset_tag')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Manufacturer', 'manufacturer')
                ->sortable()
                ->searchable(),

            Column::make('Asset type', 'asset_type')
                ->sortable()
                ->searchable(),

            Column::make('Asset model', 'asset_model')
                ->sortable()
                ->searchable(),

            Column::make('Asset specification', 'asset_specification')
                ->sortable()
                ->searchable(),

            Column::make('Serial number', 'serial_number')
                ->sortable()
                ->searchable(),

            Column::make('Color', 'color')
                ->sortable()
                ->searchable(),

            Column::make('Current owner', 'current_owner')
                ->sortable()
                ->searchable(),

            Column::make('Previous owner', 'previous_owner')
                ->sortable()
                ->searchable(),

            Column::make('Windows version', 'windows_version')
                ->sortable()
                ->searchable(),

            Column::make('Assign date', 'assign_date_formatted', 'assign_date')
                ->sortable(),

            Column::make('Purchase date', 'purchase_date_formatted', 'purchase_date')
                ->sortable(),

            Column::make('Invoice no', 'invoice_no')
                ->sortable()
                ->searchable(),

            Column::make('Taxable amount', 'taxable_amount')
                ->sortable()
                ->searchable(),

            Column::make('Gst central', 'gst_central')
                ->sortable()
                ->searchable(),

            Column::make('Gst state', 'gst_state')
                ->sortable()
                ->searchable(),

            Column::make('Invoice amount', 'invoice_amount')
                ->sortable()
                ->searchable(),

            Column::make('Vendor', 'vendor')
                ->sortable()
                ->searchable(),

            Column::make('Other assets', 'other_assets')
                ->sortable()
                ->searchable(),

            Column::make('Sophos antivirus', 'sophos_antivirus')
                ->sortable()
                ->searchable(),

            Column::make('Vpn creation', 'vpn_creation')
                ->sortable()
                ->searchable(),

            Column::make('Teramind', 'teramind')
                ->sortable()
                ->searchable(),

            Column::make('System name', 'system_name')
                ->sortable()
                ->searchable(),

            Column::make('System upgradation', 'system_upgradation')
                ->sortable()
                ->searchable(),

            Column::make('Screenshot of programms', 'screenshot_of_programms')
                ->sortable()
                ->searchable(),

            Column::make('One drive', 'one_drive')
                ->sortable()
                ->searchable(),

            Column::make('Mac address', 'mac_address')
                ->sortable()
                ->searchable(),

            Column::make('Laptop received', 'laptop_received')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Created at', 'created_at')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datepicker('assign_date'),
            Filter::datepicker('purchase_date'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function actions(AssetModel $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: '.$row->id)
                ->id()
                ->class('pg-btn-navyblue dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id])
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
