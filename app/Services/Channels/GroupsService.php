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
            //$group->users()->sync($request->get('user_ids'));
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
     * Удалить группу
     * @param Group $group
     * @return bool
     * @throws \Throwable
     */
    public function destroy(Group $group)
    {
        foreach ($group->channels as $channel){
            $this->repository->detachChannel($group, $channel->channel_id);
        }

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

    /**
     * Метод удаления канала из группы
     *
     * @param Group $group
     * @param $channel_id
     * @return bool
     */
    public function detachChannel(Group $group, $channel_id)
    {
        return $this->repository->detachChannel($group, $channel_id);
    }
}
