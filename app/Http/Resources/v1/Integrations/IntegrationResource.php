<?php

namespace App\Http\Resources\v1\Integrations;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IntegrationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'fields'=>$this->fields,
            'options'=> $this->pivot ? json_decode($this->pivot->data) : null,
            'type'=> new IntegrationTypeResource($this->type),
        ];
    }
}
