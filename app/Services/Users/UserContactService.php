<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 05.12.18
 * Time: 17:37
 */

namespace App\Services\Users;


use App\Http\Requests\Users\ContactRequest;
use App\Models\User\UserContact;
use App\Repositories\Users\UserContactRepository;

class UserContactService
{

    /**
     * @var UserContactRepository
     */
    protected $repository;

    /**
     * Construct for User service
     *
     * @param UserContactRepository $repository
     */
    public function __construct(UserContactRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Method for create user
     *
     * @param ContactRequest $request
     * @return UserContact
     */
    public function create(ContactRequest $request): UserContact
    {
        return $this->repository->create($request);
    }

    /**
     * Method for update user
     *
     * @param UserContact $userContact
     * @return UserContact
     */
    public function confirm(UserContact $userContact): UserContact
    {
        return $this->repository->confirm(UserContact::REQUEST_ACCEPTED, $userContact);
    }

    /**
     * Method for destroy user
     *
     * @param UserContact $userContact
     * @return UserContact
     */
    public function reject(UserContact $userContact)
    {
        return $this->repository->reject(UserContact::REQUEST_REJECTED, $userContact);
    }

}