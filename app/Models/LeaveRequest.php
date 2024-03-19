<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmployeeDetails;


class LeaveRequest extends Model
{
    use HasFactory;
    protected $table = 'leave_applications';
    protected $fillable = [
        'emp_id',
        'leave_type',
        'from_date',
        'from_session',
        'to_session',
        'to_date',
        'applying_to',
        'cc_to',
        'contact_details',
        'reason',  
        'file_paths'
        // Add other fields that you want to be fillable here
    ];
  

    public function employee()
    {
        return $this->belongsTo(EmployeeDetails::class, 'emp_id', 'emp_id');
    }

   // LeaveRequest.php

    public function employeeDetails()
    {
        return $this->belongsTo(EmployeeDetails::class, 'emp_id'); // Assuming employee_id is the foreign key
    }

}
