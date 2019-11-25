<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 22.10.18
 * Time: 17:17
 */

namespace App\Repositories\Channels;


use App\Http\Requests\Channels\MessageRequest;
use App\Models\Channels\Message;

class MessageRepository
{
    protected $model;

    /**
     * GroupsRepository constructor.
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->model = $message;
    }

    /**
     * Method for create message
     *
     * @param MessageRequest $request
     * @return Message
     */
    public function create(MessageRequest $request)
    {
        return $this->model::create([
            'channel_id' => $request->channel_id,
            'from' => $request->from,
            'to' => $request->to,
            'text' => $request->text,
            'read'=>$this->model::MESSAGE_UNREAD
        ]);
    }

    /**
     * Method for update Message
     *
     * @param MessageRequest $request
     * @param Message $message
     * @return Message
     */
    public function update(MessageRequest $request, Message $message)
    {
        $result = $message->update([
            'channel_id' => $request->channel_id,
            'from' => $request->from,
            'to' => $request->to,
            'text' => $request->text,
            'read' => $request->read,
        ]);

        if ($result) {
            return $message;
        }

        throw new \DomainException('Error updating message');
    }

    /**
     * Method for destroy message
     *
     * @param Message $message
     * @return bool
     * @throws \Exception
     */
    public function destroy(Message $message)
    {
        if ($message->delete()) {
            return true;
        }

        throw new \DomainException('Error deleting message!');
    }

    /**
     * @param int $id
     * @return Message|null
     */
    public function findById(int $id) :?Message
    {
        return $this->model::findOrFail($id);
    }

    /**
     * @param $id
     * @return Message|null
     */
    public function findOneWithTrashed($id) :?Message
    {
        return $this->model::where($this->model->getRouteKeyName(), $id)
            ->withTrashed()
            ->first();
    }

    /**
     * Отметить сообщения прочитаными
     * @param array $messages_ids
     * @return mixed
     */
    public function markAsRead(array $messages_ids)
    {
        return $this->model::whereIn('message_id',$messages_ids)->update(['read' => $this->model::MESSAGE_READ]);
    }
}
