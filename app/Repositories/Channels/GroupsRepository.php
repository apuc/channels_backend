<?php

namespace App\Repositories\Channels;

use App\Http\Requests\Channels\GroupRequest;
use App\Models\Channels\Channel;
use App\Models\Channels\Group;

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

        if ($result) {
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
        if ($group->delete()) {
            return true;
        }

        throw new \DomainException('Error deleting group');
    }

    /**
     * @param int $id
     * @return Group|null
     */
    public function findById(int $id) :?Group
    {
        return $this->model::findOrFail($id);
    }

    /**
     * @param $id
     * @return Group|null
     */
    public function findOneWithTrashed($id) :?Group
    {
        return $this->model::where($this->model->getRouteKeyName(), $id)
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
                $channelsRelation = [];

                foreach ($channels_ids as $channels_id) {
                    $channelsRelation[$channels_id] = ['user_id' => \Auth::id()];
                }

                $group->channels()->attach($channelsRelation);

                return true;
            });
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}