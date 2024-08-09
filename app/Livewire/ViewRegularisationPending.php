<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\RegularisationDates;
use App\Models\RegularisationNew;
use App\Models\RegularisationNew1;
use App\Models\SwipeRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ViewRegularisationPending extends Component
{
    public $regularisations;
    public $employeeId;

    public $user;

    public $remarks;

    public $regularised_date;
    public $openRejectPopupModal=false;

    public $openApprovePopupModal=false;
    public $countofregularisations;
    public function mount()
    {
        $this->employeeId = auth()->guard('emp')->user()->emp_id;
        $this->user = EmployeeDetails::where('emp_id', $this->employeeId)->first();
        $employees=EmployeeDetails::where('manager_id',$this->employeeId)->select('emp_id', 'first_name', 'last_name')->get();
        $empIds = $employees->pluck('emp_id')->toArray();
        $this->regularisations = RegularisationDates::whereIn('emp_id', $empIds)
        ->where('is_withdraw', 0) // Assuming you want records with is_withdraw set to 0
        ->where('status','pending')
        ->selectRaw('*, JSON_LENGTH(regularisation_entries) AS regularisation_entries_count')
        ->whereRaw('JSON_LENGTH(regularisation_entries) > 0')
        ->with('employee')
        ->get();
        foreach ($this->regularisations as $regularisation) {
            $this->regularised_date = Carbon::parse($regularisation->created_at)->toDateString();

            $daysDifference = Carbon::parse($this->regularised_date)->diffInDays(Carbon::now());

            if ($daysDifference >= 3) {
                $this->approve($regularisation->id);
            }


        }
    }
    public function openRejectModal()
    {
       $this->openRejectPopupModal=true;
    }
    public function closeRejectModal()
    {
        $this->openRejectPopupModal=false;
    }
    public function openApproveModal()
    {
        $this->openApprovePopupModal=true;
    }
    public function closeApproveModal()
    {
        $this->openApprovePopupModal=false;
    }
    public function approve($id)
    {
        $currentDateTime = Carbon::now();
        $item = RegularisationDates::find($id);
        $employeeId=$item->emp_id;
        $item->status='approved';
        if(empty($this->remarks))
        {

        }
        else
        {
            $item->approver_remarks=$this->remarks;
        }
        $item->approved_date = $currentDateTime;
        $item->approved_by=$this->user->first_name . ' ' . $this->user->last_name;
        $item->save();
        $regularisationEntries = json_decode($item['regularisation_entries'], true);
        if (!empty($regularisationEntries) && is_array($regularisationEntries)) {
            foreach ($regularisationEntries as $entry) {
                $swiperecord=new SwipeRecord();
                $swiperecord->emp_id=$employeeId;
                $date = $regularisationEntries[0]['date'];
                if (empty($entry['from'])) {


                    $swiperecord->in_or_out='IN';
                    $swiperecord->swipe_time= '10:00';
                    $swiperecord->created_at=$date;
                    $swiperecord->is_regularised=true;

                } else {
                    $swiperecord->in_or_out='IN';
                    $swiperecord->swipe_time= $entry['from'];
                    $swiperecord->created_at=$date;
                    $swiperecord->is_regularised=true;
                }
                $swiperecord->save();
                $swiperecord1=new SwipeRecord();
                $swiperecord1->emp_id=$employeeId;

                if (empty($entry['to'])) {


                    $swiperecord1->in_or_out='OUT';
                    $swiperecord1->swipe_time= '19:00';
                    $swiperecord1->created_at=$date;
                    $swiperecord1->is_regularised=true;

                } else {
                    $swiperecord1->in_or_out='OUT';
                    $swiperecord1->swipe_time= $entry['to'];
                    $swiperecord1->created_at=$date;
                    $swiperecord1->is_regularised=true;
                }
                $swiperecord1->save();
                // Exit the loop after the first entry since the example has one entry
                break;
            }
        }
        $this->countofregularisations--;
       
        $this->remarks='';
        Session::flash('success', 'Regularisation Request approved successfully');
        $this->closeApproveModal();
    }

    public function reject($id)
    {
        $currentDateTime = Carbon::now();
        $item = RegularisationDates::find($id);
        if(empty($this->remarks))
        {

        }
        else
        {
            $item->approver_remarks=$this->remarks;
        }
        $item->status='rejected';
        $item->rejected_date = $currentDateTime;
        $item->rejected_by=$this->user->first_name . ' ' . $this->user->last_name;
        $item->save();

        $this->countofregularisations--;
        Session::flash('success', 'Regularisation Request rejected successfully');
        $this->remarks='';
        $this->closeRejectModal();
    }


    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $employees=EmployeeDetails::where('manager_id',$employeeId)->select('emp_id', 'first_name', 'last_name')->get();
        $empIds = $employees->pluck('emp_id')->toArray();

// Retrieve records from AttendanceRegularisationNew for the extracted emp_ids
        $this->regularisations = RegularisationDates::whereIn('emp_id', $empIds)
        ->where('is_withdraw', 0) // Assuming you want records with is_withdraw set to 0
        ->where('status','pending')
        ->selectRaw('*, JSON_LENGTH(regularisation_entries) AS regularisation_entries_count')
        ->whereRaw('JSON_LENGTH(regularisation_entries) > 0')
        ->with('employee')
        ->get();


        $this->countofregularisations=$this->regularisations->count();
        return view('livewire.view-regularisation-pending');
    }
}
