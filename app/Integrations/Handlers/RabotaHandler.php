<?php

namespace App\Integrations\Handlers;

use App\Models\Channels\Attachment;
use Illuminate\Http\Request;
use App\Integrations\IntegrationContract;
use App\Integrations\IntegrationBase;
use Illuminate\Support\Facades\Log;

class RabotaHandler extends IntegrationBase implements IntegrationContract
{
    /**
     * @param Request $request
     * @return bool
     */
    public function confirmServer(Request $request)
    {
        return false;
    }



    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function acceptHook(Request $request)
    {

        $attachments = [];
        $text = '';

        //вакансия
        if($request->company_id)
        {
            $attachments = [];
            $text = $this->getVacancyText($request);

            $this->sendToChannels($text,$attachments,$this->integration->channels->filter(function($el){
                $options = json_decode($el->pivot->data,true);
                return $options['type'] == 2;
            })->pluck('channel_id')->toArray());
        }

        //резюме
        if($request->employer_id)
        {
            $attachments = $this->parseAttachments($request);
            $text = $this->getResumeText($request);

            $this->sendToChannels($text,$attachments,$this->integration->channels->filter(function($el){
                $options = json_decode($el->pivot->data,true);
                return $options['type'] == 1;
            })->pluck('channel_id')->toArray());
        }

        $this->sendToChannels($text,$attachments,$this->integration->channels->filter(function($el){
            $options = json_decode($el->pivot->data,true);
            return $options['type'] == 0;
        })->pluck('channel_id')->toArray());

        return "ok";
    }



    /**
     * @param $attachments
     * @return array
     */
    public function parseAttachments(Request $request) : array
    {
        $res = [];

        if($request->image_url){
            $res[] = [
                'type'   => Attachment::TYPE_IMAGE,
                'options'  => [
                    'url'=>'https://rabota.today'.$request->image_url,
                    'mimeType'=>'image/jpeg',
                ],
                'status'  => Attachment::STATUS_ACTIVE,
            ];
        }

        return $res;
    }

    /**
     * Текст сообщения для вакансий
     * @param Request $request
     * @return string
     */
    private function getVacancyText(Request $request)
    {
         return "Вакансия: {$request->post}.
                 Требования: {$request->qualification_requirements}.
                 Обязанности: {$request->responsibilities}.
                 Условия работы: {$request->working_conditions}.
                 Зарплата от {$request->min_salary} до {$request->max_salary}.
                 Город: {$request->city}.
                 ";
    }

    /**
     * Текст сообщения для резюме
     * @param Request $request
     * @return string
     */
    private function getResumeText(Request $request)
    {
        return "Резюме: {$request->title}.
                 VK: {$request->vk}.
                 instagram: {$request->instagram}.
                 skype: {$request->skype}.
                 Зарплата от {$request->min_salary} до {$request->max_salary}.
                 Город: {$request->city}.
                 ";
    }
}
