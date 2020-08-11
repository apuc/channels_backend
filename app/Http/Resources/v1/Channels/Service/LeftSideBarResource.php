<?php

namespace App\Http\Resources\v1\Channels\Service;

use App\Models\Channels\Channel;
use App\Models\Channels\Group;
use App\Traits\Avatar;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Список каналов и групп для левого меню
 */
class LeftSideBarResource extends JsonResource
{
    use Avatar;

    public function getResponse(Collection $collection): array
    {
        $data = [
            'channels' => [],
            'groups' => [],
        ];

        /** @var $item Channel|Group $item */
        foreach ($collection as $item){

            if ($item instanceof Channel ) {
                $data['channels'][] = [
                    'id' => $item->channel_id,
                    'title' => $item->getTitle(),
                    'slug' => $item->slug,
                    'status' => $item->status,
                    'owner_id' => $item->owner_id,
                    'private' => $item->private,
                    'type' => $item->type,
                    'count' => $item->users->count(),
                    'avatar' => $this->getAvatar($item->avatar),
                    'unread_count' => $this->getUnreadCount($item)
                ];
            }

            if ($item instanceof Group ) {
                $data['groups'][] = [
                    'id' => $item->channels_group_id,
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'status' => $item->status,
                    'owner_id' => $item->owner_id,
                    'avatar' => $this->getAvatar($item->avatar),
                ];
            }
        }

        return [
            'data' => $data
        ];
    }

    /**
     * Непрочитанные сообщения
     * @param Channel $channel
     * @return int
     */
    protected function getUnreadCount(Channel $channel)
    {
        if ( $channel->type == Channel::TYPE_DIALOG ) {
            return $channel->dialogUnread->count();
        }

        return $channel->chatUnread();
    }
}
