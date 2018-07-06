<?php

namespace Atashi;

// Vendor Require
require_once dirname ( __FILE__ ) . '/../extern/Twig/Autoloader.php';

\Twig_Autoloader::register ();

define ( 'TP_STRING', 1 );
define ( 'TP_INT', 2 );
define ( 'TP_ANUM', 4 );
define ( 'TP_ALF', 8 );
define ( 'TP_DMY', 16 );
define ( 'TP_MY', 32 );
define ( 'TP_ALL', 64 );
define ( 'TP_FIXED', 0 );

define ( 'MT_GET', 1 );
define ( 'MT_POST', 2 );
define ( 'MT_PUT', 4 );
define ( 'MT_DELETE', 8 );
define ( 'MT_ALL', 16 );
class Core {
	public $is_dev;
	public $em;
	public $twig;
	public $mailer;
	public static $globals;
	public $publicFolder;
	public $domain;
	public $eH;
	public $config;
	function __construct($config, $is_dev = true) {
		session_start ();
		spl_autoload_register ( '\Atashi\Core::loader' );
		
		self::$globals = $config ['globals'] ?? array ();
		$this->is_dev = $is_dev != false;
		
		$this->publicFolder = $config ['public_html'] ?? "";
		$this->eH = $config ['ErrorHandler'] ?? '\Atashi\ErrorHandler';
		
		$this->domain = $config ['domain'] ?? $_SERVER ['HTTP_HOST'];
		
		$this->config = array (
				'twig' => $config ['twig'] ?? array (),
				'dbase' => $config ['dbase'] ?? array (),
				'mail' => $config ['mail'] ?? array (),
				'routes' => $config ['routes'] ?? array (),
				'routes2Ctrl' => $config ['routes2Ctrl'] ?? array ()
		);
	}
	function initialize() {
		try {
			if ($this->is_dev) {
				error_reporting ( E_ALL );
			} else {
				error_reporting ( E_ERROR );
			}
			set_error_handler ( function ($errno, $errstr, $errfile, $errline, array $errcontext) {
				if ($errno & error_reporting ()) {
					throw new \ErrorException ( $errstr, 0, $errno, $errfile, $errline );
				} else {
					return false;
				}
			} );
			
			// Twig
			$this->twig = new \Twig_Environment ( new \Twig_Loader_Filesystem ( $this->config ['twig'] ['TemplatesFolder'] ), array (
					'cache' => $this->config ['twig'] ['TemplatesCacheFolder'],
					'auto_reload' => $this->is_dev 
			) );
			
			$this->twig->addFilter ( new \Twig_SimpleFilter ( 'url', array (
					$this,
					'filterUrl' 
			) ) );
			$this->twig->addFilter ( new \Twig_SimpleFilter ( 'path', array (
					$this,
					'filterPath' 
			) ) );
			
			// Mailer
			$this->mailer = new Mailer ( $this->config ['mail'] ['server'], $this->config ['mail'] ['port'], $this->config ['mail'] ['username'], $this->config ['mail'] ['pass'], $this->config ['mail'] ['sender'], $this->config ['mail'] ['senderName'] );
			
			// Routes
			$this->parseRoutes ( $this->config ['routes'], $this->config ['routes2Ctrl'] );
			$this->routes2Ctrl = $this->config ['routes2Ctrl'];
			
			// DB
			$this->em = new DBObject ( $this->config ['dbase'] );
		} catch ( \Exception $e ) {
			$this->eH::received ( $this->twig, $e, $this->is_dev );
			return false;
		}
		return true;
	}
	function run() {
		try {
			$uri = strtok ( $_SERVER ['REQUEST_URI'], '?' );
			;
			$method = strtoupper ( $_SERVER ['REQUEST_METHOD'] );
			if (($caller = $this->processRoute ( $uri, $method )) !== null) {
				$caller->execute ( $this );
			}
		} catch ( \Exception $e ) {
			$this->eH::received ( $this->twig, $e, $this->is_dev );
			return false;
		}
		return true;
	}
	function cron($class) {
		try {
			$controller = new $class ( $this );
			$controller->call ();
		} catch ( \Exception $e ) {
			$this->eH::received ( $this->twig, $e, $this->is_dev );
			return false;
		}
		return true;
	}
	static function loader($className) {
		$className = ltrim ( $className, '\\' );
		$fileName = '../';
		$fileNameV = '../extern/';
		$namespace = '';
		$lastNsPos = strripos ( $className, '\\' );
		if ($lastNsPos) {
			$namespace = substr ( $className, 0, $lastNsPos );
			$className = substr ( $className, $lastNsPos + 1 );
			$fileName .= str_replace ( '\\', '/', $namespace ) . '/';
			$fileNameV .= str_replace ( '\\', '/', $namespace ) . '/';
		}
		$fileName .= str_replace ( '_', '/', $className ) . '.php';
		$fileNameV .= str_replace ( '_', '/', $className ) . '.php';
		
		$fileName = dirname ( __FILE__ ) . '/' . $fileName;
		$fileNameV = dirname ( __FILE__ ) . '/' . $fileNameV;
		
		if (is_readable ( $fileName )) {
			require_once $fileName;
		} else if (is_readable ( $fileNameV )) {
			require_once $fileNameV;
		}
	}
	function parseRoutes($routes, $routes2Ctrl) {
		$this->routeNames = array ();
		foreach ( $routes as $k => $v ) {
			$this->addRoute ( $k, $v, '/' );
		}
	}
	function addRoute($k, $v, $base) {
		if ($k [0] == '@') {
			$this->routeNames [$k] = $this->parseRoute ( $base . $v );
		} else if (is_array ( $v )) {
			foreach ( $v as $sk => $sv ) {
				$this->addRoute ( $sk, $sv, $base . $k );
			}
		}
	}
	function parseRoute($route) {
		$ret = array ();
		$route = trim ( $route, '/' );
		$sr = explode ( '/', $route );
		
		$i = 0;
		foreach ( $sr as $v ) {
			if ($v != "" && $v [0] == '?') {
				$v = substr ( $v, 1 );
				$pv = explode ( ':', $v );
				if (count ( $pv ) == 1) {
					switch ($pv [0]) {
						case 'INT' :
							$ret [] = array (
									TP_INT,
									$i ++ 
							);
							break;
						case 'STRING' :
							$ret [] = array (
									TP_STRING,
									$i ++ 
							);
							break;
						case 'DMY' :
							$ret [] = array (
									TP_DMY,
									$i ++ 
							);
							break;
						case 'MY' :
							$ret [] = array (
									TP_MY,
									$i ++ 
							);
							break;
						case '*' :
							$ret [] = array (
									TP_ALL,
									$i ++ 
							);
							break;
						default :
							trigger_error ( 'Ruta no valida', E_ERROR );
					}
				} else if (count ( $pv ) == 2) {
					switch ($pv [1]) {
						case 'INT' :
							$ret [] = array (
									TP_INT,
									$pv [0] 
							);
							break;
						case 'STRING' :
							$ret [] = array (
									TP_STRING,
									$pv [0] 
							);
							break;
						case 'DMY' :
							$ret [] = array (
									TP_DMY,
									$pv [0] 
							);
							break;
						case 'MY' :
							$ret [] = array (
									TP_MY,
									$pv [0] 
							);
							break;
						case '*' :
							$ret [] = array (
									TP_ALL,
									$pv [0] 
							);
							break;
						default :
							trigger_error ( 'Ruta no valida', E_ERROR );
					}
				} else {
					trigger_error ( 'Ruta no valida', E_ERROR );
				}
			} else {
				$ret [] = array (
						TP_FIXED,
						$v 
				);
			}
		}
		return $ret;
	}
	function processRoute($uri, $method = 'GET') {
		$params = explode ( '/', trim ( $uri, '/' ) );
		$ptypes = $this->paramTypes ( $params );
		
		foreach ( $this->routeNames as $route => $dir ) {
			if ($this->machRoute ( $dir, $params, $ptypes )) {
				$ctrl = null;
				if (isset ( $this->routes2Ctrl [$method . $route] )) {
					$ctrl = $this->routes2Ctrl [$method . $route];
				} else if (isset ( $this->routes2Ctrl [$route] )) {
					$ctrl = $this->routes2Ctrl [$route];
				}
				
				if ($ctrl != null) {
					$caller = new Caller ( $ctrl );
					$caller->computeParams ( $dir, $params );
					return $caller;
				}
			}
		}
		$this->trigger404 ( 'Pagina no encontrada' );
		return null;
	}
	function paramTypes($params) {
		$ret = array ();
		foreach ( $params as $k => $v ) {
			$ret [$k] = 0;
			if ($v != "") {
				$ret [$k] |= TP_STRING;
				if (ctype_alnum ( $v )) {
					$ret [$k] |= TP_ANUM;
				}
				if (ctype_alpha ( $v )) {
					$ret [$k] |= TP_ALF;
				}
				if (ctype_digit ( $v )) {
					$ret [$k] |= TP_INT;
				}
				if (preg_match ( '|^[0-9]{2}-[0-9]{2}-[0-9]{4}$|i', $v )) {
					$ret [$k] |= TP_DMY;
				}
				if (preg_match ( '|^[0-9]{2}-[0-9]{4}$|i', $v )) {
					$ret [$k] |= TP_MY;
				}
			}
		}
		return $ret;
	}
	function machRoute($route, $uri, $types) {
		if (count ( $route ) > count ( $uri )) {
			return false;
		}
		
		for($i = 0; $i < count ( $route ); $i ++) {
			if ($route [$i] [0] == TP_ALL) {
				return true;
			}
			if ($route [$i] [0] == TP_FIXED) {
				if (strtolower ( $route [$i] [1] ) != strtolower ( $uri [$i] )) {
					return false;
				}
			} else if (! ($route [$i] [0] & $types [$i])) {
				return false;
			}
		}
		return count ( $types ) == $i;
	}
	function fordward($ctrl, $f, $params = array()) {
		$caller = new \Atashi\Caller ( $ctrl, $f );
		$caller->setParams ( $params );
		$caller->execute ( $this );
	}
	function setHeaders($type) {
		switch ($type) {
			case 'json' :
				header ( 'Content-Type: application/json' );
				break;
			case 'xml' :
				header ( 'Content-Type: text/xml' );
				break;
			case 'htmlUtf8' :
				header ( 'Content-Type: text/html; charset=utf-8' );
				break;
		}
	}
	function render($template, $data = array()) {
		echo $this->twig->render ( $template, $data );
	}
	function getRender($template, $data = array()) {
		return $this->twig->render ( $template, $data );
	}
	function addTwigFilter($name, $object, $function) {
		$this->twig->addFilter ( new \Twig_SimpleFilter ( $name, array (
				$object,
				$function 
		) ) );
	}
	function addTwigFilterStatic($name, $function) {
		$this->twig->addFilter ( $name, new \Twig_Filter_Function ( $function ) );
	}
	function getSession($var, $default = null) {
		return $_SESSION [$var] ?? $default;
	}
	function setSession($var, $value) {
		$_SESSION [$var] = $value;
	}
	function getSessionObject($var, $default = null) {
		return isset ( $_SESSION [$var] ) ? unserialize ( $_SESSION [$var] ) : $default;
	}
	function setSessionObject($var, $value) {
		$_SESSION [$var] = serialize ( $value );
	}
	function clearSession($var) {
		unset ( $_SESSION [$var] );
	}
	function getGlobal($var, $default = null) {
		return self::$globals [$var] ?? $default;
	}
	function setGlobal($var, $value) {
		self::$globals [$var] = $value;
	}
	function clearGlobal($var) {
		unset ( self::$globals [$var] );
	}
	function getCookie($var, $default = null) {
		return $_COOKIE [$var] ?? $default;
	}
	function setCookie($var, $value, $expire = 2147483647, $path = '/') {
		$_COOKIE [$var] = $value;
		setcookie ( $var, $value, $expire, $path );
	}
	function clearCookie($var, $path = '/') {
		unset ( $_COOKIE [$var] );
		setcookie ( $var, '', 0, $path );
	}
	function getRequest($var, $default = null) {
		return $_REQUEST [$var] ?? $default;
	}
	function getGET($var, $default = null) {
		$_GET [$var] ?? $default;
	}
	function parsePost($var) {
		if (isset ( $_POST [$var] ) && ! empty ( $_POST [$var] ) && $_POST [$var] != "") {
			$data = json_decode ( $_POST [$var] );
			foreach ( $data as $v ) {
				if (strpos ( $v [0], '[]' ) !== false) {
					$_POST [str_replace ( '[]', '', $v [0] )] [] = utf8_encode ( base64_decode ( $v [1] ) );
				} else {
					$_POST [$v [0]] = utf8_encode ( base64_decode ( $v [1] ) );
				}
			}
		}
	}
	function getPost($var, $default = null) {
		return $_POST [$var] ?? $default;
	}
	function getFILE($var) {
		return $_FILES [$var] ?? null;
	}
	function getServer($var, $default = null) {
		return $_SERVER [$var] ?? $default;
	}
	function redirect($url) {
		header ( 'Location: ' . $url );
	}
	function authenticate($msg) {
		header ( 'WWW-Authenticate: Basic realm="FSAdmin"' );
		header ( 'HTTP/1.0 401 Unauthorized' );
		echo $msg;
		exit ();
	}
	function trigger404($error_msg) {
		\http_response_code ( 404 );
		throw new \Exception ( $error_msg, 404 );
	}
	function trigger403($error_msg) {
		\http_response_code ( 403 );
		throw new \Exception ( $error_msg, 403 );
		exit ();
	}
	function trigger500($error_msg) {
		\http_response_code ( 500 );
		throw new \Exception ( $error_msg, 500 );
		exit ();
	}
	function triggerError($code, $error_msg, $end = false) {
		\http_response_code ( $code );
		throw new \Exception ( $error_msg, $code );
		if ($end) {
			exit ();
		}
	}
	function filterUrl($url, $params = array()) {
		return 'http://' . $this->domain . $this->filterPath ( $url, $params );
	}
	function filterPath($url, $params = array()) {
		$ret = '';
		if (isset ( $this->routeNames [$url] )) {
			$route = $this->routeNames [$url];
			
			foreach ( $route as $p ) {
				switch ($p [0]) {
					case TP_FIXED :
						$ret .= '/' . $p [1];
						break;
					default :
						$ret .= '/' . ($params [$p [1]] ?? $p [1]);
				}
			}
		}
		return $ret;
	}
}