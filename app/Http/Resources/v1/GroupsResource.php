<?php

namespace App\Http\Resources\v1;

use App\Traits\Avatar;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupsResource extends JsonResource
{
    use Avatar;
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
            'avatar' => $this->getAvatar($this->avatar),
            'channels' => ChannelResource::collection($this->channels)->toArray($request)
        ];
    }
}
