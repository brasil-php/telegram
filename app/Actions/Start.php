<?php

namespace App\Actions;

use App\Model\Match;
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
     * @param Match $match
     * @param array $message
     * @throws Exception
     * @SuppressWarnings(Unused)
     */
    function __invoke($bot, $match, $message)
    {
        $chatId = $message['chat']['id'];
        $parameters = [
            'chat_id' => $chatId,
            "text" => 'Hello',
            'reply_markup' => ['keyboard' => [['Hello', 'Hi']], 'one_time_keyboard' => true, 'resize_keyboard' => true]
        ];
        $bot->answer($parameters);
    }
}
