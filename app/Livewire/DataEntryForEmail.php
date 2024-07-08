<?php

namespace App\Livewire;

use App\Models\DataEntry;
use App\Models\SentEmail;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;

class DataEntryForEmail extends Component
{
    public $dataEntries = [];
    public $editIndex = null;
    public $editField = null;
    public $nextFridayDate;
    public $successMessage;
    public $to_email = 'bandaridivya1@gmail.com';
    public $toEmail;
    public $ccEmail;
    public $cc_email;
    public $subject;
    public $showEditToAddress = false;
    public $editSubject = false;
    public $scheduled_time;
    public $showCCAddress = false;


    public $file_path; // Add a property to store file path

    public function sendEmailsAndStoreData()
    {
        $this->validate([
            'to_email' => 'required|email',
            'cc_email' => 'nullable|email',
            'subject' => 'required|string',
        ]);

        // Send email immediately without storing in database
        $this->sendEmails($this->subject);

        // Optionally, you can clear the form fields after sending
        $this->to_email = '';
        $this->cc_email = '';
        $this->subject = '';

        // Emit a message or perform any other action upon success
        session()->flash('message', 'Email sent successfully!');
        return redirect()->to(url()->previous());
    }

    public function sendEmails($subject)
    {
        // Call the Artisan command to trigger export:data-entries with immediate send
        Artisan::call('export:data-entries', ['--subject' => $subject]);
    }

    public function scheduleEmails()
    {
        $this->validate([
            'to_email' => 'required|email',
            'cc_email' => 'nullable|email',
            'subject' => 'required|string',
            'scheduled_time' => 'required|date', // Ensure scheduled time is provided
        ]);

        // Store data in SentEmail table with the scheduled time
        SentEmail::create([
            'to_email' => $this->to_email,
            'cc_email' => $this->cc_email,
            'subject' => $this->subject,
            'scheduled_time' => $this->scheduled_time,
        ]);

        // Clear form fields after storing
        $this->to_email = '';
        $this->cc_email = '';
        $this->subject = '';
        $this->scheduled_time = null;

        // Emit a message or perform any other action upon success
        session()->flash('message', 'Email scheduled successfully.');

        return redirect()->to(url()->previous());
    }


    public function scheduleEmailDefault()
    {
        // Set default scheduled time to every 15 minutes
        $scheduledTime = Carbon::now()->addMinutes(30);

        // Save email data with scheduled time
        SentEmail::create([
            'to_email' => $this->to_email ?? 'bandaridivya1@gmail.com',
            'cc_email' => $this->cc_email,
            'subject' => $this->subject,
            'scheduled_time' => $scheduledTime,
        ]);

        session()->flash('message', 'Email scheduled successfully.');
    }


    public function editToAddress()
    {
        $this->showEditToAddress = !$this->showEditToAddress;
    }

    public function editCCAddress()
    {
        $this->showCCAddress = !$this->showCCAddress;
    }

    public function editSubject()
    {
        $this->editSubject = !$this->editSubject;
    }

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
        if ($today->isFriday()) {
            // If today is Friday and it's the same day as the next Friday, display today's date
            $this->nextFridayDate = $today->format('d M, Y');
        } else {
            // Otherwise, display the date of the upcoming Friday
            $this->nextFridayDate = $today->next(CarbonInterface::FRIDAY)->format('d M, Y');
        }
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
