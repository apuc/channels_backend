<?php

namespace App\Repositories\Channels;

use App\Http\Requests\Channels\AttachmentRequest;
use App\Models\Channels\Attachment;

/**
 * Class AttachmentRepository.
 *
 * @package App\Repositories\Channels
 */
class AttachmentRepository
{
    /**
     * @var Attachment
     */
    protected $model;

    /**
     * AttachmentRepository constructor.
     *
     * @param Attachment $attachment
     */
    public function __construct(Attachment $attachment)
    {
        $this->model = $attachment;
    }

    /**
     * Method for create attachment
     *
     * @param AttachmentRequest $request
     *
     * @return mixed
     */
    public function create(AttachmentRequest $request)
    {
        return $this->model::create([
            'type' => $request->type,
            'options' => $request->options,
            'status' => $request->status,
            'message_id' => $request->message_id,
        ]);
    }

    /**
     * Method for update Attachment
     *
     * @param AttachmentRequest $request
     * @param Attachment $attachment
     *
     * @return Attachment
     */
    public function update(AttachmentRequest $request, Attachment $attachment)
    {
        $result = $attachment->update([
            'type' => $request->type,
            'options' => $request->options,
            'status' => $request->status,
            'message_id' => $request->message_id,
        ]);

        if ($result) {
            return $attachment;
        }

        throw new \DomainException('Error updating attachment');
    }

    /**
     * Method for destroy attachment
     *
     * @param Attachment $attachment
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function destroy(Attachment $attachment)
    {
        if ($attachment->delete()) {
            return true;
        }

        throw new \DomainException('Error deleting attachment');
    }

    /**
     * @param int $id
     *
     * @return Attachment|null
     */
    public function findById(int $id) :?Attachment
    {
        return $this->model::findOrFail($id);
    }
}