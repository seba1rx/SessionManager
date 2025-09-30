<?php

require __DIR__."/vendor/autoload.php";
require __DIR__."/../../vendor/autoload.php";

// set_exception_handler(function (Throwable $e) {
//     echo "File: " . $e->getFile() . " Line: " . $e->getLine() . " ". $e->getMessage() . "\n";
// });

use SPA\App\Router;
use SPA\App\Response;

$routes = require __DIR__."/config/routes.php";

$router = new Router($routes);
$response = $router->routeToAction();

error_log(json_encode($response));

Response::respond($response);