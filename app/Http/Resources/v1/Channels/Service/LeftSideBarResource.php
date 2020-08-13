<?php

namespace App\Http\Resources\v1\Channels\Service;

use App\Http\Resources\v1\ChannelResource;
use App\Http\Resources\v1\GroupsResource;
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
                $data['channels'][] = (new ChannelResource($item))->toArray(app('request'));
            }

            if ($item instanceof Group ) {
                $data['groups'][] = (new GroupsResource($item))->toArray(app('request'));
            }
        }

        return [
            'data' => $data
        ];
    }
}
