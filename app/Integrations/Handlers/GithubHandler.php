<?php
namespace App\Integrations\Handlers;

use App\Integrations\IntegrationBase;
use App\Integrations\IntegrationContract;
use App\Models\Channels\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GithubHandler extends IntegrationBase implements IntegrationContract
{
    public function acceptHook(Request $request)
    {
       $messageText = "{$request->sender['login']} сделал пуш в репозиторий {$request->repository['name']}
       в ветку {$request->ref}";

       $attachments = $this->parseAttachments($request);

       $this->sendToChannels($messageText,$attachments);
    }

    public function confirmServer(Request $request)
    {
        return false;
    }

    public function parseAttachments(Request $request)
    {
        return [
             [
                'type'   => Attachment::TYPE_GITHUB,
                'options'  => [
                    'commits'=>$request->commits,
                    'ref'=>$request->ref,
                ],
                'status'  => Attachment::STATUS_ACTIVE,
            ]
        ];
    }

    public function defaultAnswer()
    {
        return "ok";
    }
}
