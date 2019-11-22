<?php

namespace App\Repositories\Channels;

use App\Http\Requests\ChannelRequest;
use App\Models\Channels\Channel;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\DialogRequest;
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
     * @param int $userId
     * @return null|\Illuminate\Database\Eloquent\Collection
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
//            ->orWhere(function (Builder $query) use ($userId) {
//                $query->where('channel.owner_id', $userId);
//                $query->where(function (Builder $query) use ($userId) {
//                    $query->where('channels_group_users.user_id', '<>', $userId);
//                    $query->orWhereNull('channels_group_users.user_id');
//                });
//            })
            ->get();
    }

    /**
     * 20 каналов для главной отсортированых по дате последнего сообщения
     * @return Channel[]|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
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
            ->get();

        return $this->model::hydrate($channels->toArray());
    }
}
