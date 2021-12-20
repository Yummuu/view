<?php

declare(strict_types=1);

namespace Yummuu\View\Compiler\Concern;

use Yummuu\View\Compiler\StringHandleInterface;

class CssStringHandle implements StringHandleInterface
{
    /**
     * 格式化数据
     *
     * @param [type] $data
     * @return string
     */
    public function format($data): string
    {
        $result = '';
        $css    = isset($data['value']) ? $data['value'] : "";
        $list   = isset($data['list']) ? $data['list'] : [];
        foreach ($list as $key => $value) {
            $result .= <<<EOF
            <link rel="stylesheet" href="$value">
EOF;
        }
        $result .= "<style>$css</style>";
        return $result;
    }
}
