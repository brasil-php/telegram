<?php

namespace Telegram;

use Telegram\Model\Match;

/**
 * Trait Router
 * @package Telegram
 */
trait Router
{
    /**
     * @var array
     */
    private $routes = [];

    /**
     * @param string $type
     * @param string $pattern
     * @param callable $callable
     * @param array $options
     * @return Bot
     */
    public function on($type, $pattern, $callable, $options = [])
    {
        $pattern = '/' . str_replace('/', '\/', $pattern) . '$/';
        $this->register($type, $pattern, $callable, $options);
        /** @var Bot $this */
        return $this;
    }

    /**
     * @param $pattern
     * @param $callable
     * @param array $options
     * @return Router
     */
    public function text($pattern, $callable, $options = [])
    {
        return $this->on($pattern, $callable, $options);
    }

    /**
     * @param string $type
     * @param string $pattern
     * @param callable $callable
     * @param array $options
     */
    private function register($type, $pattern, $callable, $options)
    {
        if (!isset($this->routes[$type])) {
            $this->routes[$type] = [];
        }
        $this->routes[$type][$pattern] = array_merge([
            '$pattern' => $pattern,
            '$callable' => $callable,
        ], $options);
    }

    /**
     * @param array $message
     * @return Match|null
     */
    public function match($message)
    {
        $type = '';
        $subject = '';
        if (isset($message['text'])) {
            $type = 'text';
            $subject = $message['text'];
        }

        $candidates = null;
        if (!isset($this->routes[$type])) {
            $candidates = $this->routes[$type];
        }

        if (is_null($candidates)) {
            return null;
        }

        // search by $match
        foreach ($candidates as $pattern => $candidate) {
            if (preg_match($pattern, $subject, $parameters)) {
                array_shift($parameters);
                $properties = array_merge(
                    ['$parameters' => $parameters, '$message' => $message],
                    $candidate
                );
                return Match::make($properties);
            }
        }
        return null;
    }
}
