<?php

namespace App\Listeners;

use App\Events\ReminderEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class ReminderEmailSender implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ReminderEvent  $event
     * @return void
     */
    public function handle(ReminderEvent $event)
    {
        $user = $event->user;
        $reminder = $event->reminder;
        $data = [
            'name' => $user->first_name,
            'code' => $reminder->code,
            'id' => $user->id
        ];
        if (view()->exists('emails.reminder')) {
            Mail::queue('emails.reminder', $data, function ($m) use ($user) {
                $m->from('admin@cakning.loc', 'Biogold');
                $m->to($user->email, $user->first_name)->subject($user->first_name.', Permintaan Reset Password Anda - Biogold');
            });
        }
        // Mail::queue('emails.reminder', $data, function($message) use ($data) {
        //     $message->to($data['email'], $data['name'])->subject($data['subject']);
        // });
    }
}
