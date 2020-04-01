<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Requests\Api\v1\Auth\RegistrationRequest;
use App\Services\Auth\RegisterService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Throwable;

class RegistrationController extends Controller
{
    /**
     * @var RegisterService
     */
    protected $registerService;

    /**
     * RegistrationController constructor.
     * @param RegisterService $service
     */
    public function __construct(RegisterService $service)
    {
        $this->registerService = $service;
    }

    /**
     * @param RegistrationRequest $request
     * @return JsonResponse
     */
    public function registration(RegistrationRequest $request)
    {
        try{
            $this->registerService->register($request);

            return response()->json(['msg' => 'success'], 201);
        }
        catch (Throwable $e){
            return response()->json(['msg' => $e->getMessage()], 200);
        }
    }
}
