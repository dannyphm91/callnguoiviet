<?php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSent;

class LogSentMessage
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
    public function handle(MessageSent $event)
    {
        $message = $event->message;

        // The Swift_Message has a __toString method so you should be able to log it ;)
        info($message->toString());
    }
}
