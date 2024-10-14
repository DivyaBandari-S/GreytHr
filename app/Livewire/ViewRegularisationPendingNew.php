<?php

namespace App\Livewire;

use App\Mail\ManagerNotificationMail;
use App\Models\EmployeeDetails;
use App\Models\RegularisationDates;
use App\Models\SwipeRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ViewRegularisationPendingNew extends Component
{
    public $regularisations;
    public $employeeId;

    public $showAlert=false;
    public $openAccordionForActive=null;
    public $managerEmail = 'pranita.priyadarshi@paygdigitals.com'; // Example manager email
    public $messageContent;  // This will hold the message input from the form
    public $senderName;

    public $regularisationEntries;
    public $searchQuery='';
    public $searching=0;
    public $regularised_date;
    public $user;

    public $auto_approve=false;
    public $remarks;

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
        ->whereNull('mail_sent')        
        ->selectRaw('*, JSON_LENGTH(regularisation_entries) AS regularisation_entries_count')
        ->whereRaw('JSON_LENGTH(regularisation_entries) > 0')
        ->with('employee')
        ->orderBy('created_at', 'desc')
        ->get();

        foreach ($this->regularisations as $regularisation) {
            $this->regularised_date = Carbon::parse($regularisation->created_at)->toDateString();

            $daysDifference = Carbon::parse($this->regularised_date)->diffInDays(Carbon::now());

            if($daysDifference>3&&empty($regularisation->mail_sent))
            {
                $this->sendMail($regularisation->id);
                $regularisation->mail_sent = 'sent';
                $regularisation->save();
            }

           


        }
    }

    public function sendMail($id)
{
    
    $item = RegularisationDates::find($id); // Ensure you have the correct ID to fetch data

    $this->regularisationEntries = json_decode($item->regularisation_entries, true); // Decode the JSON entries
    
    $employee = EmployeeDetails::where('emp_id', $item->emp_id)->first();
    // Prepare the HTML table
    $this->messageContent = " ".$this->user->first_name." ".$this->user->last_name."(".$this->user->emp_id.")" ."has neither approved nor rejected the regularization request for the past 3 days for employee ". $item->emp_id . " (" . $employee->first_name . " " . $employee->last_name . ").";
    $details = [
        'message' => $this->messageContent,
        'regularisationRequests'=>$this->regularisationEntries,
        'sender_id'=>$employee->emp_id,
        'sender_name' => $this->user->first_name." ".$this->user->last_name."(".$this->user->emp_id.")"
    ];


    // Send email to manager
    Mail::to($this->managerEmail)->send(new ManagerNotificationMail($details));

   
}

    public function toggleActiveAccordion($id)
    {
        
        if ($this->openAccordionForActive === $id) {
            $this->openAccordionForActive = null; // Close if already open
        } else {
            $this->openAccordionForActive = $id; // Set to open
        }
    }
    public function openRejectModal()
    {
       $this->openRejectPopupModal=true;
    }
    public function hideAlert()
    {
        $this->showAlert=false;
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
            if($this->auto_approve==true)
            {
                $item->approver_remarks='auto_approved';
            }

        }
        else
        {
            
                $item->approver_remarks=$this->remarks;
            
            
        }
        $item->approved_date = $currentDateTime;
        if($this->auto_approve==true)
        {
            $item->approved_by='auto_approved'; 
        }
        else
        {
            $item->approved_by=$this->user->first_name . ' ' . $this->user->last_name;
        }
        
        $item->save();
        $regularisationEntries = json_decode($item['regularisation_entries'], true);
        $count_of_regularisations=count($regularisationEntries);
        
        if (!empty($regularisationEntries) && is_array($regularisationEntries)) {
            
            for($i=0;$i<$count_of_regularisations;$i++) {
               
                $swiperecord=new SwipeRecord();
                $swiperecord->emp_id=$employeeId;
                $date = $regularisationEntries[$i]['date'];
                $from=$regularisationEntries[$i]['from'];
                $to=$regularisationEntries[$i]['to'];
                $reason=$regularisationEntries[$i]['reason'];
               
               
                
                if (empty($from)) {
                    
                    
                    $swiperecord->in_or_out='IN';
                    $swiperecord->swipe_time= '10:00';
                    $swiperecord->created_at=$date;
                    $swiperecord->is_regularised=true;
                    
                } else {
                    $swiperecord->in_or_out='IN';
                    $swiperecord->swipe_time= $from;
                    $swiperecord->created_at=$date;
                    $swiperecord->is_regularised=true;
                }
                $swiperecord->save();
                $swiperecord1=new SwipeRecord();
                $swiperecord1->emp_id=$employeeId;
                
                if (empty($to) ){
                    
                    
                    $swiperecord1->in_or_out='OUT';
                    $swiperecord1->swipe_time= '19:00';
                    $swiperecord1->created_at=$date;
                    $swiperecord1->is_regularised=true;
                    
                } else {
                    $swiperecord1->in_or_out='OUT';
                    $swiperecord1->swipe_time= $to;
                    $swiperecord1->created_at=$date;
                    $swiperecord1->is_regularised=true;
                }
                $swiperecord1->save();
                // Exit the loop after the first entry since the example has one entry
               
            }
        }
        $this->countofregularisations--;
        $this->remarks='';
        $this->closeApproveModal();
        Session::flash('success', 'Regularisation Request approved successfully');
        $this->showAlert=true;
    }
    
    public function searchRegularisation()
    {
        $this->searching=1;
       
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
        $this->remarks='';
        $this->closeRejectModal();
        Session::flash('success', 'Regularisation Request rejected successfully');
        $this->showAlert=true;
    }
    
 
    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $employees=EmployeeDetails::where('manager_id',$employeeId)->select('emp_id', 'first_name', 'last_name')->get();
        $empIds = $employees->pluck('emp_id')->toArray();
        if($this->searching==1)
        {
// Retrieve records from AttendanceRegularisationNew for the extracted emp_ids
                $this->regularisations = RegularisationDates::join('employee_details', 'regularisation_dates.emp_id', '=', 'employee_details.emp_id')
                ->whereIn('regularisation_dates.emp_id', $empIds)
                ->where('is_withdraw', 0) // Assuming you want records with is_withdraw set to 0
                ->where('regularisation_dates.status','pending')
                ->selectRaw('*, JSON_LENGTH(regularisation_entries) AS regularisation_entries_count')
                ->whereRaw('JSON_LENGTH(regularisation_entries) > 0') 
                ->with('employee') 
                ->where(function ($query) {
                    $query->where('regularisation_dates.emp_id', 'LIKE', '%' . $this->searchQuery . '%')
                        ->orWhere('employee_details.first_name', 'LIKE', '%' . $this->searchQuery . '%')
                        ->orWhere('employee_details.last_name', 'LIKE', '%' . $this->searchQuery . '%');
                        
                })
                ->get();
        }
        else
        {
            $this->regularisations = RegularisationDates::whereIn('emp_id', $empIds)
            ->where('is_withdraw', 0) // Assuming you want records with is_withdraw set to 0
            ->where('status','pending')
            ->selectRaw('*, JSON_LENGTH(regularisation_entries) AS regularisation_entries_count')
            ->whereRaw('JSON_LENGTH(regularisation_entries) > 0') 
            ->with('employee') 
            ->orderBy('created_at','desc')
            ->get();
        }
        
              
        $this->countofregularisations=$this->regularisations->count();  
        return view('livewire.view-regularisation-pending-new');
    }
}