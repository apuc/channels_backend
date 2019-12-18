<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Bot\BotMessageRequest;
use App\Models\Channels\Channel;
use App\Models\Channels\Group;
use App\Models\Channels\Message;
use App\Models\User;
use App\Services\Users\BotService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $groupsCount = Group::count();
        $usersCount = User::where('is_bot','<>',User::BOT)->count();
        $botsCount = User::where('is_bot',User::BOT)->count();
        $channelsCount = Channel::count();
        $messagesCount = Message::count();

        return view('admin.dashboard.index', compact('groupsCount', 'usersCount', 'channelsCount','messagesCount','botsCount'));
    }

    /**
     * Тест бота
     * @param Request $request
     * @param BotService $botService
     */
    public function bot(Request $request,BotService $botService)
    {
        $botService->sendBotMessage(new BotMessageRequest([
            'bot_id'=>54,
            'channel_id'=>206,
            'message'=>"{$request->data['from']['username']} сказал: '{$request->data['text']}'"
        ]));
    }
}
