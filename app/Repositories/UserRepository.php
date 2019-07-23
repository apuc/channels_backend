<?php
namespace App\Repositories;
use App\Http\Requests\Api\v1\Auth\RegistrationRequest;
use App\Models\User;

/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 29.09.18
 * Time: 16:29
 */

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

    public function register(RegistrationRequest $request)
    {
        return $this->model::create([
            'email' => $request->email,
            'login' => $request->login,
            'username' => ($request->username) ?: $request->login,
            'password' => $request->password,
        ]);
    }

}
