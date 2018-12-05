<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 05.12.18
 * Time: 17:31
 */

namespace App\Repositories\Users;


use App\Http\Requests\Users\ContactRequest;
use App\Models\User\UserContact;

class UserContactRepository
{
    protected $model;

    /**
     * GroupsRepository constructor.
     * @param UserContact $userContact
     */
    public function __construct(UserContact $userContact)
    {
        $this->model = $userContact;
    }

    /**
     * @param ContactRequest $request
     * @return UserContact
     */
    public function create(ContactRequest $request)
    {
        return $this->model::create([
            'user_id' => $request->user_id,
            'contact_id' => $request->contact_id,
            'status' => UserContact::REQUEST_SENT,
        ]);
    }

    /**
     * @param string $status
     * @param UserContact $userContact
     * @return UserContact
     * @throws \DomainException
     */
    protected function changeStatus(string $status, UserContact $userContact)
    {
        $result = $userContact->update([
            'status' => $status,
        ]);

        if ($result) {
            return $userContact;
        }

        throw new \DomainException('Error updating channel');
    }

    /**
     * @param string $status
     * @param UserContact $userContact
     * @return UserContact
     * @throws \DomainException
     */
    public function confirm(string $status, UserContact $userContact): UserContact
    {
        return $this->changeStatus($status, $userContact);
    }

    /**
     * Method for destroy group
     *
     * @param string $status
     * @param UserContact $userContact
     * @return UserContact
     * @throws \DomainException
     */
    public function reject(string $status, UserContact $userContact): UserContact
    {
        return $this->changeStatus($status, $userContact);
    }

    /**
     * @param int $user_id
     * @param int $contact_id
     * @return UserContact|null
     */
    public function findByPrimary(int $user_id, int $contact_id):?UserContact
    {
        return $this->model::where(['user_id' => $user_id, 'contact_id' => $contact_id])->firstOrFail();
    }

}