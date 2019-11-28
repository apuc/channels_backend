<?php

namespace App\Http\Resources\v1\Integrations;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\v1\Integrations\IntegrationTypeResource;

class IntegrationResource extends JsonResource
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
            'name'=>$this->name,
            'fields'=>$this->fields,
            'options'=>json_decode($this->pivot->data),
            'type'=> new IntegrationTypeResource($this->type),
        ];
    }
}
