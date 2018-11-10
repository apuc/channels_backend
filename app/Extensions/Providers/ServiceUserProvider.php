<?php
/**
 *
 */

namespace App\Extensions\Providers;


use App\Extensions\Models\ServiceAuth;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class ServiceUserProvider implements UserProvider
{
    /**
     * The User Model
     */
    private $model;

    /**
     * The ServiceAuth Model
     */
    private $serviceModel;

    /**
     * Create a new user provider.
     * @param User $userModel
     * @param ServiceAuth $serviceAuth
     * @return void
     */
    public function __construct(User $userModel, ServiceAuth $serviceAuth)
    {
        $this->model = $userModel;
        $this->serviceModel = $serviceAuth;
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials)) {
            return null;
        }

        $existService = $this->serviceModel->fetchService($credentials['service_id'], $credentials['service_token']);

        if (!$existService) {
            return null;
        }

        $user = $this->model->fetchUserByCredentials(['id' => $credentials['user_id']]);

        return $user;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials  Request credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, Array $credentials)
    {
        return ($credentials['user_id'] == $user->getAuthIdentifier());
    }

    public function retrieveById($identifier) {}

    public function retrieveByToken($identifier, $token) {}

    public function updateRememberToken(Authenticatable $user, $token) {}

}