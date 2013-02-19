<?php
namespace WScore\Html;

require_once( __DIR__ . '/require.php' );
$tags = new Elements( new ToHtml() );
return $tags;