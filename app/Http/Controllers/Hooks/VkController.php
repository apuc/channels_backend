<?php

namespace App\Http\Controllers\Hooks;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\Integrations\Integration;
use Illuminate\Support\Facades\Log;

class VKController extends Controller
{
   public function acceptHook(Request $request,$id)
   {
       $integration = Integration::findOrFail($id);

       if($request->type && $request->type == 'confirmation'){
           return $integration->fields['confirm'];
       }else{
           Log::info($request->all());
           return "ok";
       }
   }
}
