<?php
/**
 *
 */

namespace App\Repositories\Channels;


use App\Http\Requests\Channels\GroupRequest;
use App\Models\Channels\Group;

class GroupsRepository
{
    protected $model;

    public function __construct(Group $group)
    {
        $this->model = $group;
    }

    /**
     * @param GroupRequest $request
     * @return Group
     */
    public function create(GroupRequest $request)
    {
        return $this->model::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'status' => $request->status
        ]);
    }

    public function update(GroupRequest $request, Group $group)
    {

    }

    public function destroy(Group $group)
    {
        return $group->delete();
    }
}