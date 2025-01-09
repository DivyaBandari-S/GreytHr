<?php

namespace App\Livewire;

use App\Helpers\FlashMessageHelper;
use App\Mail\DelegateAddedNotification;
use App\Models\Delegate;
use App\Models\EmployeeDetails;
use App\Models\HolidayCalendar;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class Delegates extends Component
{
    use WithFileUploads;

    public $searchTerm = '';
    public $workflow = '';
    public $selectedWorkflow = '';
    public $fromDate;
    public $toDate;
    public $delegate = '';
    public $employeeDetails;
    public $isNames = false;
    public $record;
    public $mail;
    public $subject;
    public $distributor_name;
    public $description;
    public $priority;
    public $activeTab = 'active';
    public $image;
    public $selectedPerson = null;
    public $cc_to;
    public $peoples;
    public $filteredPeoples;
    public $selectedPeopleNames = [];
    public $selectedPeople = [];
    public $records;
    public $peopleFound = true;
    public $showform = false;
    public $isedit = false;
    public $showalertmodel = false;
    public $file_path;
    public $deleteid;
    public $editid;
    public $loginemp_id;

    public $retrievedData = [];

    protected $rules = [
        'workflow' => 'required',
        'fromDate' => 'required|date',
        'toDate' => 'required|date|after_or_equal:fromDate',
        'delegate' => 'required',
    ];

    public $messages = [
        'workflow' => 'Please select Workflow.',
        'fromDate' => 'From Date is required',
        'toDate' => 'To Date is required',
        'toDate.after_or_equal' => 'To Date must be a date after or equal to From Date',
        'delegate' => 'Please select Delegatee.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function showForm()
    {
        $this->showform = true;
    }
    public function hideForm()
    {
        $this->showform = false;
        $this->resetForm();
        $this->resetErrorBag();
    }
    public function showAlertModel($id)
    {

        $this->deleteid = $id;
        $this->showalertmodel = true;
    }
    public function delete()
    {
        $delegate = Delegate::findorfail($this->deleteid);
        $delegate->status = 0;
        $delegate->save();
        FlashMessageHelper::flashSuccess('Workflow Delegate Deleted Successfully!');
        $this->showalertmodel = false;
        return redirect()->to('/delegates');
    }
    public function cancel()
    {
        $this->showalertmodel = false;
    }
    public function editform($id)
    {
        $this->resetErrorBag();
        $this->isedit = true;
        $this->editid = $id;
        $delegate = Delegate::findorfail($this->editid);

        $this->workflow = $delegate->workflow;
        $this->fromDate = $delegate->from_date;
        $this->toDate = $delegate->to_date;
        $this->delegate = $delegate->delegate;
        $this->showform = true;
    }

    public function submitForm()
    {
        $this->validate($this->rules);

        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $startOfMonth = now()->startOfMonth();
            $endOfMonth = now()->endOfMonth();
            $holidays = HolidayCalendar::whereBetween('date', [$startOfMonth, $endOfMonth])
                ->pluck('date') // Get only the 'date' column
                ->map(fn($date) => Carbon::parse($date)->toDateString()) // Ensure dates are in string format
                ->toArray();


            $totalDaysDelegated = Delegate::where('emp_id', $employeeId)
                ->where('status', 1)
                ->where(function ($query) use ($startOfMonth, $endOfMonth) {
                    $query->whereBetween('from_date', [$startOfMonth, $endOfMonth])
                        ->orWhereBetween('to_date', [$startOfMonth, $endOfMonth]);
                })
                ->get()
                ->sum(function ($delegate) use ($startOfMonth, $endOfMonth, $holidays) {
                    $fromDate = Carbon::parse($delegate->from_date)->max($startOfMonth);
                    $toDate = Carbon::parse($delegate->to_date)->min($endOfMonth);
                    $totalWeekdays = 0;
                    while ($fromDate->lte($toDate)) {
                        if (!$fromDate->isWeekend() && !in_array($fromDate->toDateString(), $holidays)) { // Check if the day is not Saturday or Sunday

                            $totalWeekdays++;
                        }
                        $fromDate->addDay(); // Move to the next day
                    }

                    return $totalWeekdays;
                });



            $fromDate = Carbon::parse($this->fromDate);
            $toDate = Carbon::parse($this->toDate);
            // Calculate the number of days in the new request
            $newDaysRequested = 0;

            // Loop through each date in the range
            while ($fromDate->lte($toDate)) {
                if (!$fromDate->isWeekend() && !in_array($fromDate->toDateString(), $holidays)) {
                    // Increment only if the day is not a weekend or a holiday
                    $newDaysRequested++;
                }
                $fromDate->addDay(); // Move to the next day
            }

            // Validate against the maximum limit
            if (($totalDaysDelegated + $newDaysRequested) > 5) {
                FlashMessageHelper::flashError('You can only delegate up to 5 days per month.');
                return;
            }

            // Retrieve existing delegate data if needed
            $this->retrievedData = Delegate::where('emp_id', $employeeId)->first();

            if (!$this->isedit) {

                $delegateDetails = EmployeeDetails::where('emp_id', $this->delegate)->first();
                Delegate::create([
                    'emp_id' => $employeeId,
                    'workflow' => $this->workflow,
                    'from_date' => $this->fromDate,
                    'to_date' => $this->toDate,
                    'delegate' => $this->delegate,
                ]);

                Notification::create([
                    'emp_id' => $employeeId,
                    'notification_type' => 'delegate',
                    // 'leave_type' => $this->leave_type,
                    // 'leave_reason' => $this->reason,
                    'assignee' => $this->delegate,
                ]);

                if ($delegateDetails->email) {

                    $delegateName = ucwords(strtolower($delegateDetails->first_name)) . ' ' . ucwords(strtolower($delegateDetails->last_name)) . ' #( ' . $delegateDetails->emp_id . ')';
                    $addedBy = ucwords(strtolower($this->employeeDetails->first_name)) . ' ' . ucwords(strtolower($this->employeeDetails->last_name)) . ' #( ' . $this->employeeDetails->emp_id . ')';
                    Mail::to($delegateDetails->email)->send(new DelegateAddedNotification(
                        $addedBy,
                        $this->workflow,
                        $this->fromDate,
                        $this->toDate,
                        $delegateName,
                        true
                    ));
                }

                FlashMessageHelper::flashSuccess('Workflow Delegate Added Successfully!');
            } else {
                $delegate = Delegate::findorfail($this->editid);
                $delegate->workflow = $this->workflow;
                $delegate->from_date = $this->fromDate;
                $delegate->to_date = $this->toDate;
                $delegate->delegate = $this->delegate;
                $delegate->save();
                FlashMessageHelper::flashSuccess('Workflow Delegate Updated Successfully!');
            }

            // Clear the form inputs
            $this->resetForm();
            return redirect()->to('/delegates');
        } catch (\Exception $e) {
            Log::error('Database error: ' . $e->getMessage());
        }
    }
    public function mount()
    {

        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
        DB::table('notifications')
            ->where('notification_type', 'delegate')
            ->where('assignee', $employeeId)
            ->delete();
    }

    private function resetForm()
    {
        $this->workflow = ''; // Reset workflow
        $this->fromDate = ''; // Reset from date
        $this->toDate = '';   // Reset to date
        $this->delegate = ''; // Reset delegate

    }

    public function getDelegates()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $query = Delegate::where(function ($query) use ($employeeId) {
            $query->where('emp_id', $employeeId)
                ->orWhere('delegate', 'like', "%$employeeId%");
        });
        $query->where('status', 1);
        if ($this->selectedWorkflow != '') {
            $query->where('workflow', $this->selectedWorkflow);
        }
        $this->retrievedData = $query->orderBy('created_at', 'desc')->get();
    }


    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->loginemp_id = $employeeId;
        // Fetch records where emp_id or delegate contains the logged-in user's emp_id
        $this->getDelegates();


        $companyId = auth()->guard('emp')->user()->company_id;
        $this->peoples = EmployeeDetails::where('status', 1)->where('emp_id', '!=', $employeeId)->whereJsonContains('company_id', $companyId)->select('first_name', 'last_name', 'emp_id')->get();


        $this->record = Delegate::all();

        return view('livewire.delegates', [
            'employees' => $this->employeeDetails,
            'retrievedData' => $this->retrievedData,
            'records' => $this->record
        ]);
    }
}
