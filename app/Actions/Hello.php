<?php

namespace App\Actions;

use App\Telegram\Bot;
use Exception;

/**
 * Class Hello
 * @package App\Actions
 */
class Hello
{
    /**
     * The __invoke method is called when a script tries to call an object as a function.
     *
     * @param Bot $bot
     * @param array $message
     * @return mixed
     * @throws Exception
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.invoke
     */
    public function __invoke($bot, $message)
    {
        $chatId = $message['chat']['id'];
        /** @var Bot $bot */
        return $bot->apiRequest(
            'sendMessage', ['chat_id' => $chatId, "text" => 'Nice to meet you']
        );
    }
}