<?php
namespace WScore\Html;

use WScore\Html\Tags\Tag;

/**
 * Class Html
 * @package WScore\Html
 *
 * @method static Tag div(...$contents)
 * @method static Tag ul(...$contents)
 * @method static Tag li(...$contents)
 * @method static Tag a(...$contents)
 */
class Html
{
    /**
     * @param string $tagName
     * @return Tag
     */
    public static function create(string $tagName): Tag
    {
        $self = new Tag($tagName);
        return $self;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return Tag
     */
    public static function __callStatic($name, $arguments): Tag
    {
        $html = self::create($name);
        if ($arguments) {
            $html->setContents(...$arguments);
        }
        return $html;
    }
}