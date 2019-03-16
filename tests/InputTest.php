<?php
/**
 * Created by PhpStorm.
 * User: wsjp
 * Date: 2019/03/16
 * Time: 13:43
 */

declare(strict_types=1);

use WScore\Html\Form;
use PHPUnit\Framework\TestCase;

class InputTest extends TestCase
{
    public function testName()
    {
        $html = Form::input('text', 'name-test')
            ->name('nameA')
            ->name('nameB');
        $this->assertEquals('<input type="text" name="nameB" id="nameB">', (string) $html);
    }

    public function testRequired()
    {
        $html = Form::input('text', 'req')
            ->required();
        $this->assertEquals('<input type="text" name="req" id="req" required="required">', (string) $html);

        $html->required(false);
        $this->assertEquals('<input type="text" name="req" id="req">', (string) $html);
    }
}
