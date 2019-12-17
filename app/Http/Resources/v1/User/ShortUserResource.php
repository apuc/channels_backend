<?php
namespace App\Http\Resources\v1\User;


use Illuminate\Http\Resources\Json\JsonResource;

class ShortUserResource extends JsonResource
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
            'id' => $this->user_id,
            'username' => $this->getName(),
            'avatar' => ($this->avatar) ? $this->avatar->getSmall() : null,
            'is_bot' => $this->isBot()
        ];
    }
}
