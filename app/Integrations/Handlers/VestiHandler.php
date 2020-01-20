<?php

namespace App\Integrations\Handlers;

use App\Integrations\IntegrationRssContract;
use App\Models\Channels\Attachment;
use App\Integrations\IntegrationBase;
use SimplePie_Item;

class VestiHandler extends IntegrationBase implements IntegrationRssContract
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
                    'category'=>$item->get_category()->term,
                    'link'=>$item->get_link(),
                    'enclosure'=>$item->get_enclosure()->link,
                    'full_text'=>$item->get_item_tags('http://news.yandex.ru','full-text')[0]['data'],
                    'author'=>null,
                ],
                'status'  => Attachment::STATUS_ACTIVE,
            ]
        ];
    }
}

