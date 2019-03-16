<?php
/**
 * Created by PhpStorm.
 * User: wsjp
 * Date: 2019/03/16
 * Time: 13:43
 */

declare(strict_types=1);

use WScore\Html\Html;
use PHPUnit\Framework\TestCase;

class HtmlTest extends TestCase
{
    public function testInput()
    {
        $html = Html::input('radio', 'Html', 'tested');
        $this->assertEquals('<input type="radio" name="Html" value="tested" />', (string) $html);
    }

    public function testTextArea()
    {
        $html = Html::textArea('Text', 'Area');
        $this->assertEquals('<textarea name="Text">Area</textarea>', (string) $html);
    }
}
