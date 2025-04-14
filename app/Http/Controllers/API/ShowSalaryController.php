<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\EmpBankDetail;
use App\Models\EmpSalary;
use App\Models\EmpSalaryRevision;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ShowSalaryController extends Controller
{
    //
    public function showSalary(Request $request)
    {
        try {
            // Get authenticated employee
            $user = JWTAuth::parseToken()->authenticate();

            // Get month from request, or use current month as default
            $requestedMonth = $request->input('month', Carbon::now()->format('Y-m'));

            // Validate the month format (YYYY-MM)
            if (!preg_match('/^\d{4}-\d{2}$/', $requestedMonth)) {
                return ApiResponse::error(
                    self::ERROR_STATUS,
                    "Invalid month format. Use 'YYYY-MM'.",
                    self::ERROR
                );
            }

            // Fetch salary details using the provided or default month
            $salaryDetails = EmpSalary::join('salary_revisions', 'emp_salaries.sal_id', '=', 'salary_revisions.id')
               
            ->join('employee_details', 'salary_revisions.emp_id', '=', 'employee_details.emp_id')
            ->leftJoin('emp_departments', 'employee_details.dept_id', '=', 'emp_departments.dept_id')
            ->leftJoin('emp_personal_infos', 'employee_details.emp_id', '=', 'emp_personal_infos.emp_id')
            ->leftJoin('emp_bank_details', 'employee_details.emp_id', '=', 'emp_bank_details.emp_id') 
            ->where('salary_revisions.emp_id', $user->emp_id)
            ->where('emp_salaries.month_of_sal', $requestedMonth)
                ->select('emp_salaries.*', 'salary_revisions.*', 'emp_bank_details.bank_name', // ✅ Bank
                'emp_bank_details.account_number','emp_departments.department' )
                ->first();

            if (!$salaryDetails) {
                return ApiResponse::error(
                    self::ERROR_STATUS,
                    "Salary details not found for the month: $requestedMonth",
                    self::NOT_FOUND
                );
            }

            // Pass encrypted salary to model function
            $salaryComponents = $salaryDetails->calculateSalaryComponents($salaryDetails->salary);

            return ApiResponse::success(
                self::SUCCESS_STATUS,
                "Salary details retrieved successfully",
                [
                    'employee_id' => $user->emp_id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'job_role' => $user->job_role,
                    'hire_date' => $user->hire_date,
                    'job_location' => $user->job_location,
                    'bank_name'=>$salaryDetails->bank_name,
                    'month_of_salary' => $salaryDetails->month_of_sal,
                    'department'=>$salaryDetails->department,
                    'salary_components' => $salaryComponents,
                ],
                self::SUCCESS
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                self::ERROR_STATUS,
                "Something went wrong: " . $e->getMessage(),
                self::SERVER_ERROR
            );
        }
    }
}
