<?php

declare(strict_types=1);

namespace Yummuu\View;

class Engine
{
    public function render(string $template, array $data = [], array $config = [])
    {
        # code...
        return $template;
    }

    public static function hello()
    {
        return 'hello!';
    }
}
