<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpResignations extends Model
{
    use HasFactory;
    protected $table  =  'emp_resignations';
    protected $fillable = [
        'emp_id',
        'reason',
        'resignation_date',
        'action_date',
        'action_by',
        'last_working_day',
        'comments',
        'signature',
        'mime_type',
        'file_name',
        'status'
    ];
    public function employee()
    {
        return $this->belongsTo(EmployeeDetails::class, 'emp_id', 'emp_id');
    }
}
