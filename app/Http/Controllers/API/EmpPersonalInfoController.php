<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\EmpPersonalInfo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmpPersonalInfoController extends Controller
{
    /**
     * Update authenticated employee's personal information.
     */
    public function update(Request $request)
    {
        try {
            // Get authenticated employee based on JWT token
            $user = Auth::user();
            $empPersonalInfo = EmpPersonalInfo::where('emp_id', $user->emp_id)->first();

            if (!$empPersonalInfo) {
                return ApiResponse::error(
                    self::ERROR_STATUS,
                    'Employee personal info not found!',
                    self::NOT_FOUND
                );
            }

            // Validate input fields (all are optional)
            $validator = Validator::make($request->all(), [
                'title'                  => 'sometimes|string|max:50',
                'first_name'             => 'sometimes|string|max:255',
                'last_name'              => 'sometimes|string|max:255',
                'date_of_birth'          => 'sometimes|date',
                'gender'                 => 'sometimes|in:Male,Female,Other',
                'blood_group'            => 'sometimes|string|max:10',
                'signature'              => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
                'nationality'            => 'sometimes|string|max:100',
                'religion'               => 'sometimes|string|max:100',
                'marital_status'         => 'sometimes|string|max:50',
                'physically_challenge'   => 'sometimes|boolean',
                'mobile_number'          => 'sometimes|string|max:15',
                'alternate_mobile_number' => 'sometimes|string|max:15',
                'city'                   => 'sometimes|string|max:100',
                'state'                  => 'sometimes|string|max:100',
                'postal_code'            => 'sometimes|string|max:10',
                'country'                => 'sometimes|string|max:100',
                'qualification'          => 'sometimes|string|max:255',
                'company_name'           => 'sometimes|string|max:255',
                'designation'            => 'sometimes|string|max:255',
                'experience'             => 'sometimes|string|max:255',
                'present_address'        => 'sometimes|string|max:500',
                'permenant_address'      => 'sometimes|string|max:500',
                'passport_no'            => 'sometimes|string|max:50',
                'pan_no'                 => 'sometimes|string|max:50',
                'adhar_no'               => 'sometimes|string|max:50',
                'pf_no'                  => 'sometimes|string|max:50',
                'nick_name'              => 'sometimes|string|max:100',
                'biography'              => 'sometimes|string|max:1000',
                'facebook'               => 'sometimes|url',
                'twitter'                => 'sometimes|url',
                'linked_in'              => 'sometimes|url',
                'status'                 => 'sometimes|boolean',
                'skill_set'              => 'sometimes|string|max:1000'
            ]);

            if ($validator->fails()) {
                return ApiResponse::error(
                    self::ERROR_STATUS,
                    $validator->errors()->first(),
                    self::VALIDATION_ERROR
                );
            }

            // Update only fields that are provided in the request
            foreach ($request->only(array_keys($validator->getRules())) as $key => $value) {
                if ($request->has($key)) {
                    $empPersonalInfo->$key = $value;
                }
            }

            // Handle image update (Store as Binary in DB)
            if ($request->hasFile('signature')) {
                $imageData = file_get_contents($request->file('signature')->getRealPath()); // Convert image to binary
                $empPersonalInfo->signature = $imageData;
            }

            // Save updated details
            $empPersonalInfo->save();

            return ApiResponse::success(
                self::SUCCESS_STATUS,
                'Personal details updated successfully',
                [
                    'emp_id'         => $empPersonalInfo->emp_id,
                    'first_name'     => $empPersonalInfo->first_name,
                    'last_name'      => $empPersonalInfo->last_name,
                    'date_of_birth'  => $empPersonalInfo->date_of_birth,
                    'gender'         => $empPersonalInfo->gender,
                    'blood_group'    => $empPersonalInfo->blood_group,
                    'signature'      => $empPersonalInfo->signature ? base64_encode($empPersonalInfo->signature) : null,
                    'nationality'    => $empPersonalInfo->nationality,
                    'religion'       => $empPersonalInfo->religion,
                    'marital_status' => $empPersonalInfo->marital_status,
                    'mobile_number'  => $empPersonalInfo->mobile_number,
                    'city'           => $empPersonalInfo->city,
                    'state'          => $empPersonalInfo->state,
                    'postal_code'    => $empPersonalInfo->postal_code,
                    'country'        => $empPersonalInfo->country,
                    'qualification'  => $empPersonalInfo->qualification,
                    'company_name'   => $empPersonalInfo->company_name,
                    'designation'    => $empPersonalInfo->designation,
                    'experience'     => $empPersonalInfo->experience,
                    'nick_name'      => $empPersonalInfo->nick_name,
                    'biography'      => $empPersonalInfo->biography,
                    'facebook'       => $empPersonalInfo->facebook,
                    'twitter'        => $empPersonalInfo->twitter,
                    'linked_in'      => $empPersonalInfo->linked_in,
                    'status'         => $empPersonalInfo->status,
                    'skill_set'      => $empPersonalInfo->skill_set
                ],
                self::SUCCESS
            );
        } catch (Exception $e) {
            return ApiResponse::error(
                self::ERROR_STATUS,
                'An unexpected error occurred. Please try again later.',
                self::SERVER_ERROR
            );
        }
    }
    public function show()
    {
        try {
            // Get authenticated user based on JWT token
            $user = Auth::user();
            $empPersonalInfo = EmpPersonalInfo::where('emp_id', $user->emp_id)->first();
dd($empPersonalInfo );
            if (!$empPersonalInfo) {
                return ApiResponse::error(
                    self::ERROR_STATUS,
                    'Employee personal info not found!',
                    self::NOT_FOUND
                );
            }

            return ApiResponse::success(
                self::SUCCESS_STATUS,
                'Employee personal details retrieved successfully',
                $empPersonalInfo,
                self::SUCCESS
            );
        } catch (Exception $e) {
            return ApiResponse::error(
                self::ERROR_STATUS,
                'An unexpected error occurred. Please try again later.',
                self::SERVER_ERROR
            );
        }
    }
}
