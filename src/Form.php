<?php
namespace WScore\Html;

use WScore\Html\Tags\Choices;
use WScore\Html\Tags\Tag;
use WScore\Html\Tags\Input;

class Form
{
    /**
     * @param string $action
     * @param string $method
     * @return Tag
     */
    public static function open(string $action = '', string $method='post'): Tag
    {
        $form = Tag::create('form')
            ->set('action', $action)
            ->set('method', $method)
            ->setHasCloseTag(false);
        return $form;
    }

    /**
     * @param string $action
     * @return Tag
     */
    public static function openForUpload(string $action = ''): Tag
    {
        $form = Tag::create('form')
            ->set('action', $action)
            ->set('method', 'post')
            ->set('enctype', 'multipart/form-data')
            ->setHasCloseTag(false);
        return $form;
    }

    /**
     * @return Tag
     */
    public static function close(): Tag
    {
        return Tag::create("/form")
            ->setHasCloseTag(false);
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

    /**
     * @param string $name
     * @param array $choices
     * @param string $value
     * @return Choices
     */
    public static function choices(string  $name, array $choices = [], $value = ''): Choices
    {
        return Choices::createNew($name, $choices, $value);
    }
}