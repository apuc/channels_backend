<?php

namespace App\Notifications;

use App\Models\Channels\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InviteToChannelNotification extends Notification
{
    use Queueable;

    /**
     * @var Channel
     */
    private $channel;

    private $password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Channel $channel,string $password)
    {
        $this->channel = $channel;
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
        return (new MailMessage)
                    ->subject('Channels: Приглашение в канал')
                    ->line('Вас пригласили в канал')
                    ->line("Логин: {$notifiable->email}")
                    ->line("Пароль: {$this->password}")
                    ->action('Присоедениться к каналу', url("http://mychannels.gq/{$this->channel->slug}"));

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
