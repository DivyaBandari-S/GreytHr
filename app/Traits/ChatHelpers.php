<?php

namespace App\Traits;

use App\Models\EmployeeDetails;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ChatHelpers
{
    /**
     * Check if the user is online based on their last activity timestamp.
     *
     * @return bool
     */
    public function isOnline()
    {
        if (property_exists($this, 'last_activity')) {
            return Carbon::parse($this->last_activity)->greaterThan(Carbon::now()->subMinutes(5));
        }

        return false;
    }

    public function unreadMessagesCount($userId)
    {
        return $this->messages()
            ->where(function ($query) use ($userId) {
                $query->where('receiver_id', $userId) // Messages sent to the user
                      ->orWhere('receiver_id', auth()->id()); // Include auth user as receiver
            })
            ->where('read', false) // Only unread messages
            ->count();
    }

    /**
     * Define the 'messages' relationship, assuming it's a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'receiver_id', 'emp_id');
    }

    public function sender()
    {
        return $this->belongsTo(EmployeeDetails::class, 'sender_id', 'emp_id');
    }

    public function receiver()
    {
        return $this->belongsTo(EmployeeDetails::class, 'receiver_id', 'emp_id');
    }
}
