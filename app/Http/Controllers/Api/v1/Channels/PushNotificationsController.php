<?php

namespace App\Http\Controllers\Api\v1\Channels;

use App\Http\Resources\v1\User\UserPushResource;
use App\Repositories\Channels\ChannelRepository;
use App\Services\Channels\PushNotificationsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PushNotificationsController extends Controller
{
    /**
     * @var PushNotificationsService
     */
    private $pushService;

    /**
     * PushNotificationsController constructor.
     * @param PushNotificationsService $service
     */
    public function __construct(PushNotificationsService $service)
    {
        $this->pushService = $service;
    }

    /**
     * Подписка на пуши
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe(Request $request,$id)
    {
        try {
            $this->pushService->subscribe($request->endpoint,$id);

            return response()->json(['success'=>true], 200);;
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'error'=>$e->getMessage()], 200);
        }
    }

    /**
     * Отписка от пушей
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function unSubscribe(Request $request,$id)
    {
        try {
            $this->pushService->unsubscribe($request->endpoint,$id);

            return response()->json(['success'=>true], 200);;
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'error'=>$e->getMessage()], 200);
        }
    }

    /**
     * Пользователи канала для отправки пуш уведомлений
     * @param ChannelRepository $repository
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getUsersToPush(ChannelRepository $repository,$id)
    {
       $users = $repository->getUsersToPush($id);
       return UserPushResource::collection($users);
    }
}
