<?php
namespace WScore\Html\Tags;

class ToString
{
    /**
     * @param Tag $html
     * @return string
     */
    public static function from(Tag $html): string
    {
        if ($html instanceof Choices ) {
            return self::choiceToString($html);
        }
        return self::htmlToString($html);
    }

    /**
     * @param Choices $html
     * @return string
     */
    private static function choiceToString(Choices $html): string
    {
        if ($html->getTagName() === 'select') {
            return self::choiceToSelectString($html);
        }
        if (empty($html->getChoices())) {
            return self::choiceToInputString($html);
        }
        $string = '';
        foreach ($html->getChoices() as $choice) {
            $string .= Tag::create('label')
                    ->setContents(
                        self::choiceToInputString($choice) . ' ' . $choice->getLabel()) . "\n";
        }
        return $string;
    }

    /**
     * @param Choices $form
     * @return string
     */
    private static function choiceToInputString(Choices $form): string
    {
        if (!$form->getInitValue()) {
            return self::htmlToString($form);
        }
        $values = (array) $form->getInitValue();
        if (in_array($form->get('value'), $values)) {
            $form->set('checked', true);
        }
        return self::htmlToString($form);
    }

    /**
     * @param Choices $form
     * @return string
     */
    private static function choiceToSelectString(Choices $form): string
    {
        if ($form->isMultiple()) {
            $form->name($form->get('name') . '[]');
        }
        foreach ($form->getChoices() as $option) {
            $value = $option->get('value');
            $label = $option->getLabel();
            $form->setContents("<option value=\"{$value}\">{$label}</option>");
        }
        return self::htmlToString($form);
    }

    /**
     * @param Tag $html
     * @return string
     */
    private static function htmlToString(Tag $html): string
    {
        $attributes = self::makeAttributes($html);
        if ($html->hasCloseTag()) {
            $contents = implode("\n", $html->getContents());
            if (count($html->getContents()) > 1) {
                $contents = "\n" . $contents . "\n";
            }
            return "<{$attributes}>{$contents}</{$html->getTagName()}>";
        }
        return "<{$attributes}>";
    }

    private static function makeAttributes(Tag $tag): string
    {
        $attributes = $tag->getAttributes();
        $list = [$tag->getTagName()];
        foreach ($attributes as $key => $attribute) {
            $attr = htmlspecialchars($attribute, ENT_QUOTES);
            if (!$attr) continue;
            $list[] = "{$key}=\"{$attr}\"";
        }
        return implode(' ', $list);
    }
}