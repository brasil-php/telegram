<?php

namespace App\Telegram;

use Exception;
use function is_array;
use function is_callable;
use function is_null;
use Php\File;

/**
 * Class Telegram
 * @package App
 */
class Bot
{
    /**
     * @trait
     */
    use Request, RequestJson, RequestWebHook, Router;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $api;

    /**
     * Telegram constructor.
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
        $this->api = "https://api.telegram.org/bot{$token}";
    }

    /**
     * @param $handle
     * @return bool|mixed
     * @throws Exception
     */
    function request($handle)
    {
        $response = curl_exec($handle);

        if ($response === false) {
            $errorNumber = curl_errno($handle);
            $error = curl_error($handle);
            error_log("Curl returned error {$errorNumber}: {$error}\n");
            curl_close($handle);
            return false;
        }

        $httpCode = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
        curl_close($handle);

        if ($httpCode >= 500) {
            // do not wat to DDOS server if something goes wrong
            sleep(10);
            return false;
        }

        if ($httpCode != 200) {
            $response = json_decode($response, true);
            error_log("Request has failed with error {$response['error_code']}: {$response['description']}\n");
            if ($httpCode == 401) {
                throw new Exception('Invalid access token provided');
            }
            return false;
        }

        $response = json_decode($response, true);
        if (isset($response['description'])) {
            error_log("Request was successful: {$response['description']}\n");
        }
        return $response['result'];
    }

    /**
     * @param $filename
     * @return Bot
     * @throws Exception
     */
    public function actions($filename)
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
    function text($body)
    {
        $message = $body['message'];
        $chatId = $message['chat']['id'];
        if (!isset($message['text'])) {
            return $this->apiRequest(
                'sendMessage',
                ['chat_id' => $chatId, 'text' => 'I understand only text messages']
            );
        }

        $text = $message['text'];
        $match = $this->match($text);
        if (is_null($match)) {
            return false;
        }

        return call_user_func_array($match->get('callable'), [$message, $match]);
    }
}