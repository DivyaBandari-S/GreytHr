<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'hr_emp_id', 'admin_emp_id', 'emp_id', 'category', 'description', 'file_path','manager_id','mime_type','file_name'
    ];

    public function isImage()
    {
        return $this->file_path ? 'data:image/jpeg;base64,' . base64_encode($this->file_path) : null;
    }
// In Post.php model
public function employeeDetails()
{
    return $this->belongsTo(EmployeeDetails::class, 'manager_id', 'emp_id');
}

    public function getImageUrlAttribute()
    {
        return $this->file_path ? 'data:image/jpeg;base64,' . base64_encode($this->file_path) : null;
    }
}
