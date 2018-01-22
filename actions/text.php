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

    $bot->add('How much is (.*) \+ (.*)\?', function ($bot, $match) {
        /** @var Bot $bot */
        /** @var Match $match */
        $parameters = $match->get('$parameters');
        if (count($parameters) !== 2) {
            return $bot->reply('Can`t resolve this math');
        }
        $sum = $parameters[0] + $parameters[1];
        return $bot->reply("That is easy, the answer is `{$sum}`");
    });

    $bot->add('.*', OtherWise::class);
};
