<?php

namespace App\Integrations\Handlers;

use App\Models\Channels\Attachment;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use App\Integrations\IntegrationContract;
use App\Integrations\IntegrationBase;
use Illuminate\Http\Response;

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
     * @return ResponseFactory|Response|string
     */
    public function acceptHook(Request $request)
    {
        $attachments = $this->parseAttachments($request);

        $this->sendToChannels($request->object['text'],$attachments);

        return "ok";
    }


    /**
     * @param Request $request
     * @return array
     */
    public function parseAttachments(Request $request) : array
    {
        $res = [];

        if(!isset($request->object['attachments'])){
            return $res;
        }

        foreach ($request->object['attachments'] as $attachment){

            if($attachment['type'] == 'photo'){
                $res[] = $this->parsePhoto($attachment);
            }

            if($attachment['type'] == 'link'){
                $res[] = $this->parseLink($attachment);
            }
        }

        return $res;
    }

    /**
     * @return string
     */
    public function defaultAnswer()
    {
        return "ok";
    }

    /**
     * @param array $attachment
     * @return array
     */
    private function parsePhoto(array $attachment)
    {
        return [
            'type'   => Attachment::TYPE_IMAGE,
            'options'  => [
                'url'=>$attachment['photo']['photo_604'],
                'mimeType'=>'image/jpeg',
            ],
            'status'  => Attachment::STATUS_ACTIVE,
        ];
    }

    /**
     * @param array $attachment
     * @return array
     */
    private function parseLink(array $attachment)
    {
        return [
            'type'   => Attachment::TYPE_LINK,
            'options'  => [
                'url' => $attachment['link']['url'],
                'title' => $attachment['link']['title'],
                'description' => $attachment['link']['description'],
                'base' => $attachment['link']['caption'],

            ],
            'status'  => Attachment::STATUS_ACTIVE,
        ];
    }
}
