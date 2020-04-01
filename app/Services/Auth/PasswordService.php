<?php


namespace App\Services\Auth;


use App\Notifications\PasswordReset;
use App\Repositories\Users\UserRepository;

class PasswordService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * PasswordService constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->userRepository = $repository;
    }

    /**
     * Запрос восстановления пароля
     * @param string $email
     */
    public function requestReset(string $email)
    {
        $user = $this->userRepository->findByEmailOrUsername($email);
        $user->generatePasswordResetToken();
        $user->save();

        $user->notify(new PasswordReset($user->reset_token));
    }

    /**
     * Восстановление пароля
     * @param string $token
     * @param string $password
     */
    public function resetPassword(string $token,string $password)
    {
        $user = $this->userRepository->findByResetToken($token);
        $user->password = bcrypt($password);
        $user->reset_token = null;
        $user->save();
    }
}
