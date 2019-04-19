<?php

namespace App\Repositories\Channels;

use App\Models\Channels\Notification;

/**
 * Class NotificationRepository.
 *
 * @package App\Repositories\Channels
 */
class NotificationRepository
{
    /**
     * @var Notification
     */
    protected $model;

    /**
     * NotificationRepository constructor.
     *
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->model = $notification;
    }

    /**
     * Method for create notification
     *
     * @param int $channel_id
     * @param int $message_id
     * @param string $content
     *
     * @return mixed
     */
    public function create(int $message_id,int $channel_id,string $content = '')
    {
        return $this->model::create([
            'channel_id' => $channel_id,
            'message_id' => $message_id,
            'content' => $content,
        ]);
    }
}