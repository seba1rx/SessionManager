<?php

namespace App;

use App\TemplateEngine;

class Controller
{
    private $response;

    public function __construct()
    {
        $this->response = new \stdClass;
    }

    public function start():string
    {
        $html = TemplateEngine::render(tpl_dir("main.php"));
        return $html;
    }

    public function hello(): object
    {
        $this->response->dialog = "Hello from backend!";
        return $this->response;
    }

    public function demoData(): object
    {
        $data = new \stdClass;
        $data->foo = "foo";
        $data->bar = "bar";
        $data->baz = "baz";

        $this->response->dialog = json_encode($data);

        return $this->response;
    }
}