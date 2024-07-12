<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Hr extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    protected $primaryKey = 'hr_emp_id';
    public $incrementing = false;
    protected $table = 'hr';

    protected $fillable = [
        'hr_emp_id','image','emp_id',
        'company_id', 'employee_name', 'position', 'department',
        'email', 'company_email','phone_number', 'emergency_contact_number',
        'date_of_birth', 'address', 'nationality', 'marital_status', 'gender',
        'password','tax_id', 'salary', 'joining_date', 'is_active'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'joining_date' => 'date',
        'is_active' => 'boolean',
    ];
    public function employeeDetails()
    {
        return $this->belongsTo(EmployeeDetails::class, 'emp_id', 'emp_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'hr_emp_id', 'emp_id');
    }

    public function com()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }
}
