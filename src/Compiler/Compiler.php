<?php

declare(strict_types=1);

namespace Yummuu\View\Compiler;

abstract class Compiler
{
    /**
     * The Filesystem instance.
     *
     */
    protected $files;

    /**
     * Get the cache path for the compiled views.
     *
     * @var null|string
     */
    protected $cachePath;

    protected $htmlStr;

    /**
     * Get the path to the compiled version of a view.
     *
     * @param string $path
     * @return string
     */
    public function getCompiledPath($path)
    {
        return $this->cachePath . '/' . sha1($path) . '.php';
    }

    /**
     * Determine if the view at the given path is expired.
     *
     * @param string $path
     * @return bool
     */
    public function isExpired($path)
    {
        $compiled = $this->getCompiledPath($path);

        if (file_exists($compiled)) {
            return true;
        } else {
            return false;
        }
    }

    public function toString($data = [])
    {
        /**
         * 替换内容
         */
        $pattern = "/<\?php[\n\r\s]+echo[\n\r\s]+(.*?)[\n\r\s]+\?>/s";
        $this->htmlStr = preg_replace($pattern, '{{ ${1} }}', $this->htmlStr);
        /**
         * 生成内容
         */
        $result = [];
        foreach ($data as $key => $value) {
            $result[$key] = StringHandleFactory::get($value);
            $this->compilePhpEcho($key, $result[$key]);
        }
        return $this->htmlStr;
    }

    protected function compilePhpEcho($key, $value)
    {
        $search = "{{ $" . $key . " }}";
        $this->htmlStr = str_replace($search, $value, $this->htmlStr);
    }
}
