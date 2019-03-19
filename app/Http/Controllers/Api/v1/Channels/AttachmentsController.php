<?php

namespace App\Http\Controllers\Api\v1\Channels;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Channels\AttachmentRepository;
use App\Models\Channels\Attachment;
use App\Services\Channels\AttachmentService;
use App\Http\Requests\Channels\AttachmentRequest;
use App\Http\Resources\v1\AttachmentResource;

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

    public function __construct(AttachmentService $attachmentService, AttachmentRepository $attachmentRepository)
    {
        $this->attachmentService = $attachmentService;
        $this->attachmentRepository = $attachmentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
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
     * @return AttachmentResource
     */
    public function store(AttachmentRequest $request)
    {
        try {
            $attachment = $this->attachmentService->create($request);

            return new AttachmentResource($attachment);
        } catch (\Throwable $e) {
            abort(500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return AttachmentResource
     */
    public function show($id)
    {
        $group = $this->attachmentRepository->findById($id);

        return new AttachmentResource($group);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  AttachmentRequest $request
     * @param  int $id
     * @return AttachmentResource
     */
    public function update(AttachmentRequest $request, $id)
    {
        try {
            $attachment = $this->attachmentRepository->findById($id);
            $attachment = $this->attachmentService->update($request, $attachment);

            return new AttachmentResource($attachment);
        } catch (\Throwable $e) {
            abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $attachment = $this->attachmentRepository->findById($id);
            $this->attachmentService->destroy($attachment);
            return response()->json(['msg' => 'success'], 204);
        }catch (\Throwable $e) {
            return response()->json(['error' => 'Server error'], 500);
        }
    }

}
