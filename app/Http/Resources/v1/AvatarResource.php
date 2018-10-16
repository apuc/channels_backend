<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 05.10.18
 * Time: 12:14
 */

namespace App\Http\Resources\v1;


use Illuminate\Http\Resources\Json\JsonResource;

class AvatarResource extends JsonResource
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
            'avatar_id' => $this->avatar_id,
            'origin' => $this->getOrigin(),
            'average' => $this->getAverage(),
            'small' => $this->getSmall(),
            'status' => $this->status
        ];
    }

}