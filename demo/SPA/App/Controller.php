<?php

namespace App;

use App\TemplateEngine;

class Controller
{

    public function start():string
    {
        $html = TemplateEngine::render(tpl_dir("main.php"));
        return $html;
    }

    public function hello(): string
    {
        return "hello";
    }

    public function demoData(): object
    {
        $data = new \stdClass;
        $data->foo = "foo";
        $data->bar = "bar";
        $data->baz = "baz";
        return $data;
    }
}