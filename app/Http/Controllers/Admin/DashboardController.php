<?php

namespace App\Http\Controllers\Admin;

use App\Models\Channels\Channel;
use App\Models\Channels\Group;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $groupsCount = Group::count();
        $usersCount = User::count();
        $channelsCount = Channel::count();


        return view('admin.dashboard.index', compact('groupsCount', 'usersCount', 'channelsCount'));
    }
}
