<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\PeopleList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\HelpDesks;
use Livewire\WithFileUploads;

class HelpDesk extends Component
{
    use WithFileUploads;
    public $searchTerm = '';

    public $isRotated = false;
    public $selectedPerson = null;
    public $peoples;
    public $filteredPeoples;
    public $peopleFound = true;
    public $category;
    public $subject;
    public $description;
    public $file_path;
    public $cc_to;
    public $priority;
    public $records;
    public $image;
    public $mobile;
    public $selectedPeopleNames = [];
    public $employeeDetails;
    public $showDialog = false;
    public $record;
    public $activeTab = 'active';
    protected function resetInputFields()
    {
        $this->category = '';
        $this->subject = '';
        $this->description = '';
        $this->file_path = '';
        $this->cc_to = '';
        $this->priority = '';
    }


    protected function addErrorMessages($messages)
    {
        foreach ($messages as $field => $message) {
            $this->addError($field, $message[0]);
        }
    }





    public function openForDesks($taskId)
    {
        $task = HelpDesks::find($taskId);

        if ($task) {
            $task->update(['status' => 'Completed']);
        }
        return redirect()->to('/HelpDesk');
    }

    public function closeForDesks($taskId)
    {
        $task = HelpDesks::find($taskId);

        if ($task) {
            $task->update(['status' => 'Open']);
        }
        return redirect()->to('/HelpDesk');
    }

    public function submit()
    {
        $this->validate([
            'category' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx,txt,ppt,pptx,gif,jpg,jpeg,png|max:2048',
            'cc_to' => 'required',
            'priority' => 'required|in:High,Medium,Low',
            'image' => 'image|max:2048',
        ]);
        if ($this->image) {
            $fileName = uniqid() . '_' . $this->image->getClientOriginalName();

            $this->image->storeAs('public/help-desk-images', $fileName);

            $this->image = 'help-desk-images/' . $fileName;
        }
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

        HelpDesks::create([
            'emp_id' => $this->employeeDetails->emp_id,
            'category' => $this->category,
            'subject' => $this->subject,
            'description' => $this->description,
            'file_path' => $this->image,
            'cc_to' => $this->cc_to,
            'priority' => $this->priority,
            'mail' =>'N/A',
            'mobile' => 'N/A',
            'distributor_name' => 'N/A',
        ]);

        $this->reset();
    }


    public function open()
    {
        $this->showDialog = true;
    }
    public $selectedPeople = [];


    public function close()
    {
        $this->showDialog = false;
    }
    public function closePeoples()
    {
        $this->isRotated = false;
    }

    public function updatedSelectedPeople()
    {
        $this->cc_to = implode(', ', array_unique($this->selectedPeopleNames));
    }

    public function selectPerson($personId)
    {
        $selectedPerson = $this->peoples->where('emp_id', $personId)->first();

        if ($selectedPerson) {
            if (in_array($personId, $this->selectedPeople)) {
                $this->selectedPeopleNames[] = $selectedPerson->first_name . ' #(' . $selectedPerson->emp_id . ')';
            } else {
                $this->selectedPeopleNames = array_diff($this->selectedPeopleNames, [$selectedPerson->first_name . ' #(' . $selectedPerson->emp_id . ')']);
            }
            $this->cc_to = implode(', ', array_unique($this->selectedPeopleNames));
        }
    }

    public function toggleRotation()
    {
        $this->isRotated = true;

        $this->selectedPeopleNames = [];
        $this->cc_to = '';
    }



    public function filter()
    {
        $companyId = Auth::user()->company_id;

        $trimmedSearchTerm = trim($this->searchTerm);

        $this->filteredPeoples = EmployeeDetails::where('company_id', $companyId)
            ->where(function ($query) use ($trimmedSearchTerm) {
                $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $trimmedSearchTerm . '%')
                    ->orWhere('emp_id', 'like', '%' . $trimmedSearchTerm . '%');
            })
            ->get();

        $this->peopleFound = count($this->filteredPeoples) > 0;
    }

    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $companyId = Auth::user()->company_id;

        $this->peoples = EmployeeDetails::where('company_id', $companyId)
        ->orderBy('first_name')
        ->orderBy('last_name')
        ->get();
        $peopleData = $this->filteredPeoples ? $this->filteredPeoples : $this->peoples;
        $this->record = HelpDesks::all();
        $employeeName = auth()->user()->first_name . ' #(' . $employeeId . ')';

        $this->records = HelpDesks::with('emp')
            ->where(function ($query) use ($employeeId, $employeeName) {
                $query->where('emp_id', $employeeId)
                    ->orWhere('cc_to', 'LIKE', "%$employeeName%");
            })
            ->orderBy('created_at', 'desc')
            ->get();
            return view('livewire.help-desk', [
                'peopleData' => $peopleData,
            ]);
    }
}
