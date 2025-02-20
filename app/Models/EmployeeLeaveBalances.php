<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class EmployeeLeaveBalances extends Model
{
    use HasFactory;

    // Fields that can be mass-assigned
    protected $fillable = [
        'emp_id',
        'leave_scheme',
        'period',
        'status',
        'periodicity',
        'leave_policy_id'
    ];

    protected static function boot()
    {
        parent::boot();
    }
    /**
     * Get the employee associated with the leave balance.
     */
    public function employee()
    {
        return $this->belongsTo(EmployeeDetails::class, 'emp_id', 'emp_id');
    }

    /**
     * Get the leave balance for a given year, leave type, and employee.
     *
     * @param string $employeeId
     * @param string $leaveName
     * @param int $year
     * @return int
     */
    public static function getLeaveBalancePerYear($employeeId, $leaveName, $year)
    {
        // Retrieve all records for the specific employee and year
        $balances = self::where('emp_id', $employeeId)
            ->where('period', 'like', "%$year%")
            ->get();
        // Loop through each balance record
        foreach ($balances as $balance) {
            // Decode the JSON leave_policy_id column
            $leavePolicies = is_string($balance->leave_policy_id) ? json_decode($balance->leave_policy_id, true) : $balance->leave_policy_id;

            if (is_array($leavePolicies)) {
                foreach ($leavePolicies as $policy) {
                    // Check if the leave_name matches the specified leave name
                    if (isset($policy['leave_name']) && $policy['leave_name'] == $leaveName) {
                        // Return the grant_days for the specified leave_name
                        return $policy['grant_days'];
                    }
                }
            }
        }
        // Return 0 if the leave type is not found in any of the records
        return 0;
    }

    public static function getOpeningLeaveBalancePerYear($employeeId, $leaveName, $year)
    {
        try {
            // Retrieve all records with the given employee ID and 'opening balance' status
            $openbalances = self::where('emp_id', $employeeId)
                ->where('granted_for_year', '!=', $year)
                ->where('status', 'opening balance')
                ->get();

            // Loop through each balance record
            foreach ($openbalances as $balance) {
                // Decode the JSON leave_policy_id column if it's a string
                $leavePolicies = is_string($balance->leave_policy_id)
                    ? json_decode($balance->leave_policy_id, true)
                    : $balance->leave_policy_id;

                if (is_array($leavePolicies)) {
                    foreach ($leavePolicies as $policy) {
                        // Check if the leave_name matches the specified leave name
                        if (isset($policy['leave_name']) && $policy['leave_name'] == $leaveName) {
                            // Return the grant_days for the specified leave_name
                            return $policy['grant_days'];
                        }
                    }
                }
            }

            // If the leave type is not found, return 0
            return 0;
        } catch (\Exception $e) {
            // Handle the exception and log the error message
            // You can log the error or show a message depending on your requirements
            Log::error('Error fetching opening leave balance: ' . $e->getMessage());

            // Optionally, you can throw the exception again or return a default value
            return 0; // or you can choose to rethrow the exception: throw $e;
        }
    }
}
