<?php

namespace App\Listeners\Notifications\NotificationCreated;

use App\Events\Notifications\NotificationCreated;
use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Support\Facades\Log;

class SendNotificationToRabbit
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
     * @param  NotificationCreated  $event
     *
     * @return void
     */
    public function handle(NotificationCreated $event)
    {
        Amqp::publish('notifications_queue', $event->notification , ['queue' => 'notifications_queue']);
        Log::info('Notification sent to rabbit!',['notification'=>unserialize($event->notification)]);
    }
}
