<?php

namespace App\Http\Controllers\Api\v1\Users;

use App\Http\Requests\Users\ContactRequest;
use App\Http\Requests\Users\CreateRequest;
use App\Http\Requests\Users\ProfileRequest;
use App\Http\Requests\Users\SearchRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\Http\Resources\v1\AvatarResource;
use App\Http\Resources\v1\Integrations\IntegrationResource;
use App\Http\Resources\v1\User\FullUserResource;
use App\Http\Resources\v1\User\ContactUserResource;
use App\Models\User\UserContact;
use App\Repositories\Users\UserContactRepository;
use App\Repositories\Users\UserRepository;
use App\Services\Files\AvatarService;
use App\Services\Users\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class UsersController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var AvatarService
     */
    protected $avatarService;

    /**
     * @var UserContactRepository
     */
    protected $userContactRepository;


    /**
     * UsersController constructor.
     *
     * @param UserRepository $userRepository
     * @param UserService $userService
     * @param AvatarService $avatarService
     * @param UserContactRepository $userContactRepository
     *
     */
    public function __construct(UserRepository $userRepository, UserService $userService, AvatarService $avatarService, UserContactRepository $userContactRepository)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
        $this->avatarService = $avatarService;
        $this->userContactRepository = $userContactRepository;
    }

    /**
     * @param SearchRequest $request
     * @return JsonResponse|AnonymousResourceCollection|void
     */
    public function index(SearchRequest $request)
    {
        try {
            $users = $this->userService->search($request);

            return FullUserResource::collection($users);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }

    }

    /**
     * @return FullUserResource|JsonResponse
     */
    public function me()
    {
        try {
            $user = \Auth::user();

            return new FullUserResource($user);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return FullUserResource|JsonResponse
     */
    public function store(CreateRequest $request)
    {
        try {
            $user = $this->userService->create($request);

            return new FullUserResource($user);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return FullUserResource|JsonResponse
     */
    public function show($id)
    {
        try {
            $user = $this->userRepository->findById((int)$id);

            return new FullUserResource($user);

        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }

    }


    /**
     * Редактировать юзера (пароль и емайл)
     *
     * @param UpdateRequest $request
     * @param int $id
     *
     * @return FullUserResource|JsonResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $user = $this->userRepository->findById((int)$id);
            $user = $this->userService->update($request, $user);

            return new FullUserResource($user);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Редактировать профиль (аватар и имя)
     *
     * @param ProfileRequest $request
     * @param $id
     *
     * @return FullUserResource|JsonResponse
     */
    public function profile(ProfileRequest $request, $id)
    {
        try {
            $user = $this->userRepository->findById((int)$id);
            $user = $this->userService->updateProfile($request, $user);

            return new FullUserResource($user);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Удалить юзера
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $user = $this->userRepository->findById((int)$id);
            $this->userService->destroy($user);
            $this->avatarService->destroy($user->avatar);

            return response()->json(['msg' => 'success'], 204);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Устоновить аватарку
     *
     * @param Request $request
     *
     * @return AvatarResource|JsonResponse
     */
    public function avatar(Request $request)
    {
        try {
            $avatarRequest = $this->avatarService->upload($request->file('avatar'), 'user');
            $avatar = $this->avatarService->save($avatarRequest);

            return new AvatarResource($avatar);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Добавить в контакты
     *
     * @param ContactRequest $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function addContact(ContactRequest $request)
    {
        try {
            $this->userContactRepository->create($request);

            return response()->json(['msg' => 'success'], 200);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /**
     * Принять запрос на добавление в контакты
     *
     * @param ContactRequest $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function confirmContact(ContactRequest $request)
    {
        try {
            $userContact = $this->userContactRepository->findByPrimary($request->user_id, $request->contact_id);
            $this->userContactRepository->confirm(UserContact::REQUEST_ACCEPTED, $userContact);

            return response()->json(['msg' => 'success'], 200);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /**
     * Отклонить запрос на добавление в контакты
     *
     * @param ContactRequest $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function rejectContact(ContactRequest $request)
    {
        try {
            $userContact = $this->userContactRepository->findByPrimary($request->user_id, $request->contact_id);
            $this->userContactRepository->confirm(UserContact::REQUEST_REJECTED, $userContact);

            return response()->json(['msg' => 'success'], 204);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Контакты пользователя
     *
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function contacts()
    {
        try {
            $user = \Auth::user()->contacts();

            return FullUserResource::collection($user);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Получение всех запросов в друзья(которые отправили пользователю и которые отправил пользователь)
     *
     * @return ContactUserResource|JsonResponse
     */
    public function senders()
    {
        try {
            return new ContactUserResource(Auth::user());
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /**
     * @param $id
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function integrations($id)
    {
        try {
            $user = $this->userRepository->findById($id);

            return IntegrationResource::collection($user->integrations);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
