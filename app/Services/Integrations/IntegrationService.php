<?php


namespace App\Services\Integrations;

use App\Http\Requests\Channels\GroupRequest;
use App\Models\Channels\Channel;
use App\Models\Channels\Group;
use App\Repositories\Integrations\IntegrationRepository;
use App\Http\Requests\Integrations\CreateRequest;

/**
 * Service for manage channels groups
 */
class IntegrationService
{
    /**
     * @var IntegrationRepository
     */
    protected $repository;

    /**
     * IntegrationService constructor.
     *
     * @param IntegrationRepository $repository
     */
    public function __construct(IntegrationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param CreateRequest $request
     * @return \App\Models\User|\Illuminate\Database\Eloquent\Model
     */
    public function createIntegration(CreateRequest $request)
    {
        return $this->repository->create($request);
    }
}
