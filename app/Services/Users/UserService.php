<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 16.10.18
 * Time: 16:48
 */

namespace App\Services\Users;


use App\Http\Requests\Users\UserRequest;
use App\Models\User;
use App\Repositories\Users\UserRepository;

class UserService
{

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * Construct for User service
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Method for create user
     *
     * @param UserRequest $request
     * @return User
     */
    public function create(UserRequest $request) :User
    {
        return $this->repository->create($request);
    }

    /**
     * Method for update user
     *
     * @param UserRequest $request
     * @param User $user
     * @return User
     */
    public function update(UserRequest $request, User $user): User
    {
        return $this->repository->update($request, $user);
    }

    /**
     * Method for destroy user
     *
     * @param User $user
     * @return bool
     */
    public function destroy(User $user)
    {
        return $this->repository->destroy($user);
    }

}