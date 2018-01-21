<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Telegram\Bot;

try {
    $telegram = new Bot(env('BOT_TOKEN'));
    if (php_sapi_name() === 'cli') {
        $telegram->remove(isset($argv[1]) && $argv[1] == 'delete' ? '' : env('WEBHOOK_URL'));
        exit;
    }
    $content = file_get_contents("php://input");
    $body = json_decode($content, true);
    if (!$body) {
        exit;
    }

    if (!isset($body['message'])) {
        exit;
    }
    $telegram
        ->actions(dirname(__DIR__) . '/actions/text.php')
        ->text($body);

} catch (Exception $e) {
    error_log($e);
}
