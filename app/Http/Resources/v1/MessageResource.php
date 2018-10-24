<?php

namespace App\Http\Resources\v1;

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
            'to' => $this->to,
            'from' => $this->from,
            'read' => $this->read,
            'created_at' => $this->created_at->format('d-m-Y H:i:s'),
            'text' => $this->text
        ];
    }
}
