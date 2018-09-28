<?php

namespace App\Http\Controllers\Admin\Channels;

use App\Models\Channels\Channel;
use App\Repositories\Channels\ChannelRepository;
use App\Services\Channels\ChannelService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelController extends Controller
{
    /**
     * @var ChannelService
     */
    protected $channelService;
    /**
     * @var ChannelRepository
     */
    protected $channelRepository;

    public function __construct(ChannelService $service, ChannelRepository $channelRepository)
    {
        $this->channelService   = $service;
        $this->channelRepository = $channelRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $channels = Channel::withTrashed()->paginate(10);

        return view('admin.channel.index', compact('channels'));
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $channel = $this->channelRepository->findOneWithTrashed($id);

        return view('admin.channel.show', compact('channel'));
    }
}
