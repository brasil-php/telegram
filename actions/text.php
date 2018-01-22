<?php

use App\Actions\Hello;
use App\Actions\OtherWise;
use App\Actions\Start;
use App\Model\Match;
use App\Telegram\Bot;

return function (Bot $bot) {
    // start command
    $bot->add('/start', Start::class);

    $bot->add('^Hello|^Hi', Hello::class);

    $bot->add('How much is (?<first>.*) \+ (?<second>.*)\?', function ($bot, $match) {
        /** @var Bot $bot */
        /** @var Match $match */
        $parameters = $match->get('$parameters');
        if (!isset($parameters['first']) or !isset($parameters['second'])) {
            return $bot->reply('Can`t resolve this math');
        }
        $sum = $parameters['first'] + $parameters['second'];
        return $bot->reply("That is easy, the answer is `{$sum}`");
    });

    $bot->add('.*', OtherWise::class);
};
