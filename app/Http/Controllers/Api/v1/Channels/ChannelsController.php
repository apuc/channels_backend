<?php

namespace App\Http\Controllers\Api\v1\Channels;

use App\Http\Requests\ChannelRequest;
use App\Http\Requests\Channels\User\AddRequest;
use App\Http\Requests\Files\AvatarRequest;
use App\Http\Resources\v1\AvatarResource;
use App\Http\Resources\v1\ChannelResource;
use App\Http\Resources\v1\GroupsResource;
use App\Http\Resources\v1\MessageResource;
use App\Http\Resources\v1\UserResource;
use App\Models\Avatar;
use App\Models\Channels\Channel;
use App\Repositories\Channels\ChannelRepository;
use App\Services\Channels\ChannelService;
use App\Services\Files\AvatarService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function __construct(ChannelService $service, ChannelRepository $groupsRepository, AvatarService $avatarService)
    {
        $this->channelService = $service;
        $this->channelRepository = $groupsRepository;
        $this->avatarService = $avatarService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $channels = \Auth::user()->channels;

        return ChannelResource::collection($channels);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function avatar(AvatarRequest $request)
    {
        //dd($request->file('avatar')->getClientOriginalExtension());
        $avatarRequest = $this->avatarService->upload($request->file('avatar'), 'channel');
        $avatar = $this->avatarService->save($avatarRequest);

        return new AvatarResource($avatar);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ChannelRequest $request
     * @return ChannelResource
     */
    public function store(ChannelRequest $request)
    {
        try {
            $channel = $this->channelService->create($request);

            return new ChannelResource($channel);
        } catch (\Throwable $e) {
            abort(500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return ChannelResource
     */
    public function show($id)
    {
        $channel = $this->channelRepository->findOneWithTrashed($id);

        return new ChannelResource($channel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ChannelRequest $request
     * @param  int $id
     * @return ChannelResource
     */
    public function update(ChannelRequest $request, $id)
    {
        try {
            $channel = $this->channelRepository->findOneWithTrashed($id);
            $channel = $this->channelService->update($request, $channel);

            return new ChannelResource($channel);
        } catch (\Throwable $e) {
            abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            \DB::transaction(function () use ($id) {
                $channel = $this->channelRepository->findById($id);
                $this->channelService->destroy($channel);

                if ($channel->avatar) {
                    $this->avatarService->destroy($channel->avatar);
                }
            });

            return response()->json(['msg' => 'success'], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['msg' => 'Channel not found'], 404);
        } catch (\Throwable $e) {
            if (config('app.debug')) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return response()->json(['error' => 'Server error'], 500);
        }
    }

    /**
     * @param AddRequest $request
     * @return ChannelResource
     */
    public function addUser(AddRequest $request)
    {
        $channel = $this->channelService->addUser($request);
        return new ChannelResource($channel);
    }

    /**
     * @param AddRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function deleteUser(AddRequest $request)
    {
        try {
            $this->channelService->deleteUser($request);
            return response()->json(['msg' => 'success'], 204);
        } catch (\Throwable $e) {
            return back()->with(['error' => $e->getMessage()]);
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function usersList($id)
    {
        $channel = $this->channelRepository->findById($id);
        return UserResource::collection($channel->users);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function messagesList($id)
    {
        $channel = $this->channelRepository->findById($id);
        return MessageResource::collection($channel->messages);
    }

    public function delava($id)
    {
        $avatar = Avatar::where('avatar_id', $id)->first();
        $this->avatarService->destroy($avatar);
    }
}
