<?php
namespace App\Repositories\Integrations;

use App\Http\Requests\Integrations\CreateRequest;
use App\Models\Integrations\Integration;

class IntegrationRepository
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
    public function __construct(Integration $integration)
    {
        $this->model = $integration;
    }

    /**
     * @param CreateRequest $request
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    public function create(CreateRequest $request)
    {
        return $this->model::create([
            'user_id' => Auth::user()->id,
            'type_id' => $request->type_id,
            'name' => $request->name,
            'fields' => $request->fields,
        ]);
    }

}
