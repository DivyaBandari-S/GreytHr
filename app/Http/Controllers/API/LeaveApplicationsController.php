<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Livewire\LeaveBalances;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LeaveApplicationsController extends Controller
{
    //get balance for selected leave type
    public function getBalanceBySelectingLeaveType(Request $request)
    {
        try {
            $leave_type = $request->input('leave_type');
            $from_date = $request->input('from_date');
            $to_date = $request->input('to_date');
            $selectedYear = Carbon::now()->format('Y');
            if ($from_date && $to_date) {
                $fromYear = Carbon::parse($from_date)->format('Y');
                $toYear = Carbon::parse($to_date)->format('Y');
                // If both from and to dates belong to the same year, use that year
                // Otherwise, use the current year or the year from 'from_date' as fallback
                $selectedYear = ($fromYear === $toYear) ? $fromYear : Carbon::now()->format('Y');
            } else {
                // Fallback to the current year if no dates are set
                $selectedYear = Carbon::now()->format('Y');
            }
            $employeeId = auth()->guard('emp')->user()->emp_id;
            // Retrieve all leave balances
            $allLeaveBalances = LeaveBalances::getLeaveBalances($employeeId, $selectedYear);
            $leaveBalances = [];
            switch ($leave_type) {
                case 'Casual Leave Probation':
                    $leaveBalances = [
                        'casualProbationLeaveBalance' => $allLeaveBalances['casualProbationLeaveBalance'] ?? '0'
                    ];
                    break;
                case 'Casual Leave':
                    $leaveBalances = [
                        'casualLeaveBalance' => $allLeaveBalances['casualLeaveBalance'] ?? '0'
                    ];
                    break;
                case 'Loss of Pay':
                    $leaveBalances = [
                        'lossOfPayBalance' => $allLeaveBalances['lossOfPayBalance'] ?? '0'
                    ];
                    break;
                case 'Sick Leave':
                    $leaveBalances = [
                        'sickLeaveBalance' => $allLeaveBalances['sickLeaveBalance'] ?? '0'
                    ];
                    break;
                case 'Maternity Leave':
                    $leaveBalances = [
                        'maternityLeaveBalance' => $allLeaveBalances['maternityLeaveBalance'] ?? '0'
                    ];
                    break;
                case 'Paternity Leave':
                    $leaveBalances = [
                        'paternityLeaveBalance' => $allLeaveBalances['paternityLeaveBalance'] ?? '0'
                    ];
                    break;
                case 'Marriage Leave':
                    $leaveBalances = [
                        'marriageLeaveBalance' => $allLeaveBalances['marriageLeaveBalance'] ?? '0'
                    ];
                    break;
                case 'Earned Leave':
                    $leaveBalances = [
                        'earnedLeaveBalance' => $allLeaveBalances['earnedLeaveBalance'] ?? '0'
                    ];
                    break;
                default:
                    break;
            }
            return ApiResponse::success(self::SUCCESS_STATUS, self::SUCCESS_MESSAGE, [
                'leaveBalances' => $leaveBalances,
                'selectedYear' => $selectedYear,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching employee details: ' . $e->getMessage());
            return ApiResponse::error(self::ERROR_STATUS, self::INTERNAL_SERVER_ERROR, self::SERVER_ERROR);
        }
    }

    //get total count of approval leave days
    public function getApprovedLeaveDays(Request $request)
    {
        try {
            $employeeId = $request->input('employee_id');
            $selectedYear = $request->input('selected_year');
            $selectedYear = (int) $selectedYear;
            $approvedLeaveRequests = LeaveRequest::where('emp_id', $employeeId)
                ->where('category_type', 'Leave')
                ->where(function ($query) {
                    $query->where('leave_status', 2)
                        ->whereIn('cancel_status', [6, 5, 3, 4]);
                })
                ->whereIn('leave_type', [
                    'Casual Leave Probation',
                    'Loss Of Pay',
                    'Sick Leave',
                    'Casual Leave',
                    'Maternity Leave',
                    'Marriage Leave',
                    'Paternity Leave',
                    'Earned Leave'
                ])
                ->whereYear('to_date', '=', $selectedYear)
                ->get();
            return ApiResponse::success(self::SUCCESS_STATUS, self::SUCCESS_MESSAGE, [
                'approvedLeaveRequests' => $approvedLeaveRequests,
            ]);
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return ApiResponse::error(self::ERROR_STATUS, self::INTERNAL_SERVER_ERROR, self::SERVER_ERROR);
        }
    }
}
