<?php

namespace App\Integrations;

use App\Models\Integrations\Integration;
use App\Services\Channels\MessageService;

class IntegrationHandlerFactory
{
    public static function createHandler(string $type,int $id)
    {
        $name = ucfirst($type).'Handler';
        $class = "App\Integrations\Handlers\\".$name;
        return new $class(Integration::find($id),app()->make(MessageService::class));
    }
}
