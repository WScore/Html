<?php
namespace WScore\Html;

require_once( __DIR__ . '/require.php' );
$tags = new Tags( new ToHtml() );
return $tags;