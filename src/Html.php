<?php
namespace WScore\Html;

use WScore\Html\Tags\Tag;

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

}