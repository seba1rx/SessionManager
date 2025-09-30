<?php

namespace SPA\APP;

class Response
{
    public static function respond(mixed $data): void
    {
        $isXHR = !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
                && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($isXHR) {
            // JSON response
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'status' => 'ok',
                'data'   => $data
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            // HTML response
            header('Content-Type: text/html; charset=utf-8');
            if (is_array($data) || is_object($data)) {
                echo "<pre>" . htmlspecialchars(print_r($data, true)) . "</pre>";
                // echo json_encode($data);
            } else {
                echo $data;
            }
        }
    }
}



