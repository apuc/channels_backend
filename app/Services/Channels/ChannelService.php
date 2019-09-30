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
use Illuminate\Http\Request;

class ChannelService
{
    /**
     * @var ChannelRepository
     */
    protected $repository;

    /**
     * ChannelService constructor.
     * @param ChannelRepository $repository
     */
    public function __construct(ChannelRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Создание канала
     * @param ChannelRequest $request
     * @return Channel
     * @throws \Throwable
     */
    public function create(ChannelRequest $request): Channel
    {
        return \DB::transaction(function () use ($request) {
            $channel = $this->repository->create($request);

            $channel->users()->sync($request->get('user_ids'));

            return $channel;
        });
    }

    /**
     * Добавить юзера в канал
     * @param Request $request
     * @return Channel|null
     */
    public function addUser(Request $request)
    {
        $channel = $this->repository->findById($request->channel_id);
        $channel->users()->attach($request->get('user_id'));

        return $channel;
    }

    /**
     * Удалить юзера из канала
     * @param Request $request
     * @return Channel|null
     */
    public function deleteUser(Request $request)
    {
        $channel = $this->repository->findById($request->channel_id);
        $channel->users()->detach($request->user_id);

        return $channel;
    }

    /**
     * Редактирование канала
     * @param ChannelRequest $request
     * @param Channel $channel
     * @return Channel
     * @throws \Throwable
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
