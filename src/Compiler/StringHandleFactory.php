<?php

declare(strict_types=1);

namespace Yummuu\View\Compiler;

use Exception;

class StringHandleFactory
{
    public static function get($item,$field = 'type'): string
    {
        if (!$item) {
            return '';
        }
        if (is_object($item)) {
            $item = get_object_vars($item);
        }
        if (is_array($item)) {
            if(isset($item[$field])){
                $map = [
                    'css'  => Concern\CssStringHandle::class,
                    'js'   => Concern\JsStringHandle::class,
                    'form' => Concern\FormStringHandle::class,
                    'list' => Concern\ListStringHandle::class,
                ];
                if(isset($map[$item[$field]])) {
                    $class = new $map[$item[$field]];
                    if($class instanceof StringHandleInterface) {
                        return $class->format($item);
                    } else {
                        throw new Exception('未知类型引用');
                    }
                } else {
                    return "";
                    throw new Exception('未知map引用');
                }
            } else {
                return self::get($item,$field);    //递归调用
            }
        } else {
            return (string)$item;
        }
    }
}
