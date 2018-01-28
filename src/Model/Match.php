<?php

namespace Telegram\Model;

/**
 * Class Match
 * @package Telegram\Model
 */
class Match
{
    /**
     * @var array
     */
    private $properties;

    /**
     * Match constructor.
     * @param $properties
     */
    public function __construct($properties)
    {
        $this->properties = $properties;
    }

    /**
     * @param $properties
     * @return static
     */
    public static function make($properties)
    {
        return new static($properties);
    }

    /**
     * @param string $property
     * @param mixed $default
     * @return mixed|null
     */
    public function get($property, $default = null)
    {
        return isset($this->properties[$property]) ? $this->properties[$property] : $default;
    }
}