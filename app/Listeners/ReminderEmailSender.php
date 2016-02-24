<?php

namespace App\Listeners;

use App\Events\ReminderEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class ReminderEmailSender implements ShouldQueue
{
    public function handle(ReminderEvent $event)
    {
        $user = $event->user;
        $reminder = $event->reminder;
        $data = [
            'from_email'    => env('MAIL_USERNAME'),
            'from_name'     => env('APP_NAME'),
            'name'          => $user->first_name,
            'email'         => $user->email,
            'code'          => $reminder->code,
            'id'            => $user->id
        ];
        if (view()->exists('emails.reminder')) {
            Mail::send('emails.reminder', $data, function ($m) use ($data) {
                $m->from($data['from_email'], $data['from_name']);
                $m->to($data['email'], $data['name'])->subject($data['name'].', Permintaan Reset Password Anda - Biogold');
            });
        }
        // Mail::queue('emails.reminder', $data, function($message) use ($data) {
        //     $message->to($data['email'], $data['name'])->subject($data['subject']);
        // });
    }
}
