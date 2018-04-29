<?php
if ( !function_exists('version_compare') || version_compare( phpversion(), '5', '<' ) )
include_once( 'ckeditor_php4.php' ) ;
else
include_once( 'ckeditor_php5.php' ) ;
include_once ('/phpmakerfolder/ckfinder/ckfinder.php');
?>