<?php

namespace Telegram;

use Exception;

/**
 * Trait RequestJson
 * @package Telegram
 */
trait RequestJson
{

    /**
     * @param $method
     * @param $parameters
     * @return bool|mixed
     * @throws Exception
     */
    function apiRequestJson($method, $parameters)
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

        $parameters["method"] = $method;

        $handle = curl_init("$this->api/");
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
        curl_setopt($handle, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

        return $this->request($handle);
    }
}
