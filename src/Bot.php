<?php

namespace PhpBrasil\Telegram;

use Exception;
use Php\File;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Message;

/**
 * Class Bot
 * @package PhpBrasil\Telegram
 */
class Bot
{
    /**
     * @trait
     */
    use Router, Logger;

    /**
     * @var string
     */
    private $api;

    /**
     * @var array
     */
    private $body;

    /**
     * Bot constructor.
     * @param string $token
     * @throws TelegramSDKException
     */
    public function __construct($token)
    {
        $this->api = new Api($token);
    }

    /**
     * @param string $filename
     * @return $this
     * @throws Exception
     */
    public function actions(string $filename)
    {
        if (!File::exists($filename)) {
            throw new Exception("File not found `{$filename}`");
        }
        /** @noinspection PhpIncludeInspection */
        $callable = require $filename;
        if (!is_callable($callable)) {
            throw new Exception("Action `{$filename}` is not a callable");
        }
        $callable($this);
        return $this;
    }

    /**
     * @param array $body
     * @return bool
     * @throws Exception
     */
    public function handleText(array $body)
    {
        $this->body = $body;
        $message = get($this->body, 'message');
        if (!isset($message['text'])) {
            return null;
        }

        $match = $this->match($message);
        if (is_null($match)) {
            return false;
        }

        $callable = $match->get('$callable');
        if (!is_callable($callable) && is_string($callable) && class_exists($callable)) {
            $callable = new $callable;
        }

        return call_user_func_array(
            $callable,
            [$this, $match, $message]
        );
    }

    /**
     * @param $url
     * @throws TelegramSDKException
     */
    public function remove(string $url)
    {
        $this->api->setWebhook(['url' => $url]);
    }

    /**
     * @param string $text
     * @return Message
     */
    public function reply(string $text)
    {
        $chatId = get($this->body, 'message.chat.id');
        if (!$chatId) {
            return null;
        }
        return $this->api->sendMessage([
                'chat_id' => $chatId,
                'text' => $text
            ]
        );
    }

    /**
     * @param string $text
     * @return Message
     */
    public function replyTo(string $text)
    {
        $chatId = get($this->body, 'message.chat.id');
        $messageId = get($this->body, 'message.message_id');
        return $this->api->sendMessage([
                'chat_id' => $chatId,
                'reply_to_message_id' => $messageId,
                'text' => $text
            ]
        );
    }

    /**
     * @param array $parameters
     * @return Message
     */
    public function answer(array $parameters)
    {
        return $this->api->sendMessage($parameters);
    }

    /**
     * @param string|int $messageId
     * @return Message
     */
    public function delete($messageId = '')
    {
        $chatId = get($this->body, 'message.chat.id');
        if (!$messageId) {
            $messageId = get($this->body, 'message.message_id');
        }
        return $this->api->deleteMessage(['chat_id' => $chatId, 'message_id' => $messageId]);
    }
}
