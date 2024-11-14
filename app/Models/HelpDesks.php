<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HelpDesks extends Model
{
    use HasFactory;
    protected $fillable = [
        'emp_id', 'category', 'mail', 'distributor_name', 'mobile', 'subject',
        'description', 'active_comment', 'inprogress_remarks', 'rejection_reason',
        'assign_to', 'file_path', 'file_name', 'mime_type', 'cc_to', 'status',
        'selected_equipment', 'priority', 'request_id'
    ];

    // Generate request ID when creating a new help desk entry
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate the Request ID
            $latestRequest = DB::table('help_desks')->latest('id')->first();
            $nextRequestId = $latestRequest ? intval(substr($latestRequest->request_id, 3)) + 1 : 1000;
            $model->request_id = 'REQ-' . str_pad($nextRequestId, 7, '0', STR_PAD_LEFT);
        });
    }
    public function emp()
    {
        return $this->belongsTo(EmployeeDetails::class, 'emp_id', 'emp_id');
    }
    public function request()
    {
        return $this->belongsTo(Request::class, 'emp_id');// Update the foreign key as necessary
    }

    public function isImage()
    {
        return 'data:image/jpeg;base64,' . base64_encode($this->attributes['file_path']);
    }
    public function getImageUrlAttribute()
    {
        return $this->file_path ? 'data:image/jpeg;base64,' . base64_encode($this->file_path) : null;
    }


}
