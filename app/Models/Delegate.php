<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Delegate extends Model
{   use HasFactory;

    protected $fillable = ['emp_id', 'workflow', 'from_date', 'to_date', 'delegate','status'];

    public function emp()
    {
        return $this->belongsTo(EmployeeDetails::class, 'emp_id', 'emp_id');
    }

    public static function getEmployeeName($empId)
    {

        $employee = DB::table('employee_details')->where('emp_id', $empId)->first(['first_name', 'last_name']);

        if ($employee) {
            return ucwords($employee->first_name) . ' ' . ucwords($employee->last_name).' '.'#'.$empId;
        }


        return 'Unknown Employee'; // Default value if no record is found
    }

}
