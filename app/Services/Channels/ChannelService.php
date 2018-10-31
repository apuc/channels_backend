<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 25.09.18
 * Time: 14:51
 */

namespace App\Services\Channels;


use App\Http\Requests\ChannelRequest;
use App\Http\Requests\Channels\User\AddRequest;
use App\Models\Channels\Channel;
use App\Repositories\Channels\ChannelRepository;

class ChannelService
{
    /**
     * @var ChannelRepository
     */
    protected $repository;

    /**
     * Construct for Group service
     *
     * @param ChannelRepository $repository
     */
    public function __construct(ChannelRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Method for create group
     *
     * @param ChannelRequest $request
     * @return Channel
     */
    public function create(ChannelRequest $request): Channel
    {
        return \DB::transaction(function () use ($request) {
            $channel = $this->repository->create($request);

            $channel->users()->sync($request->get('user_ids'));

            return $channel;
        });
    }

    public function addUser(AddRequest $request)
    {
        $channel = $this->repository->findById($request->channel_id);
        $channel->users()->sync($request->get('user_id'));

        return $channel;
    }

    public function deleteUser(AddRequest $request)
    {
        $channel = $this->repository->findById($request->channel_id);
        $channel->users()->detach($request->user_id);

        return $channel;
    }

    /**
     * Method for update group
     *
     * @param ChannelRequest $request
     * @param Channel $channel
     * @return Channel
     */
    public function update(ChannelRequest $request, Channel $channel): Channel
    {
        return \DB::transaction(function () use ($request, $channel) {
            $this->repository->update($request, $channel);

            $channel->users()->sync($request->get('user_ids'));

            return $channel;
        });
    }

    /**
     * Method for destroy group
     *
     * @param Channel $channel
     * @return bool
     */
    public function destroy(Channel $channel)
    {
        return $this->repository->destroy($channel);
    }
}