<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id',
        'emp_id',
        'short_description',
        'issue',
        'priority',
        'assigned_dept',
        'file_path',
        'file_name',
        'mime_type',
        'status_code',
    ];
}
