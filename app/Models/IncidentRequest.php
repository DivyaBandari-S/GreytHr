<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'snow_id',
        'category',
        'emp_id',
        'short_description',
        'description',
        'priority',
        'assigned_dept',
       'file_paths',
       'mime_type','file_name',
        'status_code',
    ];
    public function emp()
    {
        return $this->belongsTo(EmployeeDetails::class, 'emp_id', 'emp_id');
    }

    public function request()
    {
        return $this->belongsTo(Request::class, 'emp_id');// Update the foreign key as necessary
    }
 // HelpDesks Model

public function status()
{
    return $this->belongsTo(StatusType::class, 'status_code', 'status_code');
}


    public function isImage()
    {
        return 'data:image/jpeg;base64,' . base64_encode($this->attributes['file_path']);
    }
    public function getImageUrlsAttribute()
    {
        // Assuming images are stored in the `file_paths` attribute as a JSON array
        return json_decode($this->file_paths, true); // Adjust based on your actual data structure
    }

}
