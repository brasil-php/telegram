<?php

use App\Telegram\Bot;

return function (Bot $bot) {
    // start command
    $bot->add('^/start', function ($message) {
        $chatId = $message['chat']['id'];
        $parameters = [
            'chat_id' => $chatId,
            "text" => 'Hello',
            'reply_markup' => ['keyboard' => [['Hello', 'Hi']], 'one_time_keyboard' => true, 'resize_keyboard' => true]
        ];
        $this->apiRequestJson('sendMessage', $parameters);
    });

    $bot->add('^Hello|^Hi', function ($message) {
        $chatId = $message['chat']['id'];
        return $this->apiRequest(
            'sendMessage',
            ['chat_id' => $chatId, "text" => 'Nice to meet you']
        );
    });

    $bot->add('.*', function ($message) {
        $chatId = $message['chat']['id'];
        $messageId = $message['message_id'];
        return $this->apiRequestWebhook(
            'sendMessage',
            ['chat_id' => $chatId, 'reply_to_message_id' => $messageId, 'text' => 'Cool']
        );
    });

};
