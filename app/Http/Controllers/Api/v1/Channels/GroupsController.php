<?php

namespace App\Http\Controllers\Api\v1\Channels;

use App\Http\Requests\Channels\GroupRequest;
use App\Http\Requests\SmartRequest;
use App\Http\Resources\v1\AvatarResource;
use App\Http\Resources\v1\GroupsResource;
use App\Models\Avatar;
use App\Models\Channels\Group;
use App\Http\Controllers\Controller;
use App\Repositories\Channels\GroupsRepository;
use App\Services\Channels\GroupsService;
use App\Services\Files\AvatarService;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    /**
     * @var GroupsService
     */
    protected $groupsService;

    /**
     * @var GroupsRepository
     */
    protected $groupRepository;

    /**
     * @var AvatarService
     */
    protected $avatarService;

    public function __construct(GroupsService $service, GroupsRepository $groupsRepository, AvatarService $avatarService)
    {
        $this->groupsService = $service;
        $this->groupRepository = $groupsRepository;
        $this->avatarService = $avatarService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $groups = \Auth::user()->groups;

        return GroupsResource::collection($groups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
        try {
            $group = $this->groupsService->create($request);

            return new GroupsResource($group);
        } catch (\Throwable $e) {
            abort(500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = $this->groupRepository->findOneWithTrashed($id);

        return view('admin.groups.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param   $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = $this->groupRepository->findOneWithTrashed($id);

        return view('admin.groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  GroupRequest $request
     * @param  int $id
     * @return GroupsResource
     */
    public function update(GroupRequest $request, $id)
    {
        try {
            $group = $this->groupRepository->findOneWithTrashed($id);
            $group = $this->groupsService->update($request, $group);

            return new GroupsResource($group);
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
            $group = $this->groupRepository->findOneWithTrashed($id);
            $this->groupsService->destroy($group);
            $this->avatarService->destroy($group->avatar);

            return response()->json(['msg' => 'success'], 204);
        } catch (\Throwable $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function avatar(Request $request)
    {
        //dd($request->file('avatar')->getClientOriginalExtension());
        $avatarRequest = $this->avatarService->upload($request->file('avatar'), 'group');
        $avatar = $this->avatarService->save($avatarRequest);

        return new AvatarResource($avatar);
    }

    public function delava($id)
    {
        $avatar = Avatar::where('avatar_id', $id)->first();
        $this->avatarService->destroy($avatar);
    }
}
