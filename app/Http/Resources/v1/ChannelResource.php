<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 04.10.18
 * Time: 15:16
 */

namespace App\Http\Resources\v1;


use App\Models\Channels\Channel;
use App\Traits\Avatar;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChannelResource extends JsonResource
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
        /** @var Channel $channel */
        $channel = $this->resource;

        return [
            'id' => $channel->channel_id,
            'title' => $channel->getTitle(),
            'slug' => $channel->slug,
            'status' => $channel->status,
            'owner_id' => $channel->owner_id,
            'private' => $channel->private,
            'type' => $channel->type,
            'count' => $channel->users->count(),
            'unread_count' => $channel->unread->count(),
            'avatar' => $this->getAvatar($channel->avatar),
        ];
    }
}
