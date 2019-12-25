<?php

namespace App\Http\Middleware\Api;

use Closure;
use App\Repositories\Channels\ChannelRepository;
use App\Repositories\Channels\GroupsRepository;
use Illuminate\Support\Facades\Auth;

class OwnerMiddleware
{
    private const ERROR_MESSAGE = 'You are not the owner of the entity!';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$type)
    {
        $repo = app()->make('App\Repositories\Channels\\'.ucfirst($type).'Repository');
        $id = $this->{'get'.ucfirst($type).'Id'}($request);
        $entity = $repo->findByid($id);

        if($entity->owner_id == Auth::id()){
            return $next($request);
        }

        return abort(403,self::ERROR_MESSAGE);
    }

    private function getGroupsId($request)
    {
        return $request->route('group') ?? $request->route('group_id');
    }

    private function getChannelId($request)
    {
        return (int)$request->channel_id ?? $request->route('channel');
    }
}
