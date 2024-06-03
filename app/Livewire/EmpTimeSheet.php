<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\TimeSheet;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmpTimeSheet extends Component
{
    public $employeeDetails;
    public $openTimeSheettable = false;
    public $currentWeek;
    public $submissionDate;
    public $managerDetails;
    public $managerNameOfLogin;
    public $rows = [];
    public $emp_id;
    public $week_start_date;
    public $hours = [];
    public $client_task_mapping = [];

    public $addingRow = false;
    public $total_hours;

    public function addNewRow()
    {
        if (!$this->addingRow) {
            $this->addingRow = true;
            $this->rows[] = ['',0, 0, 0, 0, 0, 0, 0, 0];
            $employeeId = auth()->guard('emp')->user()->emp_id;
            session(["timesheet_rows_{$employeeId}" => $this->rows]);
        }
    }
    public function deleteLastRow()
    {
        try {
            array_pop($this->rows);
            $employeeId = auth()->guard('emp')->user()->emp_id;
            session(["timesheet_rows_{$employeeId}" => $this->rows]);
            $this->addingRow = false; // Reset the addingRow flag
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete the last row');
            // You can also log the error if needed
            Log::error('Failed to delete the last row: ' . $e->getMessage());
        }
    }

    protected $rules = [
        'week_start_date' => 'required|date',
        'hours.*' => 'nullable|numeric|min:0',
        'total_hours' => 'nullable|numeric|min:0', // Custom rule for total hours
        'emp_id' => 'required|string', // Example validation rule for emp_id
    ];
    public function storeTimeSheet()
    {
        $this->validate();
        $totalHours = array_sum($this->hours);

        // Merge total hours into the request data for validation
        $validatedData = array_merge($this->validate(), ['total_hours' => $totalHours]);
        try {
            DB::beginTransaction();

            // Prepare the data for storage
            $data = [
                'emp_id' => $this->emp_id,
                'week_start_date' => $this->week_start_date,
                'monday_hours' => $this->hours[0] ?? null,
                'tuesday_hours' => $this->hours[1] ?? null,
                'wednesday_hours' => $this->hours[2] ?? null,
                'thursday_hours' => $this->hours[3] ?? null,
                'friday_hours' => $this->hours[4] ?? null,
                'saturday_hours' => $this->hours[5] ?? null,
                'sunday_hours' => $this->hours[6] ?? null,
                'client_task_mapping' => json_encode($this->client_task_mapping),
            ];
            // Store the data in the database
            TimeSheet::create($data);

            DB::commit();

            session()->flash('success', 'Time sheet stored successfully');

            // Reset form fields
            $this->reset();
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Failed to store time sheet');
        }
    }
    public function mount()
    {
        $this->emp_id = Auth::guard('emp')->user()->emp_id;
        $this->week_start_date = now()->startOfWeek()->format('Y-m-d');
        // Get the start of the current week
        $startOfWeek = Carbon::now()->startOfWeek();
        $employeeId = auth()->guard('emp')->user()->emp_id;
        // Get the end of the current week
        $endOfWeek = Carbon::now()->endOfWeek();
        $this->submissionDate =$endOfWeek->format('d F, Y');
        // Check if the start and end dates fall within the same month
        if ($startOfWeek->month == $endOfWeek->month) {
            // Format the dates with month name
            $formattedStartDate = $startOfWeek->format('d');
            $formattedEndDate = $endOfWeek->format('d F, Y');
        } else {
            // Format the dates with month name for both start and end dates
            $formattedStartDate = $startOfWeek->format('d F');
            $formattedEndDate = $endOfWeek->format('d F, Y');
        }

        // Set the current week range
        $this->currentWeek = $formattedStartDate . '-' . $formattedEndDate;
        if (session()->has("timesheet_rows_{$employeeId}")) {
            $this->rows = session("timesheet_rows_{$employeeId}");
        } else {
            $this->rows = [
                ['',0, 0, 0, 0, 0, 0, 0, 0],
            ];
            session(["timesheet_rows_{$employeeId}" => $this->rows]);
        }
    }

    public function openTimeSheet(){
         $this->openTimeSheettable = true;
    }
    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id',$employeeId)->first();
        if($this->employeeDetails){
            $managerId = $this->employeeDetails->manager_id;
            $this->managerDetails = EmployeeDetails::where('emp_id',$managerId)->first();
            if($this->managerDetails ){
                $this->managerNameOfLogin = ucwords(strtolower($this->managerDetails->first_name)) . ' ' . ucwords(strtolower($this->managerDetails->last_name));
            }else{
                $this->managerNameOfLogin = null;
            }
        }

        return view('livewire.emp-time-sheet',[
            'employeeDetails' => $this->employeeDetails,
            'managerNameOfLogin' => $this->managerNameOfLogin
        ]);
    }
}
