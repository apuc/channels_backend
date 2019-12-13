<?php

namespace App\Http\Middleware\Bot;

use App\Repositories\Channels\ChannelRepository;
use App\Repositories\Users\UserRepository;
use Closure;

class BotApiMiddleware
{
    /**
     * @var ChannelRepository
     */
    private $channelRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    private const ERROR_MESSAGE = 'Bot not found or bot is not in channel!';

    /**
     * BotApiMiddleware constructor.
     * @param ChannelRepository $channelRepository
     * @param UserRepository $userRepository
     */
    public function __construct(ChannelRepository $channelRepository,UserRepository $userRepository)
    {
        $this->channelRepository = $channelRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
         try{
             $channel = $this->channelRepository->findById($request->channel_id);
             $user = $this->userRepository->findById($request->bot_id);

             if(!$user->isBot() || !$channel->users()->where('users.user_id',$user->user_id)->exists()){
                 return abort(403,self::ERROR_MESSAGE);
             }

             return $next($request);

         }catch (\Throwable $e){
             return abort(403,self::ERROR_MESSAGE);
         }
    }
}
