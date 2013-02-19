<?php
namespace WScore\tests\Html;

use \WScore\Html\Elements;

class ElementsTest extends \PHPUnit_Framework_TestCase
{
    /** @var Elements */
    public $elements;
    public function setUp()
    {
        $this->elements = include( __DIR__ . '/../../../scripts/elements.php' );
    }
    // +----------------------------------------------------------------------+
    function test_form_and_method()
    {
        $form = $this->elements->form();
        $this->assertContains( '<form>', (string) $form );
        $this->assertContains( '</form>', (string) $form );
        // set basic form info.
        $form->name( 'formName' )->action( 'self' )->method( 'get' );
        $this->assertContains( '<form name="formName" action="self" method="get">', (string) $form );
        $this->assertContains( '</form>', (string) $form );
        // set method other than get.
        $form->name( 'formName' )->method( 'put' );
        $this->assertContains( '<form name="formName" action="self" method="post">', (string) $form );
        $this->assertContains( '<input type="hidden" name="_method" value="put"', (string) $form );
        $this->assertContains( '</form>', (string) $form );
    }

    function test_ime_attribute()
    {
        $input = $this->elements->input;
        $input->type( 'text' )->ime( 'on' );
        $this->assertContains( '<input type="text" style="ime-mode:active" />', (string) $input );

        $input = $this->elements->input;
        $input->type( 'text' )->ime( 'off' );
        $this->assertContains( '<input type="text" style="ime-mode:inactive" />', (string) $input );

        $input = $this->elements->input;
        $input->type( 'text' )->ime( 'i1' );
        $this->assertContains( '<input type="text" style="istyle:1" />', (string) $input );

        $input = $this->elements->input;
        $input->type( 'text' )->ime( 'i2' );
        $this->assertContains( '<input type="text" style="istyle:2" />', (string) $input );

        $input = $this->elements->input;
        $input->type( 'text' )->ime( 'i3' );
        $this->assertContains( '<input type="text" style="istyle:3" />', (string) $input );

        $input = $this->elements->input;
        $input->type( 'text' )->ime( 'i4' );
        $this->assertContains( '<input type="text" style="istyle:4" />', (string) $input );
    }

    function test_multipleName()
    {
        /** @var $input Elements */
        $input = $this->elements->input;
        $input->type( 'text' )->name( 'tests' );
        $this->assertContains( '<input type="text" name="tests" />', (string) $input );

        $input->_setMultipleName();
        $this->assertContains( '<input type="text" name="tests[]" />', (string) $input );
        $input->_setMultipleName();
        $this->assertContains( '<input type="text" name="tests[][]" />', (string) $input );
    }

    function test_multipleName_recursively()
    {
        /** @var $ul Elements */
        $ul = $this->elements->ul;
        $ul->_contain( $this->elements->input->type( 'text' )->name( 'test1' ) );
        $ul->_contain( $this->elements->input->type( 'text' )->name( 'test2' ) );

        $this->assertContains( '<input type="text" name="test1" />', (string) $ul );
        $this->assertContains( '<input type="text" name="test2" />', (string) $ul );

        $ul->_setMultipleName();
        $this->assertContains( '<input type="text" name="test1[]" />', (string) $ul );
        $this->assertContains( '<input type="text" name="test2[]" />', (string) $ul );
        $ul->_setMultipleName();
        $this->assertContains( '<input type="text" name="test1[][]" />', (string) $ul );
        $this->assertContains( '<input type="text" name="test2[][]" />', (string) $ul );
    }

    function test_setId()
    {
        /** @var $input Elements */
        $input = $this->elements->input;
        $input->type( 'text' )->name( 'tests' );
        $this->assertContains( '<input type="text" name="tests" />', (string) $input );

        $input->_setId();
        $this->assertContains( '<input type="text" name="tests" id="tests" />', (string) $input );

        $input->_setMultipleName();
        $input->_setId();
        $this->assertContains( '<input type="text" name="tests[]" id="tests__" />', (string) $input );

        $input->_setMultipleName();
        $input->_setId();
        $this->assertContains( '<input type="text" name="tests[][]" id="tests____" />', (string) $input );
    }

    function test_setId_for_checkbox()
    {
        /** @var $input Elements */
        $input = $this->elements->input;
        $input->type( 'checkbox' )->name( 'tests' )->value( 'v1' );
        $this->assertContains( '<input type="checkbox" name="tests" value="v1" />', (string) $input );

        $input->_setId();
        $this->assertContains( '<input type="checkbox" name="tests" value="v1" id="tests_v1" />', (string) $input );

        $input->_setMultipleName();
        $input->_setId();
        $this->assertContains( '<input type="checkbox" name="tests[]" value="v1" id="tests___v1" />', (string) $input );

        $input->_setMultipleName();
        $input->_setId();
        $this->assertContains( '<input type="checkbox" name="tests[][]" value="v1" id="tests_____v1" />', (string) $input );
    }
}
