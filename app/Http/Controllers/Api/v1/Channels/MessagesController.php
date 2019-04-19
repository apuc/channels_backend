<?php

namespace App\Http\Controllers\Api\v1\Channels;

use App\Http\Requests\Channels\MessageRequest;
use App\Http\Resources\v1\MessageResource;
use App\Services\Channels\NotificationService;
use App\Repositories\Channels\MessageRepository;
use App\Services\Channels\MessageService;
use App\Http\Controllers\Controller;
use\Illuminate\Http\Response;

class MessagesController extends Controller
{
    /**
     * @var MessageService
     */
    protected $messageService;

    /**
     * @var NotificationService
     */
    protected $notificationService;

    /**
     * @var MessageRepository
     */
    protected $messageRepository;

    /**
     * MessagesController constructor.
     *
     * @param NotificationService $notificationService
     * @param MessageService $messageService
     * @param MessageRepository $messageRepository
     */
    public function __construct(NotificationService $notificationService,MessageService $messageService, MessageRepository $messageRepository)
    {
        $this->messageService = $messageService;
        $this->notificationService = $notificationService;
        $this->messageRepository = $messageRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MessageRequest  $request
     *
     * @return MessageResource
     */
    public function store(MessageRequest $request)
    {
        try {
            $message = $this->messageService->create($request);
            $this->notificationService->create($message->message_id,$message->channel_id);
            return new MessageResource($message);
        } catch (\Throwable $e) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return MessageResource
     */
    public function show($id)
    {
        $message = $this->messageRepository->findById($id);

        return new MessageResource($message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MessageRequest $request
     * @param  int  $id
     *
     * @return MessageResource
     */
    public function update(MessageRequest $request, $id)
    {
        $message = $this->messageRepository->findById($id);
        $message = $this->messageService->update($request, $message);

        return new MessageResource($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $message = $this->messageRepository->findById($id);
            $this->messageService->destroy($message);

            return response()->json(['msg' => 'success'], Response::HTTP_NO_CONTENT);
        } catch (\Throwable $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }
}
