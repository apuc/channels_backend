<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordReset extends Notification
{
    use Queueable;

    private $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $token)
    {
        $this->token = $token;
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
        $url = env('FRONTEND_URL','https://mychannels.gq/');

        return (new MailMessage)
                    ->from('channels@web-artcraft.com')
                    ->subject('Channels password reset')
                    ->greeting("Уважаемый {$notifiable->username}")
                    ->line("Вы сделали запрос на восстановление пароля на сайте {$url} Чтобы восстановить пароль, пройдите по ссылке ниже")
                    ->action('Восстановить пароль', url($url."password/reset/".$this->token))
                    ->line('Если вы не делали запрос на восстановление пароля,то просто удалите данное письмо');
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
