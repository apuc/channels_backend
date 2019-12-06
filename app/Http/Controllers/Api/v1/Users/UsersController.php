<?php

namespace App\Http\Controllers\Api\v1\Users;

use App\Http\Requests\Users\ContactRequest;
use App\Http\Requests\Users\CreateRequest;
use App\Http\Requests\Users\ProfileRequest;
use App\Http\Requests\Users\SearchRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\Http\Resources\v1\AvatarResource;
use App\Http\Resources\v1\User\FullUserResource;
use App\Http\Resources\v1\User\ContactUserResource;
use App\Models\Avatar;
use App\Models\User;
use App\Models\User\UserContact;
use App\Repositories\Users\UserContactRepository;
use App\Repositories\Users\UserRepository;
use App\Services\Files\AvatarService;
use App\Services\Users\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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


    public function __construct(UserRepository $userRepository, UserService $userService, AvatarService $avatarService, UserContactRepository $userContactRepository)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
        $this->avatarService = $avatarService;
        $this->userContactRepository = $userContactRepository;
    }

    /**
     * @param SearchRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(SearchRequest $request)
    {
        try {
            $users = $this->userService->search($request);

            return FullUserResource::collection($users);
        } catch (\Throwable $e) {
            abort(500);
        }

    }

    /**
     * @return FullUserResource
     */
    public function me()
    {
        $user = \Auth::user();

        return new FullUserResource($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return FullUserResource
     */
    public function store(CreateRequest $request)
    {
        try {
            $user = $this->userService->create($request);

            return new FullUserResource($user);
        } catch (\Throwable $e) {
            abort(500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return FullUserResource
     */
    public function show($id)
    {
        $user = $this->userRepository->findById((int)$id);

        return new FullUserResource($user);
    }


    /**
     * Редактировать юзера (пароль и емайл)
     *
     * @param UpdateRequest $request
     * @param int $id
     *
     * @return FullUserResource
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $user = $this->userRepository->findById((int)$id);
            $user = $this->userService->update($request, $user);

            return new FullUserResource($user);
        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Редактировать профиль (аватар и имя)
     *
     * @param ProfileRequest $request
     * @param $id
     *
     * @return FullUserResource|\Illuminate\Http\JsonResponse
     */
    public function profile(ProfileRequest $request, $id)
    {
        try {
            $user = $this->userRepository->findById((int)$id);
            $user = $this->userService->updateProfile($request, $user);

            return new FullUserResource($user);
        } catch (\Throwable $e) {
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
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Устоновить аватарку
     *
     * @param Request $request
     *
     * @return AvatarResource
     */
    public function avatar(Request $request)
    {
        $avatarRequest = $this->avatarService->upload($request->file('avatar'), 'user');
        $avatar = $this->avatarService->save($avatarRequest);

        return new AvatarResource($avatar);
    }

    /**
     * Добавить в контакты
     *
     * @param ContactRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function addContact(ContactRequest $request)
    {
        try {
            $this->userContactRepository->create($request);

            return response()->json(['msg' => 'success'], 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /**
     * Принять запрос на добавление в контакты
     *
     * @param ContactRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function confirmContact(ContactRequest $request)
    {
        try {
            $userContact = $this->userContactRepository->findByPrimary($request->user_id, $request->contact_id);
            $this->userContactRepository->confirm(UserContact::REQUEST_ACCEPTED, $userContact);

            return response()->json(['msg' => 'success'], 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /**
     * Отклонить запрос на добавление в контакты
     *
     * @param ContactRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function rejectContact(ContactRequest $request)
    {
        try {
            $userContact = $this->userContactRepository->findByPrimary($request->user_id, $request->contact_id);
            $this->userContactRepository->confirm(UserContact::REQUEST_REJECTED, $userContact);

            return response()->json(['msg' => 'success'], 204);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Контакты пользователя
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function contacts()
    {
        $user = \Auth::user()->contacts();

        return FullUserResource::collection($user);
    }

    /**
     * Получение всех запросов в друзья(которые отправили пользователю и которые отправил пользователь)
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function senders()
    {
        return new ContactUserResource(Auth::user());
    }
}
