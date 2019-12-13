<?php
namespace App\Services\Users;

use App\Http\Requests\Bot\BotMessageRequest;
use App\Http\Requests\Channels\MessageRequest;
use App\Models\Channels\Message;
use App\Repositories\Users\UserRepository;
use App\Services\Channels\MessageService;
use App\Services\NodeService;

/**
 * Class BotService
 * @package App\Services\Users
 */
class BotService
{
    /**
     * @var MessageService
     */
   private $messageService;

    /**
     * BotService constructor.
     * @param MessageService $messageService
     */
   public function __construct(MessageService $messageService)
   {
     $this->messageService = $messageService;
   }

    /**
     * Отправка сообщения от бота
     * @param BotMessageRequest $request
     */
   public function sendBotMessage(BotMessageRequest $request)
   {
      $message = $this->messageService->create(new MessageRequest([
          'channel_id' => $request->channel_id,
          'from' => $request->bot_id,
          'text' => $request->message,
          'read'=>Message::MESSAGE_UNREAD
      ]));

      NodeService::broadcastMessage($message,[$request->channel_id]);
   }
}
