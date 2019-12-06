<?php
namespace App\Repositories\Users;


use App\Http\Requests\Api\v1\Auth\RegistrationRequest;
use App\Http\Requests\Users\ProfileRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\Models\User;
use App\Http\Requests\Bot\BotRequest;

class UserRepository
{
    protected $model;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Cоздать юзера
     * @param RegistrationRequest $request
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    public function create(RegistrationRequest $request)
    {
        return $this->model::create([
            'email' => $request->email,
            'username' => ($request->username) ?: $request->email,
            'password' => bcrypt($request->password),
        ]);
    }

    /**
     * Создать бота
     * @param $request
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    public function createBot(BotRequest $request)
    {
        return $this->model::create([
            'username' => $request->name,
            'owner_id' => $request->owner_id,
            'avatar_id' => $request->avatar_id,
            'webhook' => $request->webhook,
            'is_bot' => $this->model::BOT,
        ]);
    }

    /**
     * Редактировать данные юзера
     * @param UpdateRequest $request
     * @param User $user
     * @return User
     */
    public function update(UpdateRequest $request, User $user)
    {
        $result = $user->update([
            'email' => $request->email ?? $user->email,
            'username' => $request->username ?? $user->username,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        if ($result) {
            return $user;
        }

        throw new \DomainException('Error updating user!');
    }

    /**
     * Редактировать публичные данные профиля
     * @param ProfileRequest $request
     * @param User $user
     * @return User
     */
    public function updateProfile(ProfileRequest $request, User $user)
    {
        $result = $user->update([
            'username' => $request->username ?? $user->username,
            'avatar_id' => $request->avatar_id
        ]);

        if ($result) {
            return $user;
        }

        throw new \DomainException('Error updating profile!');
    }

    /**
     * Удалить юзера
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
    public function findByEmailOrUsername(string $search_request,$return_builder = false)
    {
        $query = $this->model->where('email', 'like', "%$search_request%")
            ->orWhere('username', 'like', "%$search_request%");

        if($return_builder){
            return $query;
        }

        return $query->first();
    }
}
