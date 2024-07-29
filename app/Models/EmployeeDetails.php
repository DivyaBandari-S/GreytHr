<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\LeaveRequest;
use App\Models\SwipeRecord;
use App\Models\Chating;

class EmployeeDetails extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasFactory;
    protected $primaryKey = 'emp_id';
    public $incrementing = false;
    protected $fillable = [
        'emp_id',
        'company_id',
        'department_id',
        'sub_department_id',
        'first_name',
        'last_name',
        'email',
        'hire_date',
        'employee_type',
        'job_role',
        'manager_id',
        'report_to',
        'employee_status',
        'emergency_contact',
        'password',
        'inter_emp',
        'job_location',
        'is_starred',
        'status',
        'skill_set',
        'job_mode',
        'resignation_date',
        'resignation_reason',
        'notice_period',
        'extension'
    ];
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'emp_id');
    }
    public function leaveApplies()
    {
        return $this->hasMany(LeaveRequest::class, 'emp_id', 'emp_id');
    }
    public function swipeRecords()
    {
        return $this->hasMany(SwipeRecord::class, 'emp_id', 'emp_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'emp_id', 'emp_id');
    }
    public function canCreatePost()
    {

        return $this->emp_id === 'emp_id'  || $this->hasPermission('create-post');

    }

    // Inside the EmployeeDetails model
    public function starredPeople()
    {
        return $this->hasMany(StarredPeople::class, 'emp_id', 'emp_id');
    }

    public function conversations()
    {

        return $this->hasMany(Chating::class,'sender_id')->orWhere('receiver_id',$this->emp_id)->whereNotDeleted();

    }
}
