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

class InputTest extends TestCase
{
    public function testName()
    {
        $html = Html::input('text', 'name-test')
            ->name('nameA')
            ->name('nameB');
        $this->assertEquals('<input type="text" name="nameB" />', (string) $html);
    }
}
