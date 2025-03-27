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
}
