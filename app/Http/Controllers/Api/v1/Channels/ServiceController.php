<?php

namespace App\Http\Controllers\Api\v1\Channels;

use App\Http\Resources\v1\Channels\Service\LeftSideBarResource;
use App\Repositories\Channels\ChannelRepository;
use App\Repositories\Channels\GroupsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ServiceController
 * @package App\Http\Controllers\Api\v1\Channels
 */
class ServiceController extends Controller
{
    /**
     * @var GroupsRepository
     */
    protected $groupRepository;

    /**
     * @var ChannelRepository
     */
    protected $channelRepository;

    /**
     * ServiceController constructor.
     * @param GroupsRepository $groupRepository
     * @param ChannelRepository $channelRepository
     */
    public function __construct(GroupsRepository $groupRepository, ChannelRepository $channelRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->channelRepository = $channelRepository;
    }

    /**
     * Метод для получения левого меню
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function leftSideBar()
    {
        $groups = $this->groupRepository->findByUser(\Auth::id(), true);
        $channels = $this->channelRepository->findByUserWithoutGroups(\Auth::id());

        $union = $groups->merge($channels);

        return LeftSideBarResource::collection($union);
    }
}
