<?php

namespace App\Http\Controllers\Hooks;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\MessageResource;
use App\Models\Channels\Attachment;
use App\Models\Channels\Message;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\Integrations\Integration;
use Illuminate\Http\Resources\Json\Resource;
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
       $integration = Integration::with('channels')->findOrFail($id);

       Log::info(json_encode($request->all()));

       if($request->type && $request->type == 'confirmation'){
           return $integration->fields['confirm'];
       }else{

           //ПАРСИМ АТАЧМЕНТЫ ОТ ВК
           if(!$attachments = $this->parseAttachments($request->object['attachments'] )){
               return "ok";
           }

           //ДОБАВЛЕНИЕ СООБЩЕНИЙ В КАНАЛЫ
           foreach ($integration->channels as $channel){
               $data = new MessageRequest([
                   'channel_id'=>$channel->channel_id,
                   'from'=>1,
                   'text'=>$request->object['text'],
                   'attachments'=>$attachments
               ]);

               $message = $this->messageService->create($data);

           }

           $this->sendToNode($message,$integration->channels->pluck('channel_id')->toArray());

           return "ok";
       }
   }

    /**
     * @param $attachments
     * @return array
     */
   private function parseAttachments(array $attachments) : array
   {
       $res = [];

       foreach ($attachments as $attachment){

           //пока пропускаем все кроме фоток
           if($attachment['type'] != 'photo'){
               continue;
           }

           $res[] = [
               'type'   => 'image/jpeg',
               'options'  => [
                   'url'=>$attachment['photo']['photo_130']
               ],
               'status'  => Attachment::STATUS_ACTIVE,
           ];
       }

       return $res;
   }

    /**
     * @param Message $message
     * @param array $channels
     */
   private function sendToNode(Message $message,array $channels)
   {
       Resource::withoutWrapping();

       $data = json_encode([
           'channels_ids'=>$channels,
           'message'=> (new MessageResource($message))->toResponse(app('request'))->getData()
       ]);

       $ch = curl_init('http://localhost:3000/integration2');
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
       curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

       $result = curl_exec($ch);
   }
}
