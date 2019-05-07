<?php

namespace App\Console\Commands\Notifications;

use App\Models\Channels\Notification;
use App\Services\Channels\NotificationService;
use Illuminate\Console\Command;
use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Support\Facades\Log;

class AttachNotificationToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:attach-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The command attaches users to the notification.';

    /**
     * @var NotificationService
     */
    private $notificationService;

    /**
     * Create a new command instance.
     *
     * @param NotificationService $service
     */
    public function __construct(NotificationService $service)
    {
        $this->notificationService = $service;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Amqp::consume(Notification::RABBIT_QUEUE_NAME, function ($message, $resolver) {

            $notification = unserialize($message->body);

            if($notification instanceof Notification) {
                $this->notificationService->attachUsers($notification);
            }else{
                Log::info('Not a notification instance came from the queue',['message'=>$message->body]);
            }

            $resolver->acknowledge($message);
        });
    }
}
