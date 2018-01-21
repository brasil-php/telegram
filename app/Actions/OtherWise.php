<?php

namespace App\Actions;

use App\Telegram\Bot;
use Exception;

/**
 * Class OtherWise
 * @package App\Actions
 */
class OtherWise
{
    /**
     * @param Bot $bot
     * @param array $message
     * @return mixed
     * @throws Exception
     */
    public function __invoke($bot, $message)
    {
        $chatId = $message['chat']['id'];
        $messageId = $message['message_id'];
        return $bot->apiRequest(
            'sendMessage',
            ['chat_id' => $chatId, 'reply_to_message_id' => $messageId, 'text' => 'Cool']
        );
    }
}
