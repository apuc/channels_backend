<?php

namespace App\Http\Controllers\Admin\Channels;

use App\Http\Requests\Channels\GroupRequest;
use App\Models\Channels\Group;
use App\Http\Controllers\Controller;
use App\Repositories\Channels\GroupsRepository;
use App\Services\Channels\GroupsService;

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

    public function __construct(GroupsService $service, GroupsRepository $groupsRepository)
    {
        $this->groupsService   = $service;
        $this->groupRepository = $groupsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::withTrashed()->paginate(10);
//

        //$groups = \Auth::user()->groups()->paginate();
        return view('admin.groups.index', compact('groups'));
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

            return redirect(route('group.show', $group))
                ->with(['success' => 'Успешно создано']);
        } catch (\Throwable $e) {
            return back()->with(['error' => $e->getMessage()]);
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
     * @return \Illuminate\Http\Response
     */
    public function update(GroupRequest $request, $id)
    {
        try {
            $group = $this->groupRepository->findOneWithTrashed($id);
            $group = $this->groupsService->update($request, $group);

            return redirect(route('group.show', $group))
                ->with(['success' => 'Успешно создано']);
        } catch (\Throwable $e) {
            return back()->with(['error' => $e->getMessage()]);
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

            return redirect(route('group.index'))
                ->with(['success' => 'Группа успешно удалена']);
        } catch (\Throwable $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }
}
