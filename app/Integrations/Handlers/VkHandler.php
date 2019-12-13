<?php

namespace App\Integrations\Handlers;

use App\Models\Channels\Attachment;
use Illuminate\Http\Request;
use App\Integrations\IntegrationContract;
use App\Integrations\IntegrationBase;

class VkHandler extends IntegrationBase implements IntegrationContract
{
    /**
     * @param Request $request
     * @return bool
     */
    public function confirmServer(Request $request)
    {
        if($request->type && $request->type == 'confirmation') {
            return $this->integration->fields['confirm'];
        }

        return false;
    }



    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function acceptHook(Request $request)
    {
        if(!$attachments = $this->parseAttachments($request)){
            return "ok";
        }

        $this->sendToChannels($request->object['text'],$attachments);

        return "ok";
    }



    /**
     * @param $attachments
     * @return array
     */
    public function parseAttachments(Request $request) : array
    {
        $res = [];

        if(!isset($request->object['attachments'])){
            return $res;
        }

        foreach ($request->object['attachments'] as $attachment){

            //пока пропускаем все кроме фоток
            if($attachment['type'] != 'photo'){
                continue;
            }

            $res[] = [
                'type'   => Attachment::TYPE_IMAGE,
                'options'  => [
                    'url'=>$attachment['photo']['photo_604'],
                    'mimeType'=>'image/jpeg',
                ],
                'status'  => Attachment::STATUS_ACTIVE,
            ];
        }

        return $res;
    }
}
