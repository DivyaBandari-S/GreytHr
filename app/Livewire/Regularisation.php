<?php
// Created by : Pranita Priyadarshi
// About this component: It shows allowing employees to adjust or provide reasons for discrepancies in their recorded work hours
namespace App\Livewire;
use App\Models\EmployeeDetails;
use App\Models\RegularisationNew;
use App\Models\RegularisationNew1;
use App\Models\Regularisations;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Livewire\Component;

class Regularisation extends Component
{
    public $c=false;
    
    public $isApply=0;

    public $isPending=0;
    public $isHistory=0;

    public $date;
    
    public $callcontainer=0;
    public $data;

    public $pendingRegularisations;

    public $historyRegularisations;

    public $regularisationEntriesArray;
    public $selectdate;
    public $data1;
    public $data7;
    public $data8;
    public $manager3;
    public $selectedDates = [];
    public $employee;
    public $data4;
    public $from;
    public $to;
    public $reason;

    public $remarks;

    public $withdraw_session=false;
    public $isdatesApplied=false;
    public $count_for_regularisation=0;

    public $updatedregularisationEntries;
    public $regularisationEntries=[];
    public $manager1;
   
    public $storedArray;

    public $storedArray1;
    public $numberOfItems;
    public $year;
    public $month;
    public $currentMonth;

    public $isdeletedArray=0;
    public $currentYear;
    public $data10;
    public $currentDate;
    public $defaultApply=1;
    public $currentDateTime;
   
    public $count=0;
    public function mount()
    {
        $this->year = now()->year;
        $this->month = now()->month;
        $this->getDaysInMonth($this->year,$this->month);
        // $this->updateCurrentMonthYear();
        $this->currentDate = now();
    }
   
    public function previousMonth()
    {
        
        // Logic to go to the previous month
        // For simplicity, I'm using Carbon for date manipulation
        // $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
  
        // $this->currentMonth = $date->format('F');
        // $this->currentYear = $date->format('Y');
        // dd($this->currentMonth . ' ' . $this->currentYear);
        $this->date = Carbon::create($this->year, $this->month, 1)->subMonth();
       
        $this->year = $this->date->year;
        
        $this->month = $this->date->month;
        $daysInMonth1 = $this->getDaysInMonth($this->year, $this->month);
        
    }

    public function nextMonth()
    {
        // Logic to go to the next month
        // For simplicity, I'm using Carbon for date manipulation
      
        $this->date = Carbon::create($this->year, $this->month, 1)->addMonth();
        
        $this->year = $this->date->year;
        $this->month = $this->date->month;
        $daysInMonth2 = $this->getDaysInMonth($this->year, $this->month);
       
       
    }
    // public function updateCurrentMonthYear()
    // {
    //     // Set the current month and year dynamically
    //     $this->currentMonth = now()->format('F');
    //     $this->currentYear = now()->format('Y');
    // }
    public function getDaysInMonth($year, $month)
    {

        $date = Carbon::create($year, $month, 1);
        $daysInMonth = $date->daysInMonth;

          return collect(range(1, $daysInMonth))->map(function ($day) use ($date) {
            return [
                'day' => $day,
                'date' => $date->copy()->addDays($day - 1),
                'isCurrentDate' => $day === now()->day && $date->isCurrentMonth(),
            ];
          });
        

        
        // $firstDayOfMonth = Carbon::parse("{$this->currentYear}-{$this->currentMonth}-01");
     
        // $lastDayOfMonth = $firstDayOfMonth->copy()->lastOfMonth();
      
        // $daysInMonth = [];
        
        // // Loop through each day in the month
        // for ($day = $firstDayOfMonth->copy(); $day->lte($lastDayOfMonth); $day->addDay()) {
        //     $daysInMonth[] = [
        //         'date' => $day->copy(),
        //         'day' => $day->format('j'),
        //         'isCurrentDate' => $day->isToday(),
        //     ];
        // }

        // return $daysInMonth;
      
        
    }
    public function selectDate123()
    {
        dd('selectDate123');
    }
 
    public function selectDate($date)
    {
            $currentDate = date('Y-m-d');
            if (strtotime($date) < strtotime($currentDate)) {
                if (!in_array($date, $this->selectedDates)) {
                    // Add the date to the selectedDates array only if it's not already selected
                    $this->selectedDates[] = $date;
                    $this->regularisationEntries[] = [
                        'date' => $date,
                        'from' => '',
                        'to' => '',
                        'reason'=>'',
                    ];
                }
            }
            $this->storedArray = array($this->selectedDates);
    }
    public function deleteStoredArray($index)
    {
       
            
        unset($this->regularisationEntries[$index]);
        $this->isdeletedArray+=1;
        $this->updatedregularisationEntries = array_values($this->regularisationEntries);
        
    }
    public function storearraydates()
    {
        $this->isdatesApplied=true;
        $employeeDetails = EmployeeDetails::where('emp_id',auth()->guard('emp')->user()->emp_id)->first();
        $emp_id=$employeeDetails->emp_id;
        $regularisationEntriesJson = json_encode($this->regularisationEntries);
        if($this->isdeletedArray>0)
        {
            $regularisationEntriesArray = $this->updatedregularisationEntries;
        }
        else
        {
            $regularisationEntriesArray = json_decode($regularisationEntriesJson, true);
        }
        
// Count the number of items
        $this->numberOfItems = count($regularisationEntriesArray);
        
        RegularisationNew1::create([
            'emp_id' => $emp_id,   
            'employee_remarks'=>$this->remarks,         
            'regularisation_entries'=>$regularisationEntriesJson,
            'is_withdraw'=>0,
            'regularisation_date'=>'2024-03-26',
        ]);
        session()->flash('message', 'CV created successfully.');
        $regularisationEntriesJson=[];
        $this->regularisationEntries=[];

    }
    
    public function applyButton()
    {
      
        
        $this->isApply=1;
        $this->isPending=0;
        $this->isHistory=0;
        $this->defaultApply=1;
    }
    public function pendingButton()
    {
        
        
        $this->isApply=0;
        $this->isPending=1;
        $this->isHistory=0;
        $this->defaultApply=0;
    }
    public function historyButton()
    {
       
       
        $this->isApply=0;
        $this->isPending=0;
        $this->isHistory=1;
        $this->defaultApply=0;
    }
  

    public function storePost()
    {
        $employeeDetails = EmployeeDetails::where('emp_id',auth()->guard('emp')->user()->emp_id)->first();
        $emp_id=$employeeDetails->emp_id;
        
        
        
        try 
        {
            
          Regularisations::create([
                
                'emp_id'=>$emp_id,
                'from' => $this->from,
                'to' => $this->to,
                'reason'=>$this->reason,
                'is_withdraw'=>0,
                'regularisation_date'=>$this->selectedDate,
                
            ]);
            session()->flash('success', 'Hurry Up! Action completed successfully');          
            
        } 
        catch (\Exception $ex) {
            
            session()->flash('error','Something goes wrong!!');
        }
    }
 
    public function withdraw($id)
    {
        $currentDateTime = Carbon::now();
        $this->data =RegularisationNew1::where('id', $id)->update(['is_withdraw' => 1,'withdraw_date' => $currentDateTime,]);
        $this->withdraw_session=true;
        session()->flash('success', 'Hurry Up! Regularisation withdrawn  successfully');
    }
    public function approve($id)
    {
       
        $regularisation = Regularisations::find($id);
        $currentDateTime1 = Carbon::now(); 
        $regularisation->status = 'approved';
        $s=EmployeeDetails::where('manager_id',auth()->guard('emp')->user()->emp_id)->pluck('report_to')->toArray();
        $s1 = implode(' ', $s); 
  
        $regularisation->approved_by =$s1 ;
     
        $regularisation->is_withdraw = 1;
        $regularisation->approved_date=$currentDateTime1;
        $regularisation->save();
      
    }
    public function updateCount()
    {
        
        $this->c= true;
       
    }

    public function reject($id)
    {
        $currentDateTime2 = Carbon::now(); 
        $regularisation = Regularisations::find($id);
        $regularisation->status = 'rejected';
        $s2=EmployeeDetails::where('manager_id',auth()->guard('emp')->user()->emp_id)->pluck('report_to')->toArray();
        $s3 = implode(' ', $s2); 
  
        $regularisation->rejected_by =$s3 ;
        $regularisation->rejected_date =$currentDateTime2;
        $regularisation->is_withdraw = 1;
        $regularisation->save();
    }

    public $regularisationdescription;

  
    public function status($id)
    {
        return redirect()->route('regularisation-history', ['id' => $id]);
    }


    public function render()
    {
      
       
        
    
        
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $s4 = EmployeeDetails::where('emp_id', auth()->guard('emp')->user()->emp_id)->pluck('report_to')->first();
     
        $employeeDetails = EmployeeDetails::select('manager_id')
        ->where('emp_id', $loggedInEmpId)
        ->first();    
        $empid=$employeeDetails->manager_id;
        $employeeDetails1 = EmployeeDetails::
         where('emp_id', $empid)
        ->first();
        // Check if the logged-in user is a manager by comparing emp_id with manager_id in employeedetails
        $isManager = EmployeeDetails::where('manager_id', $loggedInEmpId)->exists();
        
       
    
        $subordinateEmployeeIds = EmployeeDetails::where('manager_id',auth()->guard('emp')->user()->emp_id)
       ->pluck('first_name','last_name')
       ->toArray();
    //    $subordinate = implode(' ', $subordinateEmployeeIds); 
    //    dd($subordinate);
    $pendingRegularisations = RegularisationNew1::where('emp_id', $loggedInEmpId)
    ->where('status', 'pending')
    ->where('is_withdraw', 0)
    ->orderByDesc('id')
    ->get();

$this->pendingRegularisations = $pendingRegularisations->filter(function ($regularisation) {
    return $regularisation->regularisation_entries !== "[]";
});

$historyRegularisations = RegularisationNew1::where('emp_id', $loggedInEmpId)
->whereIn('status', ['pending', 'approved', 'rejected'])
->orderByDesc('id')
->get();
 
$this->historyRegularisations = $historyRegularisations->filter(function ($regularisation) {
        return $regularisation->regularisation_entries !== "[]";
});



  
        $manager = EmployeeDetails::select('manager_id', 'report_to')->distinct()->get();   
        
        $this->data10= Regularisations::where('status', 'pending')->get();
        $this->manager1 = EmployeeDetails::where('emp_id', auth()->guard('emp')->user()->emp_id)->first();
           
        $this->data = Regularisations::where('is_withdraw', '0')->count();
        $this->data8 = Regularisations::where('is_withdraw', '0')->get();
      
        $this->data1 = Regularisations::where('status', 'pending')->first();
        $this->data4 = Regularisations::where('is_withdraw', '1')->count();
        $this->data7= Regularisations::all();
        $employee = EmployeeDetails::where('emp_id',auth()->guard('emp')->user()->emp_id)->first();
       
        
        if ($employee) {
            $this->manager3 = EmployeeDetails::find($employee->manager_id);
            
        }
        
        return view('livewire.regularisation',['CallContainer'=>$this->callcontainer,'manager_report'=>$s4,'isManager1'=>$isManager,'daysInMonth' => $this->getDaysInMonth($this->year,$this->month),'subordinate'=>$subordinateEmployeeIds,'show'=>$this->c,'manager11'=>$manager,'count'=>$this->c,'count1'=> $this->data,'manager2'=>$this->manager3,'data2'=>$this->data1 ,'data5'=>$this->data4,'data81'=>$this->data7,'withdraw'=>$this->data8,'data11'=>$this->data10,'manager2'=>$this->manager1,'EmployeeDetails'=>$employeeDetails1]);
    }
}
