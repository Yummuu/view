<?php

declare(strict_types=1);

namespace Yummuu\View;

use Yummuu\View\Compiler\CompilerInterface;
use Yummuu\View\Compiler\BladeCompiler;
class Engine
{
    /**
     * @var CompilerInterface
     */
    protected $compiler;

    public function render(string $template, array $data = [], array $config = [])
    {
        $tplClass = new MyTpl();
        return $tplClass->render($template, $data);
    }

    /**
     *
     * @param string $template  模板文件
     * @param array $data       数据
     * @return string
     */
    public function getContents(string $template, array $data = [])
    {
        $this->compiler = new BladeCompiler();
        return $this->compiler->compile($template)->toString($data);
    }
}
