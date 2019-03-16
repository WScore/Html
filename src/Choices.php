<?php

declare(strict_types=1);

namespace WScore\Html;

class Choices extends Input
{
    /**
     * @var string[]
     */
    private $choices = [];

    /**
     * @var bool
     */
    private $multiple = false;

    /**
     * @var bool
     */
    private $expand = true;

    /**
     * @var string|string[]
     */
    private $initValue = null;

    /**
     * @var string
     */
    private $label = '';

    /**
     * @param string $name
     * @param array $choices
     * @param string|string[] $initValue
     * @return Choices
     */
    public static function createNew(string $name, array $choices = [], $initValue = ''): self
    {
        $form = static::create('input')
            ->set('type', 'radio')
            ->name($name);
        $form->choices = $choices;
        $form->initValue = $initValue;

        return $form;
    }

    /**
     * @param bool $multiple
     * @return Choices
     */
    public function multiple(bool $multiple = true): self
    {
        $this->multiple = $multiple;
        $this->setupTagName();

        return $this;
    }

    /**
     * @param bool $expand
     * @return Choices
     */
    public function expand(bool $expand = true): self
    {
        $this->expand = $expand;
        $this->setupTagName();

        return $this;
    }

    private function setupTagName()
    {
        if (!$this->expand) {
            $this->setTagName('select')->remove('type');
            return;
        }
        if ($this->multiple) {
            $this->setTagName('input')->reset('type', 'checkbox');
            return;
        }
        $this->setTagName('input')->reset('type', 'radio');
        return;
    }

    /**
     * @param null|Html $html
     * @return string
     * @throws \ReflectionException
     */
    public function toString($html = null): string
    {
        return ToString::from($this);
    }

    /**
     * @return self[]
     */
    public function getChoices(): array
    {
        $choices = [];
        $idx = 0;
        foreach ($this->choices as $value => $label) {
            $choice = clone($this);
            $choice->choices = [];
            $choice->label = $label;
            $choice->value($value);
            if ($choice->multiple) {
                $choice->name($choice->get('name') . "[{$idx}]");
            }

            $choices[] = $choice;
            $idx ++;
        }
        return $choices;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string|string[] $initValue
     * @return Choices
     */
    public function setInitValue($initValue): self
    {
        $this->initValue = $initValue;
        return $this;
    }

    /**
     * @return string|string[]
     */
    public function getInitValue()
    {
        return $this->initValue;
    }

    /**
     * @return bool
     */
    public function isMultiple(): bool
    {
        return $this->multiple;
    }
}