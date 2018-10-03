<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Requests\Api\v1\Auth\RegistrationRequest;
use App\Services\Auth\RegisterService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    protected $registerService;

    public function __construct(RegisterService $service)
    {
        $this->registerService = $service;
    }

    public function registration(RegistrationRequest $request)
    {
        try{
            $this->registerService->register($request);

            return response()->json(['msg' => 'success'], 201);
        }
        catch (\Throwable $e){
            abort(500);
        }

    }
}
