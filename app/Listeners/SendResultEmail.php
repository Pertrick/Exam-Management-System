<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ResultEmail;
use App\Mail\SendResultMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;


class SendResultEmail
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
     * @param  object  $event
     * @return void
     */
    public function handle(ResultEmail $event)
    {
        $result = $event->result;
        $user = User::findOrFail($result->user->id);
        Mail::to($user)->send(new SendResultMail($user, $event->result));

       
    }
}
