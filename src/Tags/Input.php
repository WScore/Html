<?php
namespace WScore\Html\Tags;

class Input extends Tag
{
    /**
     * @param string $type
     * @return $this
     */
    public function type(string $type): self
    {
        return $this->reset('type', $type);
    }

    /**
     * @param string $name
     * @return $this
     */
    public function name(string $name): self
    {
        $this->reset('name', $name);
        $id = str_replace(['[', ']'], '_', $name);
        return $this->id($id);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function value(string $value): self
    {
        return $this->reset('value', $value);
    }

    /**
     * @param bool $required
     * @return Input
     */
    public function required(bool $required = true): self
    {
        return $this->set('required', $required);
    }
}