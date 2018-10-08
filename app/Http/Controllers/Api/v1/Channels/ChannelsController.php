<?php

namespace App\Http\Controllers\Api\v1\Channels;

use App\Http\Resources\v1\AvatarResource;
use App\Http\Resources\v1\ChannelResource;
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
}
