<?php
namespace App\Http\Resources\v1;

use App\Models\Channels\Attachment;
use Illuminate\Http\Request;
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
     * @param  Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        /** @var Attachment $attachment */
        $attachment = $this->resource;

        return [
            'id' => $attachment->attachment_id,
            'status' => $attachment->status,
            'message_id' => $attachment->message_id,
            'type' => $attachment->type,
            'options' => $attachment->options,
        ];
    }
}
