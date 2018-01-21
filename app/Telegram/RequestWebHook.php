<?php

namespace App\Telegram;

/**
 * Trait RequestWebHook
 * @package App
 */
trait RequestWebHook
{
    /**
     * @param string $method
     * @param array $parameters
     * @return bool
     */
    function apiRequestWebhook($method, $parameters = [])
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

        header("Content-Type: application/json");
        echo json_encode($parameters);
        return true;
    }
}