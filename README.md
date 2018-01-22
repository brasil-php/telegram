# Telegram Bot API

Este projeto visa criar uma estrutura de recursos para utilizar a API de bots do Telegram.

## Como usar

Para entregar uma API simplificada o SDK possui uma classe que agrega as features para o bot.
```php
use App\Telegram\Bot;

$telegram = new Bot(env('BOT_TOKEN'));
```
Com estas instruções acima temos uma instância do Bot disponível para adicionar os comandos.
O exemplo abaixo mostra como podemos adicionar um comando para o Bot para ao receber uma mensagem que comece com `Hello` ou `Hi` ele responda `Nice to meet you`.
```php
$bot->add('^Hello|^Hi', function($bot, $message) {
    $chatId = $message['chat']['id'];
    /** @var Bot $bot */
    return $bot->apiRequest(
        'sendMessage', ['chat_id' => $chatId, "text" => 'Nice to meet you']
    );
});
```

O bot conta com métodos para lidar com os tipos de mensagem de forma separada.
```php
$body = json_decode(file_get_contents("php://input"), true);

// add actions to bot
$bot->add(/* regex on message */, /* callable */);
$bot->add(/* regex on message */, /* callable */);

// apply the actions
$telegram->text($body);
```

### Exemplos mais elaborados

O método add suporta qualquer callable (php.net/callable) facilitando a criação dos comandos e permitindo uma organização das instruções.

```php
$bot->add('/start', Start::class);

class Start
{
    /**
     * @param Bot $bot
     * @param array $message
     * @throws Exception
     */
    function __invoke($bot, $message)
    {
        $chatId = $message['chat']['id'];
        $parameters = [
            'chat_id' => $chatId,
            "text" => 'Hello',
            'reply_markup' => ['keyboard' => [['Hello', 'Hi']], 'one_time_keyboard' => true, 'resize_keyboard' => true]
        ];
        $bot->apiRequestJson('sendMessage', $parameters);
    }
}
```

Também é possível adicionar um arquivo que contenha uma função para adicionar as ações
```php
$telegram->actions(dirname(__DIR__) . '/actions/text.php');
```
Onde o arquivo `actions/text.php` é algo como
```php
<?php

use App\Actions\OtherWise;
use App\Telegram\Bot;

return function (Bot $bot) {
    $bot->add('.*', OtherWise::class);
};
```