<?php

namespace App\Http\Controllers\Admin\Channels;

use App\Http\Requests\ChannelRequest;
use App\Models\Channels\Channel;
use App\Repositories\Channels\ChannelRepository;
use App\Services\Channels\ChannelService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;

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
        $this->channelService = $service;
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

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $channel = $this->channelRepository->findOneWithTrashed($id);
            $this->channelService->destroy($channel);

            return redirect(route('channel.index'))
                ->with(['success' => 'Канал успешно удален']);
        } catch (\Throwable $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.channel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ChannelRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChannelRequest $request)
    {
        try {
            $channel = $this->channelService->create($request);

            return redirect(route('channel.show', $channel))
                ->with(['success' => 'Успешно создано']);
        } catch (\Throwable $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

}
