<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\EmployeeDetails;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FeedsController extends Controller
{
    public function getEmployeeFeed()
    {
        try {
            $user = Auth::guard('api')->user();
    
            if (!$user) {
                return ApiResponse::error(self::ERROR_STATUS, 'Unauthorized', self::UNAUTHORIZED);
            }
    
            $company_id = is_array($user->company_id) ? $user->company_id[0] : trim((string) $user->company_id);
            $currentDate = Carbon::now(); // Current date
            $startDate = Carbon::create($currentDate->year, 1, 1); // Start from January 1st
    
            // Fetch active employees with hire_date and personal info (date_of_birth)
            $employees = EmployeeDetails::whereJsonContains('company_id', $company_id)
                ->whereNotIn('employee_status', ['terminated', 'resigned']) // Exclude inactive employees
                ->leftJoin('emp_personal_infos', 'employee_details.emp_id', '=', 'emp_personal_infos.emp_id')
                ->select(
                    'employee_details.emp_id',
                   
                    'employee_details.first_name',
                    'employee_details.last_name',
                    'employee_details.hire_date',
             
                    'emp_personal_infos.date_of_birth'
                )
                ->get();
    
            // Process and sort employee feed data
            $feedData = $this->combineAndSortData($employees, $startDate, $currentDate);
    
            return ApiResponse::success(self::SUCCESS_STATUS, "Employee Feed Data Retrieved", $feedData);
        } catch (\Exception $e) {
            Log::error('Error fetching employee feed data: ' . $e->getMessage());
            return ApiResponse::error(self::ERROR_STATUS, 'Something went wrong', self::SERVER_ERROR);
        }
    }
   
    private function combineAndSortData($employees, $startDate, $currentDate)
    {
        $combinedData = [];
    
        foreach ($employees as $employee) {
            if (in_array($employee->employee_status, ['terminated', 'resigned'])) {
                continue;  // Skip inactive employees
            }
    
            // Process date_of_birth from emp_personal_infos
            if (!empty($employee->date_of_birth)) {
                $dateOfBirth = Carbon::parse($employee->date_of_birth);
                $formattedDate = $dateOfBirth->format('m-d'); // Extract MM-DD only
                $humanReadableTime = $dateOfBirth->copy()->year($currentDate->year)->diffForHumans(); // Human-readable time
    
                // Include birthdays from January 1st up to today’s date
                if ($formattedDate >= $startDate->format('m-d') && $formattedDate <= $currentDate->format('m-d')) {
                    $combinedData[] = [
                        'date' => $formattedDate,
                        'type' => 'date_of_birth',
                        'time' => $humanReadableTime, // Human-readable time
                        'message' => "🎂 Happy Birthday {$employee->first_name} {$employee->last_name}! Have a fantastic year ahead! 🎉",
                        'employee' => [
                            'emp_id' => $employee->emp_id,
                            'name' => "{$employee->first_name} {$employee->last_name}",
                            'date_of_birth' => $employee->date_of_birth,
                        ]
                    ];
                }
            }
    
            // Process hire_date from employee_details
            if (!empty($employee->hire_date)) {
                $hireDate = Carbon::parse($employee->hire_date);
                $formattedDate = $hireDate->format('m-d'); // Extract MM-DD only
                $humanReadableTime = $hireDate->copy()->year($currentDate->year)->diffForHumans(); // Human-readable time
    
                // Include work anniversaries from January 1st up to today’s date
                if ($formattedDate >= $startDate->format('m-d') && $formattedDate <= $currentDate->format('m-d')) {
                    $yearsCompleted = $hireDate->diffInYears(Carbon::today());
    
                    $combinedData[] = [
                        'date' => $formattedDate,
                        'type' => 'hire_date',
                        'time' => $humanReadableTime, // Human-readable time
                        'message' => "🎊 Congratulations {$employee->first_name} {$employee->last_name} on completing $yearsCompleted years with us! 🚀",
                        'employee' => [
                            'emp_id' => $employee->emp_id,
                            'name' => "{$employee->first_name} {$employee->last_name}",
                            'hire_date' => $employee->hire_date,
                        ]
                    ];
                }
            }
        }
    
        // Sort by MM-DD in descending order (latest first)
        usort($combinedData, function ($a, $b) {
            return strcmp($b['date'], $a['date']); // String comparison for MM-DD format
        });
    
        return $combinedData;
    }
    
}
