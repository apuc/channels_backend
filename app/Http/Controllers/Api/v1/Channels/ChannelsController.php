<?php

namespace App\Http\Controllers\Api\v1\Channels;

use App\Http\Resources\v1\ChannelResource;
use App\Repositories\Channels\ChannelRepository;
use App\Services\Channels\ChannelService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelsController extends Controller
{
    /**
     * @var ChannelService
     */
    protected $channelService;
    /**
     * @var ChannelRepository
     */
    protected $channelRepository;

    public function __construct(ChannelService $service, ChannelRepository $groupsRepository)
    {
        $this->channelService   = $service;
        $this->channelRepository = $groupsRepository;
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
}
