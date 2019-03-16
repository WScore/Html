<?php
namespace WScore\Html;

class Html
{
    /**
     * @param string $type
     * @param string $name
     * @param string $value
     * @return Input
     */
    public static function input(string $type, string $name, string $value = ''): Input
    {
        return Input::create('input')
            ->type($type)
            ->name($name)
            ->value($value);
    }

    /**
     * @param string $name
     * @param string $value
     * @return Input
     */
    public static function textArea(string $name, string $value = ''): Input
    {
        return Input::create('textarea')
            ->name($name)
            ->setContents($value);
    }
}