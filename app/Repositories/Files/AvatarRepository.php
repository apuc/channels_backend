<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 04.10.18
 * Time: 18:53
 */

namespace App\Repositories\Files;


use App\Http\Requests\Files\AvatarRequest;
use App\Models\Avatar;

class AvatarRepository
{
    /**
     * @var Avatar
     */
    protected $model;

    /**
     * GroupsRepository constructor.
     * @param Avatar $avatar
     */
    public function __construct(Avatar $avatar)
    {
        $this->model = $avatar;
    }

    /**
     * Method for create group
     *
     * @param AvatarRequest $request
     * @return Avatar
     */
    public function create(AvatarRequest $request) :Avatar
    {
        return $this->model::create([
            'origin' => $request->origin,
            'average' => $request->average,
            'small' => $request->small,
            'status' => $request->status
        ]);
    }

    /**
     * Method for update Group
     *
     * @param AvatarRequest $request
     * @param Avatar $avatar
     * @return Avatar
     */
    public function update(AvatarRequest $request, Avatar $avatar)
    {
        $result = $avatar->update([
            'original' => $request->origin,
            'average' => $request->average,
            'small' => $request->small,
            'status' => $request->status
        ]);

        if ($result) {
            return $avatar;
        }

        throw new \DomainException('Error updating avatar');
    }

    /**
     * Method for destroy group
     *
     * @param Avatar $avatar
     * @return bool
     */
    public function destroy(Avatar $avatar)
    {
        if ($avatar->delete()) {
            return true;
        }

        throw new \DomainException('Error deleting avatar');
    }

    /**
     * @param int $id
     * @return Avatar|null
     */
    public function findById(int $id) :?Avatar
    {
        return $this->model::findOrFail($id);
    }
}