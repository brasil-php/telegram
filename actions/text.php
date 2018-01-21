<?php

use App\Actions\Hello;
use App\Actions\OtherWise;
use App\Actions\Start;
use App\Telegram\Bot;

return function (Bot $bot) {
    // start command
    $bot->add('/start', Start::class);

    $bot->add('^Hello|^Hi', Hello::class);

    $bot->add('.*', OtherWise::class);
};
