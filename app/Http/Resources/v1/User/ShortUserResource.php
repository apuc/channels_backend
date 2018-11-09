<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 09.11.18
 * Time: 11:34
 */

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
            'user_id' => $this->user_id,
            'username' => $this->getName(),
            'avatar' => ($this->avatar) ? $this->avatar->getSmall() : null,
        ];
    }
}