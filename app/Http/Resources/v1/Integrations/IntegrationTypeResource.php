<?php

namespace App\Http\Resources\v1\Integrations;

use Illuminate\Http\Resources\Json\JsonResource;

class IntegrationTypeResource extends JsonResource
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
            'id'=>$this->id,
            'url'=>$this->url,
            'title'=>$this->title,
            'user_can_create'=>$this->user_can_create,
            'fields'=>$this->fields,
            'options'=>$this->options,
            'integrations'=>IntegrationResource::collection($this->integrations)
        ];
    }
}
