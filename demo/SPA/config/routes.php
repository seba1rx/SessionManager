<?php

return [

    // all the GET routes will be echoed with a Content-Type: text/html header
    "GET" => [
        "/" => [App\Controller::class, "start"],
        "/hello" => [App\Controller::class, "hello"],
        "/demoData" => [App\Controller::class, "demoData"],
    ],
    // any POST, PUT, DELETE route will be sent as a json with a Content-Type: application/json header
    "POST" => [
        "/login" => [App\Authentication::class, "login"],
        "/data" => [App\Controller::class, "data"],
    ],
    "PUT" => [],
    "DELETE" => [],
];