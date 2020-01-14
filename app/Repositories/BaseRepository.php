<?php
namespace App\Repositories;

use App\Http\Requests\Integrations\CreateRequest;
use App\Models\Integrations\IntegrationType;
use App\Models\Integrations\Integration;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Channels\IntegrationTypeRequest;

class BaseRepository
{
    protected $model;

    public function findById(int $id)
    {
        return $this->model::findOrFail($id);
    }
}
