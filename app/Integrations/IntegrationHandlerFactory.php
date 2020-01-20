<?php

namespace App\Integrations;

use App\Models\Integrations\Integration;
use App\Services\Channels\MessageService;

class IntegrationHandlerFactory
{
    public static function createHandler(string $type,$id)
    {
        $name = ucfirst($type).'Handler';
        $class = "App\Integrations\Handlers\\".$name;
        $integration = is_int($id) ? Integration::find($id) : $id;
        return new $class($integration,app()->make(MessageService::class));
    }
}
