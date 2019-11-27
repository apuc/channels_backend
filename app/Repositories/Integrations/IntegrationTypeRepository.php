<?php
namespace App\Repositories\Integrations;

use App\Http\Requests\Integrations\CreateRequest;
use App\Models\Channels\IntegrationType;
use App\Models\Integrations\Integration;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Channels\IntegrationTypeRequest;

class IntegrationTypeRepository
{
    /**
     * Integration
     * @var Integration|User
     */
    protected $model;

    /**
     * GroupsRepository constructor.
     * @param Integration $integration
     */
    public function __construct(IntegrationType $integration)
    {
        $this->model = $integration;
    }

    /**
     * @param CreateRequest $request
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    public function create(IntegrationTypeRequest $request)
    {
        return $this->model::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'fields' => $request->fields,
            'options' => $request->options,
            'user_can_create' => $request->user_can_create ?? 0,
            'url' => getenv('HOOKS_SERVER_URL') . strtolower($request->slug),
        ]);
    }

    /**
     * Method for update integration type
     * @var IntegrationTypeRequest $request
     * @var IntegrationType $integrationType
     * @return IntegrationType
     */
    public function update(IntegrationTypeRequest $request, IntegrationType $integrationType)
    {
        $integrationType->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'fields' => $request->fields,
            'options' => $request->options,
            'user_can_create' => $request->user_can_create ?? 0,
            'url' => getenv('HOOKS_SERVER_URL') . strtolower($request->slug),
        ]);

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
