<?php

use Illuminate\Support\Facades\Log;

/**
 * Response body
 *
 * @param boolean $status Response Status.
 * @param integer $code Response code.
 * @param string $message Response message.
 * @param array $data Response data.
 * @param string $details Response data's details.
 * @return array
 */

if (!function_exists('responseData')) {
    function responseData($status, $code, $message, $data = "", $details = null): array
    {
        $response = [
            'status'  => $status,
            'code'    => $code,
            'message' => $message
        ];

        if ($details) {
            $response['data'] = [
                'details' => $details
            ];
        } else {
            $response['data'] = $data;
        }

        return $response;
    }
}

if (!function_exists('infoLog')) {
    function infoLog(string $method, string $message, array $data): void
    {
        Log::channel('local')->info($method . '-' . $message, $data);
    }
}

if (!function_exists('errorLog')) {
    function errorLog(string $method, string $message, array $data): void
    {
        Log::channel('local')->error($method . '-' . $message, $data);
    }
}
