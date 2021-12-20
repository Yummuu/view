<?php

declare(strict_types=1);

namespace Yummuu\View\Compiler;

class BladeCompiler extends Compiler implements CompilerInterface
{

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path)
    {
        $this->path = $path;
    }

    public function compile($path) : object
    {
        if (file_exists($path)) {
            $contents = file_get_contents($path);
        } else {
            $default  = dirname(__DIR__) . '/Template/default.html';
            $contents = file_get_contents($default);
        }
        $this->compileString($contents);
        return $this;
    }

    public function compileString(string $value): string
    {
        $this->htmlStr = $value;
        return $value;
    }
}
