<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpSubDepartments extends Model
{
    use HasFactory;
    protected $fillable = [
        'sub_dept_id',
        'sub_department',
        'dept_id',
        'created_at',
        'updated_at'
    ];

    // EmpSubDepartment Model
    public function employees()
    {
        return $this->hasMany(EmployeeDetails::class, 'sub_dept_id');
    }
}
