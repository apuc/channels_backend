<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 16.10.18
 * Time: 17:04
 */

namespace App\Http\Resources\v1;


use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'user_id' => $this->user_id,
            'email' => $this->email,
            'username' => $this->getName(),
            'avatar' => [
                'origin' => ($this->avatar) ? $this->avatar->getOrigin() : null,
                'average' => ($this->avatar) ? $this->avatar->getAverage() : null,
                'small' => ($this->avatar) ? $this->avatar->getSmall() : null,
            ]
        ];
    }

}