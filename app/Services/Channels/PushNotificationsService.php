<?php
namespace App\Services\Channels;
use App\Repositories\Users\UserRepository;
use Illuminate\Support\Facades\Auth;

class PushNotificationsService
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
     * Подписка на пуши
     * @param string $subscriptionData
     * @param int $userId
     */
    public function subscribe(string $subscriptionData,int $userId)
    {
        $user = $this->repository->findById($userId);
        $endpointsCount = $user->pushEndpoints->count();
        $user->pushEndpoints->offsetSet($endpointsCount,json_decode($subscriptionData));
        $user->save();
    }

    /**
     * Отписка от пушей
     * @param string $subscriptionData
     * @param int $userId
     * @return bool
     * @throws \Exception
     */
    public function unsubscribe(string $subscriptionData,int $userId)
    {
        $user = $this->repository->findById($userId);
        $data = json_decode($subscriptionData,true);

        foreach ($user->pushEndpoints->all() as $key=>$subscription){
            if($subscription['endpoint'] == $data['endpoint']){
                $user->pushEndpoints->offsetUnset($key);

                if($user->pushEndpoints->count() == 0){
                    $user->push_endpoints = null;
                }

                $user->save();
                return true;
            }
        }

        throw new \Exception("Subscription not found!");
    }
}
