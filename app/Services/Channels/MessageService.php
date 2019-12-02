<?php
namespace App\Services\Channels;

use App\Http\Requests\Channels\MessageRequest;
use App\Http\Requests\Channels\AttachmentRequest;
use App\Models\Channels\Attachment;
use App\Models\Channels\Message;
use App\Repositories\Channels\MessageRepository;
use App\Repositories\Channels\AttachmentRepository;

class MessageService
{
    /**
     * @var MessageRepository
     */
    protected $repository;

    /**
     * @var AttachmentRepository
     */
    protected $attachmentRepository;

    /**
     * MessageService constructor.
     *
     * @param MessageRepository $repository
     * @param AttachmentRepository $attachmentRepository
     */
    public function __construct(MessageRepository $repository,AttachmentRepository $attachmentRepository)
    {
        $this->attachmentRepository = $attachmentRepository;
        $this->repository = $repository;
    }

    /**
     * Method for create group
     *
     * @param MessageRequest $request
     * @return Message
     */
    public function create(MessageRequest $request): Message
    {
        $message = $this->repository->create($request);

        if($request->attachments){

           foreach ($request->attachments as $attachment){

               $data = new AttachmentRequest([
                   'options'  => $attachment['options'],
                   'message_id'  => $message->message_id,
                   'status'  => Attachment::STATUS_ACTIVE,
                   'type'  => $attachment['type'] ?? null,
               ]);

               $this->attachmentRepository->create($data);
           }
        }

        return $message;
    }

    /**
     * Method for update group
     *
     * @param MessageRequest $request
     * @param Message $message
     * @return Message
     */
    public function update(MessageRequest $request, Message $message): Message
    {
        return $this->repository->update($request, $message);
    }

    /**
     * Method for destroy group
     *
     * @param Message $message
     * @return bool
     */
    public function destroy(Message $message)
    {
        return $this->repository->destroy($message);
    }
}
