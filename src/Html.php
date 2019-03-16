<?php

declare(strict_types=1);

namespace WScore\Html;

class Html
{
    private $tagName = '';

    private $attributes = [];

    private $contents = [];

    private $hasCloseTag = true;

    public static $noCloseTags = [
        'img', 'input', 'br',
    ];

    private function __construct(string $tagName)
    {
        $this->tagName = $tagName;
        if (in_array($tagName, self::$noCloseTags)) {
            $this->setHasCloseTag(false);
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
    public function set(string $key, $value, string $conn = ' '): self
    {
        if ($value === false) {
            return $this->remove($key);
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
     * @return string|null
     */
    public function get(string $key): ?string
    {
        return array_key_exists($key, $this->attributes) ?$this->attributes[$key]: null;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function reset(string $key, string $value): self
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function remove(string $key): self
    {
        unset($this->attributes[$key]);
        return $this;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
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
        if ($this->hasCloseTag) {
            $contents = implode("\n", $this->contents);
            if (count($this->contents) > 1) {
                $contents = "\n" . $contents . "\n";
            }
            return "<{$attributes}>{$contents}</{$this->tagName}>";
        }
        return "<{$attributes}>";
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @param bool $hasCloseTag
     * @return $this
     */
    public function setHasCloseTag(bool $hasCloseTag): self
    {
        $this->hasCloseTag = $hasCloseTag;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasContents(): bool
    {
        return $this->hasCloseTag;
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
        return $this->set('class', $class, ' ');
    }

    /**
     * @param string $style
     * @return $this
     */
    public function style(string $style): self
    {
        return $this->set('style', $style, '; ');
    }
}