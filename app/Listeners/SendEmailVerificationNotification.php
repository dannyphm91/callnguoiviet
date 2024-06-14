<?php

namespace App\Listeners;

use Illuminate\Contracts\Auth\MustVerifyEmail;

class SendEmailVerificationNotification
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
    public function handle($event)
    {
        if (setting('customer_email_verification')) {

            if ($event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail()) {
                $event->user->sendEmailVerificationNotification();
            }
        }
    }
}
