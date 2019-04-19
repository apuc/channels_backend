<?php

namespace App\Services\Channels;

use App\Http\Requests\Channels\MessageRequest;
use App\Models\Channels\Message;
use App\Repositories\Channels\MessageRepository;

class MessageService
{
    /**
     * @var MessageRepository
     */
    protected $repository;

    /**
     * Construct for Message service
     *
     * @param MessageRepository $repository
     */
    public function __construct(MessageRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Method for create message
     *
     * @param MessageRequest $request
     * @return Message
     */
    public function create(MessageRequest $request): Message
    {
        return $this->repository->create($request);
    }

    /**
     * Method for update message
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
     * Method for destroy message
     *
     * @param Message $message
     * @return bool
     */
    public function destroy(Message $message)
    {
        return $this->repository->destroy($message);
    }
}