<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 16.10.18
 * Time: 16:31
 */

namespace App\Repositories\Users;


use App\Http\Requests\Users\UserRequest;
use App\Models\User;

class UserRepository
{
    protected $model;

    /**
     * GroupsRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param UserRequest $request
     * @return User
     */
    public function create(UserRequest $request)
    {
        return $this->model::create([
            'email' => $request->email,
            'login' => $request->login,
            'username' => $request->username,
            'password' => $request->password,
        ]);
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return User
     */
    public function update(UserRequest $request, User $user)
    {

        $result = $user->update([
            'email' => $request->email,
            'login' => $request->login,
            'username' => $request->username,
            'password' => $request->password,
        ]);

        if($result){
            return $user;
        }

        throw new \DomainException('Error updating channel');

    }

    /**
     * Method for destroy group
     *
     * @param User $user
     * @return bool
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            return true;
        }

        throw new \DomainException('Error deleting group');
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function findById(int $id) :?User
    {
        return $this->model::findOrFail($id);
    }
}