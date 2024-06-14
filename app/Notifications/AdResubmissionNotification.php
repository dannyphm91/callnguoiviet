<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdResubmissionNotification extends Notification
{
    use Queueable;

    public $user;

    public $ad;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $ad)
    {
        $this->user = $user;
        $this->ad = $ad;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        if (checkSetup('mail')) {
            return ['mail', 'database'];
        } else {
            return ['database'];
        }
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $url = url('/ad/details/'.$this->ad->slug);

        return (new MailMessage())
            ->greeting('Hello '.$this->user->name.' !')
            ->subject('Ad Resubmission')
            ->line('Please, modify the Ad as admin\'s comment and resubmit it.')
            ->action('View Ad', $url)
            ->line('Thank you for using our '.config('app.name').'!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'msg' => 'Ad Resubmission',
            'type' => 'adresubmission',
            'url' => url('/ad/details/'.$this->ad->slug),
        ];
    }
}
