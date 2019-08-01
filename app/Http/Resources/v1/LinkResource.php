<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
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
            'url'           => $this->getUrl(),
            'title'         => $this->getTitle(),
            'description'   => $this->getDescription(),
            'icon'          => $this->getIcon(),
            'base'          => $this->getBase()
        ];
    }
}