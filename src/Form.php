<?php
namespace WScore\Html;

class Form
{
    /**
     * @param string $action
     * @param string $method
     * @return Html
     */
    public static function open(string $action = '', string $method='post'): Html
    {
        $form = Html::create('form')
            ->set('action', $action)
            ->set('method', $method)
            ->setHasCloseTag(false);
        return $form;
    }

    /**
     * @param string $action
     * @return Html
     */
    public static function openForUpload(string $action = ''): Html
    {
        $form = Html::create('form')
            ->set('action', $action)
            ->set('method', 'post')
            ->set('enctype', 'multipart/form-data')
            ->setHasCloseTag(false);
        return $form;
    }

    /**
     * @return string
     */
    public static function close(): string
    {
        return "</form>";
    }

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