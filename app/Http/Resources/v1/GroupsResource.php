<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'group_id' => $this->channels_group_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'status' => $this->status,
            'avatar' => [
                'avatar_id' => ($this->avatar) ? $this->avatar->getId() : null,
                'origin' => ($this->avatar) ? $this->avatar->getOrigin() : null,
                'average' => ($this->avatar) ? $this->avatar->getAverage() : null,
                'small' => ($this->avatar) ? $this->avatar->getSmall() : null,
            ],
            'channels' => ChannelResource::collection($this->channels)->toArray($request)
        ];
    }
}
