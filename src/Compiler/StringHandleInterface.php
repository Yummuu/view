<?php

declare(strict_types=1);

namespace Yummuu\View\Compiler;

interface StringHandleInterface
{
    public function format($value): string;
}
