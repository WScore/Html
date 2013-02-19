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
}
