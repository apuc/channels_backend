<?php

namespace App\Jobs\Messages;

use App\Http\Resources\v1\MessageResource;
use App\Models\Channels\Message;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendToBot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Message
     */
    private $message;

    /**
     * SendToBot constructor.
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();

        foreach ($this->message->channel->bots as $bot)
        {
            if(!$bot->webhook){
                continue;
            }

            if($bot->user_id == $this->message->fromUser->user_id){
                continue;
            }

            $data = (new MessageResource($this->message))->toResponse(app('request'))->getData();
            $client->post($bot->webhook,['form_params'=>[$data]]);
        }
    }
}
