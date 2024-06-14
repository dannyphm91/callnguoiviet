<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdResubmissionAdminNotification extends Notification
{
    use Queueable;

    public $admin;

    public $ad;

    /**
     * Create a new notification instance.
     */
    public function __construct($admin, $ad)
    {
        $this->admin = $admin;
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
    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/ad/details/'.$this->ad->slug);

        return (new MailMessage())
            ->greeting('Hello '.$this->admin->name.' !')
            ->subject('Ad Resubmission')
            ->line('Please,Check this ad resubmitted by the user .')
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
