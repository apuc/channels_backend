<?php
namespace App\Services\Integrations;

use App\Http\Requests\Channels\IntegrationTypeRequest;
use App\Models\Channels\IntegrationType;
use App\Repositories\Integrations\IntegrationTypeRepository;

class IntegrationTypesService
{
    /**
     * @var IntegrationTypeRepository
     */
    protected $repository;

    /**
     * IntegrationService constructor.
     *
     * @param IntegrationRepository $repository
     */
    public function __construct(IntegrationTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Method for create integration type
     * @return IntegrationType
     * @var IntegrationTypeRequest $request
     */
    public function create(IntegrationTypeRequest $request): IntegrationType
    {
        return $this->repository->create($request);
    }

    /**
     * Method for update integration type
     * @var IntegrationTypeRequest $request
     * @var IntegrationType $integrationType
     * @return IntegrationType
     */
    public function update(IntegrationTypeRequest $request, IntegrationType $integrationType)
    {
        return $this->repository->update($request,$integrationType);
    }

    /**
     * Method for deleting integration type
     * @param IntegrationType $type
     * @return bool
     * @throws \Exception
     * @throws  \DomainException
     */
    public function destroy(IntegrationType $type)
    {
        return $this->repository->destroy($type);
    }

}
