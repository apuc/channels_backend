<?php

namespace App\Extensions\Guards;


use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class ServiceGuard implements Guard
{
    protected $request;
    protected $provider;
    protected $user;

    /**
     * Create a new authentication guard.
     *
     * @param  \Illuminate\Contracts\Auth\UserProvider $provider
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(UserProvider $provider, Request $request)
    {
        $this->request = $request;
        $this->provider = $provider;
        $this->user = NULL;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return !is_null($this->user());
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return !$this->check();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        if ($this->validate()) {
            return $this->user;
        }

        return null;
    }

    /**
     * Get params from the current request
     *
     * @return string
     */
    public function getParams()
    {
        $data['service_id'] = $this->request->header('Service-Auth-Name');
        $data['service_token'] = $this->request->header('Service-Auth-Access-Token');
        $data = array_merge($data, $this->request->only('user_id'));

        return empty($data) ? null : $data;
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return string|null
     */
    public function id()
    {
        if ($user = $this->user()) {
            return $this->user()->getAuthIdentifier();
        }

        return null;
    }

    /**
     * Validate a user's credentials.
     * @param array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        if (empty($credentials['service_id']) || empty($credentials['service_token']) || empty($credentials['user_id'])) {
            if (!$credentials = $this->getParams()) {
                return false;
            }
        }

        $user = $this->provider->retrieveByCredentials($credentials);

        if (!is_null($user) && $this->provider->validateCredentials($user, $credentials)) {
            $this->setUser($user);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Set the current user.
     *
     * @param  Authenticatable $user User info
     * @return self
     */
    public function setUser(Authenticatable $user)
    {
        $this->user = $user;

        return $this;
    }
}
