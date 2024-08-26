<?php

namespace App\Livewire;

use App\Models\Company;
use App\Models\EmployeeDetails;
use App\Models\EmpParentDetails;
use App\Models\EmpPersonalInfo;
use App\Models\EmpSpouseDetails;
use App\Models\ParentDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelWriter;

class FamilyReport extends Component
{
    public $employees;

    public $searching = 0;

    public $selectAllEmployees=0;
    public $notFound;

    public $search;

    public $EmployeeId=[];

    public function updateEmployeeId()
    {
       
          
       
            $this->EmployeeId=$this->EmployeeId;
        
        
    }


    public function downloadInExcel()
    {
      if(empty($this->EmployeeId))
      {
        return redirect()->back()->with('error', 'Select at least one employee detail');
      }
      else
      {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
     
        $employees1 = EmployeeDetails::where('manager_id', $loggedInEmpId)
    ->join('emp_parent_details', 'employee_details.emp_id', '=', 'emp_parent_details.emp_id')
    ->whereIn('employee_details.emp_id', $this->EmployeeId)
    ->select('employee_details.emp_id', 'employee_details.first_name', 'employee_details.last_name',
             'emp_parent_details.father_first_name', 'emp_parent_details.father_last_name',
             'emp_parent_details.mother_first_name', 'emp_parent_details.mother_last_name',
             'emp_parent_details.father_dob', 'emp_parent_details.mother_dob',
             'emp_parent_details.father_address', 'emp_parent_details.mother_address',
             'emp_parent_details.father_email', 'emp_parent_details.mother_email',
             'emp_parent_details.father_phone', 'emp_parent_details.mother_phone',
             'emp_parent_details.father_occupation', 'emp_parent_details.mother_occupation')
    ->get();
 
    $employees3= EmployeeDetails::where('manager_id', $loggedInEmpId)
    ->join('emp_spouse_details', 'employee_details.emp_id', '=', 'emp_spouse_details.emp_id')
    ->whereIn('employee_details.emp_id', $this->EmployeeId)
    ->select('employee_details.emp_id', 'employee_details.first_name', 'employee_details.last_name',
             'emp_spouse_details.*')
    ->get();
        $employees2=EmployeeDetails::whereIn('emp_id', $this->EmployeeId)->get();
       
       
       
        $rows = [];
        $data = [
            ['List of Family Details of Employees'],
            ['Employee Number', 'Employee Name', 'Joined On',    'Company',    'Designation',    'Member Name',    'Relation', 'Date of Birth',    'Gender', 'Blood Group', 'Nationality', 'Profession'],
 
        ];
        $rows=$data;
    
foreach ($employees2 as $employee) {
    // Default data row for the employee
    
    $selfData = [
        $employee['emp_id'],
        $employee['first_name'] . ' ' . $employee['last_name'],
        isset($employee['hire_date']) ? \Carbon\Carbon::parse($employee['hire_date'])->format('jS F Y') : 'NA',
        isset($employee['company_id']) ? Company::where('company_id', $employee['company_id'])->value('company_name') :'NA'
        ,
        isset($employee['job_role'])? $employee['job_role']:'NA',
        $employee['first_name'] . ' ' . $employee['last_name'],
        'self',
        isset($employee['date_of_birth'])? EmpPersonalInfo::where('emp_id',$employee['emp_id'])->value('date_of_birth'):'NA',
        isset($employee['gender'])? $employee['gender']:'NA',
        isset($employee['blood_group']) ? EmpPersonalInfo::where('emp_id',$employee['emp_id'])->value('blood_group'):'NA',
        isset($employee['nationality'])? EmpPersonalInfo::where('emp_id',$employee['emp_id'])->value('nationality'):'NA',
        ' '
    ];
    
    // Add the employee's own data row to the rows array
    $rows[] = $selfData;
 
    // Check if employee exists in employees1
    $emp_id_exists_in_employees1 = $employees1->contains('emp_id', $employee['emp_id']);
    $employee_is_married=EmpSpouseDetails::where('emp_id', $employee['emp_id'])->exists();
    $employee_has_children = DB::table('emp_spouse_details')->where('emp_id', $employee['emp_id'])
    ->whereNotNull('children')
    ->where('children', '!=', '[]')
    ->exists();
    if ($emp_id_exists_in_employees1) {
        $parentdetails = EmpParentDetails::where('emp_id', $employee['emp_id'])->first(); // Use first() instead of get() to get a single record
        if ($parentdetails) {
            // Data row for the parent's details
            $motherData = [
                $employee['emp_id'],
                $employee['first_name'] . ' ' . $employee['last_name'],
                isset($employee['hire_date']) ? \Carbon\Carbon::parse($employee['hire_date'])->format('jS F Y') : 'NA',
                isset($employee['company_id']) ? Company::where('company_id', $employee['company_id'])->value('company_name') :'NA',
                isset($employee['job_role']) ? $employee['job_role']:'NA',
                $parentdetails->mother_first_name . ' ' . $parentdetails->mother_last_name,
                'mother',
                \Carbon\Carbon::parse($parentdetails->mother_dob)->format('jS F Y'),
                'Female',
                $parentdetails->mother_blood_group,
                $parentdetails->mother_nationality,
                $parentdetails->mother_occupation
            ];
            $fatherData = [
                $employee['emp_id'],
                $employee['first_name'] . ' ' . $employee['last_name'],
                isset($employee['hire_date']) ? \Carbon\Carbon::parse($employee['hire_date'])->format('jS F Y') : 'NA',
                isset($employee['company_id']) ? Company::where('company_id', $employee['company_id'])->value('company_name') :'NA',
                isset($employee['job_role']) ? $employee['job_role']:'NA',
                $parentdetails->father_first_name . ' ' . $parentdetails->father_last_name,
                'Father',
                \Carbon\Carbon::parse($parentdetails->father_dob)->format('jS F Y'),
                'Male',
                $parentdetails->father_blood_group,
                $parentdetails->father_nationality,
                $parentdetails->father_occupation
            ];
 
            // Add the parent's details row to the rows array
            $rows[] = $motherData;
            $rows[]= $fatherData;
        }
    }
    if ($employee_is_married) {
        $spouseDetails = DB::table('emp_spouse_details')->where('emp_id', $employee['emp_id'])->first(); // Use first() instead of get() to get a single record
        if ($spouseDetails) {
            // Data row for the parent's details
            if($spouseDetails->gender=='Female')
            {
                    $spouseData = [
                        $employee['emp_id'],
                        $employee['first_name'] . ' ' . $employee['last_name'],
                        isset($employee['hire_date']) ? \Carbon\Carbon::parse($employee['hire_date'])->format('jS F Y') : 'NA',
                        isset($employee['company_id']) ? Company::where('company_id', $employee['company_id'])->value('company_name') :'NA',
                        isset($employee['job_role']) ? $employee['job_role']:'NA',
                        $spouseDetails->name,
                        'wife',
                        \Carbon\Carbon::parse($spouseDetails->dob)->format('jS F Y'),
                        'Female',
                        $spouseDetails->bld_group,
                        $spouseDetails->nationality,
                        $spouseDetails->profession
                    ];
                }
                else
                {
                    $spouseData = [
                        $employee['emp_id'],
                        $employee['first_name'] . ' ' . $employee['last_name'],
                        isset($employee['hire_date']) ? \Carbon\Carbon::parse($employee['hire_date'])->format('jS F Y') : 'NA',
                        isset($employee['company_id']) ? Company::where('company_id', $employee['company_id'])->value('company_name') :'NA',
                        isset($employee['job_role']) ? $employee['job_role']:'NA',
                        $spouseDetails->name,
                        'Husband',
                        \Carbon\Carbon::parse( $spouseDetails->dob)->format('jS F Y'),
                        'Male',
                        $spouseDetails->bld_group,
                        $spouseDetails->nationality,
                        $spouseDetails->profession
                    ];
                }
               
               
               
            // Add the parent's details row to the rows array
            $rows[] = $spouseData;
           
           
        }
    }
    if ($employee_has_children) {
        $childrenDetails = DB::table('emp_spouse_details')->where('emp_id', $employee['emp_id'])->select('children')->first();
       
        $children = json_decode($childrenDetails->children, true);
       
        if (is_array($children)) {
         
            foreach ($children as $child) {
           
               if($child['gender']=='female')
               {
                $childrenData = [
                    $employee['emp_id'],
                    $employee['first_name'] . ' ' . $employee['last_name'],
                    \Carbon\Carbon::parse( $employee['hire_date'])->format('jS F Y'),
                    $employee['company_name'],
                    $employee['job_title'],
                    $child['name'],
                    'daughter',
                   \Carbon\Carbon::parse( $child['dob'])->format('jS F Y'),
                    $child['gender'],
                    isset($child['blood_group']) ?? $child['blood_group'] ?? 'NA', // Assuming blood group is not available for children
                    isset($child['nationality']) ?? $child['nationality'] ?? 'NA', // Assuming nationality is not available for children
                    ''  // Assuming occupation is not applicable for children
                ];
               }
               else
               {
                        $childrenData = [
                            $employee['emp_id'],
                            $employee['first_name'] . ' ' . $employee['last_name'],
                            \Carbon\Carbon::parse( $employee['hire_date'])->format('jS F Y'),
                            $employee['company_name'],
                            $employee['job_title'],
                            $child['name'],
                            'son',
                            \Carbon\Carbon::parse( $child['dob'] )->format('jS F Y'),
                            $child['gender'],
                            $child['blood-group'] ?? 'NA', // Assuming blood group is not available for children
                            $child['nationality'] ?? 'NA', // Assuming nationality is not available for children
                            ''  // Assuming occupation is not applicable for children
                        ];
            }
                // Add the child's details row to the rows array
                $rows[] = $childrenData;
            }
        }
       
        }
   
    }    
       $filePath = storage_path('app/family_reports.xlsx');
        SimpleExcelWriter::create($filePath)->addRows($rows);
        return response()->download($filePath, 'family_reports.xlsx');

      }
    }
    public function searchfilter()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $this->searching = 1;
     
            
    }
   
    public function render()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $this->employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->get();
        if($this->searching==1)
        {
            $nameFilter = $this->search; // Assuming $this->search contains the name filter
            $filteredEmployees = $this->employees->filter(function ($employee) use ($nameFilter) {
                return stripos($employee->first_name, $nameFilter) !== false ||
                    stripos($employee->last_name, $nameFilter) !== false ||
                    stripos($employee->emp_id, $nameFilter) !== false||
                    stripos($employee->job_title, $nameFilter) !== false||
                    stripos($employee->city, $nameFilter) !== false||
                    stripos($employee->state, $nameFilter) !== false;
            });

            if ($filteredEmployees->isEmpty()) {
                $this->notFound = true; // Set a flag indicating that the name was not found
            } else {
                $this->notFound = false;
            }
        }
        else
        {
            $filteredEmployees=$this->employees;
        }

        return view('livewire.family-report',['Employees'=>$filteredEmployees]);
    }
}
