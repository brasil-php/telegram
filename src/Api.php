<?php

namespace PhpBrasil\Telegram;

use Telegram\Bot\Api as Http;
use Telegram\Bot\Objects\Message;

/**
 * Class Api
 * @package PhpBrasil\Telegram
 */
class Api extends Http
{
    /**
     * Delete messages of chat history.
     *
     * <code>
     * $params = [
     *   'chat_id'                  => '',
     *   'message_id'               => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#deletemessage
     *
     * @param array    $params
     *
     * @var int|string $params ['chat_id']
     * @var int|string $params ['message_id']
     *
     * @return Message
     */
    public function deleteMessage(array $params)
    {
        $response = $this->post('deleteMessage', $params);

        return new Message($response->getDecodedBody());
    }
}