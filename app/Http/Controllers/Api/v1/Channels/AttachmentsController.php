<?php

namespace App\Http\Controllers\Api\v1\Channels;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Repositories\Channels\AttachmentRepository;
use App\Models\Channels\Attachment;
use App\Services\Channels\AttachmentService;
use App\Http\Requests\Channels\AttachmentRequest;
use App\Http\Requests\Files\AttachmentFileRequest;
use App\Http\Resources\v1\AttachmentResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use\Illuminate\Http\Response;

/**
 * Class AttachmentsController.
 *
 * @package App\Http\Controllers\Api\v1\Channels
 */
class AttachmentsController extends Controller
{
    /**
     * @var AttachmentService
     */
    protected $attachmentService;

    /**
     * @var AttachmentRepository
     */
    protected $attachmentRepository;

    /**
     * AttachmentsController constructor.
     *
     * @param AttachmentService $attachmentService
     * @param AttachmentRepository $attachmentRepository
     */
    public function __construct(AttachmentService $attachmentService, AttachmentRepository $attachmentRepository)
    {
        $this->attachmentService = $attachmentService;
        $this->attachmentRepository = $attachmentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $attachments = Attachment::all();

        return AttachmentResource::collection($attachments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AttachmentRequest $request
     *
     * @return AttachmentResource|JsonResponse
     */
    public function store(AttachmentRequest $request)
    {
        try {
            $attachment = $this->attachmentService->create($request);

            return new AttachmentResource($attachment);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     *
     * @return AttachmentResource
     */
    public function show($id)
    {
        $attachment = $this->attachmentRepository->findById($id);

        return new AttachmentResource($attachment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AttachmentRequest $request
     * @param  int $id
     *
     * @return AttachmentResource|JsonResponse
     */
    public function update(AttachmentRequest $request, $id)
    {
        try {
            $attachment = $this->attachmentRepository->findById($id);
            $attachment = $this->attachmentService->update($request, $attachment);

            return new AttachmentResource($attachment);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse|Response
     */
    public function destroy($id)
    {
        try {
            $attachment = $this->attachmentRepository->findById($id);
            $this->attachmentService->destroy($attachment);

            return response()->json(['msg' => 'success'], Response::HTTP_NO_CONTENT);
        }catch (\Throwable $e) {
            return response()->json(['error' => 'Server error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Upload attachment file.
     *
     * @param AttachmentFileRequest $request
     *
     * @return JsonResponse|string
     */
    public function upload(AttachmentFileRequest $request)
    {
        try{
           $fileInfo = $this->attachmentService->upload($request->file('attachment'));

           return response()->json($fileInfo, Response::HTTP_OK);
        }catch (\Throwable $e){
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
