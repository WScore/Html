<?php
namespace WScore\Html;

require_once( __DIR__ . '/require.php' );
$util = new Utils();
$tags = new Elements( new ToHtml( $util ), $util );
return $tags;