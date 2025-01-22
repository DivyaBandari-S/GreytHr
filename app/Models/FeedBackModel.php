<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedBackModel extends Model
{
    use HasFactory;
    // Define the table name if it's not the plural form of the model name
    // protected $table = 'feed_back_models';
    // Define the fillable properties
    protected $fillable = [
        'feedback_type',
        'feedback_to',
        'feedback_from',
        'feedback_message',
        'is_draft',
        'is_accepted',
        'status',
        'replay_feedback_message',
        'is_declined',
    ];
    public function feedbackFromEmployee()
    {
        return $this->belongsTo(EmployeeDetails::class, 'feedback_from', 'emp_id');
    }

    public function feedbackToEmployee()
    {
        return $this->belongsTo(EmployeeDetails::class, 'feedback_to', 'emp_id');
    }
}
