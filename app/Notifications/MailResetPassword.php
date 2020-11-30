<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Mail\UserResetPassword;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MailResetPassword extends Notification
{
    use Queueable;

    protected $password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($password)
    {
        //
        $this->password = $password;
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
        $password = $this->password;
        return (new MailMessage)
                    ->subject('【パスワード再設定のお知らせ】にじさんじランド')
                    ->greeting('こんにちは')
                    ->line('新しいパスワードは')
                    ->line(new HtmlString("<h1 style='text-align:center'>{$password}</h1><br/><br/>"))
                    ->salutation('にじさんじランドをご利用いただきありがとうございます!');
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
