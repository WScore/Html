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
    public function testTagConstruction()
    {
        $tag = Html::create('test');
        $html = $tag->toString();
        $this->assertTrue($tag instanceof Html);
        $this->assertStringStartsWith('<test>', $html);
        $this->assertStringEndsWith('</test>', $html);
    }

    public function testSetAttribute()
    {
        $tag = Html::create('test')
            ->set('name', 'tested');
        $html = $tag->toString();
        $this->assertStringStartsWith('<test ', $html);
        $this->assertStringEndsWith('</test>', $html);
        $this->assertStringContainsString('name="tested"', $html);
    }

    public function testSetAttributeWithConnector()
    {
        $tag = Html::create('test')
            ->set('name', 'tested')
            ->set('name', 'tested', '--');
        $html = $tag->toString();
        $this->assertStringContainsString('name="tested--tested"', $html);
    }

    public function testSetAttributeWithFalse()
    {
        $tag = Html::create('test')
            ->set('some', 'tested')
            ->set('name', 'tested')
            ->set('name', false);
        $html = (string) $tag;
        $this->assertStringContainsString('some="tested"', $html);
        $this->assertStringNotContainsString('name="', $html);
    }

    public function testHasNoContents()
    {
        $tag = Html::create('test')
            ->setHasCloseTag(false);
        $html = (string) $tag;
        $this->assertEquals('<test />', $html);
    }

    public function testSetContents()
    {
        $tag = Html::create('test')
            ->setContents('test1');
        $html = (string) $tag;
        $this->assertEquals('<test>test1</test>', $html);

        $tag = Html::create('test')
            ->setContents('test1')
            ->setContents('test2');
        $html = (string) $tag;
        $this->assertEquals("<test>\ntest1\ntest2\n</test>", $html);
    }

    public function testClass()
    {
        $html = Html::create('test')
            ->class('classA')
            ->class('classB');
        $this->assertEquals('<test class="classA classB"></test>', (string) $html);
    }

    public function testStyle()
    {
        $html = Html::create('test')
            ->style('styleA')
            ->style('styleB');
        $this->assertEquals('<test style="styleA; styleB"></test>', (string) $html);
    }
}
