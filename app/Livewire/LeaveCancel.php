<?php
// File Name                       : LeaveCancel.php
// Description                     : This file contains the implementation to apply a approved leave to get cancelled.
// Creator                         : Bandari Divya
// Email                           : bandaridivya1@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : LeaveRequest,EmployeeDetails,HolidayCalendar
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\LeaveRequest;
use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\DB;

class LeaveCancel extends Component
{
    use WithFileUploads, WithPagination;

    public $leave_type;
    public $emp_id;
    public $from_date;
    public $from_session;
    public $to_session;
    public $to_date;
    public $applying_to;
    public $contact_details;
    public $reason;
    public $reportTo;
    public $report_to;
    public $managerId;
    public $employeeId;
    public $file_paths;
    public $filePaths = [];
    public $defaultApplyingTo;
    public $cc_to;
    public $searchTerm = '';
    public $selectedEmployeeNames = [];
    public $selectedPeople = [];
    public $selectedManager = [];
    public $first_name;
    public $employeeDetails = [];
    public $ccRecipients = [];
    public $applyingToDetails = [];
    public $files = [];
    public $filteredEmployees = [];
    public $has;
    public $isOpen = false;

    public function mount()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->applying_to = EmployeeDetails::where('emp_id', $employeeId)->first();
        if ($this->applying_to) {
            // Concatenate both report_to and manager_id
            // $this->defaultApplyingTo = $this->applying_to->report_to . ' ' . $this->applying_to->manager_id;

            // Or display them separately
            $this->reportTo = $this->applying_to->report_to;
            $this->managerId = $this->applying_to->manager_id;
        }
        $this->searchEmployees();
        $this->searchCCRecipients();
    }

    public  $LeaveShowinfoMessage = true;
    public  $LeaveShowinfoButton = false;
    public function toggleInfoLeave()
    {
        $this->LeaveShowinfoMessage = !$this->LeaveShowinfoMessage;
        $this->LeaveShowinfoButton = !$this->LeaveShowinfoButton;
    }
    // Add this method to your Livewire component
    public function searchEmployees()
    {
        // Fetch employees based on the search term
        $this->employeeDetails = EmployeeDetails::where('company_id', $this->applying_to->company_id)
            ->where(function ($query) {
                $query->where('company_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('emp_id', 'like', '%' . $this->searchTerm . '%');
            })

            ->select(
                'manager_id',
                DB::raw('MIN(report_to) as report_to'),
                DB::raw('MIN(image) as image'),
                DB::raw('MIN(emp_id) as emp_id'),
                DB::raw('MIN(CONCAT(first_name, " ", last_name)) as full_name')
            )
            ->groupBy('manager_id')
            ->distinct()
            ->get();
    }
    public function searchCCRecipients()
    {
        // Fetch employees based on the search term for CC To
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->ccRecipients = EmployeeDetails::where('company_id', $this->applying_to->company_id)
            ->where('emp_id', '!=', $employeeId) // Exclude the current user
            ->where(function ($query) {
                $query->where('company_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('emp_id', 'like', '%' . $this->searchTerm . '%');
            })
            ->groupBy('emp_id')
            ->select(
                'emp_id',
                DB::raw('MIN(CONCAT(first_name, " ", last_name)) as full_name')
            )
            ->get();
    }

    public function leaveApply()
    {

        $this->validate([
            'leave_type' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'from_session' => 'required',
            'to_session' => 'required',
            'reason' => 'required',
            'applying_to' => 'required',
            'files.*' => 'required|mimes:pdf,excel,png,jpg|max:2048',
            'contact_details' => 'required',

        ]);

        $filePaths = [];

        if (isset($this->files)) {
            foreach ($this->files as $file) {
                $fileName = uniqid() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/help-desk-files', $fileName);
                $filePaths[] = 'help-desk-files/' . $fileName;
            }
        }

        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

        $ccToDetails = [];
        foreach ($this->selectedPeople as $selectedEmployeeId) {
            // Fetch additional details from EmployeeDetails table
            $employeeDetails = EmployeeDetails::where('emp_id', $selectedEmployeeId)->first();

            // Concatenate first_name and last_name to get the full name
            $fullName = $employeeDetails->first_name . ' ' . $employeeDetails->last_name;

            $ccToDetails[] = [
                'emp_id' => $selectedEmployeeId,
                'full_name' => $fullName,
            ];
        }

        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

        $applyingToDetails = [];
        foreach ($this->selectedManager as $selectedManagerId) {
            // Fetch additional details from EmployeeDetails table
            $employeeDetails = EmployeeDetails::where('manager_id', $selectedManagerId)->first();

            if ($employeeDetails) {
                $applyingToDetails[] = [
                    'manager_id' => $selectedManagerId,
                    'report_to' => $employeeDetails->report_to,
                ];
            }
        }
        LeaveRequest::create([
            'emp_id' => $this->employeeDetails->emp_id,
            'leave_type' => $this->leave_type,
            'from_date' => $this->from_date,
            'from_session' => $this->from_session,
            'to_session' => $this->to_session,
            'to_date' => $this->to_date,
            'applying_to' => json_encode($applyingToDetails),
            'file_paths' => json_encode($filePaths),
            'cc_to' => json_encode($ccToDetails),
            'contact_details' => $this->contact_details,
            'reason' => $this->reason,
        ]);
        $this->reset();
        session()->flash('message', 'Leave application submitted successfully!');
        return redirect()->to('/leave-page');
    }
    public function render()
    {
        return view('livewire.leave-cancel');
    }
}
