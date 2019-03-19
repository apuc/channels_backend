<?php

namespace App\Services\Channels;

use App\Http\Requests\Channels\AttachmentRequest;
use App\Models\Channels\Attachment;
use App\Repositories\Channels\AttachmentRepository;
use Illuminate\Http\Request;

/**
 * Class AttachmentService.
 *
 * @package App\Services\Channels
 */
class AttachmentService
{
    /**
     * @var AttachmentRepository
     */
    protected $repository;

    /**
     * Construct for Attachment service.
     *
     * @param AttachmentRepository $repository
     */
    public function __construct(AttachmentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Method for create attachment.
     *
     * @param AttachmentRequest $request
     *
     * @return Attachment
     */
    public function create(AttachmentRequest $request): Attachment
    {
        return $this->repository->create($request);
    }

    /**
     * Method for update Attachment.
     *
     * @param AttachmentRequest $request
     * @param Attachment $attachment
     *
     * @return Attachment
     */
    public function update(AttachmentRequest $request, Attachment $attachment): Attachment
    {
        return $this->repository->update($request,$attachment);
    }

    /**
     * Method for destroy attachment.
     *
     * @param Attachment $attachment
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function destroy(Attachment $attachment)
    {
        return $this->repository->destroy($attachment);
    }
}