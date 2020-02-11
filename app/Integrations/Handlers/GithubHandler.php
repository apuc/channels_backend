<?php


namespace App\Integrations\Handlers;


use App\Integrations\IntegrationBase;
use App\Integrations\IntegrationContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GithubHandler extends IntegrationBase implements IntegrationContract
{
    public function acceptHook(Request $request)
    {
        Log::info(json_encode($request->all()));
    }

    public function confirmServer(Request $request)
    {
        return false;
    }

    public function parseAttachments(Request $request)
    {

    }
}
