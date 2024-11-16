<?php

namespace App\Traits;

use Carbon\Carbon;

trait ChatHelpers
{
    /**
     * Get the last message for a conversation.
     *
     * @return mixed
     */
    public function getLastMessage()
    {
        if (method_exists($this, 'messages')) {
            return $this->messages()->latest('last_time_message')->first();
        }

        throw new \Exception("Method 'messages' not found in " . get_class($this));
    }

    /**
     * Check if a conversation or message is unread.
     *
     * @return bool
     */
    public function isUnread()
    {
        if (property_exists($this, 'read')) {
            return !$this->read;
        }

        throw new \Exception("Property 'read' not found in " . get_class($this));
    }

    /**
     * Add a member to a conversation.
     *
     * @param \Illuminate\Database\Eloquent\Model $user
     * @return mixed
     */
    public function addMember($user)
    {
        if (method_exists($this, 'members')) {
            return $this->members()->attach($user->id);
        }

        throw new \Exception("Method 'members' not found in " . get_class($this));
    }

    /**
     * Remove a member from a conversation.
     *
     * @param \Illuminate\Database\Eloquent\Model $user
     * @return mixed
     */
    public function removeMember($user)
    {
        if (method_exists($this, 'members')) {
            return $this->members()->detach($user->id);
        }

        throw new \Exception("Method 'members' not found in " . get_class($this));
    }

    /**
     * Mark a message or all messages in a conversation as read.
     *
     * @return void
     */
    public function markAsRead()
    {
        if (method_exists($this, 'messages')) {
            $this->messages()->update(['read' => true]);
        } elseif (property_exists($this, 'read')) {
            $this->update(['read' => true]);
        } else {
            throw new \Exception("Method 'messages' or property 'read' not found in " . get_class($this));
        }
    }

    /**
     * Get all unread messages in a conversation.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUnreadMessages()
    {
        if (method_exists($this, 'messages')) {
            return $this->messages()->where('read', false)->get();
        }

        throw new \Exception("Method 'messages' not found in " . get_class($this));
    }

    /**
     * Check if the user is online.
     *
     * This could be based on the last activity time or a session-based flag.
     *
     * @return bool
     */
    public function isOnline()
    {
        if (property_exists($this, 'last_activity')) {
            // Consider user online if they were active in the last 5 minutes
            return Carbon::parse($this->last_activity)->greaterThan(Carbon::now()->subMinutes(5));
        }

        // Or, if you're using a session variable to track online status:
        // return session('user_is_online') === true;

        // If no property or session-based tracking, return false
        return false;
    }
}
