<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \App\Http\Requests\Channels\LinkRequest $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'url'           => $request->url,
            'title'         => $request->title,
            'description'   => $request->description,
            'icon'          => $request->icon,
            'base'          => $request->base
        ];
    }
}