<?php

namespace App\Livewire;
use App\Models\EmployeeDetails;
use App\Models\Regularisations;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Livewire\Component;

class Regularisation extends Component
{
    public $c=false;   
    public $data;
    public $data1;
    public $data7;
    public $data8;
    public $manager3;
    public $employee;
    public $data4;
    public $from,$to,$reason,$date;
    public $manager1;
   
    public $data10;
   
    public $currentDateTime;

    
   
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
                 'regularisation_date'=>$this->date,
                
            ]);
            session()->flash('success', 'Hurry Up! Action completed successfully');
            // $this->from = '';
            // $this->to = '';
            // $this->reason = '';
            
            
        } 
        catch (\Exception $ex) {
            
            session()->flash('error','Something goes wrong!!');
        }
    }
 
    public function withdraw($id)
    {
        $currentDateTime = Carbon::now();
       
        $this->data =Regularisations::where('id', $id)->update(['is_withdraw' => 1,'withdraw_date' => $currentDateTime,]);
         
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
     
                      
        // Check if the logged-in user is a manager by comparing emp_id with manager_id in employeedetails
        $isManager = EmployeeDetails::where('manager_id', $loggedInEmpId)->exists();
      
        $subordinateEmployeeIds = EmployeeDetails::where('manager_id',auth()->guard('emp')->user()->emp_id)
       ->pluck('first_name','last_name')
       ->toArray();
    //    $subordinate = implode(' ', $subordinateEmployeeIds); 
    //    dd($subordinate);
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
        
        return view('livewire.regularisation',['manager_report'=>$s4,'isManager1'=>$isManager,'subordinate'=>$subordinateEmployeeIds,'show'=>$this->c,'manager11'=>$manager,'count'=>$this->c,'count1'=> $this->data,'manager2'=>$this->manager3,'data2'=>$this->data1 ,'data5'=>$this->data4,'data81'=>$this->data7,'withdraw'=>$this->data8,'data11'=>$this->data10,'manager2'=>$this->manager1]);
    }
}
