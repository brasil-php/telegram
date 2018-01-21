<?php

namespace App\Telegram;

use Exception;

/**
 * Trait Request
 * @package App\Telegram
 */
trait Request
{
    /**
     * @param string $method
     * @param array $parameters
     * @return bool
     * @throws Exception
     */
    function apiRequest($method, $parameters = [])
    {
        if (!is_string($method)) {
            error_log("Method name must be a string\n");
            return false;
        }

        if (!$parameters) {
            $parameters = [];
        }
        if (!is_array($parameters)) {
            error_log("Parameters must be an array\n");
            return false;
        }

        foreach ($parameters as &$val) {
            // encoding to JSON array parameters, for example reply_markup
            if (!is_numeric($val) && !is_string($val)) {
                $val = json_encode($val);
            }
        }
        $query = http_build_query($parameters);

        $handle = curl_init("{$this->api}/{$method}?{$query}");
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);

        return $this->request($handle);
    }
}