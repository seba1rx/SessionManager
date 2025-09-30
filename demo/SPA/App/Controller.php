<?php

namespace SPA\App;

class Controller
{
    public function start():string
    {
        return "start";
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