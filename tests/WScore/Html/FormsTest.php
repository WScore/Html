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
    // +----------------------------------------------------------------------+
    //  test on select
    // +----------------------------------------------------------------------+
    function test_select()
    {
        $lang = array(
            array( 'eng', 'english' ),
            array( 'ger', 'german' ),
            array( 'fra', 'french' ),
        );
        $form = $this->forms->select( 'lang', $lang, 'ger' );
        $this->assertEquals( '<select name="lang">
  <option value="eng">english</option>
  <option value="ger" selected="selected">german</option>
  <option value="fra">french</option>
</select>' . "\n", (string) $form );
    }

    function test_select_with_group()
    {
        $lang = array(
            array( 'eng', 'english' ),
            array( 'ger', 'german', 'europe' ),
            array( 'fra', 'french', 'europe' ),
            array( 'spa', 'spanish', 'europe' ),
            array( 'jpn', 'japanese' ),
            array( 'zhi', 'chinese', 'asia' ),
            array( 'kor', 'korean', 'asia' ),
        );
        $form = $this->forms->select( 'lang', $lang, array( 'ger', 'zhi' ), array( 'multiple' => true ) );
        $this->assertEquals( '<select name="lang[]" multiple="multiple">
  <option value="eng">english</option>
  <optgroup label="europe">
    <option value="ger" selected="selected">german</option>
    <option value="fra">french</option>
    <option value="spa">spanish</option>
  </optgroup>
  <option value="jpn">japanese</option>
  <optgroup label="asia">
    <option value="zhi" selected="selected">chinese</option>
    <option value="kor">korean</option>
  </optgroup>
</select>' . "\n", (string) $form );
    }
    // +----------------------------------------------------------------------+
    function test_radio_in_box()
    {
        $ages = array(
            array( '10', 'teenage' ),
            array( '20', 'twenties' ),
            array( '30', 'thirtish' ),
        );
        $form = $this->forms->radioList( 'user_age', $ages, '20' );
        $this->assertEquals( '<div class="forms-DivList"><ul>
  <li><label><input type="radio" name="user_age" value="10" />teenage</label></li>
  <li><label><input type="radio" name="user_age" value="20" checked="checked" />twenties</label></li>
  <li><label><input type="radio" name="user_age" value="30" />thirtish</label></li>
</ul>
</div>'."\n", (string) $form );
    }

    function test_check_in_box()
    {
        $ages = array(
            array( '10', 'teenage' ),
            array( '20', 'twenties' ),
            array( '30', 'thirtish' ),
        );
        $form = $this->forms->checkList( 'user_age', $ages, '20' );
        $form = (string) $form;
        $this->assertEquals( '<div class="forms-DivList"><ul>
  <li><label><input type="checkbox" name="user_age[]" value="10" />teenage</label></li>
  <li><label><input type="checkbox" name="user_age[]" value="20" checked="checked" />twenties</label></li>
  <li><label><input type="checkbox" name="user_age[]" value="30" />thirtish</label></li>
</ul>
</div>'."\n", $form );
    }
    // +----------------------------------------------------------------------+
}
