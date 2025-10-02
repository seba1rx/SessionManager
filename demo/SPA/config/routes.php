<?php

return [

    "GET" => [
        "/" => [App\Controller::class, "start"],
        "/private" => [App\Controller::class, "private"],
    ],
    "POST" => [
        "/hello" => [App\Controller::class, "hello"],
        "/demoData" => [App\Controller::class, "demoData"],
        "/login" => [App\Authentication::class, "login"],
        "/data" => [App\Controller::class, "data"],
    ],
    "PUT" => [],
    "DELETE" => [],
];