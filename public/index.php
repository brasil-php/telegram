<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Telegram\Bot;

try {
    $telegram = new Bot(env('BOT_TOKEN'));
    if (php_sapi_name() === 'cli') {
        $telegram->remove(isset($argv[1]) && $argv[1] == 'delete' ? '' : env('WEBHOOK_URL'));
        exit;
    }
    $body = json_decode(file_get_contents("php://input"), true);
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
    try {
        $telegram->reply("Error: {$e->getMessage()}");
    } catch (Exception $e) {
    }
    error_log($e);
}
