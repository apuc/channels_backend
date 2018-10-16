<?php

namespace App\Http\Controllers\Api\v1\Channels;

use App\Http\Requests\ChannelRequest;
use App\Http\Resources\v1\AvatarResource;
use App\Http\Resources\v1\ChannelResource;
use App\Http\Resources\v1\GroupsResource;
use App\Models\Channels\Channel;
use App\Repositories\Channels\ChannelRepository;
use App\Services\Channels\ChannelService;
use App\Services\Files\AvatarService;
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
    public function avatar(Request $request)
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
        } catch (\Throwable $e){
            abort(500);
        }
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
        } catch (\Throwable $e){
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
            $group = $this->channelRepository->findOneWithTrashed($id);
            $this->channelService->destroy($group);

            return response()->json(['msg' => 'success'], 204);
        } catch (\Throwable $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }
}
