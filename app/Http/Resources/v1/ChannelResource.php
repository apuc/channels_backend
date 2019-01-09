<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 04.10.18
 * Time: 15:16
 */

namespace App\Http\Resources\v1;


use App\Traits\Avatar;
use Illuminate\Http\Resources\Json\JsonResource;

class ChannelResource extends JsonResource
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
            'id' => $this->channel_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'status' => $this->status,
            'owner_id' => $this->owner_id,
            'private' => $this->private,
            'type' => $this->type,
            'count' => $this->getUserCount(),
            'avatar' => $this->getAvatar($this->avatar)
        ];
    }
}