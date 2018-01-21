<?php

use App\Actions\Hello;
use App\Actions\OtherWise;
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

    $bot->add('^Hello|^Hi', Hello::class);

    $bot->add('.*', OtherWise::class);
};
