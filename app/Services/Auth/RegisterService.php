<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 29.09.18
 * Time: 16:39
 */

namespace App\Services\Auth;


use App\Http\Requests\Api\v1\Auth\RegistrationRequest;
use App\Repositories\Users\UserRepository;
use Illuminate\Database\Eloquent\Model;

class RegisterService
{

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * Construct for Group service
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param RegistrationRequest $request
     * @return $this|Model
     */
    public function register(RegistrationRequest $request)
    {
        return $this->repository->create($request);
    }

}
