<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class IncidentRequest extends Model
{
    use HasFactory;
    
   
  
    
        protected $fillable = [
            'snow_id',
            'category',
            'emp_id',
            'short_description',
            'description',
            'active_inc_notes',
            'active_ser_notes',
            'inc_assign_to',
            'ser_assign_to',
            'inc_pending_notes',
            'ser_pending_notes',
            'inc_inprogress_notes',
            'ser_inprogress_notes',
            'inc_completed_notes',
            'ser_completed_notes',
            'inc_cancel_notes',
            'ser_cancel_notes',
            'inc_customer_visible_notes',
            'ser_customer_visible_notes',
            'in_progress_since',
            'ser_progress_since',
            'total_in_progress_time',
            'total_ser_progress_time',
            'inc_end_date',
            'ser_end_date',
            'priority',
            'assigned_dept',
            'file_path',
     
            'status_code',
        ];
      

   
        public function getImageUrlAttribute()
        {
            return $this->file_path ? 'data:image/jpeg;base64,' . base64_encode($this->file_path) : null;
        }
     
     
        protected static function booted()
    {
        static::created(function ($incidentRequest) {
            $title = '';
            $message = '';
            $redirect_url = route('incidentRequest.show', ['id' => $incidentRequest->id]);
     
            if ($incidentRequest->category == 'Incident Request') {
                $title = 'New Incident Request Created';
                $message = "An Incident Request has been created with ID: {$incidentRequest->snow_id}";
            } elseif ($incidentRequest->category == 'Service Request') {
                $title = 'New Service Request Created';
                $message = "A Service Request has been created with ID: {$incidentRequest->snow_id}";
            }
     
            // Check if any value is missing, if so, log it
            if (!$title || !$message || !$redirect_url) {
                Log::error('Missing required notification data: title, message or redirect_url');
                return; // Prevent creating a notification if any data is missing
            }
     
            // Create notification
            ticket_notifications::create([
                'title' => $title,
                'message' => $message,
                'redirect_url' => $redirect_url,
                'notifiable_id' => $incidentRequest->id,
                'notifiable_type' => IncidentRequest::class,
            ]);
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
