<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class PlanExpiredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public $user, public $plan, public $expired_date)
    {
        //
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
        return (new MailMessage)
            ->subject('Expiry of Your Classified Ad Listing Plan')
            ->greeting('Hello '.$this->user->name.' !')
            ->line(new HtmlString('<h2>Expiry of Your Classified Ad Listing Plan! </h2>'))
            ->line('We hope this email finds you well. We wanted to inform you that your classified ad listing plan has expired. We appreciate your previous subscription and the trust you placed in our platform. In this email, we would like to provide you with important information regarding the expiration of your plan.')
            ->line(new HtmlString(
                'Plan Name : '.$this->plan->label.'<br>
                 Ads Limit : '.$this->plan->ad_limit.'<br>
                 Featured Ads Limit : '.$this->plan->featured_limit.'<br>
                 Expired Date : '.Carbon::parse($this->expired_date)->format('M d, Y')
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
