<?php
namespace App\Services;

use App\Http\Resources\v1\MessageResource;
use App\Models\Channels\Message;
use Illuminate\Http\Resources\Json\Resource;
use GuzzleHttp\Client;

/**
 * Class NodeService
 * @package App\Services\Channels
 */
class NodeService
{
    /**
     * Отправляет сообщение на нод,чтобы он отправил всем
     * @param Message $message
     * @param array $channels
     */
   public static function broadcastMessage(Message $message,array $channels)
   {
       Resource::withoutWrapping();

       $data = json_encode([
           'channels_ids'=>$channels,
           'message'=> (new MessageResource($message))->toResponse(app('request'))->getData()
       ]);

       $rout = config('integrations.node_integration_url');

       $client = new Client();

       $client->post("http://localhost:3000/{$rout}",[
           'body'=>$data,
           'headers' => ['Content-Type' => 'application/json',]
       ]);
   }
}
