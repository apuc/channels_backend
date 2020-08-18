<?php

namespace App\Http\Resources\v1;

use App\Models\Channels\Group;
use App\Traits\Avatar;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupsResource extends JsonResource
{
    use Avatar;
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Group $group */
        $group = $this->resource;

        return [
            'id' => $group->channels_group_id,
            'title' => $group->title,
            'slug' => $group->slug,
            'status' => $group->status,
            'owner_id' => $group->owner_id,
            'avatar' => $this->getAvatar($group->avatar),
            'count' => $this->whenLoaded('channels', $group->channels->count()),
            'channels' => ChannelResource::collection($this->whenLoaded('channels'))
        ];
    }
}
