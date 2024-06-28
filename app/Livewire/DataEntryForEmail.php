<?php

namespace App\Livewire;

use App\Models\DataEntry;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Livewire\Component;

class DataEntryForEmail extends Component
{
    public $dataEntries = [];
    public $editIndex = null;
    public $editField = null;
    public $nextFridayDate;

    protected $rules = [
        'dataEntries.*.employee_name' => 'nullable|string',
        'dataEntries.*.employee_title' => 'nullable|string',
        'dataEntries.*.project_title' => 'nullable|string',
        'dataEntries.*.employee_email' => 'nullable|email|unique:data_entries,employee_email',
        'dataEntries.*.work_location' => 'nullable|string',
        'dataEntries.*.project_manager' => 'nullable|string',
        'dataEntries.*.access_network' => 'nullable|string',
        'dataEntries.*.po_number' => 'nullable|string',
        'dataEntries.*.hourly_paid' => 'nullable|numeric',
        'dataEntries.*.mark_up' => 'nullable|numeric',
        'dataEntries.*.hourly_max' => 'nullable|numeric',
        'dataEntries.*.start_date' => 'nullable|date',
        'dataEntries.*.sow_end_date' => 'nullable|date',
        'dataEntries.*.background_check' => 'nullable|string',
        'dataEntries.*.on_site_resource' => 'nullable|string',
        'dataEntries.*.vaccination_status' => 'nullable|string',
    ];

    public function mount()
    {
        $this->dataEntries = DataEntry::all()->toArray();
        // Set the timezone to your desired timezone
        date_default_timezone_set('Asia/Kolkata');

        $today = Carbon::now();

        // Calculate the date of the upcoming Friday
        $this->nextFridayDate = $today->next(CarbonInterface::FRIDAY)->format('d M, Y');
    }

    public function addRow()
    {
        $newEntry = DataEntry::create([
            'employee_name' => '',
            'employee_title' => '',
            'project_title' => '',
            'employee_email' => '',
            'work_location' => '',
            'project_manager' => '',
            'access_network' => '',
            'po_number' => '',
            'hourly_paid' => null,
            'mark_up' => null,
            'hourly_max' => null,
            'start_date' => null,
            'sow_end_date' => null,
            'background_check' => '',
            'on_site_resource' => '',
            'vaccination_status' => '',
        ]);

        $this->dataEntries[] = $newEntry->toArray();
    }

    public function editCell($index, $field)
    {
        $this->editIndex = $index;
        $this->editField = $field;
    }

    public function updateRow($index)
    {
        $entry = $this->dataEntries[$index];

        if (isset($entry['id'])) {
            $dataEntry = DataEntry::find($entry['id']);

            if ($dataEntry) {
                $dataEntry->update($entry);
            }
        }

        $this->editIndex = null;
        $this->editField = null;
    }

    public function deleteRow($index)
    {
        if (isset($this->dataEntries[$index]['id'])) {
            DataEntry::find($this->dataEntries[$index]['id'])->delete();
        }

        unset($this->dataEntries[$index]);
        $this->dataEntries = array_values($this->dataEntries);
    }

    public function save()
    {
        foreach ($this->dataEntries as $entry) {
            if (isset($entry['id'])) {
                $dataEntry = DataEntry::find($entry['id']);
                if ($dataEntry) {
                    $dataEntry->update($entry);
                }
            } else {
                DataEntry::create($entry);
            }
        }
    }


    public function render()
    {
        return view('livewire.data-entry-for-email');
    }
}
