<?php

namespace App\Repositories\Channels;

use App\Http\Requests\ChannelRequest;
use App\Models\Channels\Channel;
use App\Models\Channels\Message;
use App\Traits\Sluggable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChannelRepository
{
    use Sluggable;

    protected $model;

    /**
     * GroupsRepository constructor.
     * @param Channel $channel
     */
    public function __construct(Channel $channel)
    {
        $this->model = $channel;
    }

    /**
     * Method for create channel
     *
     * @param ChannelRequest $request
     * @return Channel
     */
    public function create(ChannelRequest $request)
    {
        return $this->model::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'status' => $request->status,
            'owner_id' => $request->owner_id,
            'type' => $request->type,
            'private' => $request->private,
            'avatar_id' => $request->avatar
        ]);
    }

    /**
     * Создание диалога
     * @param int $owner
     * @param int $to
     * @return mixed
     */
    public function createDialog(int $owner, int $to)
    {
        $str = Str::random(5);

        return $this->model::create([
            'slug' => "{$owner}_{$str}_{$to}",
            'to_id' => $to,
            'status'=>$this->model::STATUS_ACTIVE,
            'owner_id' => $owner,
            'type' => $this->model::TYPE_DIALOG,
            'private' => $this->model::PRIVATE_CHANNEL,
        ]);
    }

    /**
     * Method for update channel
     *
     * @param ChannelRequest $request
     * @param Channel $channel
     * @return Channel
     */
    public function update(ChannelRequest $request, Channel $channel)
    {
        $result = $channel->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'status' => $request->status,
            'owner_id' => $request->owner_id,
            'type' => $request->type,
            'private' => $request->private,
            'avatar_id' => $request->avatar
        ]);

        if ($result) {
            return $channel;
        }

        throw new \DomainException('Error updating channel');
    }

    /**
     * Method for destroy channel
     *
     * @param Channel $channel
     * @return bool
     * @throws \Exception
     */
    public function destroy(Channel $channel)
    {
        if ($channel->delete()) {
            return true;
        }

        throw new \DomainException('Error deleting channel');
    }

    /**
     * @param int $id
     * @return Channel|null
     */
    public function findById(int $id) :?Channel
    {
        return $this->model::findOrFail($id);
    }

    /**
     * @param $id
     * @return Channel|null
     */
    public function findOneWithTrashed($id) :?Channel
    {
        return $this->model::where($this->model->getRouteKeyName(), $id)
            ->withTrashed()
            ->first();
    }

    /**
     * Получает каналы юзера которые не в группах
     * @param int $userId
     * @return null|Collection
     */
    public function findByUserWithoutGroups(int $userId)
    {
        return $this->model->newQuery()
            ->select(['channel.*'])
            ->leftJoin('channels_group_users', 'channels_group_users.channel_id', '=', 'channel.channel_id')
            ->where(function (Builder $query) use ($userId) {
                $query->where('channels_group_users.user_id', $userId);
                $query->whereNull('channels_group_users.channels_group_id');
            })
            ->get();
    }

    /**
     * Получает все каналы юзера
     * @param int $userId
     * @return Collection
     */
    public function findByUser(int $userId)
    {
        return $this->model->newQuery()
            ->select(['channel.*','cgu.channels_group_id'])
            ->with(['users','avatar'])
            ->leftJoin('channels_group_users as cgu', 'cgu.channel_id', '=', 'channel.channel_id')
            ->where(function (Builder $query) use ($userId) {
                $query->where('cgu.user_id', $userId);
            })
            ->get();
    }

    /**
     * 20 каналов для главной отсортированых по дате последнего сообщения
     * @return mixed
     */
    public function findPopular()
    {
        $channels =  DB::table("channel")
            ->select(
                "channel.*",
                DB::raw("(select created_at from message
               where message.channel_id = channel.channel_id
               order by message_id desc limit 1) as m_date")
            )->orderBy('m_date','desc')->take(20)
            ->where('private','=',$this->model::PUBLIC_CHANNEL)
            ->whereNull('deleted_at')
            ->get();

        return $this->model::hydrate($channels->toArray());
    }

    /**
     * Получает пользователей канала для отправки пуш уведомлений
     * @param $channelId
     * @return Collection
     */
    public function getUsersToPush($channelId)
    {
        $channel = $this->findById($channelId);

        return $channel->users()->where([
            ['push_endpoints','<>',null],
            ['is_bot',0],
        ])->get();
    }

    /**
     * Сообщения канала
     *
     * @param Channel $channel
     * @return LengthAwarePaginator
     */
    public function getChannelMessages(Channel $channel)
    {
        return $channel->messages()
            ->orderBy('message_id','desc')
            ->paginate(Message::MESSAGES_PER_PAGE);
    }
}
