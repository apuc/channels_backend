<?php
namespace App\Http\Resources\v1;

use App\Models\Channels\Message;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AttachmentResource.
 *
 * @package App\Http\Resources\v1
 */
class AttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->attachment_id,
            'status' => $this->status,
            'message_id' => $this->message_id,
            'type' => $this->type,
            'options' => $this->options,
        ];
    }
}