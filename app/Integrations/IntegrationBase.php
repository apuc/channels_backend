<?php

namespace App\Integrations;

use App\Http\Requests\Channels\MessageRequest;
use App\Http\Resources\v1\MessageResource;
use App\Models\Channels\Message;
use App\Models\Integrations\Integration;
use App\Services\Channels\MessageService;
use App\Services\NodeService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Log;
use Vedmant\FeedReader\Facades\FeedReader;

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
     * IntegrationBase constructor.
     * @param MessageService $service
     * @param Integration $integration
     */
    public function __construct(Integration $integration,MessageService $service)
    {
        $this->messageService = $service;
        $this->integration = $integration;
        $this->integration->load('channels');
    }

    /**
     * Есть ли интеграцияя в каком-либо канале
     * @return bool
     */
    public function integrationHasChannels()
    {
        return $this->integration->channels->count() > 0;
    }

    /**
     * Создает сообщения в каналах
     * @param $text
     * @param $attachments
     */
    protected function sendToChannels(string $text,array $attachments,array $channels_ids = [])
    {
        $ids = empty($channels_ids) ? $this->integration->channels->pluck('channel_id')->toArray() : $channels_ids;

        $channels = $this->integration->channels->keyBy('channel_id');

        $message = null;

        foreach ($ids as $id){

            $bot = $channels[$id]->bots()->where('users.owner_id',0)->first();

            $data = new MessageRequest([
                'channel_id'=>$id,
                'from'=> $bot ? $bot->user_id : 1,
                'text'=>$text,
                'attachments'=>$attachments
            ]);

            $message = $this->messageService->create($data);
        }

        NodeService::broadcastMessage($message,$ids);
    }

    /**
     * Парсит rss и отправляет новые новости в каналы
     */
    public function parseRss()
    {
        $items = FeedReader::read($this->integration->rss_url)->get_items();

        //первый парсинг(берем первую новость и запоминаем ее тайтл)
        if(!$this->integration->fields->get('last_item'))
        {
            $this->integration->fields->set('last_item',$items[0]->get_title());
            $this->integration->save();

            $this->sendToChannels(
                $this->integration->name,
                $this->parseAttachments($items[0]),
                $this->integration->channels->pluck('channel_id')->toArray()
            );

            return 1;
        }

        //последующие парсинги(идем по новостям и добавляем пока не найдем прошлый тайтл)
        foreach ($items as $item)
        {
            if($item->get_title() == $this->integration->fields->get('last_item')){
                $this->integration->fields->set('last_item',$items[0]->get_title());
                $this->integration->save();
                break;
            }

            $this->sendToChannels(
                $this->integration->name,
                $this->parseAttachments($item),
                $this->integration->channels->pluck('channel_id')->toArray()
            );
        }
    }
}
