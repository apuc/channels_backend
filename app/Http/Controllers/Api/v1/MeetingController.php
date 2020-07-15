<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\MeetingRequest;
use App\Http\Resources\v1\MeetingResource;
use App\Services\MeetingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Throwable;

class MeetingController extends Controller
{
    /**
     * @var MeetingService
     */
    private $meetingService;

    /**
     * MeetingController constructor.
     * @param MeetingService $meetingService
     */
    public function __construct(MeetingService $meetingService)
    {
        $this->meetingService = $meetingService;
    }

    /**
     * @param MeetingRequest $request
     * @return MeetingResource|JsonResponse
     */
    public function store(MeetingRequest $request)
    {
        try {
            $meeting = $this->meetingService->createMeeting($request);

            return new MeetingResource($meeting);
        } catch (Throwable $e) {
            return Response::json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @param $token
     * @return MeetingResource|JsonResponse|\Illuminate\Http\Response|Response
     */
    public function show($token)
    {
        try {
            $meeting = $this->meetingService
                ->getRepository()
                ->checkByToken($token);

            if(!$meeting){
                return Response::make('not found', 404);
            }

            return new MeetingResource($meeting);
        } catch (Throwable $e) {
            return Response::json(['error' => $e->getMessage()], 500);
        }
    }
}
