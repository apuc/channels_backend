<?php

namespace App\Http\Controllers\Api\v1\Users;

use App\Http\Requests\Users\ContactRequest;
use App\Http\Requests\Users\CreateRequest;
use App\Http\Requests\Users\ProfileRequest;
use App\Http\Requests\Users\SearchRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\Http\Resources\v1\AvatarResource;
use App\Http\Resources\v1\User\FullUserResource;
use App\Models\Avatar;
use App\Models\User\UserContact;
use App\Repositories\Users\UserContactRepository;
use App\Repositories\Users\UserRepository;
use App\Services\Files\AvatarService;
use App\Services\Users\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param int $id
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
     * @param ProfileRequest $request
     * @param $id
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
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = $this->userRepository->findById((int)$id);
            $this->userService->destroy($user);
            $this->avatarService->destroy($user->avatar);

            return response()->json(['msg' => 'success'], 204);
        } catch (\Throwable $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return AvatarResource
     */
    public function avatar(Request $request)
    {
        //dd($request->file('avatar')->getClientOriginalExtension());
        $avatarRequest = $this->avatarService->upload($request->file('avatar'), 'user');
        $avatar = $this->avatarService->save($avatarRequest);

        return new AvatarResource($avatar);
    }

    /**
     * @param ContactRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function addContact(ContactRequest $request)
    {
        try {
            $this->userContactRepository->create($request);

            return response()->json(['msg' => 'success'], 200);
        } catch (\Throwable $e) {
            return back()->with(['error' => $e->getMessage()]);
        }

    }

    /**
     * @param ContactRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function confirmContact(ContactRequest $request)
    {
        try {
            $userContact = $this->userContactRepository->findByPrimary($request->user_id, $request->contact_id);
            $this->userContactRepository->confirm(UserContact::REQUEST_ACCEPTED, $userContact);

            return response()->json(['msg' => 'success'], 200);
        } catch (\Throwable $e) {
            return back()->with(['error' => $e->getMessage()]);
        }

    }

    /**
     * @param ContactRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function rejectContact(ContactRequest $request)
    {
        try {
            $userContact = $this->userContactRepository->findByPrimary($request->user_id, $request->contact_id);
            $this->userContactRepository->confirm(UserContact::REQUEST_REJECTED, $userContact);

            return response()->json(['msg' => 'success'], 204);
        } catch (\Throwable $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function contacts()
    {
        $user = \Auth::user()->contacts();

        return FullUserResource::collection($user);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function senders()
    {
        $user = \Auth::user()->senders;

        return FullUserResource::collection($user);
    }

    public function delava($id)
    {
        $avatar = Avatar::where('avatar_id', $id)->first();
        $this->avatarService->destroy($avatar);
    }
}
