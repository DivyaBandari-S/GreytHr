<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\EmployeeDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeDetailsController extends Controller
{

    public function show()
    {
        // Get the authenticated user
        $user = Auth::user();
        // $employee = EmployeeDetails::where('emp_id', $user->emp_id)->first();

        if (!$user) {
            return ApiResponse::error(
                self::ERROR_STATUS,
                'Employee record not found!',
                self::NOT_FOUND
            );
        }

        return ApiResponse::success(
            self::SUCCESS_STATUS,
            'Employee details retrieved successfully',
            $user,
            self::SUCCESS
        );
    }
    public function getAllEmployeeDetails(Request $request)
    {
        $query = EmployeeDetails::select(
            'emp_id',
            'company_id',
            'dept_id',
            'sub_dept_id',
            'first_name',
            'last_name',
            'gender',
            'email',
            'image',
            'hire_date',
            'employee_type',
            'job_role',
            'manager_id',
            'employee_status',
            'emergency_contact',
            'status',
            'confirmation_date',
            'probation_Period'
        )
            ->with([
                'empDepartment:id,dept_id,department',
                'empSubDepartment:id,sub_dept_id,sub_department',
                'manager:emp_id,first_name,last_name'
            ])
            ->where('status', 1);

        // Apply filters if present
        if ($request->filled('emp_id')) {
            $query->where('emp_id', $request->emp_id);
        }

        if ($request->filled('first_name')) {
            $query->where('first_name', 'like', '%' . $request->first_name . '%');
        }

        if ($request->filled('last_name')) {
            $query->where('last_name', 'like', '%' . $request->last_name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        $employees = $query->orderBy('emp_id', 'desc')->get();

        if ($employees->isEmpty()) {
            return ApiResponse::error(
                self::ERROR_STATUS,
                'No Active Employees found.',
                self::NOT_FOUND
            );
        }

        return ApiResponse::success(
            self::SUCCESS_STATUS,
            'Employee list retrieved successfully.',
            [
                'total_active_employees' => $employees->count(),
                'employees' => $employees,
            ],
            self::SUCCESS
        );
    }
}
