<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpJobRole extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_id',
        'job_title',
        'sub_dept_id',
        'dept_id',
    ];
}
