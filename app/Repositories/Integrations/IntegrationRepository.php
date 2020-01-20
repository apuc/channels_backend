<?php
namespace App\Repositories\Integrations;

use App\Http\Requests\Integrations\CreateRequest;
use App\Models\Integrations\Integration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'user_id' => Auth::user()->user_id,
            'type_id' => $request->type_id,
            'name' => $request->name,
            'fields' => $request->fields,
        ]);
    }

    public function getRssIntegrarions()
    {
        return $this->model->newQuery()
                ->select(DB::raw(
                    'integrations.*,
                    JSON_UNQUOTE(JSON_EXTRACT(settings,"$.parse_url")) as rss_url,
                    integration_types.slug'
                ))
                ->leftJoin('integration_types', 'integrations.type_id', '=', 'integration_types.id')
                ->whereRaw('integration_types.settings -> "$.is_rss" = true')
                ->get();
    }

}
