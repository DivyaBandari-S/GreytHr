<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TimeSheet;
use App\Helpers\FlashMessageHelper;
use Illuminate\Support\Facades\DB;

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
    public $time_sheet_type = "weekly";
    public $manager_approval = '';
    public $hr_approval = '';
    public $submission_status = '';

    public $first_name_cm = '';
    public $last_name_cm = '';
    public $emp_id_cm = '';
    public $start_date_cm = '';
    public $end_date_cm = '';
    public $time_sheet_type_cm = "weekly";
    public $manager_approval_cm = '';
    public $hr_approval_cm = '';
    public $submission_status_cm = '';

    public $openAccordionIndex = null; // Store the currently open accordion index
    public $activeTab ='currentMonth';
    public function setActiveTab($tab)
    {
        if ($tab === 'currentMonth') {
            $this->activeTab = 'currentMonth';
        } elseif ($tab === 'all') {
            $this->activeTab = 'all';
        }
    }

    public function toggleAccordion($index)
    {
        if ($this->openAccordionIndex === $index) {
            $this->openAccordionIndex = null; // Close the currently open item if clicked again
        } else {
            $this->openAccordionIndex = $index; // Open the new item
        }
    }


    public function teamTimeSheetsFilter()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;

        $managedEmployees = DB::table('employee_details')
            ->where('manager_id', $employeeId)
            ->pluck('emp_id');

        // Fetch all relevant timesheets first
        $this->filteredTeamTimeSheets = TimeSheet::with('employee', 'approvalStatusForManager')
            ->orderBy('start_date', 'desc')
            ->whereIn('emp_id', $managedEmployees)
            ->whereRaw('DATEDIFF(end_date, start_date) >= 4')
            ->where(function ($query) {
                $query->where('approval_status_for_manager', '5')
                    ->orWhere('approval_status_for_manager', '2')
                    ->orWhere('approval_status_for_manager', '3')
                    ->orWhere('approval_status_for_manager', '14');
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

    public $filteredTeamTimeSheetsCurrentMonth,$initialTeamTimeSheetsCurrentMonth,$teamTimeSheetsCurrentMonth;
    public function teamTimeSheetsFilterCurrentMonth()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;

        $managedEmployees = DB::table('employee_details')
            ->where('manager_id', $employeeId)
            ->pluck('emp_id');

        // Fetch all relevant timesheets first
        $this->filteredTeamTimeSheetsCurrentMonth = TimeSheet::with('employee', 'approvalStatusForManager')
            ->orderBy('start_date', 'desc')
            ->whereIn('emp_id', $managedEmployees)
            ->whereRaw('DATEDIFF(end_date, start_date) >= 4')
            ->where(function ($query) {
                $query->where('approval_status_for_manager', '5')
                    ->orWhere('approval_status_for_manager', '2')
                    ->orWhere('approval_status_for_manager', '3')
                    ->orWhere('approval_status_for_manager', '14');
            })
            ->when($this->first_name_cm, function ($query) {
                $query->whereHas('employee', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->first_name_cm . '%');
                });
            })
            ->when($this->last_name_cm, function ($query) {
                $query->whereHas('employee', function ($q) {
                    $q->where('last_name', 'like', '%' . $this->last_name_cm . '%');
                });
            })
            ->when($this->emp_id_cm, function ($query) {
                $query->whereHas('employee', function ($q) {
                    $q->where('emp_id', 'like', '%' . $this->emp_id_cm . '%');
                });
            })
            ->when($this->start_date_cm, function ($query) {
                $query->where('start_date', '>=', $this->start_date_cm);
            })
            ->when($this->end_date_cm, function ($query) {
                $query->where('end_date', '<=', $this->end_date_cm);
            })
            ->when($this->time_sheet_type_cm, function ($query) {
                $query->where('time_sheet_type', $this->time_sheet_type_cm);
            })
            ->when($this->submission_status_cm, function ($query) {
                $query->where('submission_status', $this->submission_status_cm);
            })
            ->when($this->manager_approval_cm, function ($query) {
                $query->where('approval_status_for_manager', $this->manager_approval_cm);
            })
            ->when($this->hr_approval_cm, function ($query) {
                $query->where('approval_status_for_hr', $this->hr_approval_cm);
            })
            ->where(function ($query) {
                // At least one of start_date or end_date must be in the current month
                $query->where(function ($q) {
                    $q->whereMonth('start_date', now()->month)
                      ->whereYear('start_date', now()->year);
                })
                ->orWhere(function ($q) {
                    $q->whereMonth('end_date', now()->month)
                      ->whereYear('end_date', now()->year);
                });
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
        $this->initialTeamTimeSheets = TimeSheet::with('employee', 'approvalStatusForManager')
            ->orderBy('start_date', 'desc')
            ->whereIn('emp_id', $managedEmployees)
            ->whereRaw('DATEDIFF(end_date, start_date) >=4')
            ->get();
        $this->teamTimeSheets = $this->filteredTeamTimeSheets ?? $this->initialTeamTimeSheets;
        $this->initialTeamTimeSheetsCurrentMonth = TimeSheet::with('employee', 'approvalStatusForManager')
        ->orderBy('start_date', 'desc')
        ->whereIn('emp_id', $managedEmployees)
        ->whereRaw('DATEDIFF(end_date, start_date) >= 4')
        ->where(function ($query) {
            // At least one of start_date or end_date must be in the current month
            $query->where(function ($q) {
                $q->whereMonth('start_date', now()->month)
                  ->whereYear('start_date', now()->year);
            })
            ->orWhere(function ($q) {
                $q->whereMonth('end_date', now()->month)
                  ->whereYear('end_date', now()->year);
            });
        })
        ->get();
        $this->teamTimeSheetsCurrentMonth = $this->filteredTeamTimeSheetsCurrentMonth ?? $this->initialTeamTimeSheetsCurrentMonth;

        return view('livewire.all-team-time-sheets');
    }

    public function approve($id)
    {
        $timesheet = TimeSheet::find($id);

        if (!$timesheet) {
            FlashMessageHelper::flashError('Timesheet not found.');
            return;
        }

        if ($timesheet->approval_status_for_manager === "2") {
            FlashMessageHelper::flashError('Timesheet already approved!');
        } else {
            $timesheet->update([
                'approval_status_for_manager' => '2'
            ]);
            FlashMessageHelper::flashSuccess('Timesheet approved successfully!');
        }
        return redirect('/team-time-sheets');
    }

    public function reject($id, $reason)
    {
        $timesheet = TimeSheet::find($id);

        if (!$timesheet) {
            FlashMessageHelper::flashError('Timesheet not found.');
            return;
        }

        $timesheet->update([
            'approval_status_for_manager' => '3',
            'reject_reason_for_manager' => $reason,
        ]);
        FlashMessageHelper::flashSuccess('Timesheet rejected successfully!');
        return redirect('/team-time-sheets');
    }

    public function resubmit($id, $reason)
    {
        $timesheet = TimeSheet::find($id);

        if (!$timesheet) {
            FlashMessageHelper::flashError('Timesheet not found.');
            return;
        }

        $timesheet->update([
            'submission_status' => '12',
            'approval_status_for_manager' => '14',
            'resubmit_reason_for_manager' => $reason,
        ]);
        FlashMessageHelper::flashSuccess('Timesheet status changed to resubmit successfully!');
        return redirect('/team-time-sheets');
    }
}
