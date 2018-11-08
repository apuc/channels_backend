<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 16.10.18
 * Time: 16:31
 */

namespace App\Repositories\Users;


use App\Http\Requests\Users\CreateRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\Models\User;
use Psy\Util\Str;

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
     * @param CreateRequest $request
     * @return User
     */
    public function create(CreateRequest $request)
    {
        return $this->model::create([
            'email' => $request->email,
            'login' => $request->login,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);
    }

    /**
     * @param UpdateRequest $request
     * @param User $user
     * @return User
     */
    public function update(UpdateRequest $request, User $user)
    {

        $result = $user->update([
            'email' => $request->email ?? $user->email,
            'login' => $request->login ?? $user->login,
            'username' => $request->username ?? $user->username,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
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