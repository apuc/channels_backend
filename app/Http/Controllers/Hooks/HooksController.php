<?php

namespace App\Http\Controllers\Hooks;

use App\Http\Controllers\Controller;
use App\Integrations\IntegrationHandlerFactory;
use Illuminate\Http\Request;

class HooksController extends Controller
{
    public function handle(Request $request,$type,$id)
    {
        $handler = IntegrationHandlerFactory::createHandler($type,$id);

        $confirmation = $handler->confirmServer($request);

        if($confirmation !== false){
            return $confirmation;
        }

        return $handler->acceptHook($request);
    }
}
