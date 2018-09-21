<?php


namespace App\Services\Channels;

use App\Http\Requests\Channels\GroupRequest;
use App\Models\Channels\Group;
use App\Repositories\Channels\GroupsRepository;

class GroupsService
{
    protected $repository;

    public function __construct(GroupsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(GroupRequest $request): Group
    {
        return $this->repository->create($request);
    }


    public function update(GroupRequest $request, Group $group): Group
    {

    }


    public function destroy(GroupRequest $request)
    {

    }
}