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
        return $this->resetAttribute('type', $type);
    }

    /**
     * @param string $name
     * @return $this
     */
    public function name(string $name): self
    {
        return $this->resetAttribute('name', $name);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function value(string $value): self
    {
        return $this->resetAttribute('value', $value);
    }
}