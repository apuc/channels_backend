<?php

namespace App\Http\Controllers\Api\v1\Integrations;

use App\Http\Requests\Integrations\CreateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Integrations\IntegrationService;
use App\Http\Resources\v1\Integrations\IntegrationTypeResource;
use App\Http\Resources\v1\Integrations\IntegrationResource;
use App\Models\Integrations\IntegrationType;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IntegrationsController extends Controller
{
    /**
     * @var IntegrationService
     */
    private $integrationService;

    /**
     * IntegrationsController constructor.
     *
     * @param IntegrationService $service
     */
    public function __construct(IntegrationService $service)
    {
         $this->integrationService = $service;
    }

    /**
     * Получение списка типов интеграций
     *
     * @return AnonymousResourceCollection|void
     */
    public function index()
    {
        try {
            return IntegrationTypeResource::collection(IntegrationType::with('integrations')->get());
        } catch (\Throwable $e) {
            return abort(500);
        }
    }


    /**
     * Создать интеграцию
     *
     * @param CreateRequest $request
     * @return IntegrationResource|JsonResponse
     */
    public function store(CreateRequest $request)
    {
        try {
          $integration = $this->integrationService->createIntegration($request);

          return new IntegrationResource($integration);
        } catch (\Throwable $e) {
            return new JsonResponse($e->getMessage());
        }
    }


}
