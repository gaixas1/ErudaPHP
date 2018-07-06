<?php

namespace Atashi;

class ErrorHandler {
	public static $twig;
	static function received($twig, \Exception $e, $dev) {
		$code = $e->getCode ();
		$msg = $e->getMessage ();
		$line = $e->getLine ();
		$file = $e->getFile ();
		
		if ($dev) {
			header ( 'Content-Type: text/html; charset=utf-8' );
			switch ($code) {
				case E_ERROR :
					echo "<b>ERROR</b>  $msg <br />\n";
					echo "  Error fatal en la linea $line en el archivo $file";
					echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
					echo "Abortando...<br />\n";
					exit ( 1 );
					break;
				
				case E_WARNING :
					echo "<b>WARNING</b> $msg<br />";
					break;
				case E_NOTICE :
					echo "<b>NOTICE</b>  $msg<br />";
					break;
				case E_USER_ERROR :
					echo "<b>USER_ERROR</b>  $msg<br />";
					break;
				case 404 :
					echo "<b>ERROR 404</b>  $msg<br />";
					break;
				case 403 :
					echo "<b>ERROR 403</b>  $msg<br />";
					break;
				case 500 :
					echo "<b>ERROR 500</b>  $msg<br />";
					echo "  Error fatal en la linea $line en el archivo $file";
					break;
				default :
					echo "<b>UNDEFINED ERROR</b>  $msg<br />";
			}
		} else {
			header ( 'Content-Type: text/html; charset=utf-8' );
			switch ($code) {
				case 404 :
					self::printbody ( '<b>ERROR 404</b>' . nl2br ( $msg ) . '<br />', 'Error 404' );
					break;
				case 403 :
					self::printbody ( '<b>ERROR 403</b>' . nl2br ( $msg ) . '<br />', 'Error 403' );
					break;
				case 500 :
					self::printbody ( '<b>ERROR 500</b>' . nl2br ( $msg ) . '<br />', 'Error 500' );
					break;
				default :
					self::printbody ( '<b>ERROR ' . $code . '</b>' . nl2br ( $msg ) . '<br />' . $line . '</br>' . nl2br ( $file ), 'Error Desconocido' );
			}
		}
	}
	static function printbody($text, $title) {
		echo '<!DOCTYPE html><html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>' . $title . '</title>
    <meta name="description" content="FallenSoul, todos nuestras series on-line para tu disfrute.">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://local.es/service/rss.xml" />
</head>

<body>
' . $text . '
</body>
</html>';
	}
}
