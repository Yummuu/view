<?php

declare(strict_types=1);

namespace Yummuu\View;

class Engine
{
    public function render(string $template, array $data = [], array $config = [])
    {
        $tplClass = new MyTpl();
        return $tplClass->render($template,$data);
    }
}
