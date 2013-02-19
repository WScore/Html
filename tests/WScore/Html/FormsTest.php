<?php
namespace WScore\tests\Html;

use \WScore\Html\Forms;

class FormsTest extends \PHPUnit_Framework_TestCase
{
    /** @var Forms */
    public $forms;
    public function setUp()
    {
        $this->forms = include( __DIR__ . '/../../../scripts/forms.php' );
    }
    // +----------------------------------------------------------------------+

    function test_inputs()
    {
        $input = $this->forms->input( 'text' );
        $this->assertContains( '<input type="text" name="" value="" />', (string) $input );

        $input = $this->forms->input( 'password' );
        $this->assertContains( '<input type="password" name="" value="" />', (string) $input );

        $input = $this->forms->input( 'text', 'name1', 'value2' );
        $this->assertContains( '<input type="text" name="name1" value="value2" />', (string) $input );
    }

    function test_inputs_using_call()
    {
        $input = $this->forms->text();
        $this->assertContains( '<input type="text" name="" value="" />', (string) $input );

        $input = $this->forms->password();
        $this->assertContains( '<input type="password" name="" value="" />', (string) $input );

        $input = $this->forms->text( 'name1', 'value2' );
        $this->assertContains( '<input type="text" name="name1" value="value2" />', (string) $input );
    }

    function test_textArea()
    {
        $ta = $this->forms->textArea( 'text-area' );
        $this->assertContains( '<textarea name="text-area"></textarea>', (string) $ta );

        $ta = $this->forms->textArea( 'text-area', 'value2' );
        $this->assertContains( '<textarea name="text-area">value2</textarea>', (string) $ta );

        $ta = $this->forms->textArea( 'text-area' )->_contain( 'value3' );
        $this->assertContains( '<textarea name="text-area">value3</textarea>', (string) $ta );


        $ta = $this->forms->textArea( 'text-area' )->_contain( 'value2', 'value3' );
        $this->assertContains( '<textarea name="text-area">value2value3</textarea>', (string) $ta );

        $ta = $this->forms->textArea( 'text-area' )->_contain( 'value3' )->_contain( 'value4' );
        $this->assertContains( '<textarea name="text-area">value3value4</textarea>', (string) $ta );

        $ta = $this->forms->textArea( 'text-area' )->_contain( 'value3'."\n" )->_contain( 'value4' );
        $this->assertContains( '<textarea name="text-area">value3' . "\n" .'value4</textarea>', (string) $ta );
    }

    function test_input_no_class_is_set()
    {
        $form = $this->forms->input( 'text', 'user_name', 'taro-san', array( 'class' => 'myClass', 'ime' => 'ON' ) );
        $this->assertContains( '<input type="text" name="user_name" value="taro-san"', (string) $form );
        $this->assertContains( 'value="taro-san" class="myClass" style="ime-mode:active" />', (string) $form );

        // no class is set.
        $form = $this->forms->input( 'date', 'user_bdate', '1989-01-01' )->ime( 'OFF' );
        $this->assertEquals( '<input type="date" name="user_bdate" value="1989-01-01" style="ime-mode:inactive" />',(string)  $form );
    }

    function test_check()
    {
        $form = $this->forms->check( 'user_OK', 'YES' );
        $this->assertEquals( '<input type="checkbox" name="user_OK" value="YES" />', (string) $form );

        // check if radio does NOT have [] in the name.
        $form = $this->forms->radio( 'user_OK', 'YES' );
        $this->assertEquals( '<input type="radio" name="user_OK" value="YES" />', (string) $form );
    }
    function test_radio()
    {
        $form = $this->forms->radio( 'user_OK', 'YES' );
        $this->assertEquals( '<input type="radio" name="user_OK" value="YES" />', (string) $form );
    }
}
