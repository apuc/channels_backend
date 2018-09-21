<?php

namespace App\Http\Controllers\Admin\Channels;

use App\Http\Requests\Channels\GroupRequest;
use App\Models\Channels\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Channels\GroupsService;

class GroupsController extends Controller
{

    protected $groupsService;

    public function __construct(GroupsService $service)
    {
        $this->groupsService = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::withTrashed()->paginate(10);

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
     * @param  Group $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
