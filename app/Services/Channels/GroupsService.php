<?php


namespace App\Services\Channels;

use App\Http\Requests\Channels\GroupRequest;
use App\Models\Channels\Channel;
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
        return \DB::transaction(function () use ($request) {
            $group = $this->repository->create($request);

            $group->users()->sync($request->get('user_ids'));

            return $group;
        });
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

    /**
     * Метод для добавления каналов в группу
     *
     * @param Group $group
     * @param array $channel_ids
     * @return mixed
     * @throws \Throwable
     */
    public function attachChannels(Group $group, array $channel_ids)
    {
        return $this->repository->attachChannels($group, $channel_ids);
    }
}