<?php

namespace App\Services\Channels;

use App\Events\Notifications\NotificationCreated;
use App\Models\Channels\Notification;
use App\Repositories\Channels\NotificationRepository;
use Illuminate\Support\Facades\Event;


/**
 * Class NotificationService.
 *
 * @package App\Services\Channels
 */
class NotificationService
{
    /**
     * @var NotificationRepository
     */
    protected $repository;

    /**
     * Construct for Notification service.
     *
     * @param NotificationRepository $repository
     */
    public function __construct(NotificationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Method for create Notification.
     *
     * @param int $channel_id
     * @param int $message_id
     *
     * @return Notification
     */
    public function create(int $message_id,int $channel_id): Notification
    {
        $notification = $this->repository->create($message_id,$channel_id);
        Event::fire(new NotificationCreated($notification));
        return $notification;
    }
}