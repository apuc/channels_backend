<?php

namespace App\Integrations;

use App\Http\Requests\Channels\MessageRequest;
use App\Http\Resources\v1\MessageResource;
use App\Models\Channels\Message;
use App\Models\Integrations\Integration;
use App\Services\Channels\MessageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;

class IntegrationBase
{
    /**
     * @var MessageService
     */
    private $messageService;

    /**
     * @var Integration
     */
    protected $integration;

    /**
     * VkHandler constructor.
     * @param MessageService $service
     * @param Integration $integration
     */
    public function __construct(Integration $integration,MessageService $service)
    {
        $this->messageService = $service;
        $this->integration = $integration;
    }

    /**
     * Создает сообщения в каналах
     * @param $text
     * @param $attachments
     */
    protected function sendToChannels(string $text,array $attachments)
    {
        foreach ($this->integration->channels as $channel){

            $data = new MessageRequest([
                'channel_id'=>$channel->channel_id,
                'from'=>1,
                'text'=>$text,
                'attachments'=>$attachments
            ]);

            $message = $this->messageService->create($data);

        }

        $this->sendToNode($message,$this->integration->channels->pluck('channel_id')->toArray());
    }


    /**
     * Отправляет сообщение на нод,чтобы он отправил всем
     * @param Message $message
     * @param array $channels
     */
    private function sendToNode(Message $message,array $channels)
    {
        Resource::withoutWrapping();

        $data = json_encode([
            'channels_ids'=>$channels,
            'message'=> (new MessageResource($message))->toResponse(app('request'))->getData()
        ]);

        $rout = config('integrations.node_integration_url');

        $ch = curl_init("http://localhost:3000/{$rout}");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $result = curl_exec($ch);
    }
}
