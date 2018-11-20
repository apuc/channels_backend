<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 25.09.18
 * Time: 14:44
 */

namespace App\Repositories\Channels;


use App\Http\Requests\ChannelRequest;
use App\Models\Channels\Channel;

class ChannelRepository
{
    protected $model;

    /**
     * GroupsRepository constructor.
     * @param Channel $channel
     */
    public function __construct(Channel $channel)
    {
        $this->model = $channel;
    }

    /**
     * Method for create channel
     *
     * @param ChannelRequest $request
     * @return Channel
     */
    public function create(ChannelRequest $request)
    {
        return $this->model::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'status' => $request->status,
            'owner_id' => $request->owner_id,
            'type' => $request->type,
            'private' => $request->private,
            'avatar_id' => $request->avatar
        ]);
    }

    /**
     * Method for update Group
     *
     * @param ChannelRequest $request
     * @param Channel $channel
     * @return Channel
     */
    public function update(ChannelRequest $request, Channel $channel)
    {
        $result = $channel->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'status' => $request->status,
            'owner_id' => $request->owner_id,
            'type' => $request->type,
            'private' => $request->private,
            'avatar_id' => $request->avatar
        ]);

        if ($result) {
            return $channel;
        }

        throw new \DomainException('Error updating channel');
    }

    /**
     * Method for destroy group
     *
     * @param Channel $channel
     * @return bool
     */
    public function destroy(Channel $channel)
    {
        if ($channel->delete()) {
            return true;
        }

        throw new \DomainException('Error deleting group');
    }

    /**
     * @param int $id
     * @return Channel|null
     */
    public function findById(int $id) :?Channel
    {
        return $this->model::findOrFail($id);
    }

    /**
     * @param $id
     * @return Channel|null
     */
    public function findOneWithTrashed($id) :?Channel
    {
        return $this->model::where($this->model->getRouteKeyName(), $id)
            ->withTrashed()
            ->first();
    }
}