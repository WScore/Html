<?php
namespace WScore\Html;

require_once( __DIR__ . '/require.php' );
$forms = new Forms( include( __DIR__ . '/elements.php' ) );
return $forms;