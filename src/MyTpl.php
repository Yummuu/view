<?php

declare(strict_types=1);

namespace Yummuu\View;

class MyTpl
{
    public $tplArray;
    public $key;
    public $value;
    public $config;

    public function render($template, $contents)
    {
        $filePath = $template ? dirname(__DIR__) . '/src/Template/' . $template . '.html' : dirname(__DIR__) . '/src/Template/default.html';
        extract($contents, EXTR_OVERWRITE);
        include $filePath;
    }
}
