<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentVerificationStatusNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $user;

    public $document;

    public function __construct(object $user, object $document)
    {
        $this->user = $user;
        $this->document = $document;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $subject = $this->document->status == 'approved' ? 'Your account has been fully verified!' : 'Your document verification has been rejected.';
        $line = $this->document->status == 'approved' ? 'Congratulations! Your account has been fully verified!' : $this->document->rejected_reason;

        if ($this->document->status == 'rejected') {
            return (new MailMessage)
                ->greeting('Hello '.$this->user->name.' !')
                ->subject($subject)
                ->line('Your document verification has been rejected!')
                ->line('reason : '.$line);
        } else {
            return (new MailMessage)
                ->greeting('Hello '.$this->user->name.' !')
                ->subject($subject)
                ->line($line);
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
