<?php

namespace App\Integrations;

use App\Models\Integrations\Integration;
use App\Services\Channels\MessageService;

class IntegrationHandlerFactory
{
    public static function createHandler(string $type,$record)
    {
        $name = ucfirst($type).'Handler';
        $class = "App\Integrations\Handlers\\".$name;
        $integration = $record  instanceof Integration ? $record : Integration::find($record);
        return new $class(app()->make(MessageService::class),$integration);
    }
}
