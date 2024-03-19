<?php

namespace App\Livewire;

use App\Models\Finance;
use App\Models\Hr;
use App\Models\Admin;
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
            $this->employee = DB::table('employee_details')
                ->join('companies', 'employee_details.company_id', '=', 'companies.company_id')
                ->where('employee_details.emp_id', $employeeId)
                ->select('companies.company_logo')
                ->first();
        } elseif (auth()->guard('hr')->check()) {
            $hrId = auth()->guard('hr')->user()->hr_emp_id;
            $this->hr = Hr::with('com')
                ->join('companies', 'hr.company_id', '=', 'companies.company_id')
                ->where('hr.hr_emp_id', $hrId)
                ->select('hr.*', 'companies.company_logo')
                ->first();
        } elseif (auth()->guard('it')->check()) {
            $itId = auth()->guard('it')->user()->it_emp_id;
            $this->it = IT::with('com')
                ->join('companies', 'i_t.company_id', '=', 'companies.company_id')
                ->where('i_t.it_emp_id', $itId)
                ->select('i_t.*','companies.company_logo')
                ->first();
        } elseif (auth()->guard('finance')->check()) {
            $financeId = auth()->guard('finance')->user()->fi_emp_id;
            $this->finance = Finance::with('com')
                ->join('companies', 'finance.company_id', '=', 'companies.company_id')
                ->where('finance.fi_emp_id', $financeId)
                ->select('finance.*','companies.company_logo')
                ->first();
        }
        elseif (auth()->guard('admins')->check()) {
            $adminId = auth()->guard('admins')->user()->admin_emp_id;
            $this->admin = Admin::with('com')
                ->join('companies', 'admins.company_id', '=', 'companies.company_id')
                ->where('admins.admin_emp_id', $adminId)
                ->select('admins.*','companies.company_logo')
                ->first();
        }

        return view('livewire.company-logo');
    }
}
