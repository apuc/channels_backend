<?php


namespace App\Http\Resources\v1\Channels;


use App\Http\Resources\v1\Integrations\IntegrationResource;
use App\Http\Resources\v1\MeetingResource;
use App\Http\Resources\v1\MessageResource;
use App\Http\Resources\v1\User\FullUserResource;
use App\Models\Channels\Channel;
use App\Repositories\Channels\ChannelRepository;
use App\Traits\Avatar;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullChannelResource extends JsonResource
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
        return [
            'id' => $this->channel_id,
            'title' => $this->getTitle(),
            'slug' => $this->slug,
            'status' => $this->status,
            'owner_id' => $this->owner_id,
            'private' => $this->private,
            'type' => $this->type,
            'count' => $this->getUserCount(),
            'avatar' => $this->getAvatar($this->avatar),
            'users' => FullUserResource::collection($this->users),
            'integrations' => IntegrationResource::collection($this->integrations),
            'meetings' => MeetingResource::collection($this->activeMeetings)
        ];
    }
}
