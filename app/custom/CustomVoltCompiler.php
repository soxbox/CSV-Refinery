<?php
/**
 * Created by PhpStorm.
 * User: Nathan
 * Date: 11/28/2014
 * Time: 12:05 AM
 */


class CustomVoltCompiler extends \Phalcon\Mvc\View\Engine\Volt\Compiler
{
    protected function _compileSource($source, $something = null)
    {
        $source = str_replace('{{', '<' . '?php $ng = <<<NG' . "\n" . '\x7B\x7B', $source);
        $source = str_replace('}}', '\x7D\x7D' . "\n" . 'NG;' . "\n" . ' echo $ng; ?' . '>', $source);

        $source = str_replace('[[', '{{', $source);
        $source = str_replace(']]', '}}', $source);

        return parent::_compileSource($source, $something);
    }
}