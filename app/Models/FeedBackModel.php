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
        'emp_id',
        'message',
        'feedback_by',
    ];
}
