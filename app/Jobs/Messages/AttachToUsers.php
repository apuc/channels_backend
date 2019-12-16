<?php

namespace App\Jobs\Messages;

use App\Models\Channels\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Auth;

class AttachToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Message
     */
    private $message;

    private $userId;

    /**
     * AttachToUsers constructor.
     * @param Message $message
     * @param $userId
     */
    public function __construct(Message $message,$userId)
    {
        $this->message = $message;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = $this->message->channel->users()
            ->wherePivot('user_id','<>',$this->userId)
            ->get()
            ->pluck('user_id')
            ->toArray();

        $this->message->users()->attach($users,['channel_id'=>$this->message->channel_id]);
    }
}
