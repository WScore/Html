<?php
namespace WScore\Html;

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
        return $this->reset('name', $name);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function value(string $value): self
    {
        return $this->reset('value', $value);
    }
}