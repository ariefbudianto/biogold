<?php

namespace App\Events;

use App\Events\Event;
use Cartalyst\Sentinel\Reminders\EloquentReminder as Reminder;
use Illuminate\Queue\SerializesModels;
use App\User;

class ReminderEvent extends Event
{
    use SerializesModels;
    
    public $user;

    public $reminder;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Reminder $reminder)
    {
        $this->user = $user;
        $this->reminder = $reminder;
    }
}
