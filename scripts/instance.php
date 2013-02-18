<?php
namespace WScore\Tags;

require_once( __DIR__ . '/require.php' );
$tags = new Tags( new ToHtml() );
return $tags;