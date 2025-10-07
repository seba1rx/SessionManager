<?php

return [

    "GET" => [
        "/" => [App\Controller::class, "start"],
    ],
    "POST" => [
        "/hello" => [App\Controller::class, "hello"],
        "/reloadSessionData" => [App\Controller::class, "reloadSessionData"],
        "/showLogin" => [App\Controller::class, "showLogin"],
        "/authenticate" => [App\Authentication::class, "authenticate"],
        "/demoData" => [App\Controller::class, "demoData"],
        "/logout" => [App\Controller::class, "logout"],
    ],
    "PUT" => [],
    "DELETE" => [],
];