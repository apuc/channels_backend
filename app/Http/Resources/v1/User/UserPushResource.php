<?php
namespace App\Http\Resources\v1\User;


use Illuminate\Http\Resources\Json\JsonResource;

class UserPushResource extends JsonResource
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
            'endpoints' => $this->pushEndpoints->all(),
        ];
    }
}

