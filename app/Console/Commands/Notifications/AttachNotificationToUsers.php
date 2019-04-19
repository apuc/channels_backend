<?php

namespace App\Console\Commands\Notifications;

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
    protected $signature = 'notifications:attachusers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Amqp::consume('notifications_queue', function ($message, $resolver) {

            $notification = unserialize($message->body);

            $notification->users()->attach(
                $notification->channel->users->pluck('user_id'),
                ['status'=>0]
            );

            Log::info('Users are attached to notification '.$notification->id,['notification'=>$notification]);
            $resolver->acknowledge($message);

        });
    }
}
