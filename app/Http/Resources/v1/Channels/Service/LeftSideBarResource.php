<?php

namespace App\Http\Resources\v1\Channels\Service;

use App\Models\Contracts\ChannelEntityInterface;
use App\Traits\Avatar;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Список каналов и групп для левого меню
 */
class LeftSideBarResource extends JsonResource
{
    use Avatar;

    protected const TYPE_CHANNEL = 'channel';
    protected const TYPE_GROUP = 'group';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /**@var $this ChannelEntityInterface*/

        $data = [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'slug' => $this->getSlug(),
            'owner_id' => $this->getOwnerId(),
            'type' => $this->getType(),
            'count' => $this->getCount(),
            'avatar' => $this->getAvatar($this->avatar)
        ];

        if ($this->getType() === self::TYPE_GROUP) {
            $data['channels'] = $this->addChannels();
        }

        return $data;
    }

    /**
     * Метод для добавления каналов
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    protected function addChannels()
    {
        return self::collection($this->channels);
    }
}
