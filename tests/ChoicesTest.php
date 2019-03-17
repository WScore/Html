<?php
/**
 * Created by PhpStorm.
 * User: wsjp
 * Date: 2019/03/16
 * Time: 18:16
 */

use PHPUnit\Framework\TestCase;
use WScore\Html\Form;
use WScore\Html\Tags\Choices;
use WScore\Html\Tags\Tag;

class ChoicesTest extends TestCase
{
    private function buildChoices()
    {
        return Form::choices('test', ['val1' => 'label1', 'val2' => 'label2'])->setInitValue('val2');
    }

    public function testRadio()
    {
        $choice = $this->buildChoices();
        $this->assertEquals(Choices::class, get_class($choice));
        $this->assertEquals('<label><input type="radio" name="test" id="test_0" value="val1"> label1</label>
<label><input type="radio" name="test" id="test_1" value="val2" checked="checked"> label2</label>
', (string) $choice);
    }

    public function testCheckbox()
    {
        $choice = $this->buildChoices()->multiple();
        $this->assertEquals(Choices::class, get_class($choice));
        $this->assertEquals('<label><input type="checkbox" name="test[0]" id="test_0_" value="val1"> label1</label>
<label><input type="checkbox" name="test[1]" id="test_1_" value="val2" checked="checked"> label2</label>
', (string) $choice);
    }

    public function testSelect()
    {
        $choice = $this->buildChoices()->multiple()->expand(false);
        $this->assertEquals(Choices::class, get_class($choice));
        $this->assertEquals('<select name="test[]" id="test__" multiple="multiple">
<option value="val1">label1</option>
<option value="val2" selected>label2</option>
</select>', (string) $choice);
    }

    public function testGetChoices()
    {
        $form = $this->buildChoices()->multiple();
        $html = '';
        foreach ($form->getChoices() as $choice) {
            $html .= $choice->toString() . Tag::create('label')->set('for', $choice->get('id')) . "\n";
        }
        $this->assertEquals('<input type="checkbox" name="test[0]" id="test_0_" value="val1"><label for="test_0_"></label>
<input type="checkbox" name="test[1]" id="test_1_" value="val2" checked="checked"><label for="test_1_"></label>
', $html);
    }
}
