<?php


namespace App\Http\Controllers\Api\v1\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\PasswordReset;
use App\Http\Requests\Api\v1\Auth\PasswordResetRequest;
use App\Services\Auth\PasswordService;
use Illuminate\Http\JsonResponse;
use Throwable;

class PasswordResetController extends Controller
{
    /**
     * @var PasswordService
     */
    private $passwordService;

    /**
     * PasswordResetController constructor.
     * @param PasswordService $service
     */
    public function __construct(PasswordService $service)
    {
        $this->passwordService = $service;
    }

    /**
     * Запрос восстановления пароля
     * @param PasswordResetRequest $request
     * @return JsonResponse
     */
    public function requestReset(PasswordResetRequest $request)
    {
        try{
            $this->passwordService->requestReset($request->email);

            return response()->json(['success' => true], 200);
        }
        catch (Throwable $e){
            return response()->json(['success' => false,'error' => $e->getMessage()], 200);
        }
    }

    /**
     * Сброс пароля
     * @param PasswordReset $request
     * @return JsonResponse
     */
    public function reset(PasswordReset $request)
    {
        try{
            $this->passwordService->resetPassword($request->reset_token,$request->password);

            return response()->json(['success' => true], 200);
        }
        catch (Throwable $e){
            return response()->json(['success' => false,'error' => $e->getMessage()], 200);
        }
    }
}
