<?php
namespace App\Http\Resources\v1;

use App\Models\Meeting;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id' => $this->id,
           'channel_id' => $this->channel_id,
           'name' => $this->name,
           'token' => $this->token,
        ];
    }
}
