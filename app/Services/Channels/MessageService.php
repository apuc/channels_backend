<?php
namespace App\Services\Channels;

use App\Http\Requests\Channels\MessageRequest;
use App\Http\Requests\Channels\AttachmentRequest;
use App\Http\Resources\v1\MessageResource;
use App\Jobs\Messages\AttachToUsers;
use App\Jobs\Messages\SendToBot;
use App\Models\Channels\Attachment;
use App\Models\Channels\Message;
use App\Repositories\Channels\MessageRepository;
use App\Repositories\Channels\AttachmentRepository;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

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
     * Method for create message
     *
     * @param MessageRequest $request
     * @return Message
     */
    public function create(MessageRequest $request): Message
    {
        $message = $this->repository->create($request);
        $message->load(['channel','channel.bots']);

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

        //создает связи пользователь-сообщение чтобы определять ктро прочитал а кто нет в чатах
        if(!$message->channel->isDialog()){
            AttachToUsers::dispatch($message,Auth::id());
        }

        //отправка сообщений ботам
        if($message->channel->bots->count() > 0){
            SendToBot::dispatch($message);
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
     * Удалить сообщение
     * @param Message $message
     * @return bool
     * @throws \Exception
     */
    public function destroy(Message $message)
    {
        return $this->repository->destroy($message);
    }
}
