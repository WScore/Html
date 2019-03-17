<?php
/**
 * Created by PhpStorm.
 * User: wsjp
 * Date: 2019/03/16
 * Time: 12:00
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use WScore\Html\Html;

class HtmlTest extends TestCase
{
    public function testCreate()
    {
        $html = Html::create('tagName')
            ->class('test-class');
        $this->assertEquals('<tagName class="test-class"></tagName>', (string) $html);
    }

    public function testStaticCall()
    {
        $html = Html::ul(
            Html::li('test1'),
            Html::li('test1')
        )->style('a:b');
        $this->assertEquals('<ul style="a:b">
<li>test1</li>
<li>test1</li>
</ul>', (string) $html);
    }

    public function testSampleCode()
    {
        $html = Html::a('sample link')->href('test.php')->target('_blank');
        $this->assertEquals('<a href="test.php" target="_blank">sample link</a>', (string) $html);
    }
}