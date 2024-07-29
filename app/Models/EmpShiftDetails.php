<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpShiftDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id',
        'shift_type',
        'shift_start_time',
        'shift_end_time',
     ];

    // Assuming emp_id is not auto-incrementing or not an integer ID
    protected $keyType = 'string';

    // Assuming primary key name is not 'id'
    protected $primaryKey = 'emp_id';

    // Relationships
    public function employee()
    {
        return $this->belongsTo(EmployeeDetails::class, 'emp_id');
    }


}
