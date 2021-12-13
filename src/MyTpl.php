<?php

declare(strict_types=1);

namespace Yummuu\View;

class MyTpl
{
    public $tplArray;
    public $key;
    public $value;

    public function render($template, $contents)
    {
        $filePath = $template ? dirname(__DIR__) . '/src/template/' . $template . '.html' : dirname(__DIR__) . '/src/template/default.html';
        extract($contents, EXTR_OVERWRITE);
        include $filePath;
    }
}
