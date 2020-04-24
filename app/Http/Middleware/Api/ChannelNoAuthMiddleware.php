<?php
namespace App\Http\Middleware\Api;

use App\Repositories\Channels\ChannelRepository;
use Closure;
use Illuminate\Http\Request;

class ChannelNoAuthMiddleware
{
    /**
     * @var ChannelRepository
     */
    private $channelRepository;

    /**
     * ChannelNoAuthMiddleware constructor.
     *
     * @param ChannelRepository $channelRepository
     */
    public function __construct(ChannelRepository $channelRepository)
    {
        $this->channelRepository = $channelRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $channel = $this->channelRepository->findOrFail($request->route('id'));
        $user = auth('api')->user();

        if($user === null && ($channel->isPrivate() || $channel->isDialog()) ){
            return abort(403,'Not authorized!');
        }

        $request->merge(['channel'=>$channel]);
        return $next($request);
    }
}
