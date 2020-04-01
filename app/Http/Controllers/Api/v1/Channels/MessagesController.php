<?php

namespace App\Http\Controllers\Api\v1\Channels;

use App\Http\Requests\Channels\MessageRequest;
use App\Http\Requests\Channels\Messages\MarkReadRequest;
use App\Http\Resources\v1\MessageResource;
use App\Repositories\Channels\MessageRepository;
use App\Services\Channels\MessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Throwable;

class MessagesController extends Controller
{
    /**
     * @var MessageService
     */
    protected $messageService;

    /**
     * @var MessageRepository
     */
    protected $messageRepository;

    /**
     * MessagesController constructor.
     * @param MessageService $messageService
     * @param MessageRepository $messageRepository
     */
    public function __construct(MessageService $messageService, MessageRepository $messageRepository)
    {
        $this->messageService = $messageService;
        $this->messageRepository = $messageRepository;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  MessageRequest  $request
     * @return MessageResource
     */
    public function store(MessageRequest $request)
    {
        try {
            $message = $this->messageService->create($request);

            return new MessageResource($message);
        }catch (\Exception $e) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR,$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
     * @return JsonResponse|RedirectResponse|Response
     */
    public function destroy($id)
    {
        try {
            $message = $this->messageRepository->findById($id);
            $this->messageService->destroy($message);

            return response()->json(['msg' => 'success'], 204);
        } catch (Throwable $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Отмечает прочитанные сообщения в диалоге
     * @param MarkReadRequest $request
     * @return JsonResponse|mixed
     */
    public function markReadDialog(MarkReadRequest $request)
    {
        try {
            $messages = $this->messageRepository->markReadDialog($request->channel_id);

            return $messages;
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Отмечает прочитанные сообщения в чате
     * @param MarkReadRequest $request
     * @return JsonResponse|mixed
     */
    public function markReadChat(MarkReadRequest $request)
    {
        try {
            $messages = $this->messageRepository->markReadChat($request->channel_id);

            return $messages;
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
