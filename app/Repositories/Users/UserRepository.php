<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 16.10.18
 * Time: 16:31
 */

namespace App\Repositories\Users;


use App\Http\Requests\Api\v1\Auth\RegistrationRequest;
use App\Http\Requests\Users\CreateRequest;
use App\Http\Requests\Users\ProfileRequest;
use App\Http\Requests\Users\SearchRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\Models\User;
use Doctrine\DBAL\Query\QueryBuilder;
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
     * C
     * @param RegistrationRequest $request
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    public function create(RegistrationRequest $request)
    {
        return $this->model::create([
            'email' => $request->email,
            'login' => $request->email,
            'username' => ($request->username) ?: $request->login,
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

        if ($result) {
            return $user;
        }

        throw new \DomainException('Error updating user!');

    }

    /**
     * @param ProfileRequest $request
     * @param User $user
     * @return User
     */
    public function updateProfile(ProfileRequest $request, User $user)
    {
        $result = $user->update([
            'username' => $request->username ?? $user->username,
            'avatar_id' => $request->avatar_id ?? $user->avatar_id
        ]);

        if ($result) {
            return $user;
        }

        throw new \DomainException('Error updating profile!');
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            return true;
        }

        throw new \DomainException('Error deleting user');
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function findById(int $id):?User
    {
        return $this->model::findOrFail($id);
    }

    /**
     * @param string $search_request
     * @return User|\Illuminate\Database\Eloquent\Builder
     */
    public function findByEmailOrUsername(string $search_request)
    {
        return $this->model->where('email', 'like', "%$search_request%")
            ->orWhere('username', 'like', "%$search_request%")->first();
    }
}
