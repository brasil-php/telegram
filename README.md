# Telegram Bot API

Este projeto visa criar uma estrutura de recursos para utilizar a API de bots do Telegram.

## Como usar

Para entregar uma API simplificada o SDK possui uma classe que agrega as features para o bot.
```php
use PhpBrasil\Telegram\Bot;

$telegram = new Bot(env('BOT_TOKEN'));
```
Com estas instruções acima temos uma instância do Bot disponível para adicionar os comandos.

### Gerar Log

O trecho abaixo mostra um exemplo de como gerar um log de uma requisição no webhook. O bot suporta todos os níveis de logs propostos pelas [PSR-3](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md).
```php
$input = File::read('php://input');
$body = JSON::decode($input, true);

$telegram = new Bot(environment('APP_TOKEN'));

if (environment('APP_DEBUG')) {
    $telegram->info(
        get($body, 'message.message_id'),
        $body
    );
}
```

### Adcionar Regras Regex nas Mensagens

O exemplo abaixo mostra como podemos adicionar um comando para o Bot para ao receber uma mensagem que comece com `Hello` ou `Hi` ele responda `Nice to meet you`.
```php
$bot->on('text', '^Hello|^Hi', function($bot, $match) {
    $message = $match->get('$message');
    $chatId = get($message, 'chat.id');
    /** @var Bot $bot */
    return $bot->apiRequest(
        'sendMessage', ['chat_id' => $chatId, "text" => 'Nice to meet you']
    );
});
```

O bot conta com métodos para lidar com os tipos de mensagem de forma separada.
```php
$input = File::read('php://input');
$body = JSON::decode($input, true);

// add actions to bot
$bot->text(/* regex over message */, /* callable */);
$bot->text(/* regex over message */, /* callable */);

// apply the actions
$telegram->handleText($body);
```

### Lidando com mensages tipo `text`

O método add suporta qualquer callable (php.net/callable) facilitando a criação dos comandos e permitindo uma organização das instruções.

#### Class & __invoke

A instrução abaixo adiciona o listener ao comando `/start`
```php
$bot->text('/start', Start::class);
```
Relacionando-o à classe Start
```php
/**
 * Class Start
 */
class Start
{
    /**
     * @param Bot $bot
     * @param Match $match
     * @param array $message
     * @throws Exception
     * @SuppressWarnings(Unused)
     */
    function __invoke($bot, $match, $message)
    {
        $chatId = get($message, 'chat.id');
        $parameters = [
            'chat_id' => $chatId,
            "text" => 'Hello',
            'reply_markup' => ['keyboard' => [['Hello', 'Hi']], 'one_time_keyboard' => true, 'resize_keyboard' => true]
        ];
        $bot->answer($parameters);
    }
}
```

#### Actions File

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
    $bot->text('.*', OtherWise::class);
};
```

#### Anonymous Functions

A classe Bot possui alguns métodos simplificadas como o reply ou replyTo.
```php
$bot->text('^Hello|^Hi', function($bot) {
    return $bot->reply('Nice to meet you');
});
```

### Interagindo com a mensagem

Criando grupos de expressão regular é possível interagir com a mensagem de forma simples e rápida
```php
$bot->text('How much is (?<n1>.*) \+ (?<n2>.*)\?', function (Bot $bot, Match $match) {
    $parameters = $match->get('$parameters');
    if (count($parameters) !== 2) {
        return $bot->reply('Can`t resolve this math');
    }
    $sum = get($parameters, 'n1') + get($parameters, 'n2');
    return $bot->reply("That is easy, the answer is `{$sum}`");
});
```
