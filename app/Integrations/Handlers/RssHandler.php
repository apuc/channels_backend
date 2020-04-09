<?php

namespace App\Integrations\Handlers;

use App\Models\Channels\Attachment;
use App\Integrations\IntegrationBase;
use SimplePie_Item;;
use Vedmant\FeedReader\Facades\FeedReader;

class RssHandler extends IntegrationBase
{
    /**
     * Собирает атачмент
     * @param SimplePie_Item $item
     * @return array
     */
    public function parseAttachments(SimplePie_Item $item) : array
    {
        return [
                [
                'type'   => Attachment::TYPE_RSS,
                'options'  => [
                    'title'=>$item->get_title(),
                    'description'=>$item->get_description(),
                    'date'=>$item->get_date('d.m.Y H:i'),
                    'category'=>$item->get_category()->term ?? '',
                    'link'=>$item->get_link(),
                    'enclosure'=>$item->get_enclosure()->link ?? '',
                    'full_text'=>$item->get_item_tags('http://news.yandex.ru','full-text')[0]['data'],
                    'author'=>null,
                ],
                'status'  => Attachment::STATUS_ACTIVE,
            ]
        ];
    }

    /**
     * Парсит rss и отправляет новые новости в каналы
     */
    public function parseRss()
    {
        $items = FeedReader::read($this->integration->fields->get('rss_url'))->get_items();

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

