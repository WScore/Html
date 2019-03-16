<?php
/**
 * Created by PhpStorm.
 * User: wsjp
 * Date: 2019/03/16
 * Time: 12:00
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use WScore\Html\Tag;

class TagTest extends TestCase
{
    public function testTagConstruction()
    {
        $tag = Tag::create('test');
        $html = $tag->toString();
        $this->assertTrue($tag instanceof Tag);
        $this->assertStringStartsWith('<test>', $html);
        $this->assertStringEndsWith('</test>', $html);
    }

    public function testSetAttribute()
    {
        $tag = Tag::create('test')
            ->set('name', 'tested');
        $html = $tag->toString();
        $this->assertStringStartsWith('<test ', $html);
        $this->assertStringEndsWith('</test>', $html);
        $this->assertStringContainsString('name="tested"', $html);
    }

    public function testSetAttributeWithConnector()
    {
        $tag = Tag::create('test')
            ->set('name', 'tested')
            ->set('name', 'tested', '--');
        $html = $tag->toString();
        $this->assertStringContainsString('name="tested--tested"', $html);
    }

    public function testSetAttributeWithFalse()
    {
        $tag = Tag::create('test')
            ->set('some', 'tested')
            ->set('name', 'tested')
            ->set('name', false);
        $html = (string) $tag;
        $this->assertStringContainsString('some="tested"', $html);
        $this->assertStringNotContainsString('name="', $html);
    }

    public function testHasNoContents()
    {
        $tag = Tag::create('test')
            ->setHasCloseTag(false);
        $html = (string) $tag;
        $this->assertEquals('<test />', $html);
    }

    public function testSetContents()
    {
        $tag = Tag::create('test')
            ->setContents('test1');
        $html = (string) $tag;
        $this->assertEquals('<test>test1</test>', $html);

        $tag = Tag::create('test')
            ->setContents('test1')
            ->setContents('test2');
        $html = (string) $tag;
        $this->assertEquals("<test>\ntest1\ntest2\n</test>", $html);
    }

    public function testClass()
    {
        $html = Tag::create('test')
            ->class('classA')
            ->class('classB');
        $this->assertEquals('<test class="classA classB"></test>', (string) $html);
    }

    public function testStyle()
    {
        $html = Tag::create('test')
            ->style('styleA')
            ->style('styleB');
        $this->assertEquals('<test style="styleA; styleB"></test>', (string) $html);
    }
}
