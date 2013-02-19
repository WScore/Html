<?php
namespace WScore\tests\Html;

ini_set( 'display_errors', 1 );
error_reporting( E_ALL );

class AllHtmlTests
{
    public static function suite()
    {
        $suite = new \PHPUnit_Framework_TestSuite( 'all tests for WScore\'s Validation' );
        $suite->addTestFile( __DIR__ . '/TagsTest.php' );
        $suite->addTestFile( __DIR__ . '/ElementsTest.php' );
        $suite->addTestFile( __DIR__ . '/FormsTest.php' );

        return $suite;
    }
}