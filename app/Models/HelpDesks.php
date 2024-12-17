<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
 
class HelpDesks extends Model
{
    use HasFactory;
    protected $fillable=[
        'id','emp_id', 'category', 'subject', 'description', 'file_paths','mime_type','file_name', 'cc_to', 'priority','status','mail','mobile','distributor_name','selected_equipment','request_id'
     ];
     protected static function booted()
     {
         static::created(function ($helpDesk) {
             $title = 'Catalog Request'; // Default title
             $message = "Subject : {$helpDesk->category}";
             $redirect_url = route('it.itrequest.show', ['currentCatalogId' => $helpDesk->id]);
  
             // Check if any value is missing, log it if necessary
             if (!$title || !$message || !$redirect_url) {
                 Log::error('Missing required notification data: title, message or redirect_url');
                 return; // Prevent creating a notification if any data is missing
             }
  
             // Create the notification
             ticket_notifications::create([
                 'title' => $title,
                 'message' => $message,
                 'redirect_url' => $redirect_url,
                 'notifiable_id' => $helpDesk->id,
                 'notifiable_type' => HelpDesks::class, // Use the HelpDesks model as the notifiable type
             ]);
         });
     }

    public function emp()
    {
        return $this->belongsTo(EmployeeDetails::class, 'emp_id', 'emp_id');
    }
    public function employee()
    {
        return $this->belongsTo(EmployeeDetails::class, 'emp_id', 'emp_id');
    }

    public function request()
    {
        return $this->belongsTo(Request::class, 'emp_id');// Update the foreign key as necessary
    }
 // HelpDesks Model
 public function incidentRequests()
 {
     return $this->hasMany(IncidentRequest::class, 'incident_id', 'emp_id');
 }
 // In HelpDesks model (HelpDesks.php)
// In HelpDesks model (HelpDesks.php)
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