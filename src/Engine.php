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

    //data设计:{"name":{"type":"css","value":"","list":[]},"name1":{"type":"js","value":"","list":[]},"name2":{"type":"form","form":"","content":""},"name3":{"type":"list","content":""}}
    public function getContens(string $template, array $data = [])
    {
        $this->compiler = new BladeCompiler();
        return $this->compiler->compile($template)->toString($data);
    }
}
