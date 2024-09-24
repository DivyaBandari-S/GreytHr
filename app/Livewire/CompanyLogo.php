<?php

namespace App\Livewire;

use App\Models\Finance;
use App\Models\Hr;
use App\Models\Admin;
use App\Models\EmployeeDetails;
use App\Models\IT;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CompanyLogo extends Component
{
    public $employee, $it, $hr, $finance, $admin;


    public function render()
    {

        if (auth()->guard('emp')->check()) {
            $employeeId = auth()->guard('emp')->user()->emp_id;

            // Retrieve the employee details including the company_id
            $employeeDetails = DB::table('employee_details')
                ->where('emp_id', $employeeId)
                ->select('company_id') // Select only the company_id
                ->first();
            // Decode the company_id from employee_details
            $companyIds = json_decode($employeeDetails->company_id);

            $needsFlattening = false;
            foreach ($companyIds as $item) {
                if (is_array($item)) {
                    $needsFlattening = true;
                    break;
                }
            }

            if ($needsFlattening) {
                // If there's nesting, flatten the array
                $flattenedArray = array_merge(...$companyIds);
            } else {
                // Otherwise, use the array as-is
                $flattenedArray = $companyIds;
            }
            if ($companyIds) {

                // Now perform the join with companies table
                if (count($flattenedArray) <= 1) {
                    $this->employee = DB::table('companies')
                        ->whereIn('company_id', $companyIds)
                        ->select('companies.company_logo', 'companies.company_name')
                        ->first();
                } else {
                    $this->employee = DB::table('companies')
                        ->whereIn('company_id', $companyIds)
                        ->where('is_parent', 'yes')
                        ->select('companies.company_logo', 'companies.company_name')
                        ->first();
                }
            }
        } elseif (auth()->guard('hr')->check()) {
            $hrId = auth()->guard('hr')->user()->hr_emp_id;
            $this->hr = Hr::join('employee_details', 'hr.emp_id', '=', 'employee_details.emp_id')
                ->join('companies', 'employee_details.company_id', '=', 'companies.company_id')
                ->where('hr.hr_emp_id', $hrId)
                ->select('hr.*', 'companies.company_logo')
                ->first();
        } elseif (auth()->guard('it')->check()) {
            $itId = auth()->guard('it')->user()->it_emp_id;
            $this->it = IT::with('com')
                ->join('companies', 'i_t.company_id', '=', 'companies.company_id')
                ->where('i_t.it_emp_id', $itId)
                ->select('i_t.*', 'companies.company_logo')
                ->first();
        } elseif (auth()->guard('finance')->check()) {
            $financeId = auth()->guard('finance')->user()->fi_emp_id;
            $this->finance = Finance::with('com')
                ->join('companies', 'finance.company_id', '=', 'companies.company_id')
                ->where('finance.fi_emp_id', $financeId)
                ->select('finance.*', 'companies.company_logo')
                ->first();
        } elseif (auth()->guard('admins')->check()) {
            $adminId = auth()->guard('admins')->user()->admin_emp_id;
            $this->admin = Admin::with('com')
                ->join('companies', 'admins.company_id', '=', 'companies.company_id')
                ->where('admins.admin_emp_id', $adminId)
                ->select('admins.*', 'companies.company_logo')
                ->first();
        }

        return view('livewire.company-logo');
    }
}
