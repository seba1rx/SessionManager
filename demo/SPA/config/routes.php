<?php

return [
    "POST" => [
        "/login" => [SPA\App\Authentication::class, "login"],
    ],
    "GET" => [
        "/" => [SPA\App\Controller::class, "start"],
        "/hello" => [SPA\App\Controller::class, "hello"],
        "/demoData" => [SPA\App\Controller::class, "demoData"],
    ],
    "PUT" => [],
    "DELETE" => [],
];