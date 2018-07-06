<?php
include '../Atashi/Core.php';
include '../AtashiPrivate/config.php';
$atashi = new \Atashi\Core ( $config, true );
if ($atashi->initialize ()) {
	$atashi->run ();
}