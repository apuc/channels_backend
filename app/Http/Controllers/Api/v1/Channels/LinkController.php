<?php

namespace App\Http\Controllers\Api\v1\Channels;

use App\Http\Controllers\Controller;
use App\Http\Requests\Channels\LinkRequest;
use App\Http\Resources\v1\ChannelResource;
use App\Http\Resources\v1\LinkResource;
use App\Models\Channels\Message;
use App\Services\Channels\LinkService;
use DiDom\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LinkController extends Controller
{
    /**
     * @var LinkService
     */
    private $linkService;

    /**
     * LinkController constructor.
     * @param LinkService $linkService
     */
    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    /**
     * Обработка простого урла
     *
     * @param LinkRequest $request
     * @return LinkResource
     */
    public function singleLink(LinkRequest $request)
    {
        try{
            $link = $this->linkService->grabMeta($request->link);

            return new LinkResource($link);
        } catch (\Throwable $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Обработка текста с урлами
     *
     * @param LinkRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function textLink(LinkRequest $request)
    {
        try{
            $links = $this->linkService->parse($request->link);

            return LinkResource::collection($links);
        } catch (\Throwable $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
