<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'incident_id',
        'emp_id',
        'short_description',
        'description',
        'priority',
        'assigned_dept',
        'file_path',
        'file_name',
        'mime_type',
        'status_code',
    ];
}
