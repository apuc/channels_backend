<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\User\ShortUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class MessageResource
 * @package App\Http\Resources\v1
 * @property integer $channel_id
 * @property integer $to
 * @property integer $from
 * @property integer $read
 * @property string $text
 */
class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'message_id' => $this->message_id,
            'channel' => $this->channel_id,
            'to' => new ShortUserResource($this->toUser),
            'from' => new ShortUserResource($this->fromUser),
            'read' => ($this->read) ? $this->read : 0,
            'created_at' => $this->created_at->format('d-m-Y H:i:s'),
            'text' => $this->text
        ];
    }
}
