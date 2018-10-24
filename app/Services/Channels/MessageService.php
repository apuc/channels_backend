<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 22.10.18
 * Time: 17:39
 */

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
     * Construct for Group service
     *
     * @param MessageRepository $repository
     */
    public function __construct(MessageRepository $repository)
    {
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
        return $this->repository->create($request);
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