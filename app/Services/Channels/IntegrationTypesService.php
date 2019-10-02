<?php


namespace App\Services\Channels;


use App\Http\Requests\Channels\IntegrationTypeRequest;
use App\Models\Channels\IntegrationType;
use foo\bar;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use phpDocumentor\Reflection\Types\Boolean;

class IntegrationTypesService
{
    /**
     * Method for create integration type
     * @return IntegrationType
     * @var IntegrationTypeRequest $request
     */
    public function create(IntegrationTypeRequest $request): IntegrationType
    {
        $newIntegrationType = IntegrationType::create(['title' => $request->post('title'), 'slug' => $request->post('slug'), 'fields' => $request->post('fields'), 'options' => $request->post('options'),]);

        return $newIntegrationType;
    }


    /**
     * Method for update integration type
     * @var IntegrationTypeRequest $request
     * @var IntegrationType $integrationType
     * @return IntegrationType
     */
    public function update(IntegrationTypeRequest $request, IntegrationType $integrationType): IntegrationType
    {
        $integrationType->fill($request->all());
        $integrationType->save();

        return $integrationType;
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
        if($type->delete()) {
            return true;
        }

        throw new \DomainException('Error deleting integration type');
    }

}
