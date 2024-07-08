<?php

namespace App\Livewire;

use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelWriter;

class FamilyReport extends Component
{
    public $employees;

    public $searching = 0;



    public function downloadInExcel()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $employees1 = EmployeeDetails::where('manager_id', $loggedInEmpId)
            ->join('parent_details', 'employee_details.emp_id', '=', 'parent_details.emp_id')
            ->select('employee_details.*', 'parent_details.*')
            ->get();
        $data = [
            ['List of Family Details of Employees'],
            ['Employee ID', 'Name', 'Father Name',    'Mother Name',    'Father Date Of Birth',    'Mother Date Of Birth',    'Father Address', 'Mother Address',    'Father Email', 'Mother Email', 'Father Phone', 'Mother Phone', 'Father Occupation',    'Mother Occupation'],

        ];
        foreach ($employees1 as $employee) {
            $data[] = [$employee['emp_id'], $employee['first_name'] . ' ' . $employee['last_name'], $employee['father_first_name'] . ' ' . $employee['father_last_name'], $employee['mother_first_name'] . ' ' . $employee['mother_last_name'], $employee['father_dob'], $employee['mother_dob'], $employee['father_address'], $employee['mother_address'], $employee['father_email'], $employee['mother_email'], $employee['father_phone'], $employee['mother_phone'], $employee['father_occupation'], $employee['mother_occupation']];
        }
        $filePath = storage_path('app/family_reports.xlsx');
        SimpleExcelWriter::create($filePath)->addRows($data);
        return response()->download($filePath, 'family_reports.xlsx');
    }
    public function searchfilter()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $this->searching = 1;
        $this->employees = EmployeeDetails::where('manager_id', $loggedInEmpId)
            ->join('parent_details', 'employee_details.emp_id', '=', 'parent_details.emp_id')
            ->select('employee_details.*', 'parent_details.*')
            ->get();
    }
    public function render()
    {
        $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
        $this->employees = EmployeeDetails::where('manager_id', $loggedInEmpId)
            ->join('parent_details', 'employee_details.emp_id', '=', 'parent_details.emp_id')
            ->select('employee_details.*', 'parent_details.*')
            ->get();
        return view('livewire.family-report');
    }
}
