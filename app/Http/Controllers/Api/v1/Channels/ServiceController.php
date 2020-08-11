<?php

namespace App\Http\Controllers\Api\v1\Channels;

use App\Http\Resources\v1\Channels\Service\LeftSideBarResource;
use App\Repositories\Channels\ChannelRepository;
use App\Repositories\Channels\GroupsRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
     * @return array
     */
    public function leftSideBar()
    {
        $groups = $this->groupRepository->findByUser(Auth::id(), true);
        $channels = $this->channelRepository->findByUser(Auth::id());
        $union = $groups->merge($channels);

        return (new LeftSideBarResource($union->first()))->getResponse($union);
    }
}
