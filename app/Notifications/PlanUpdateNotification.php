<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class PlanUpdateNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $user;

    public $plan;

    public $plan_status;

    public function __construct($user, $plan, $plan_status)
    {
        $this->user = $user;
        $this->plan = $plan;
        $this->plan_status = $plan_status;
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
        $badge = $this->plan->badge ? 'Yes' : 'No';

        return (new MailMessage)
            ->subject('Your plan has been successfully '.$this->plan_status)
            ->greeting('Hello '.$this->user->name.' !')
            ->line(new HtmlString("<h2>Your plan has been successfully $this->plan_status ! </h2>"))
            ->line('Thank you for choosing our classified ad listing website and purchasing one of our plans. We appreciate your trust in our platform and are excited to provide you with an exceptional experience. In this email, we would like to provide you with important information about your newly purchased plan.')
            ->line(new HtmlString(
                'Plan Name : '.$this->plan->label.'<br>
                 Ads Limit : '.$this->plan->ad_limit.'<br>
                 Featured Ads Limit : '.$this->plan->featured_limit.'<br>
                 Special Badge : '.$badge
            ));
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
