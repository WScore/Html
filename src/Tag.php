<?php

declare(strict_types=1);

namespace WScore\Html;

class Tag
{
    private $tagName = '';

    private $attributes = [];

    private $contents = [];

    private $hasContents = true;

    public static $noCloseTags = [
        'img', 'input', 'br',
    ];

    private function __construct(string $tagName)
    {
        $this->tagName = $tagName;
        if (in_array($tagName, self::$noCloseTags)) {
            $this->setHasContents(false);
        }
    }

    /**
     * @param string $tagName
     * @return $this
     */
    public static function create(string $tagName): self
    {
        $self = new static($tagName);
        return $self;
    }

    /**
     * @param string $key
     * @param bool|string $value
     * @param string $conn
     * @return $this
     */
    public function setAttribute(string $key, $value, string $conn = ' '): self
    {
        if ($value === false) {
            return $this->removeAttribute($key);
        }
        if (isset($this->attributes[$key]) && $this->attributes[$key]) {
            $this->attributes[$key] .= $conn . $value;
            return $this;
        }
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function resetAttribute(string $key, string $value): self
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function removeAttribute(string $key): self
    {
        unset($this->attributes[$key]);
        return $this;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasAttribute(string $key): bool
    {
        return isset($this->attributes[$key]);
    }

    private function makeAttributes(): string
    {
        $list = [$this->tagName];
        foreach ($this->attributes as $key => $attribute) {
            $attr = htmlspecialchars($attribute, ENT_QUOTES);
            if (!$attr) continue;
            $list[] = "{$key}=\"{$attr}\"";
        }
        return implode(' ', $list);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        $attributes = $this->makeAttributes();
        if ($this->hasContents) {
            $contents = implode("\n", $this->contents);
            if (count($this->contents) > 1) {
                $contents = "\n" . $contents . "\n";
            }
            return "<{$attributes}>{$contents}</{$this->tagName}>";
        }
        return "<{$attributes} />";
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @param bool $hasContents
     * @return $this
     */
    public function setHasContents(bool $hasContents): self
    {
        $this->hasContents = $hasContents;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasContents(): bool
    {
        return $this->hasContents;
    }

    /**
     * @param mixed ...$contents
     * @return $this
     */
    public function setContents(...$contents)
    {
        foreach ($contents as $content) {
            if (!$content) continue;
            $this->contents[] = $content;
        }
        return $this;
    }

    /**
     * @param string $class
     * @return $this
     */
    public function class(string $class): self
    {
        return $this->setAttribute('class', $class, ' ');
    }

    /**
     * @param string $style
     * @return $this
     */
    public function style(string $style): self
    {
        return $this->setAttribute('style', $style, '; ');
    }
}