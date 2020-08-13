<?php

namespace App\Repositories\Channels;

use App\Http\Requests\Channels\GroupRequest;
use App\Models\Channels\Channel;
use App\Models\Channels\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Class for Group repository
 */
class GroupsRepository
{
    protected $model;

    /**
     * GroupsRepository constructor.
     * @param Group $group
     */
    public function __construct(Group $group)
    {
        $this->model = $group;
    }

    /**
     * Method for create group
     *
     * @param GroupRequest $request
     * @return Group
     */
    public function create(GroupRequest $request)
    {
        return $this->model::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'status' => $request->status,
            'owner_id' => $request->owner_id,
            'avatar_id' => $request->avatar
        ]);
    }

    /**
     * Method for update Group
     *
     * @param GroupRequest $request
     * @param Group $group
     * @return Group
     */
    public function update(GroupRequest $request, Group $group)
    {
        $result = $group->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'status' => $request->status,
            'avatar_id' => $request->avatar
        ]);

        if ( $result ) {
            return $group;
        }

        throw new \DomainException('Error updating group');
    }

    /**
     * Method for destroy group
     *
     * @param Group $group
     * @return bool
     */
    public function destroy(Group $group)
    {
        if ( $group->delete() ) {
            return true;
        }

        throw new \DomainException('Error deleting group');
    }

    /**
     * @param int $id
     * @return Group|null
     */
    public function findById(int $id): ?Group
    {
        return $this->model::findOrFail($id);
    }

    /**
     * @param $id
     * @return Group|null
     */
    public function findOneWithTrashed($id): ?Group
    {
        return $this->model::where($this->model->getRouteKeyName(), $id)
            ->with('channels')
            ->withTrashed()
            ->first();
    }

    /**
     * Метод для сохранения каналов в группе
     *
     * @param Group $group
     * @param array $channels_ids
     * @return mixed
     * @throws \Throwable
     */
    public function attachChannels(Group $group, array $channels_ids)
    {
        try {
            return \DB::transaction(function () use ($group, $channels_ids) {
                $user = Auth::user();

                foreach ($channels_ids as $channel_id) {
                    $user->channels()->updateExistingPivot($channel_id, ['channels_group_id' => $group->channels_group_id]);
                }

                return true;
            });
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * Метод удаления канала из группы
     *
     * @param Group $group
     * @param $channel_id
     * @return bool
     * @throws \Throwable
     */
    public function detachChannel(Group $group, $channel_id)
    {
        try {
            Auth::user()->channels()->updateExistingPivot($channel_id, ['channels_group_id' => null]);

            return true;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * @param int $userId
     * @return null|Collection
     */
    public function findByUser(int $userId)
    {
        $query = $this->model->newQuery()
            ->with(['channels', 'avatar'])
            ->select(['channels_group.*'])
            ->leftJoin('channels_group_users as cgu', 'cgu.channels_group_id', '=', 'channels_group.channels_group_id')
            ->where('cgu.user_id', $userId)
            ->orWhere('channels_group.owner_id', $userId)
            ->groupBy(['channels_group.channels_group_id']);

        return $query->get();
    }
}
