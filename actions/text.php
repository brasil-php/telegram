<?php

use App\Telegram\Bot;

return function (Bot $bot) {
    // start command
//    $bot->add('\/start', function ($message) {
//        $chatId = $message['chat']['id'];
//        $parameters = [
//            'chat_id' => $chatId,
//            "text" => 'Hello',
//            'reply_markup' => ['keyboard' => [['Hello', 'Hi']], 'one_time_keyboard' => true, 'resize_keyboard' => true]
//        ];
//        $this->apiRequestJson('sendMessage', $parameters);
//    });

    $bot->add('^Hello|^Hi', function ($bot, $message) {
        $chatId = $message['chat']['id'];
        /** @var Bot $bot */
        return $bot->apiRequest(
            'sendMessage', ['chat_id' => $chatId, "text" => 'Nice to meet you']
        );
    });

    $bot->add('.*', function ($bot, $message) {
        /** @var Bot $bot */
        $chatId = $message['chat']['id'];
        $messageId = $message['message_id'];
        return $bot->apiRequestWebhook(
            'sendMessage',
            ['chat_id' => $chatId, 'reply_to_message_id' => $messageId, 'text' => 'Cool']
        );
    });
};
