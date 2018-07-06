<?php
$preferences = Swift_Preferences::getInstance ();

$preferences->setCharset ( 'utf-8' );

$tmp = getenv ( 'TMPDIR' );
if ($tmp && @is_writable ( $tmp )) {
	$preferences->setTempDir ( $tmp )->setCacheType ( 'disk' );
} elseif (function_exists ( 'sys_get_temp_dir' ) && @is_writable ( sys_get_temp_dir () )) {
	$preferences->setTempDir ( sys_get_temp_dir () )->setCacheType ( 'disk' );
}

if (version_compare ( phpversion (), '5.4.7', '<' )) {
	$preferences->setQPDotEscape ( false );
}
