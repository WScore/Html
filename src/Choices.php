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
     */
    public function toString($html = null): string
    {
        $form = clone($this);
        if ($form->getTagName() === 'select') {
            return $this->toSelectString($form);
        }
        if (empty($this->choices)) {
            return $this->toChoiceString($form);
        }
        $html = '';
        foreach ($form->getChoices() as $choice) {
            $html .= Html::create('label')
                ->setContents(
                    $this->toChoiceString($choice) . ' ' . $choice->label) . "\n";
        }
        return $html;
    }

    private function toChoiceString(Choices $form): string
    {
        if (!$form->initValue) {
            return parent::toString($form);
        }
        $values = (array) $form->initValue;
        if (in_array($form->get('value'), $values)) {
            $form->set('checked', true);
        }
        return parent::toString($form);
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

    private function toSelectString(Choices $form): string
    {
        if ($form->multiple) {
            $form->name($form->get('name') . '[]');
        }
        foreach ($this->choices as $value => $label) {
            $form->setContents("<option value=\"{$value}\">{$label}</option>");
        }
        return parent::toString($form);
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
}