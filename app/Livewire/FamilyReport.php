<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\ParentDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelWriter;

class FamilyReport extends Component
{
    public $employees;

    public $searching = 0;

    public $EmployeeId=[];
    public function updateEmployeeId()
    {
        $this->EmployeeId=$this->EmployeeId;
    }


    public function downloadInExcel()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
      
        $employees1 = EmployeeDetails::where('manager_id', $loggedInEmpId)
    ->join('parent_details', 'employee_details.emp_id', '=', 'parent_details.emp_id')
    ->whereIn('employee_details.emp_id', $this->EmployeeId)
    ->select('employee_details.emp_id', 'employee_details.first_name', 'employee_details.last_name', 
             'parent_details.father_first_name', 'parent_details.father_last_name',
             'parent_details.mother_first_name', 'parent_details.mother_last_name',
             'parent_details.father_dob', 'parent_details.mother_dob',
             'parent_details.father_address', 'parent_details.mother_address',
             'parent_details.father_email', 'parent_details.mother_email',
             'parent_details.father_phone', 'parent_details.mother_phone',
             'parent_details.father_occupation', 'parent_details.mother_occupation')
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
        \Carbon\Carbon::parse($employee['hire_date'])->format('jS F Y'),
        $employee['company_name'],
        $employee['job_title'],
        $employee['first_name'] . ' ' . $employee['last_name'],
        'self',
        \Carbon\Carbon::parse($employee['date_of_birth'])->format('jS F Y'),
        $employee['gender'],
        $employee['blood_group'],
        $employee['nationality'],
        ' '
    ];

    // Add the employee's own data row to the rows array
    $rows[] = $selfData;

    // Check if employee exists in employees1
    $emp_id_exists_in_employees1 = $employees1->contains('emp_id', $employee['emp_id']);
    $employee_is_married=EmployeeDetails::where('emp_id', $employee['emp_id'])->where('marital_status','married')->exists();
    $employee_has_children = DB::table('emp_spouse_details')->where('emp_id', $employee['emp_id'])
    ->whereNotNull('children')
    ->where('children', '!=', '[]')
    ->exists();
    if ($emp_id_exists_in_employees1) {
        $parentdetails = ParentDetail::where('emp_id', $employee['emp_id'])->first(); // Use first() instead of get() to get a single record
        if ($parentdetails) {
            // Data row for the parent's details
            $motherData = [
                $employee['emp_id'],
                $employee['first_name'] . ' ' . $employee['last_name'],
                \Carbon\Carbon::parse($employee['hire_date'])->format('jS F Y'),
                $employee['company_name'],
                $employee['job_title'],
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
                \Carbon\Carbon::parse($employee['hire_date'])->format('jS F Y'),
                $employee['company_name'],
                $employee['job_title'],
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
                        \Carbon\Carbon::parse($employee['hire_date'])->format('jS F Y'),
                        $employee['company_name'],
                        $employee['job_title'],
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
                        \Carbon\Carbon::parse( $employee['hire_date'])->format('jS F Y'),
                        $employee['company_name'],
                        $employee['job_title'],
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
                    $child['blood-group'], // Assuming blood group is not available for children
                    $child['nationality'], // Assuming nationality is not available for children
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
                            $child['blood-group'], // Assuming blood group is not available for children
                            $child['nationality'], // Assuming nationality is not available for children
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
    public function searchfilter()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $this->searching = 1;
        
            
    }
    public function render()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $this->employees = EmployeeDetails::where('manager_id', $loggedInEmpId)->get();
        return view('livewire.family-report');
    }
}
