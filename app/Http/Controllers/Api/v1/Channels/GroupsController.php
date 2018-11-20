<?php

namespace App\Http\Controllers\Api\v1\Channels;

use App\Http\Requests\Channels\GroupRequest;
use App\Http\Requests\Channels\Groups\AttachChannelsRequest;
use App\Http\Requests\Files\AvatarRequest;
use App\Http\Resources\v1\AvatarResource;
use App\Http\Resources\v1\GroupsResource;
use App\Models\Avatar;
use App\Models\Channels\Group;
use App\Http\Controllers\Controller;
use App\Repositories\Channels\GroupsRepository;
use App\Services\Channels\GroupsService;
use App\Services\Files\AvatarService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * Store a newly created resource in storage.
     *
     * @param  GroupRequest $request
     * @return GroupsResource
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
     * @return GroupsResource
     */
    public function show($id)
    {
        $group = $this->groupRepository->findOneWithTrashed($id);

        return new GroupsResource($group);
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
            \DB::transaction(function () use ($id){
                $group = $this->groupRepository->findById($id);
                $this->groupsService->destroy($group);

                if ($group->avatar) {
                    $this->avatarService->destroy($group->avatar);
                }
            });

            return response()->json(['msg' => 'success'], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['msg' => 'Group not found'], 404);
        } catch (\Throwable $e) {
            if (config('app.debug')) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return response()->json(['error' => 'Server error'], 500);
        }
    }

    /**
     * @param AvatarRequest $request
     * @return AvatarResource
     */
    public function avatar(AvatarRequest $request)
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

    /**
     * Добавление каналов в группу
     *
     * @param AttachChannelsRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function channels(AttachChannelsRequest $request, $id)
    {
        try {
            $group = $this->groupRepository->findById($id);
            $this->groupsService->attachChannels($group, $request->channel_ids);

            return response()->json([], 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
