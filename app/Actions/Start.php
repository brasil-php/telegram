<?php

namespace App\Actions;

use App\Telegram\Bot;
use Exception;

/**
 * Class Start
 * @package App\Actions
 */
class Start
{
    /**
     * @param Bot $bot
     * @param array $message
     * @throws Exception
     */
    function __invoke($bot, $message)
    {
        $chatId = $message['chat']['id'];
        $parameters = [
            'chat_id' => $chatId,
            "text" => 'Hello',
            'reply_markup' => ['keyboard' => [['Hello', 'Hi']], 'one_time_keyboard' => true, 'resize_keyboard' => true]
        ];
        $bot->apiRequestJson('sendMessage', $parameters);
    }
}
