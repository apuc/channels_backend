<?php


namespace App\Services\Channels;

use App\Http\Requests\Channels\GroupRequest;
use App\Models\Channels\Group;
use App\Repositories\Channels\GroupsRepository;

/**
 * Service for manage channels groups
 */
class GroupsService
{
    /**
     * @var GroupsRepository
     */
    protected $repository;

    /**
     * Construct for Group service
     *
     * @param GroupsRepository $repository
     */
    public function __construct(GroupsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Method for create group
     *
     * @param GroupRequest $request
     * @return Group
     */
    public function create(GroupRequest $request): Group
    {
        return $this->repository->create($request);
    }

    /**
     * Method for update group
     *
     * @param GroupRequest $request
     * @param Group $group
     * @return Group
     */
    public function update(GroupRequest $request, Group $group): Group
    {
        return $this->repository->update($request, $group);
    }

    /**
     * Method for destroy group
     *
     * @param Group $group
     * @return bool
     */
    public function destroy(Group $group)
    {
        return $this->repository->destroy($group);
    }
}