<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 04.10.18
 * Time: 15:16
 */

namespace App\Http\Resources\v1;


use Illuminate\Http\Resources\Json\JsonResource;

class ChannelResource extends JsonResource
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
            'channel_id' => $this->channel_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'status' => $this->status,
            'private' => $this->private
        ];
    }
}