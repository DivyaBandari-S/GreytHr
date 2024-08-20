<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TimeSheet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AllTeamTimeSheets extends Component
{
    public $teamTimeSheets;
    public $initialTeamTimeSheets;
    public $filteredTeamTimeSheets;
    public $first_name = '';
    public $last_name = '';
    public $emp_id = '';
    public $start_date = '';
    public $end_date = '';
    public $time_sheet_type="weekly";
    public $manager_approval = 'pending';
    public $hr_approval = '';
    public $submission_status = '';

    public function teamTimeSheetsFilter()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;

        $managedEmployees = DB::table('employee_details')
            ->where('manager_id', $employeeId)
            ->pluck('emp_id');

        // Fetch all relevant timesheets first
        $this->filteredTeamTimeSheets = TimeSheet::with('employee')
            ->orderBy('start_date', 'desc')
            ->whereIn('emp_id', $managedEmployees)
            ->whereRaw('DATEDIFF(end_date, start_date) = 6')
            ->where(function ($query) {
                $query->where('approval_status_for_manager', 'pending')
                    ->orWhere('approval_status_for_manager', 'approved')
                    ->orWhere('approval_status_for_manager', 'rejected')
                    ->orWhere('approval_status_for_manager', 're-submit');
            })
            ->when($this->first_name, function ($query) {
                $query->whereHas('employee', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->first_name . '%');
                });
            })
            ->when($this->last_name, function ($query) {
                $query->whereHas('employee', function ($q) {
                    $q->where('last_name', 'like', '%' . $this->last_name . '%');
                });
            })
            ->when($this->emp_id, function ($query) {
                $query->whereHas('employee', function ($q) {
                    $q->where('emp_id', 'like', '%' . $this->emp_id . '%');
                });
            })
            ->when($this->start_date, function ($query) {
                $query->where('start_date', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
                $query->where('end_date', '<=', $this->end_date);
            })
            ->when($this->time_sheet_type, function ($query) {
                $query->where('time_sheet_type', $this->time_sheet_type);
            })
            ->when($this->submission_status, function ($query) {
                $query->where('submission_status', $this->submission_status);
            })
            ->when($this->manager_approval, function ($query) {
                $query->where('approval_status_for_manager', $this->manager_approval);
            })
            ->when($this->hr_approval, function ($query) {
                $query->where('approval_status_for_hr', $this->hr_approval);
            })
            ->get();
    }

    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;

        $managedEmployees = DB::table('employee_details')
            ->where('manager_id', $employeeId)
            ->pluck('emp_id');

        // Initial timesheets
        $this->initialTeamTimeSheets = TimeSheet::with('employee')
            ->orderBy('start_date', 'desc')
            ->whereIn('emp_id', $managedEmployees)
            ->whereRaw('DATEDIFF(end_date, start_date) != 7')
            ->where(function ($query) {
                $query->where('approval_status_for_manager', 'pending')
                    ->orWhere('approval_status_for_manager', 'approved')
                    ->orWhere('approval_status_for_manager', 'rejected')
                    ->orWhere('approval_status_for_manager', 're-submit');
            })
            ->get();

        // Apply filters
        $this->teamTimeSheetsFilter();

        // Set the final team time sheets
        $this->teamTimeSheets = $this->filteredTeamTimeSheets ?: $this->initialTeamTimeSheets;

        return view('livewire.all-team-time-sheets');
    }

    public function approve($id)
    {
        $timesheet = TimeSheet::find($id);

        if (!$timesheet) {
            session()->flash('approve_status', 'Timesheet not found.');
            return;
        }

        if ($timesheet->approval_status_for_manager === "approved") {
            session()->flash('approve_status', 'Timesheet already approved!');
        } else {
            $timesheet->update([
                'approval_status_for_manager' => 'approved'
            ]);
            session()->flash('approve_status', 'Timesheet approved successfully!');
        }
    }

    public function reject($id, $reason)
    {
        $timesheet = TimeSheet::find($id);

        if (!$timesheet) {
            session()->flash('approve_status', 'Timesheet not found.');
            return;
        }

        $timesheet->update([
            'approval_status_for_manager' => 'rejected',
            'reject_reason_for_manager' => $reason,
        ]);
        session()->flash('approve_status', 'Timesheet rejected successfully!');
    }

    public function resubmit($id, $reason)
    {
        $timesheet = TimeSheet::find($id);

        if (!$timesheet) {
            session()->flash('approve_status', 'Timesheet not found.');
            return;
        }

        $timesheet->update([
            'submission_status' => 'saved',
            'approval_status_for_manager' => 're-submit',
            'resubmit_reason_for_manager' => $reason,
        ]);

        session()->flash('approve_status', 'Timesheet status changed to resubmit successfully!');
    }
}
