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
     * @return mixed
     * @throws Exception
     */
    public function __invoke($bot)
    {
        return $bot->replyTo('Cool');
    }
}
