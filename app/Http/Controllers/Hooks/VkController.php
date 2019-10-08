<?php

namespace App\Http\Controllers\Hooks;

use App\Http\Controllers\Controller;
use App\Models\Channels\Attachment;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\Integrations\Integration;
use Illuminate\Support\Facades\Log;
use App\Services\Channels\MessageService;
use App\Http\Requests\Channels\MessageRequest;

class VKController extends Controller
{

    /**
     * @var MessageService
     */
   private $messageService;

    /**
     * VKController constructor.
     * @param MessageService $service
     */
   public function __construct(MessageService $service)
   {
       $this->messageService = $service;
   }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
   public function acceptHook(Request $request,$id)
   {
       $integration = Integration::findOrFail($id);

       Log::info(json_encode($request->all()));

       if($request->type && $request->type == 'confirmation'){
           return response($integration->fields['confirm'], 200)
               ->header('Content-Type', 'text/plain');
       }else{

           //ПАРСИМ АТАЧМЕНТЫ ОТ ВК
           $attachments = [];

           foreach ($request->object['attachments'] as $attachment){

               //пока пропускаем все кроме фоток
               if($attachment['type'] != 'photo'){
                   continue;
               }

               $attachments[] = [
                   'type'   => Attachment::TYPE_IMAGE,
                   'options'  => json_encode([
                       'url'=>$attachment['photo']['photo_130']
                   ]),
                   'status'  => Attachment::STATUS_ACTIVE,
               ];
           }

           if(empty($attachments)){
               return response('ok', 200)
                   ->header('Content-Type', 'text/plain');
           }

           //ДОБАВЛЕНИЕ СООБЩЕНИЙ В КАНАЛЫ
           foreach ($integration->channels as $channel){

               $data = new MessageRequest([
                   'channel_id'=>$channel->channel_id,
                   'from'=>1,
                   'text'=>$request->object['text'],
                   'attachments'=>$attachments
               ]);

               $this->messageService->create($data);

           }

           return response('ok', 200)
               ->header('Content-Type', 'text/plain');
       }
   }
}
