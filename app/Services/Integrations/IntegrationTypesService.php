<?php
namespace App\Services\Integrations;

use App\Http\Requests\Channels\IntegrationTypeRequest;
use App\Http\Requests\Integrations\CreateRequest;
use App\Models\Integrations\IntegrationType;
use App\Repositories\Integrations\IntegrationTypeRepository;
use App\Repositories\Integrations\IntegrationRepository;

class IntegrationTypesService
{
    /**
     * @var IntegrationTypeRepository
     */
    protected $repository;

    /**
     * @var IntegrationRepository
     */
    protected $integrationRepository;

    /**
     * IntegrationService constructor.
     *
     * @param IntegrationRepository $integrationRepository
     * @param IntegrationTypeRepository $repository
     */
    public function __construct(IntegrationTypeRepository $repository,IntegrationRepository $integrationRepository)
    {
        $this->repository = $repository;
        $this->integrationRepository = $integrationRepository;
    }

    /**
     * Method for create integration type
     * @return IntegrationType
     * @var IntegrationTypeRequest $request
     */
    public function create(IntegrationTypeRequest $request): IntegrationType
    {
        $newType = $this->repository->create($request);

        if($request->is_rss){
            $newType->settings = ['parse_url'=>$request->rss_url,'is_rss'=>true];
            $newType->save();

            $this->integrationRepository->create(new CreateRequest([
                'type_id'=>$newType->id,
                'name'=>$newType->title,
                'fields'=>[],
            ]));
        }

        return $newType;
    }

    /**
     * Method for update integration type
     * @var IntegrationTypeRequest $request
     * @var IntegrationType $integrationType
     * @return IntegrationType
     */
    public function update(IntegrationTypeRequest $request, IntegrationType $integrationType)
    {
        $integrationType->settings->set('is_rss',isset($request->is_rss));
        $integrationType->settings->set('parse_url',$request->rss_url);

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
