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
                'emp_id'   => 'nullable|string',
                'email'    => 'nullable|email',
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
     * Get the authenticated User
     */
    public function empDetails()
    {
        $user = Auth::guard('api')->user();
        return ApiResponse::success(self::SUCCESS_STATUS, self::SUCCESS_MESSAGE, $user);
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
                'emp_id'      => $employeeDetails->emp_id,
                'email'       => $employeeDetails->email,
                'first_name'  => $employeeDetails->first_name,
                'last_name'   => $employeeDetails->last_name,
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
            // Get the authenticated user
            $user = Auth::guard('api')->user();

            if (!$user) {
                return ApiResponse::error(self::ERROR_STATUS, 'Unauthorized', self::UNAUTHORIZED);
            }

            // Get the current token
            $token = Auth::guard('api')->getToken();

            if (!$token) {
                return ApiResponse::error(self::ERROR_STATUS, 'Token not found', self::ERROR);
            }

            // Invalidate the token
            Auth::guard('api')->invalidate($token);
            auth()->logout(true);
            auth()->invalidate(true);
            // Revoke all tokens (if using multiple token systems like OAuth or personal access tokens)
            // JWTAuth::parseToken()->invalidate(true); // Forcefully revoke and blacklist the token
            // JWTAuth::invalidate(JWTAuth::parseToken());
            JWTAuth::invalidate(JWTAuth::getToken());
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
}
