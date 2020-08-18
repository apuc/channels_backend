<?php

namespace App\Http\Controllers\Api\v1\Channels;

use App\Http\Requests\ChannelRequest;
use App\Http\Requests\Channels\InviteRequest;
use App\Http\Requests\Files\AvatarRequest;
use App\Http\Resources\v1\AvatarResource;
use App\Http\Resources\v1\ChannelResource;
use App\Http\Resources\v1\Channels\FullChannelResource;
use App\Http\Resources\v1\MessageResource;
use App\Http\Resources\v1\User\FullUserResource;
use App\Models\Avatar;
use App\Repositories\Channels\ChannelRepository;
use App\Services\Channels\ChannelService;
use App\Services\Files\AvatarService;
use DB;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Channels\AddIntegrationRequest;
use App\Http\Requests\DialogRequest;
use App\Http\Resources\v1\Integrations\IntegrationResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ChannelsController extends Controller
{
    /**
     * @var ChannelService
     */
    protected $channelService;

    /**
     * @var AvatarService
     */
    protected $avatarService;

    /**
     * @var ChannelRepository
     */
    protected $channelRepository;

    /**
     * ChannelsController constructor.
     * @param ChannelService $service
     * @param ChannelRepository $groupsRepository
     * @param AvatarService $avatarService
     */
    public function __construct(
        ChannelService $service,
        ChannelRepository $groupsRepository,
        AvatarService $avatarService
    )
    {
        $this->channelService = $service;
        $this->channelRepository = $groupsRepository;
        $this->avatarService = $avatarService;

        $this->middleware('owner:channel', ['only' => [
            'update',
            'destroy',
            'addIntegration',
            'removeIntegration',
        ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index()
    {
        try {
            $channels = $this->channelRepository->findByUser(Auth::id());

            return ChannelResource::collection($channels);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Каналы для главной
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function popular()
    {
        try {
            $channels = $this->channelRepository->findPopular();

            return ChannelResource::collection($channels);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * @param AvatarRequest $request
     * @return AvatarResource|JsonResponse
     */
    public function avatar(AvatarRequest $request)
    {
        try {
            $avatarRequest = $this->avatarService->upload($request->file('avatar'), 'channel');
            $avatar = $this->avatarService->save($avatarRequest);

            return new AvatarResource($avatar);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param ChannelRequest $request
     * @return ChannelResource|JsonResponse
     * @throws Throwable
     */
    public function store(ChannelRequest $request)
    {
        try {
            $channel = $this->channelService->create($request);

            return new ChannelResource($channel);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return ChannelResource|JsonResponse
     */
    public function show($id)
    {
        try {
            $channel = $this->channelRepository->findOrFail($id);

            return new ChannelResource($channel);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Полная инфа о канале
     *
     * @param Request $request
     *
     * @return FullChannelResource|JsonResponse
     */
    public function showFull(Request $request)
    {
        try {
            //канал добавляется в реквест в миделваре
            return new FullChannelResource($request->channel);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ChannelRequest $request
     * @param int $id
     * @return ChannelResource|JsonResponse
     */
    public function update(ChannelRequest $request, $id)
    {
        try {
            $channel = $this->channelRepository->findOneWithTrashed($id);
            $channel = $this->channelService->update($request, $channel);

            return new ChannelResource($channel);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse|Response
     */
    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $channel = $this->channelRepository->findById($id);
                $this->channelService->destroy($channel);

                if ( $channel->avatar ) {
                    $this->avatarService->destroy($channel->avatar);
                }
            });

            return response()->json(['msg' => 'success'], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['msg' => 'Channel not found'], 404);
        } catch (Throwable $e) {
            if ( config('app.debug') ) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return response()->json(['error' => 'Server error'], 500);
        }
    }

    /**
     * @param Request $request
     * @return ChannelResource|JsonResponse
     */
    public function addUser(Request $request)
    {
        try {
            $channel = $this->channelService->addUser($request);

            return new ChannelResource($channel);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function deleteUser(Request $request)
    {
        try {
            $this->channelService->deleteUser($request);
            return response()->json(['msg' => 'success'], 204);
        } catch (Throwable $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function usersList($id)
    {
        try {
            $channel = $this->channelRepository->findById($id);
            return FullUserResource::collection($channel->users);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function messagesList(Request $request)
    {
        try {
            //канал добавляется в реквест в миделваре
            $messages = $this->channelRepository->getChannelMessages($request->channel);

            return MessageResource::collection($messages);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * @param $id
     * @return ResponseFactory|Application|JsonResponse|Response
     */
    public function delava($id)
    {
        try {
            $avatar = Avatar::where('avatar_id', $id)->first();
            $this->avatarService->destroy($avatar);

            return response('',Response::HTTP_NO_CONTENT);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Добавление интеграции в канал
     *
     * @param AddIntegrationRequest $request
     * @param $id
     *
     * @return IntegrationResource|JsonResponse
     */
    public function addIntegration(AddIntegrationRequest $request, $id)
    {
        try {
            $integration = $this->channelService->addIntegration($request, $id);

            return new IntegrationResource($integration);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Удаление интеграции из канала
     *
     * @param $channel
     * @param $integration
     *
     * @return JsonResponse
     */
    public function removeIntegration($channel, $integration)
    {
        try {
            $this->channelService->removeIntegration($channel, $integration);

            return response()->json(['msg' => 'success'], 200);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Приглашение юзера в канал по email
     *
     * @param InviteRequest $request
     * @param $channel
     *
     * @return FullUserResource|JsonResponse
     */
    public function inviteByEmail(InviteRequest $request, $channel)
    {
        try {
            $user = $this->channelService->addUserByEmail($request->email, intval($channel));

            return new FullUserResource($user);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Создать диалог
     *
     * @param DialogRequest $request
     *
     * @return ChannelResource|JsonResponse
     */
    public function createDialog(DialogRequest $request)
    {
        try {
            $channel = $this->channelService->createDialog($request);

            return new ChannelResource($channel);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Список интеграций канала
     *
     * @param $id
     *
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function integrationsList($id)
    {
        try {
            $channel = $this->channelRepository->findById($id);

            return IntegrationResource::collection($channel->integrations);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
