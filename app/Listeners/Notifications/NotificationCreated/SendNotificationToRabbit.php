<?php

namespace App\Listeners\Notifications\NotificationCreated;

use App\Events\Notifications\NotificationCreated;
use App\Models\Channels\Notification;
use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Support\Facades\Log;

class SendNotificationToRabbit
{
    /**
     * Handle the event.
     *
     * @param  NotificationCreated  $event
     *
     * @return void
     */
    public function handle(NotificationCreated $event)
    {
        Amqp::publish(Notification::RABBIT_QUEUE_NAME,serialize($event->notification),['queue' => 'notifications_queue']);
        Log::info('Notification sent to rabbit',['notification'=>$event->notification]);
    }
}
