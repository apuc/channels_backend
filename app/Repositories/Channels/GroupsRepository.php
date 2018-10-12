<?php

namespace App\Repositories\Channels;

use App\Http\Requests\Channels\GroupRequest;
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
}