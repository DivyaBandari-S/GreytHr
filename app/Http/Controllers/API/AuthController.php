<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Log;
use App\Helpers\ApiResponse;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login User and return a JWT token
     */
    public function login(Request $request)
    {
        try {
            Log::info('Login request received.', $request->all());

            // Validate input fields
            $validator = Validator::make($request->all(), [
                'emp_id'   => 'nullable|string|required_without:email',
                'email'    => 'nullable|email|required_without:emp_id',
                'password' => 'required|string|min:6',
            ]);


            if ($validator->fails()) {
                return ApiResponse::error(self::ERROR_STATUS, $validator->errors()->first(), self::ERROR);
            }

            // Ensure at least one of emp_id or email is provided
            if (!$request->filled('emp_id') && !$request->filled('email')) {
                return ApiResponse::error(self::ERROR_STATUS, self::LOGIN_REQUIRED, self::ERROR);
            }

            // Perform a single query to find the user by either emp_id or email
            $user = EmployeeDetails::where(function ($query) use ($request) {
                if ($request->filled('emp_id')) {
                    $query->where('emp_id', $request->emp_id);
                }
                if ($request->filled('email')) {
                    $query->orWhere('email', $request->email);
                }
            })->first();

            // If user not found, return error
            if (!$user) {
                return ApiResponse::error(self::ERROR_STATUS, self::USER_NOT_FOUND, self::NOT_FOUND);
            }

            // Check if the user is active
            if ($user->status != 1) {
                return ApiResponse::error(self::ERROR_STATUS, self::INACTIVE_USER, self::FORBIDDEN);
            }

            // Prepare authentication credentials
            $credentials = ['password' => $request->password];
            if ($request->filled('emp_id')) {
                $credentials['emp_id'] = $request->emp_id;
            } else {
                $credentials['email'] = $request->email;
            }

            // Attempt login
            if (!$token = auth('api')->attempt($credentials)) {
                return ApiResponse::error(self::ERROR_STATUS, self::INVALID_CREDENTIALS, self::UNAUTHORIZED);
            }

            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return ApiResponse::error(self::ERROR_STATUS, self::INTERNAL_SERVER_ERROR, self::SERVER_ERROR);
        }
    }




    /**
     * Get Employee Details
     */
    public function getEmployeeDetails(Request $request)
    {
        try {
            // Get the authenticated user from the token
            $user = Auth::guard('api')->user();

            if (!$user) {
                return ApiResponse::error(self::ERROR_STATUS, 'Unauthorized', self::UNAUTHORIZED);
            }

            // Fetch only the logged-in employee's details
            $employeeDetails = EmployeeDetails::where('emp_id', $user->emp_id)->first();

            if (!$employeeDetails) {
                return ApiResponse::error(self::ERROR_STATUS, 'Employee details not found', self::NOT_FOUND);
            }

            return ApiResponse::success(self::SUCCESS_STATUS, self::SUCCESS_MESSAGE, [
                'employee' => $employeeDetails,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching employee details: ' . $e->getMessage());
            return ApiResponse::error(self::ERROR_STATUS, self::INTERNAL_SERVER_ERROR, self::SERVER_ERROR);
        }
    }

    /**
     * Log the user out (Invalidate the token)
     */
    public function logout(Request $request)
    {
        try {
            Auth::guard('api')->logout();
            return ApiResponse::success(self::SUCCESS_STATUS, self::USER_LOGGED_OUT);
        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());
            return ApiResponse::error(self::ERROR_STATUS, 'Could not log out', self::SERVER_ERROR);
        }
    }



    /**
     * Refresh a token.
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    /**
     * Return token response
     */
    protected function respondWithToken($token, $user = null)
    {
        return ApiResponse::success(self::SUCCESS_STATUS, self::SUCCESS_MESSAGE, [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => Auth::guard('api')->factory()->getTTL() * 60,
            'user'         => $user,
        ]);
    }


    public function resetPassword(Request $request)
    {
        $user = Auth::guard('api')->user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]+$/',
                'confirmed'
            ],

        ], [
            'new_password.regex' => 'Password must be at least 8 characters and include at least one uppercase letter, one lowercase letter, one number, and one special character.',

        ]);

        if ($validator->fails()) {
            return ApiResponse::error(
                self::ERROR_STATUS,
                $validator->errors()->first(),
                self::VALIDATION_ERROR
            );
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return ApiResponse::error(
                self::ERROR_STATUS,
                'Current password is incorrect.',
                self::FORBIDDEN
            );
        }
        // Prevent reusing current password
        if (Hash::check($request->new_password, $user->password)) {
            return ApiResponse::error(
                self::ERROR_STATUS,
                'New password cannot be the same as your current password.',
                self::VALIDATION_ERROR
            );
        }

        // Get company name safely
        $company = Company::where('company_id', $user->company_id)->first();
        $companyName = $company ? $company->company_name : 'Your Company';

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Send email notification
        if (!empty($user->email)) {
            $user->notify(new \App\Notifications\PasswordChangedNotification($companyName));
        }

        return ApiResponse::success(
            self::SUCCESS_STATUS,
            'Password updated successfully.'
        );
    }
}
