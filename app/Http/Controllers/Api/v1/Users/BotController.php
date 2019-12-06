<?php
namespace App\Http\Controllers\Api\v1\Users;

use App\Http\Controllers\Controller;
use App\Repositories\Users\UserRepository;
use App\Services\Users\UserService;
use App\Http\Requests\Users\ProfileRequest;
use App\Http\Requests\Bot\BotRequest;
use App\Http\Resources\v1\User\ShortUserResource;
use\Illuminate\Http\Response;

/**
 * Class AttachmentsController.
 *
 * @package App\Http\Controllers\Api\v1\Channels
 */
class BotController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * BotController constructor.
     * @param UserService $userService
     * @param UserRepository $userRepository
     */
    public function __construct(UserService $userService, UserRepository $userRepository)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }


    /**
     * Создать бота
     * @param BotRequest $request
     * @return ShortUserResource
     */
    public function store(BotRequest $request)
    {
        try {
            $bot = $this->userService->createBot($request);

            return new ShortUserResource($bot);
        } catch (\Throwable $e) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Редактировать бота
     * @param ProfileRequest $request
     * @param $id
     * @return ShortUserResource
     */
    public function update(ProfileRequest $request, $id)
    {
        try {
            $bot = $this->userRepository->findById($id);
            $bot = $this->userService->updateProfile($request, $bot);

            return new ShortUserResource($bot);
        } catch (\Throwable $e) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Удалить бота
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $bot = $this->userRepository->findById($id);
            $this->userService->destroy($bot);

            return response()->json(['msg' => 'success'], Response::HTTP_NO_CONTENT);
        }catch (\Throwable $e) {
            return response()->json(['error' => 'Server error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
