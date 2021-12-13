<?php

namespace Yummuu\View;

use Yummuu\View\Engine;
use PHPUnit\Framework\TestCase;

class EngineTest extends TestCase
{
    public function render()
    {
        $engine = new Engine();
        $this->assertIsString($engine->render(''));
    }
}