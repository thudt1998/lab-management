<?php

namespace App\Listeners;

use App\Events\SendPassword;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendNewPassword
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
     * @param  SendPassword  $event
     * @return void
     */
    public function handle(SendPassword $event)
    {
        Mail::to($event->email)
            ->send(new \App\Mail\SendMailPassword($event->password));
    }
}
