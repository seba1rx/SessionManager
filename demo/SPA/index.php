<?php

require __DIR__."/vendor/autoload.php";
require __DIR__."/../../vendor/autoload.php";

set_exception_handler(function (Throwable $e) {
    $msg = "File: " . $e->getFile() . " Line: " . $e->getLine() . " ". $e->getMessage() . "\n";
    error_log($msg);
});

use App\Router;
use App\Response;
use App\MySPASessionAdmin;

$routes = require __DIR__."/config/routes.php";

// include the session script
include __DIR__."/config/session.php";

/**
 * Globally scoped function
 * @return string
 */
function tpl_dir($tpl): string
{
    return __DIR__."/App/tpl/".$tpl;
}

/**
 * Globally scoped function
 */
function sessionAdmin(): MySPASessionAdmin
{
    global $spa_sessionAdmin;
    return $spa_sessionAdmin;
}

$router = new Router($routes);
$response = $router->routeToAction();

Response::send($response);