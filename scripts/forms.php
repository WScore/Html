<?php
namespace WScore\Html;

require_once( __DIR__ . '/require.php' );
$forms = new Forms( new Elements( new ToHtml() ) );
return $forms;