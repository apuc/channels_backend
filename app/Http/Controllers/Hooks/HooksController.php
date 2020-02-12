<?php

namespace App\Http\Controllers\Hooks;

use App\Http\Controllers\Controller;
use App\Integrations\IntegrationHandlerFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HooksController extends Controller
{
    public function handle(Request $request,$type,$id)
    {
        try {
            $handler = IntegrationHandlerFactory::createHandler($type,$id);

            $confirmation = $handler->confirmServer($request);

            if($confirmation !== false){
                return $confirmation;
            }

            if(!$handler->integration->hasChannels()){
                return $handler->defaultAnswer();
            }

            return $handler->acceptHook($request);

        }catch (\Exception $e){
            Log::error("Type: {$type} Id: {$id} Message: {$e->getMessage()} Trace: {$e->getTraceAsString()}");
        }
    }
}
