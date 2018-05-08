<?php

namespace PhpBrasil\Telegram;

use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as Monolog;

/**
 * Trait Logger
 * @package PhpBrasil\Telegram
 */
trait Logger
{
    /**
     * @var Monolog
     */
    private static $logger;

    /**
     * @return Monolog
     * @throws Exception
     */
    final static function instance()
    {
        if (static::$logger) {
            return static::$logger;
        }
        static::$logger = new Monolog('logger');
        static::$logger->pushHandler(new StreamHandler(APP_ROOT . '/log/index.log', Monolog::DEBUG));
        return static::$logger;
    }

    /**
     * Adds a log record at an arbitrary level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  mixed $level The log level
     * @param  string $message The log message
     * @param  array $context The log context
     * @return Boolean Whether the record has been processed
     * @throws Exception
     */
    public function log($level, $message, array $context = [])
    {
        return static::instance()->log($level, $message, $context);
    }

    /**
     * Adds a log record at the DEBUG level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array $context The log context
     * @return Boolean Whether the record has been processed
     * @throws Exception
     */
    public function debug($message, array $context = [])
    {
        return static::instance()->debug($message, $context);
    }

    /**
     * Adds a log record at the INFO level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array $context The log context
     * @return Boolean Whether the record has been processed
     * @throws Exception
     */
    public function info($message, array $context = [])
    {
        return static::instance()->info($message, $context);
    }

    /**
     * Adds a log record at the NOTICE level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array $context The log context
     * @return Boolean Whether the record has been processed
     * @throws Exception
     */
    public function notice($message, array $context = [])
    {
        return static::instance()->notice($message, $context);
    }

    /**
     * Adds a log record at the WARNING level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array $context The log context
     * @return Boolean Whether the record has been processed
     * @throws Exception
     */
    public function warning($message, array $context = [])
    {
        return static::instance()->warning($message, $context);
    }

    /**
     * Adds a log record at the ERROR level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array $context The log context
     * @return Boolean Whether the record has been processed
     * @throws Exception
     */
    public function error($message, array $context = [])
    {
        return static::instance()->error($message, $context);
    }

    /**
     * Adds a log record at the CRITICAL level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array $context The log context
     * @return Boolean Whether the record has been processed
     * @throws Exception
     */
    public function critical($message, array $context = [])
    {
        return static::instance()->critical($message, $context);
    }

    /**
     * Adds a log record at the ALERT level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array $context The log context
     * @return Boolean Whether the record has been processed
     * @throws Exception
     */
    public function alert($message, array $context = [])
    {
        return static::instance()->alert($message, $context);
    }

    /**
     * Adds a log record at the EMERGENCY level.
     *
     * This method allows for compatibility with common interfaces.
     *
     * @param  string $message The log message
     * @param  array $context The log context
     * @return Boolean Whether the record has been processed
     * @throws Exception
     */
    public function emergency($message, array $context = [])
    {
        return static::instance()->emergency($message, $context);
    }
}
